<?php
/**
 * orderingStatusExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文ステータスデータ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();
$SendMailOBJ = SendMail::getInstance();
$AffiliateControlOBJ = AffiliateControl::getInstance();

$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);
$userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);

$tags = array(
            "sesKey",
            "ordering_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$insertData = null;

$insertData["status"]        = $param["status"];
$insertData["description"]      = $param["description"];
$insertData["update_datetime"]  = date("YmdHis");

$validationOBJ = new ComArrayValidation($insertData);

$validationOBJ->check("status", "注文ステータス",
                array("Numeric" => null),
                array("Numeric" => "注文ステータスを選択してください"));

if ($orderingData["is_paid"] AND $param["status"] == AdmOrdering::ORDERING_STATUS_PRE_COMPLETE) {
    $validationOBJ->setErrorMessage("status", "入金済みで仮購入は変更できません");
}

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $param["return_cd"] = "status";
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

if ($param["ordering_id"]) {

    if (!$AdmOrderingOBJ->updateOrderingData($insertData, array("id = " . $param["ordering_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $param["return_cd"] = "status";
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    if ($param["status"] != $orderingData["status"]) {
        // キャンセルでなく入金済みで決済完了もしくは余り金完了にしたら購入回数を上げる
        if (!$orderingData["is_cancel"] AND $orderingData["is_paid"] AND ($param["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $param["status"] == AdmOrdering::ORDERING_STATUS_REST)) {

            // 先に初入金の場合はタグ送信
            if ($userData["buy_count"] == 0 && !$userData["affiliate_tag_first_payment_url"]){
                if ($userData["affiliate_value"]) {
                    // 登録時のQUERY_STRINGを配列に格納
                    parse_str($userData["affiliate_value"], $aryAffiliateValue);
                    // 「初入金時」のみフラグを配列に追加
                    $aryAffiliateValue["from_first_payment"] = 1;

                    if ($aryAffiliateValue["ad_code"]) {
                        $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
                    }

                    // タグ発行
                    if (!$AffiliateControlOBJ->sendAffiliateData($userData["user_id"], $aryAffiliateValue, AffiliateControl::SEND_TYPE_REGIST, $isSuccess = TRUE)) {
                        $userAffiliateUpdateArray["affiliate_tag_first_payment_url"] = "NO_TAG";
                        // userテーブルへの更新処理
                        if (!$AdminUserOBJ->updateUserData($userAffiliateUpdateArray, array("id = " . $userData["user_id"]))) {
                            $mailElements["subject"] = $payTypeName . "管理手動「初入金タグ」アフィリエイトソケット通信エラー";
                            $mailElements["text_body"] = $errMsg;

                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            //$SendMailOBJ->operationMailTo($mailElements);
                        }
                    }
                }
            }

            // アフィリエイトデータの取得
            $affiliateData = $AffiliateControlOBJ->getAffiliateDataFromAdvcd($userData["media_cd"]);

            //入金時タグ発行（成果報酬媒体の場合）
            if ($affiliateData["payment_parameter"]) {
                if ($userData["affiliate_value"]) {
                    // 登録時のQUERY_STRINGを配列に格納
                    $aryAffiliateValue = "" ;
                    parse_str($userData["affiliate_value"], $aryAffiliateValue);
                    // 「入金時」のみフラグを配列に追加
                    $aryAffiliateValue["from_payment"] = 1;

                    if ($aryAffiliateValue["ad_code"]) {
                        $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
                    }

                    $aryAffiliateValue["payment"] =  $orderingData["pay_total"];

                    // タグ発行
                    if (!$AffiliateControlOBJ->sendAffiliateData($userData["user_id"], $aryAffiliateValue, AffiliateControl::SEND_TYPE_REGIST, $isSuccess = TRUE)) {
                        // payment_parameter_logテーブルへのインサート処理
                        $insertArray["user_id"] = $userData["user_id"];
                        $insertArray["media_cd"] = $aryAffiliateValue["advcd"];
                        $insertArray["affiliate_tag_url"] = "NO_TAG";
                        $insertArray["create_datetime"] = date("YmdHis");
                        $insertArray["update_datetime"] = date("YmdHis");

                        if (!$AffiliateControlOBJ->insertPaymentAffiliateTagLog($insertArray)) {
                            $mailElements["subject"] = $payTypeName . "ユーザー「入金タグ」アフィリエイトソケット通信エラー";
                            $mailElements["text_body"] = $errMsg;

                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);

                        }
                    }
                }
            }

            $setProfileParam["buy_count"] = $userData["buy_count"] + 1;
            $setProfileParam["last_buy_datetime"] = date("YmdHis");
            if (!ComValidation::isDateTime($userData["first_pay_datetime"])) {
                $setProfileParam["first_pay_datetime"] = date("YmdHis");
                $execMsgSessOBJ->first_pay_msg = array("初回入金日が変更されました。<br>");
            }
            $isBought = true;
        // キャンセルでなく入金済みで決済完了もしくは余り金完了で決済完了もしくは余り金完了以外にしたら購入回数を下げる
        } else if (!$orderingData["is_cancel"] AND $orderingData["is_paid"] AND ($param["status"] != AdmOrdering::ORDERING_STATUS_COMPLETE AND $param["status"] != AdmOrdering::ORDERING_STATUS_REST)
         AND ($orderingData["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $orderingData["status"] == AdmOrdering::ORDERING_STATUS_REST)) {
            $setProfileParam["buy_count"] = $userData["buy_count"] - 1;
            if ($setProfileParam["buy_count"] == 0) {
                $setProfileParam["first_pay_datetime"] = "";
                $execMsgSessOBJ->first_pay_msg = array("初回入金日が初期化されました。<br>");
            }

        }

        $setProfileParam["update_datetime"] = date("YmdHis");

        $userProfileWhere[] = "user_id = " . $orderingData["user_id"];

        // userを更新
        if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }
    }

    // 購入完了なら同商品が入っている注文の削除
    if ($isBought) {
        $orderingDetailList = $AdmItemOBJ->getOrderingDetailItemList($param["ordering_id"]);
        foreach ((array)$orderingDetailList as $val) {
            $itemIdArray[] = $val["id"];
        }

        // キャンセルする注文データの取得
        $cancelOrderingList = $AdmOrderingOBJ->getOrderingListFromItemId($orderingData["user_id"], $itemIdArray);
        if ($cancelOrderingList) {
            foreach ((array)$cancelOrderingList as $val) {
                // 注文詳細リストの確認
                if (!$itemList = $AdmItemOBJ->getOrderingDetailItemList($val["id"])) {
                    continue;
                }
                foreach ((array)$itemList as $itemVal) {

                    // 注文詳細をキャンセルログに登録する
                    $orderingChangeLogArray = null;

                    // 注文変更ログ登録
                    $orderingChangeLogArray["ordering_id"] = $val["id"];
                    $orderingChangeLogArray["item_id"] = $itemVal["id"];
                    $orderingChangeLogArray["price"] = (0 - $itemVal["price"]);
                    $orderingChangeLogArray["create_datetime"] = date("YmdHis");

                    if (!$AdmOrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
                        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                        // ロールバック
                        $AdmOrderingOBJ->rollbackTransaction();
                        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
                        exit;
                    }

                    $orderingDetailArray = null;

                    $orderingDetailArray["disable"] = 1;
                    $orderingDetailArray["update_datetime"] = date("YmdHis");

                    // 注文詳細データ更新
                    if (!$AdmOrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $itemVal["detail_id"]))) {
                        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                        // ロールバック
                        $AdmOrderingOBJ->rollbackTransaction();
                        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
                        exit;
                    }
                }

                $orderingArray = null;

                $orderingArray["is_cancel"] = 1;
                $orderingArray["pay_total"] = 0;
                $orderingArray["cancel_datetime"] = date("YmdHis");
                $orderingArray["update_datetime"] = date("YmdHis");
                // 注文データ更新
                if (!$AdmOrderingOBJ->updateOrderingData($orderingArray, array("id = " . $val["id"]))) {
                    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                    // ロールバック
                    $AdmOrderingOBJ->rollbackTransaction();
                    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
                    exit;
                }
            }
        }
    }
    $execMsgSessOBJ->errMsg = array("更新しました。", "ポイントの増減があれば、ユーザー情報で行ってください。");
}

// コミット
$AdmOrderingOBJ->commitTransaction();

header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;
?>