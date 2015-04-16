<?php
/**
 * orderingDelExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文情報キャンセル処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);
$paymentData = $AdmPaymentLogOBJ->getPaymentLogData($param["ordering_id"]);

$tags = array(
            "ordering_id",
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$orderingArray = null;

// 削除ならdisableを立てる
if ($param["is_delete"]) {
    $orderingArray["disable"] = 1;
} else {
    $orderingArray["is_cancel"] = 1;
}

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

$orderingArray["pay_total"] = 0;
$orderingArray["cancel_datetime"] = date("YmdHis");
$orderingArray["update_datetime"] = date("YmdHis");
// 注文データ更新
if (!$AdmOrderingOBJ->updateOrderingData($orderingArray, array("id = " . $param["ordering_id"]))) {
    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
    // ロールバック
    $AdmOrderingOBJ->rollbackTransaction();
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

$orderingDetailList = $AdmOrderingOBJ->getOrderingDetailList($param["ordering_id"]);

foreach ((array)$orderingDetailList as $val) {

    // 注文詳細をキャンセルログに登録する
    if (!$param["is_delete"]) {
        $orderingChangeLogArray = null;

        // 変更時ステータスの取得
        if ($orderingData["is_paid"]) {
            $status = AdmOrderChangeLog::STATUS_PAID;
        } else {
            $status = AdmOrderChangeLog::STATUS_NOT_PAID;
        }

        // 注文変更ログ登録
        $orderingChangeLogArray["ordering_id"] = $param["ordering_id"];
        $orderingChangeLogArray["item_id"] = $val["item_id"];
        $orderingChangeLogArray["price"] = (0 - $val["price"]);
        $orderingChangeLogArray["status"] = $status;
        $orderingChangeLogArray["create_datetime"] = date("YmdHis");

        if (!$AdmOrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
            $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
            exit;
        }

    }

    $orderingDetailArray = null;

    if (!$param["is_delete"]) {
        $orderingDetailArray["is_cancel"] = 1;
    } else {
        $orderingDetailArray["disable"] = 1;
    }
    $orderingDetailArray["update_datetime"] = date("YmdHis");

    // 注文詳細データ更新
    if (!$AdmOrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $val["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }
}

$userData = $AdminUserOBJ->getUserData($orderingData["user_id"]);

// 入金ログ削除
if ($paymentData) {
    if ($param["is_delete"]) {
        $paymentArray["disable"] = 1;
    } else {
        $paymentArray["is_cancel"] = 1;
    }
    if (!$AdmPaymentLogOBJ->updatePaymentLogData($paymentArray, array("id = " . $paymentData["id"]))) {
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $setProfileData = "";
    $setProfileParam["update_datetime"] = date("YmdHis");
    // 入金済みで決済完了もしくは余り金完了であれば購入回数を下げる
    if ($orderingData["is_paid"] AND ($orderingData["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $orderingData["status"] == AdmOrdering::ORDERING_STATUS_REST)) {
        $setProfileParam["buy_count"] = $userData["buy_count"] - 1;
        $setProfileParam["total_payment"] = $userData["total_payment"] - $orderingData["pay_total"];
        if ($setProfileParam["buy_count"] == 0) {
            $setProfileParam["first_pay_datetime"] = "";
            $execMsgSessOBJ->first_pay_msg = array("初回入金日が初期化されました。<br>");
        }
    }

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

// 削除でなければキャンセル
if (!$param["is_delete"]) {

    $userProfileWhere = "";
    $setProfileData = "";

    $setProfileData["cancel_count"] = $userData["cancel_count"] + 1;
    $setProfileData["update_datetime"] = date("YmdHis");

    $userProfileWhere[] = "user_id = " . $orderingData["user_id"];
    // ユーザーデータに登録
    if(!$AdminUserOBJ->updateProfileData($setProfileData, $userProfileWhere)) {
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        $execMsgSessOBJ->exec_msg = $adminUserOBJ->getErrorMsg();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    // コミット
    $AdmOrderingOBJ->commitTransaction();
    $execMsgSessOBJ->exec_msg = array("キャンセルしました。", "ポイントの減算があれば、ユーザー情報で行ってください。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;

} else {

    // コミット
    $AdmOrderingOBJ->commitTransaction();
    $execMsgSessOBJ->exec_msg = array("削除しました。", "ポイントの減算があれば、ユーザー情報で行ってください。");
    header("location: ./?action_ordering_OrderingSearchList=1&" . $URLparam);
    exit;

}


?>

