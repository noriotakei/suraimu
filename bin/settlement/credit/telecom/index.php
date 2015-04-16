<?php
/**
 * index.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * クレジット戻り受け取り処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(dirname(dirname(__FILE__))))));

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
$fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_TELECOM] . ".txt", "SJIS");
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
$SettlementTelecomOBJ = SettlementTelecom::getInstance();

// パラメーター受け取り
$param["clientip"]         = $requestOBJ->getParameter("clientip");
$param["money"]         = $requestOBJ->getParameter("money");
$param["telecom_certify_phone_number"]  = $requestOBJ->getParameter("telno");
$orderingId    = $requestOBJ->getParameter("sendpoint");
$userId      = $requestOBJ->getParameter("sendid");
$result         = $requestOBJ->getParameter("rel");

// メール送信文言作成
$mailElements["text_body"][] = "注文ID:" . $orderingId;
$mailElements["text_body"][] = "入金額:" . $param["money"] . "円";

$result = strtoupper($result);

// YESなら正常決済処理
if ($result != "YES") {
    // 異常決済処理
    $mailElements["subject"] = "テレコムクレジット決済NG";
    $mailElements["text_body"][] = "テレコムクレジット決済NGの結果が返ってきました。";

    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);

    print("SuccessOK");
    exit();

} else {
    // 正常決済処理
    if (!is_numeric($param["money"]) OR $param["money"] <= 0) {
        $mailElements["subject"] = "クレジット金額のエラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";

        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);
        print("SuccessOK");
        exit;
    }

    // 注文情報の取得
    if (!$orderingData = $OrderingOBJ->getOrderingData($orderingId, $userId)) {
        $mailElements["subject"] = "クレジット注文データの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("SuccessOK");
        exit;
    }

    // ユーザーデータの取得
    if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
        $mailElements["subject"] = "クレジットユーザーデータの取得エラー";
        $mailElements["text_body"][] = "手動で対応して下さい。";
        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
        // システムにエラーメール
        $SendMailOBJ->debugMailTo($mailElements);
        // 運営にエラーメール
        $SendMailOBJ->operationMailTo($mailElements);

        print("SuccessOK");
        exit;
    }


    // エラー文言
    $param["errMsg"][] = "入金額:" . $param["money"] . "円";

    // トランザクション開始
    $SettlementTelecomOBJ->beginTransaction();
    // 決済処理
    if (!$SettlementTelecomOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_TELECOM, $param)) {
        // ロールバック
        $SettlementTelecomOBJ->rollbackTransaction();
        print("SuccessOK");
        exit;
    }

    // コミット
    $SettlementTelecomOBJ->commitTransaction();
    print("SuccessOK");
    exit();

}
?>