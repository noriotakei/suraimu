<?php
/**
 * settleBankManualPaymentExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ZERO銀行振り込み戻り受け取り処理ファイル。
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
    $execMsgSessOBJ->exec_msg = array("BAS注文データの取得エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// ユーザーデータの取得
if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
    $execMsgSessOBJ->exec_msg = array("BASユーザーデータの取得エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// パラメーター設定
$param["money"] = $orderingData["pay_total"];

// telnoを整形（10桁）
$telnoLen = strlen($orderingData["id"]); // 3桁
if (strlen($orderingId) < 10) {
    for ($i=$telnoLen;$i<10;$i++) {
        $addZero .= "0";
    }
}

// パラメータセット
$param["telno"]       = $addZero . $orderingData["id"];
$param["bank_name"]   = "カンリ";
$param["branch_name"] = "カンリ";

// 振込口座番号生成
$fKoza = SettlementBank::ACCOUNT_NUMBER;
$param["fkoza"] = ereg_replace('[^0-9]', '', $fKoza);

// バスログ登録
$SettlementBankOBJ = SettlementBank::getInstance();

$basLogInsertArray = array();
$basLogInsertArray["receive_money"] = $param["money"];
$basLogInsertArray["telno"] = $param["telno"];
$basLogInsertArray["bank_name"] = $param["bank_name"];
$basLogInsertArray["branch_name"] = $param["branch_name"];
$basLogInsertArray["fkoza"] = $param["fkoza"];
$basLogInsertArray["is_manual"] = 1;
$basLogInsertArray["create_datetime"] = date("YmdHis");

if (!$SettlementBankOBJ->insertBasLogData($basLogInsertArray)) {
    $execMsgSessOBJ->exec_msg = array("BASログ登録エラー");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
} else {
    $param["bas_log_id"] = $SettlementBankOBJ->getInsertId();
}

// メール送信文言作成
$mailElements["text_body"][] = "振り込み者名義:" . $param["telno"]; // telno
$mailElements["text_body"][] = "振り込み金額:" . $param["money"] . "円"; // 金額
$mailElements["text_body"][] = "振り込み元銀行名:" . $param["bank_name"]; // 銀行名
$mailElements["text_body"][] = "振り込み元支店名:" . $param["branch_name"]; // 支店店名
$mailElements["text_body"][] = "振り込み先口座番号:" . $param["fkoza"]; // 振込先口座番号

// エラー文言
$param["errMsg"] = $mailElements["text_body"];

// トランザクション開始
$SettlementOBJ->beginTransaction();
// 決済処理
if (!$SettlementOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_BANK_AUTOMATIONBAS, $param)) {
    // ロールバック
    $SettlementOBJ->rollbackTransaction();

    $execMsgSessOBJ->exec_msg = array("手動一括完済処理エラー", "個別手動で対応して下さい。");
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// コミット
$SettlementOBJ->commitTransaction();

// 決済共通ログ登録（決済処理がOKでもNGでもこのログは作成）
// ディレクトリ確認
if (!is_dir(D_BASE_DIR . "/log/settlement/" . date("Ym"))) {
    if (!is_dir(D_BASE_DIR . "/log/settlement")) {
        mkdir(D_BASE_DIR . "/log/settlement");
    }
    mkdir(D_BASE_DIR . "/log/settlement/" . date("Ym"));
}
// 書き込み
$fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_BANK_AUTOMATIONBAS] . ".txt", "SJIS");
$writeString = "admin_id=" . $loginAdminData["id"]   // 手動対応管理者ID
             . "&telno=" . $param["telno"]           // 注文ID(10桁)
             . "&money=" . $param["money"]           // 購入金額（支払い金額）
             . "&bankname=" . $param["bank_name"]    // 振込み銀行名（手動なので「カンリ」で固定）
             . "&sitenname=" . $param["branch_name"] // 振込み支店名（手動なので「カンリ」で固定）
             . "&fkoza=" . $param["fkoza"];          // 振込口座番号（手動なので「0137526」で固定）

ComUtility::writeLog($writeString, $fileName);

$execMsgSessOBJ->exec_msg = array("手動一括完済処理が完了しました");
header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;

?>