<?php
/**
 * orderingPaymentExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金情報更新ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$SendMailOBJ = SendMail::getInstance();
$AffiliateControlOBJ = AffiliateControl::getInstance();
$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);

$paymentData = $AdmPaymentLogOBJ->getPaymentLogData($param["ordering_id"]);

$tags = array(
            "ordering_id",
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

// 入金キャンセル
if ($param["payment_cancel"]) {

    // 入金ログ削除
    $paymentArray["disable"] = 1;
    if (!$AdmPaymentLogOBJ->updatePaymentLogData($paymentArray, array("ordering_id = " . $paymentData["ordering_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    // 入金ログインサート
    $insertData["pay_type"] = $orderingData["pay_type"];
    $insertData["user_id"]         = $orderingData["user_id"];
    $insertData["ordering_id"]     = $param["ordering_id"];
    $insertData["receive_money"]   = 0 - $orderingData["pay_total"];
    $insertData["is_manual"]   = 1;
    $insertData["is_cancel"]   = 1;
    $insertData["create_datetime"] = date("YmdHis");

    if (!$AdmPaymentLogOBJ->insertPaymentLogData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $userData = $AdminUserOBJ->getUserData($orderingData["user_id"]);

    $setProfileParam["total_payment"] = $userData["total_payment"] - $orderingData["pay_total"];
    $setProfileParam["update_datetime"] = date("YmdHis");

    // 決済完了もしくは余り金完了になら購入回数を下げる
    if ($orderingData["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $orderingData["status"] == AdmOrdering::ORDERING_STATUS_REST) {
        $setProfileParam["buy_count"] = $userData["buy_count"] - 1;
        if ($setProfileParam["buy_count"] == 0) {
            $setProfileParam["first_pay_datetime"] = "";
            $execMsgSessOBJ->first_pay_msg = array("初回入金日が初期化されました。<br>");
        }
    }

    $userProfileWhere[] = "user_id = " . $orderingData["user_id"];

    // userを更新
    if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
        $execMsgSessOBJ->exec_msg = array("データ更新できませんでした。");
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->errMsg = array("入金キャンセルしました。");
    // 更新注文データ
    $orderingArray["is_paid"] = 0;
    $orderingArray["paid_datetime"] = "0000-00-00 00:00:00";

// 入金処理
} else {

    // 入金ログ削除
    if ($paymentData) {
        $paymentArray["disable"] = 1;
        if (!$AdmPaymentLogOBJ->updatePaymentLogData($paymentArray, array("ordering_id = " . $paymentData["ordering_id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }
    }

    // 更新注文データ
    $orderingArray["is_paid"] = 1;
    $orderingArray["paid_datetime"] = date("YmdHis");

/* 入金日付を指定させないように変更

    $orderingArray["paid_datetime"] = $param["paid_datetime_Date"] . " " . $param["paid_datetime_Time"];
    $validationOBJ = new ComArrayValidation($orderingArray);

    $validationOBJ->check("paid_datetime", "入金日",
                    array("Datetime" => null),
                    array("Datetime" => "入金日に日時を入力してください"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }
*/
    $insertData = null;

    // 入金ログインサート
    $insertData["pay_type"] = $orderingData["pay_type"];
    $insertData["user_id"]         = $orderingData["user_id"];
    $insertData["ordering_id"]     = $param["ordering_id"];
    $insertData["receive_money"]   = $orderingData["pay_total"];
    $insertData["is_manual"]   = 1;
    $insertData["create_datetime"] = $orderingArray["paid_datetime"];

    if (!$AdmPaymentLogOBJ->insertPaymentLogData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $userData = $AdminUserOBJ->getUserData($orderingData["user_id"]);

    $setProfileParam["total_payment"] = $userData["total_payment"] + $orderingData["pay_total"];
    $setProfileParam["update_datetime"] = date("YmdHis");
    // 決済完了もしくは余り金完了になら購入回数を上げる
    if ($orderingData["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $orderingData["status"] == AdmOrdering::ORDERING_STATUS_REST) {

        // 先に初入金の場合はタグ送信(「購入回数が0」 and 「初入金タグが未発行」の場合のみ)
        if ($userData["buy_count"] == 0 && !$userData["affiliate_tag_first_payment_url"]) {
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
        $isBought = true;
    }
    if (!ComValidation::isDateTime($userData["first_pay_datetime"])) {
        $setProfileParam["first_pay_datetime"] = date("YmdHis");
        $execMsgSessOBJ->first_pay_msg = array("初回入金日が変更されました。<br>");
    }

    $userProfileWhere[] = "user_id = " . $orderingData["user_id"];

    // userを更新
    if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
        $execMsgSessOBJ->exec_msg = array("データ更新できませんでした。");
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");

}

if (!$AdmOrderingOBJ->updateOrderingData($orderingArray, array("id = " . $param["ordering_id"]))) {
    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    // ロールバック
    $AdmOrderingOBJ->rollbackTransaction();
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// 購入完了なら同商品が入っている注文の削除
if ($isBought) {
    $orderingDetailList = $AdmItemOBJ->getOrderingDetailItemList($param["ordering_id"]);
    foreach ((array)$orderingDetailList as $val) {
        if (ComValidation::isNumeric($val["id"])) {

            // ポイント追加もここえ一緒にしてしまう
            if ($val["point"]) {
                if (!$UserOBJ->updatePoint($userData, $val["point"], $param["ordering_id"])){
                    // エラーメッセージの設定
                    $errMsg[] = "注文ID:" . $param["ordering_id"] . "\nユーザーID:" . $userData["user_id"] . "\n" . "\nポイント更新処理に失敗しました。";

                    $execMsgSessOBJ->exec_msg = $errMsg;
                    $param["return_flag"] = true;
                    $returnSessOBJ->return = $param;
                    // ロールバック
                    $AdmOrderingOBJ->rollbackTransaction();
                    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
                    exit;
                }
            }

            //商品管理で指定してある商品ＩＤの注文が入っているものも一緒に削除
            if($val["target_delete_item_id"]){
                $targetDeleteItemIdAry = explode(",", $val["target_delete_item_id"]) ;
                foreach((array)$targetDeleteItemIdAry as $targetDeleteItemIdVal){
                    if($targetDeleteItemIdVal != $val["id"]){
                        $itemIdArray[] = $targetDeleteItemIdVal;
                    }
				}
            }

            $itemIdArray[] = $val["id"];
        }
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

                $orderingDetailArray["is_cancel"] = 1;
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

// コミット
$AdmOrderingOBJ->commitTransaction();

header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;

?>

