<?php
/**
 * index.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ZERO銀行振り込み戻り受け取り処理ファイル。
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
$fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_BANK_AUTOMATIONBAS] . ".txt", "SJIS");
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
$SettlementOBJ = Settlement::getInstance();

// パラメーター受け取り
$param["telno"]         = $requestOBJ->getParameter("telno");
$param["money"]         = $requestOBJ->getParameter("money");
$param["bank_name"]      = $requestOBJ->getParameter("bankname");
$param["branch_name"]     = $requestOBJ->getParameter("sitenname");
$param["fkoza"]     = $requestOBJ->getParameter("fkoza");

// SJISで来るため変換
$param["telno"] = mb_convert_encoding($param["telno"], "UTF-8", "auto");
$param["bank_name"]  = mb_convert_encoding($param["bank_name"], "UTF-8", "auto");
$param["branch_name"] = mb_convert_encoding($param["branch_name"], "UTF-8", "auto");
$param["fkoza"] = mb_convert_encoding($param["fkoza"], "UTF-8", "auto");

// メール送信文言作成
$mailElements["text_body"][] = "振り込み者名義:" . $param["telno"];
$mailElements["text_body"][] = "振り込み金額:" . $param["money"] . "円";
$mailElements["text_body"][] = "振り込み元銀行名:" . $param["bank_name"];
$mailElements["text_body"][] = "振り込み元支店名:" . $param["branch_name"];
$mailElements["text_body"][] = "振り込み先口座番号:" . $param["fkoza"];

// バスログ登録
$SettlementBankOBJ = SettlementBank::getInstance();

$basLogInsertArray = array();
$basLogInsertArray["receive_money"] = $param["money"];
$basLogInsertArray["telno"] = $param["telno"];
$basLogInsertArray["bank_name"] = $param["bank_name"];
$basLogInsertArray["branch_name"] = $param["branch_name"];
$basLogInsertArray["fkoza"] = $param["fkoza"];
$basLogInsertArray["create_datetime"] = date("YmdHis");

// 登録できなくても進む
if (!$SettlementBankOBJ->insertBasLogData($basLogInsertArray)) {
    $mailElements["subject"] = "BASログ登録エラー";
    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);
} else {
    $param["bas_log_id"] = $SettlementBankOBJ->getInsertId();
}


if (!is_numeric($param["money"]) OR $param["money"] <= 0) {
    $mailElements["subject"] = "BAS金額のエラー";
    $mailElements["text_body"][] = "手動で対応して下さい。";

    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);
    print("NG");
    exit;
}

//telnoを整形
$param["telno"] = ereg_replace("[^0-9]","",$param["telno"]);

$telnoLen = strlen($param["telno"]);
for($i = 0; $i < $telnoLen; $i++ ){
    if(substr($param["telno"] ,0 , 1) == "0"){
        //これいるのかな？？
        $addzero .= "0";
        $param["telno"] = substr($param["telno"] ,1);
    }
    if(substr($param["telno"] ,0 , 1) != "0"){
        break;
    }
}

$telnoLen = strlen($param["telno"]);
//0を取っても8桁以上ある場合はユーザIDが2つ並んでいるの可能性があるため分割
//注意 → ユーザIDが8桁以上になると障害となる可能性あり
if($telnoLen >= 8){
    $tmpUserId = substr($param["telno"],0,$telnoLen/2);
    if(ereg("(".$tmpUserId."){2}",$param["telno"])){
        $param["telno"] = $tmpUserId;
    }
}

//数値以外削除
$orderingId    = intval($param["telno"] );
$orderingIdLen = strlen($orderingId);

//注意 → 注文IDが10桁より大きいと障害となる可能性あり
if($orderingIdLen > 10){
    $mailElements["subject"] = "BAS注文IDのエラー";
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
if (!$orderingData = $OrderingOBJ->getOrderingDataFromOrderId($orderingId)) {
    $mailElements["subject"] = "BAS注文データの取得エラー";
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
    $mailElements["subject"] = "BASユーザーデータの取得エラー";
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
$param["errMsg"] = $mailElements["text_body"];

// トランザクション開始
$SettlementOBJ->beginTransaction();
// 決済処理
if (!$SettlementOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_BANK_AUTOMATIONBAS, $param)) {
    // ロールバック
    $SettlementOBJ->rollbackTransaction();
    print("NG");
    exit;
}

// コミット
$SettlementOBJ->commitTransaction();
print("successok");
exit();
?>