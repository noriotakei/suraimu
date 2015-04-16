<?php
/**
 * orderingDetailExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文詳細データ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);

$tags = array(
            "sesKey",
            "ordering_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$currentDateTime = date("YmdHis");

$updateData = null;

$updateData["update_datetime"]  = $currentDateTime;

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

if ($param["ordering_id"]) {

    // 既存の注文分の処理
    foreach((array)$param["price"] as $orderingDetailId => $val) {

        $updateDetailData = null;

        if ($val < 0) {
            $execMsgSessOBJ->exec_msg= array("価格を正しく入力してください");
            $param["return_flag"] = true;
            $param["return_cd"] = "detail";
            $returnSessOBJ->return = $param;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }

        // 注文詳細データの取得
        if (!$orderingDetailArray = $AdmOrderingOBJ->getOrderingDetailData($orderingDetailId)) {
            $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $param["return_cd"] = "detail";
            $returnSessOBJ->return = $param;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }

        $updateDetailData["price"] = $val;
        if ($param["disable"][$orderingDetailId]) {
            $updateDetailData["disable"] = $param["disable"][$orderingDetailId];
        }
        $updateDetailData["update_datetime"]  = $currentDateTime;

        // 注文詳細データを更新
        if (!$AdmOrderingOBJ->updateOrderingDetailData($updateDetailData, array("id = " . $orderingDetailId))) {
            $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $param["return_cd"] = "detail";
            $returnSessOBJ->return = $param;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }

        $changePrice = $val - $orderingDetailArray["price"];

        // 価格変動があれば増減ログにインサート
        if ($changePrice != 0 OR $param["disable"][$orderingDetailId]) {
            // 変更時ステータスの取得
            if ($orderingData["is_paid"]) {
                $status = AdmOrderChangeLog::STATUS_PAID;
            } else {
                $status = AdmOrderChangeLog::STATUS_NOT_PAID;
            }

            $insertOrderingChangeLog["ordering_id"]        = $orderingData["id"];
            $insertOrderingChangeLog["item_id"]            = $orderingDetailArray["item_id"];
            $insertOrderingChangeLog["price"]              = $param["disable"][$orderingDetailId] ? (0 - $orderingDetailArray["price"]) : $changePrice;
            $insertOrderingChangeLog["status"]             = $status;
            $insertOrderingChangeLog["create_datetime"]    = $currentDateTime;
            if (!$AdmOrderChangeLogOBJ->insertOrderingChangeLogData($insertOrderingChangeLog)) {
                $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                $param["return_flag"] = true;
                $param["return_cd"] = "detail";
                $returnSessOBJ->return = $param;
                // ロールバック
                $AdmOrderingOBJ->rollbackTransaction();
                header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
                exit;
            }
        }
    }

    // 注文データ更新
    if (!$AdmOrderingOBJ->updateOrderingData($updateData, array("id = " . $param["ordering_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    // 注文額の小計、合計を更新
    if (!$AdmOrderingOBJ->updatePayTotal($param["ordering_id"])) {
        $execMsgSessOBJ->exec_msg = array("データ更新できませんでした。");
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    // 新しい注文データを取得
    $newOrderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);

    $changePayTotal = $newOrderingData["pay_total"] - $orderingData["pay_total"];

    // 合計金額が違えば、userの合計金額を変える。paymentLogに入れる
    if ($changePayTotal != 0 AND $newOrderingData["is_paid"]) {

        $insertPaymentLog["ordering_id"]        = $orderingData["id"];
        $insertPaymentLog["user_id"]            = $orderingData["user_id"];
        $insertPaymentLog["pay_type"]           = $orderingData["pay_type"];
        $insertPaymentLog["receive_money"]      = $changePayTotal;
        $insertPaymentLog["is_manual"]          = 1;
        if ($param["disable"][$orderingDetailId]) {
            $insertPaymentLog["is_cancel"]          = 1;
        }
        $insertPaymentLog["create_datetime"]    = $currentDateTime;
        // paymentLogにインサート
        if (!$AdmPaymentLogOBJ->insertPaymentLogData($insertPaymentLog)) {
            $execMsgSessOBJ->exec_msg = array("データ更新できませんでした。");
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }

        $userData = $AdminUserOBJ->getUserData($orderingData["user_id"]);

        $setProfileParam["total_payment"] = $userData["total_payment"] + $changePayTotal;
        $setProfileParam["update_datetime"] = $currentDateTime;

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
    }
}

$execMsgSessOBJ->exec_msg = array("更新しました。");

// コミット
$AdmOrderingOBJ->commitTransaction();

header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;
?>