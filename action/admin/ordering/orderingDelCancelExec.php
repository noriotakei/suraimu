<?php
/**
 * orderingDelCancelExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文情報キャンセル復帰処理ページファイル。
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

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();


$changeItemList = $AdmOrderChangeLogOBJ->getChangeItemList($param["ordering_id"]);
foreach ((array)$changeItemList as $val) {

    $orderingChangeLogArray = null;

    // 注文変更ログの削除
    $orderingChangeLogArray["disable"] = 1;
    $orderingChangeLogArray["create_datetime"] = date("YmdHis");

    if (!$AdmOrderChangeLogOBJ->updateOrderingChangeLogData($orderingChangeLogArray, array("id = " . $val["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

}

// 全注文詳細リストの取得
$orderingDetailList = $AdmOrderingOBJ->getAllOrderingDetailList($param["ordering_id"]);
foreach ((array)$orderingDetailList as $val) {

    $orderingDetailArray = null;

    $orderingDetailArray["is_cancel"] = 0;
    $orderingDetailArray["disable"] = 0;
    $orderingDetailArray["update_datetime"] = date("YmdHis");

    // 注文詳細データ更新
    if (!$AdmOrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $val["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $payTotal += $val["price"];
}

$orderingArray["is_cancel"] = 0;
$orderingArray["pay_total"] = $payTotal;
$orderingArray["cancel_datetime"] = "";
$orderingArray["update_datetime"] = date("YmdHis");
// 注文データ更新
if (!$AdmOrderingOBJ->updateOrderingData($orderingArray, array("id = " . $param["ordering_id"]))) {
    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
    // ロールバック
    $AdmOrderingOBJ->rollbackTransaction();
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// 入金ログの更新
if ($paymentData) {
    $paymentArray["is_cancel"] = 0;
    if (!$AdmPaymentLogOBJ->updatePaymentLogData($paymentArray, array("id = " . $paymentData["id"]))) {
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }
}
$userData = $AdminUserOBJ->getUserData($orderingData["user_id"]);

$userProfileWhere = "";
$setProfileData = "";

$setProfileData["cancel_count"] = $userData["cancel_count"] - 1;
$setProfileData["update_datetime"] = date("YmdHis");
// 入金済みで決済完了もしくは余り金完了であれば購入回数を上げる
if ($orderingData["is_paid"] AND ($orderingData["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $orderingData["status"] == AdmOrdering::ORDERING_STATUS_REST)) {
    $setProfileData["buy_count"] = $userData["buy_count"] + 1;
    $setProfileData["total_payment"] = $userData["total_payment"] + $payTotal;
    if (!ComValidation::isDateTime($userData["first_pay_datetime"])) {
        $setProfileData["first_pay_datetime"] = date("YmdHis");
        $execMsgSessOBJ->first_pay_msg = array("初回入金日が変更されました。<br>");
    }
}

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
$execMsgSessOBJ->exec_msg = array("キャンセルを取りやめました。", "ポイントの加算があれば、ユーザー情報で行ってください。");
header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;


?>

