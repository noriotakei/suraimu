<?php
/**
 * settleRakutenManualPaymentExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 楽天銀行振り込み一括完済処理処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

/*
// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}
*/

$SendMailOBJ = SendMail::getInstance();
$OrderingOBJ = Ordering::getInstance();
$UserOBJ = User::getInstance();
$SettlementOBJ = Settlement::getInstance();

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "ordering_id",
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// 初期化
$result = "";
$orderingId = "";

// 注文ID
$orderingId = $param["ordering_id"];

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromOrderId($orderingId)) {
    $execMsgSessOBJ->exec_msg = array("注文データの取得エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// ユーザーデータの取得
if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
    $execMsgSessOBJ->exec_msg = array("ユーザーデータの取得エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// パラメーター設定
$param["money"] = $orderingData["pay_total"];

// メール送信文言作成
$mailElements["text_body"][] = "管理一括手動完済エラー";

// エラー文言
$param["errMsg"] = $mailElements["text_body"];

// トランザクション開始
$SettlementOBJ->beginTransaction();
// 決済処理
if (!$SettlementOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_BANK_RAKUTEN, $param)) {
    // ロールバック
    $SettlementOBJ->rollbackTransaction();

    $execMsgSessOBJ->exec_msg = array("手動一括完済処理エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// コミット
$SettlementOBJ->commitTransaction();

$execMsgSessOBJ->exec_msg = array("手動一括完済処理が完了しました");
header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;

?>