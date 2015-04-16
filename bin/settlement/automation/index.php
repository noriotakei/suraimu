<?php
/**
 * index.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ZERO入金おまかせ戻り受け取り処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(dirname(__FILE__)))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// 決済共通ログ登録
// ディレクトリ確認
if (!is_dir(D_BASE_DIR . "/log/settlement/" . date("Ym"))) {
    if (!is_dir(D_BASE_DIR . "/log/settlement")) {
        mkdir(D_BASE_DIR . "/log/settlement");
    }
    mkdir(D_BASE_DIR . "/log/settlement/" . date("Ym"));
}
// 書き込み
$fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_BANK_AUTOMATION] . ".txt", "SJIS");
ComUtility::writeLog(urldecode($_SERVER["QUERY_STRING"]), $fileName);

/*
// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}
*/

$SendMailOBJ = SendMail::getInstance();
$OrderingOBJ = Ordering::getInstance();
$UserOBJ = User::getInstance();
$SettlementBankOBJ = SettlementBank::getInstance();

// パラメーター受け取り
$param["clientip"]         = $requestOBJ->getParameter("clientip");
$param["money"]         = $requestOBJ->getParameter("money");
$param["status"]     = $requestOBJ->getParameter("status");
$param["payment"]     = $requestOBJ->getParameter("payment");
$param["order_no"]     = $requestOBJ->getParameter("order_no");
$param["tracking_no"]     = $requestOBJ->getParameter("tracking_no");
$orderingId    = $requestOBJ->getParameter("sendpoint");
$userId      = $requestOBJ->getParameter("sendid");

// メール送信文言作成
$mailElements["text_body"][] = "ユーザーID:" . $userId;
$mailElements["text_body"][] = "注文ID:" . $orderingId;
$mailElements["text_body"][] = "振り込み金額:" . $param["money"] . "円";
$mailElements["text_body"][] = "ゼロ発行のオーダーナンバー:" . $param["order_no"];
$mailElements["text_body"][] = "ゼロ発行の振込用受付番号:" . $param["tracking_no"];
$mailElements["text_body"][] = "振込結果コード:" . $param["status"];
$mailElements["text_body"][] = "ゼロからの支払い有無コード:" . $param["payment"];

if (!(intval($param["status"]) == 3 AND intval($param["payment"]) == 1)) {
    //支払い対象の時のみお知らせ
    if(intval($param["payment"]) == 1){
        // 異常決済処理
        $mailElements["subject"] = "入金おまかせ決済NG";
        $mailElements["text_body"][] = "ZEROより入金おまかせ決済NGの結果が返ってきました。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);
    }

    print("NG");
    exit();

} else {
    // 正常決済処理
    if (!is_numeric($param["money"]) OR $param["money"] <= 0) {
        $mailElements["subject"] = "入金おまかせ金額のエラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";

        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);
        print("NG");
        exit;
    }

    // 注文情報の取得
    if (!$orderingData = $OrderingOBJ->getOrderingData($orderingId, $userId)) {
        $mailElements["subject"] = "入金おまかせ注文データの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("NG");
        exit;
    }

    // ユーザーデータの取得
    if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
        $mailElements["subject"] = "入金おまかせユーザーデータの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("NG");
        exit;
    }

    // エラー文言
    $param["errMsg"][] = "振り込み金額:" . $param["money"] . "円";

    // トランザクション開始
    $SettlementBankOBJ->beginTransaction();

    // 決済処理
    if (!$SettlementBankOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_BANK_AUTOMATION, $param)) {
        // ロールバック
        $SettlementBankOBJ->rollbackTransaction();
        print("NG");
        exit;
    }

    // コミット
    $SettlementBankOBJ->commitTransaction();
    print("successok");
    exit();

}
?>