<?php
/**
 * index.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * CCHECK戻り受け取り処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
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
$fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_CCHECK] . ".txt", "SJIS");
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
$SettlementCcheckOBJ = SettlementCcheck::getInstance();

// パラメーター受け取り
$param["seq"]  = $requestOBJ->getParameter("SEQ");
$param["date"] = $requestOBJ->getParameter("DATE");
$param["time"] = $requestOBJ->getParameter("TIME");
$param["sid"]  = $requestOBJ->getParameter("SID");
$param["money"]= $requestOBJ->getParameter("KINGAKU");
$param["fuka"] = $requestOBJ->getParameter("FUKA");

//未決済の申込データ取得
if (!$ccheckData = $SettlementCcheckOBJ->getNoPaidCcheckData($param["sid"])) {
    if ($ccheckData = $SettlementCcheckOBJ->getCcheckDataFromSid($param["sid"])) {
        $mailElements["subject"] = "未決済C-checkデータの取得エラー";
        $mailElements["text_body"][] = "ユーザーID:" . $ccheckData["user_id"];
        $mailElements["text_body"][] = "注文ID:" . $ccheckData["ordering_id"];
        $mailElements["text_body"][] = "入金額:" . $param["money"] . "円";
        $mailElements["text_body"][] = "確認後手動で対応して下さい。";
    } else {
        // 異常決済処理
        $mailElements["subject"] = "未決済C-checkデータの取得エラー";
        $mailElements["text_body"][] = "C-checkデータがありません。";
        $mailElements["text_body"][] = "手動で対応して下さい。";
    }

    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);

    print("0");
    exit();

} else {

    // メール送信文言作成
    $mailElements["text_body"][] = "ユーザーID:" . $ccheckData["user_id"];
    $mailElements["text_body"][] = "注文ID:" . $ccheckData["ordering_id"];
    $mailElements["text_body"][] = "入金額:" . $param["money"] . "円";

    // 正常決済処理
    if (!is_numeric($param["money"]) OR $param["money"] <= 0) {
        $mailElements["subject"] = "C-check金額のエラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";

        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);
        print("0");
        exit();
    }

    // 注文情報の取得
    if (!$orderingData = $OrderingOBJ->getOrderingData($ccheckData["ordering_id"], $ccheckData["user_id"])) {
        $mailElements["subject"] = "C-check注文データの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("0");
        exit();
    }

    // ユーザーデータの取得
    if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
        $mailElements["subject"] = "C-checkユーザーデータの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("0");
        exit();
    }

    // パラメータ設定
    $param["ccheck_id"] = $ccheckData["id"];
    // エラー文言
    $param["errMsg"][] = "入金額:" . $param["money"] . "円";

    // トランザクション開始
    $SettlementCcheckOBJ->beginTransaction();
    // 決済処理
    if (!$SettlementCcheckOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_CCHECK, $param)) {
        // ロールバック
        $SettlementCcheckOBJ->rollbackTransaction();
        print("0");
        exit();
    }

    // コミット
    $SettlementCcheckOBJ->commitTransaction();
    print("0");
    exit();

}
?>