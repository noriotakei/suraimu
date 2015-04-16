<?php
/**
 * customerExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後お問い合わせ送信処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$SendMailOBJ = AutoMail::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();
$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$param["mail_address"] = $param["mail_account"] . "@" . $param["mail_domain"];

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("mail_address", "メールアドレス",
                array("MailAddress" => null));

$validationOBJ->check("message", "お問い合わせ内容",
                array("Value" => null));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Customer=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 運営にメール送信
$mailElements["from_address"] = $param["mail_address"];
$mailElements["return_path"] = $param["mail_address"];
$mailElements["subject"] = "PC側お問い合わせ";
$mailElements["text_body"] = $param["message"];
$mailElements["to_address"] = SendMail::OPERATION_MAIL_ACCOUNT . $_config["define"]["MAIL_DOMAIN"];

$SendMailOBJ->mailTo($mailElements);

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_CustomerComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit();



?>
