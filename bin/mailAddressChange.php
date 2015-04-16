<?php
/**
 * mailAddressChange.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * メールアドレス変更処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}

// 標準入力からメール情報を取得し、解析する
$ComMimeParserMailOBJ    = ComMimeParserMail::getInstance();
$UserOBJ = User::getInstance();
$MailAddressChangeOBJ = MailAddressChange::getInstance();

// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

$headers = $ComMimeParserMailOBJ->getHeaders();

// 携帯メールアドレスである
if (ComValidation::isMobileAddress($headers["from"])) {
    $mbFlag = true;
}
// 送信元メアドの取得
$mailAddress = $headers["from"];
// ---<初期チェック>
// 以下の情報が無ければ抜ける
if (!$mailAddress AND !ComValidation::isMailAddress($mailAddress)) {
    exit();
}

// 識別キーの取得
$matches = array();

if (preg_match("/^adch-([0-9a-f]+)@.*/", $headers["to"], $matches)) {
    $remailKey = $matches[1];
}
if (!$remailKey) {
    exit();
}

// メアドの重複チェック
$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress);

// 重複メアドがあった場合
if ($duplicateUserData) {

    // リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("mail_change", "registed", $mailAddress);

    // メアド重複登録メール送信
    $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $duplicateUserData["user_id"]);
    // メール送信
    $AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
    exit();
}

$userData = $UserOBJ->getUserDataFromRemailKey($remailKey);
if (!$userData) {
    exit();
}


$mailChangeAry = array(
    "user_id"          => $userData["user_id"],
    "mail_address"  => $mailAddress,
    "create_datetime" => date("YmdHis"),
);

// mail_address_changeテーブルへのインサート処理
if (!$MailAddressChangeOBJ->insertMailAddressChangeData($mailChangeAry)) {
    exit();
}

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("mail_change", "mail_change", $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"]);
// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    exit();
}

exit("COMPLETE");
?>
