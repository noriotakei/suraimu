<?php
/**
 * taikaiExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後退会仮処理ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$UserOBJ = User::getInstance();

// ユーザー情報を更新
$updateUserArray["regist_status"] = $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"];
$updateUserArray["quit_datetime"] = date("YmdHis");
$updateUserArray["update_datetime"] = date("YmdHis");

if (!$UserOBJ->updateUserData($updateUserArray, array("id = " . $comUserDataId))) {
    $errSessOBJ->errMsg[] = "退会情報更新処理ができませんでした。<br />お手数ですが<a href=\"mailto:" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . ">" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "</a>までご連絡下さい。<br>";
    header("Location: ./?action_TaikaiChk=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

header("Location: ./?action_TaikaiEnd=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit;
?>
