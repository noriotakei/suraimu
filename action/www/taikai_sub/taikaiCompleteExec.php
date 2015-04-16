<?php
/**
 * taikaiCompleteExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後退会仮処理ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$mailAddress = $param["mail_account"] . "@" . $param["mail_domain"];

if ($param["login_id"] != $comUserData["login_id"]) {
    $errFlag = true;
}

if ($UserOBJ->createPasswordKey($param["password"]) != $comUserData["password"]) {
    $errFlag = true;
}

if (!ComValidation::isMailAddress($mailAddress)) {
    $errFlag = true;
}

if ((!ComValidation::isNumeric($param["q1"]) OR ($param["q1"] == 1 AND !ComValidation::isNumeric($param["q6"])))
        OR (!ComValidation::isNumeric($param["q2"]) OR ($param["q2"] == 1 AND !ComValidation::isNumeric($param["q7"])))
        OR (!ComValidation::isNumeric($param["q3"]) OR ($param["q3"] == 1 AND !ComValidation::isNumeric($param["q8"])))
        OR (!ComValidation::isNumeric($param["q4"]) OR ($param["q4"] == 1 AND !ComValidation::isNumeric($param["q9"])))
        OR (!ComValidation::isNumeric($param["q5"]) OR ($param["q5"] == 1 AND !$param["q10"]))
        ) {
    $errFlag = true;
}

if ($errFlag) {
    $errSessOBJ->errMsg[] = "必須項目に入力漏れがあります";
    header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$QuitRequestOBJ = QuitRequest::getInstance();

if (!$QuitRequestOBJ->getQuitRequestData($comUserDataId)) {
    // 退会申請情報をインサート
    $insertArray["user_id"] = $comUserDataId;
    $insertArray["create_datetime"] = date("YmdHis");

    if (!$QuitRequestOBJ->insertQuitRequestData($insertArray)) {
        $errSessOBJ->errMsg[] = "退会申請情報処理ができませんでした。";
        header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("quit", "quit_complete", $mailAddressMB);
$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserDataId);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信できませんでした。";
    header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

header("Location: ./?action_TaikaiComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;
?>
