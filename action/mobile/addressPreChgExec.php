<?php
/**
 * addressPreChgExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後メアド仮変更処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$MailAddressChangeOBJ = MailAddressChange::getInstance();
$AutoMailOBJ = AutoMail::getInstance();
$UserOBJ = User::getInstance();

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("pc_mail_address", "メールアドレス",
            array("MailAddress" => null));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$mailAddress = $param["pc_mail_address"];

// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
    $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress);
}
// 重複メアドがあった場合
if ($duplicateUserData) {
    $errSessOBJ->errMsg[] = "メールアドレスはすでに登録済みです。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$mailChangeAry = array(
    "user_id"          => $comUserData["user_id"],
    "mail_address"  => $mailAddress,
    "create_datetime" => date("YmdHis"),
);

// mail_address_changeテーブルへのインサート処理
if (!$MailAddressChangeOBJ->insertMailAddressChangeData($mailChangeAry)) {
    $errSessOBJ->errMsg = $UserOBJ->getErrorMsg();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("mail_change", "mail_change", $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"]);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信ができませんでした。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_AddressPreChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit();
?>
