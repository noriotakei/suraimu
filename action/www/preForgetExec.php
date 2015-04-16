<?php
/**
 * preForgetExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCＩＤ・PASS忘れ処理ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");

$errSessOBJ = new ComSessionNamespace("err_msg");
$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$param["mail_address"] = $param["mail_account"] . "@" . $param["mail_domain"];

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("mail_address", "メールアドレス",
                array("MailAddress" => null));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_PreForget=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$userData = $UserOBJ->getUserDataFromMailAddress($param["mail_address"]);
if (!$userData) {
    $errSessOBJ->errMsg[] = "該当するメールアドレスがありません";
    header("Location: ./?action_PreForget=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$ComUtilityOBJ = ComUtility::getInstance();

// userデータに新パスワードを登録
$password = ComUtility::getRamdomNumber(4);

$updateUserData = array(
    "password"            => $UserOBJ->createPasswordKey($password),
    "update_datetime" => date("YmdHis"),
);

if (!$UserOBJ->updateUserData($updateUserData, array("id=" . $userData["user_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    header("Location: ./?action_PreForget=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

$convAry = array("-%password-" => $password);

// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("forget", "forget_complete", $param["mail_address"]);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"], $convAry);
// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信できませんでした。";
    header("Location: ./?action_PreForget=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_PreForgetComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;
?>
