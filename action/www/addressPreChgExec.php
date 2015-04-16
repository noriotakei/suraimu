<?php
/**
 * addressPreChgExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後メアド仮変更処理ファイル。
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

// 登録アドレスドメインのチェック
if ($param["pc_mail_domain"]) {
    if (!$UserOBJ->chkRegistUserAddressDomain($param["pc_mail_domain"])) {
        // NGドメインなのでさようなら
        header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

if ($param["pc_mail_account"] AND $param["pc_mail_domain"]) {
    $param["pc_mail_address"] = $param["pc_mail_account"] . "@" . $param["pc_mail_domain"];
}
if ($param["mb_mail_account"] AND $param["mb_mail_domain"]) {
    $param["mb_mail_address"] = $param["mb_mail_account"] . "@" . $param["mb_mail_domain"];
}


$validationOBJ = new ComArrayValidation($param);

if ($param["pc_mail_address"]) {
    $validationOBJ->check("pc_mail_address", "メールアドレス",
                array("MailAddress" => null));
}

if ($param["mb_mail_address"]) {
    $validationOBJ->check("mb_mail_address", "携帯メールアドレス",
                array("MobileAddress" => null));
}

if (!$param["pc_mail_address"] AND !$param["mb_mail_address"]) {
    $validationOBJ->setErrorMessage("no_address", "メールアドレスを入力してください。");
}

//-20110217-takuro vodafone,softbank以外の携帯アドレス大文字混入阻止
if($param["mb_mail_domain"]){

    if( !strstr($param["mb_mail_domain"],"softbank.ne.jp") && !strstr($param["mb_mail_domain"],"vodafone.ne.jp") ){
        if(preg_match("/[A-Z]/s", $param["mb_mail_account"])){
            $validationOBJ->setErrorMessage("no_address", "携帯アドレスは半角英数字で入力して下さい。");
        }
    }

}

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$mailAddress = $param["pc_mail_address"] ? $param["pc_mail_address"] : $param["mb_mail_address"];

// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
    $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress);
}
// 重複メアドがあった場合
if ($duplicateUserData) {
    $errSessOBJ->errMsg[] = "メールアドレスはすでに登録済みです。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
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
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("mail_change", "mail_change", $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"]);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信ができませんでした。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_AddressPreChgComp=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit();



?>
