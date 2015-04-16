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
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$UserOBJ = User::getInstance();
$QuitRequestOBJ = QuitRequest::getInstance();

if ($comUserDataId AND $QuitRequestOBJ->getQuitRequestData($comUserDataId)) {

    // トランザクション開始
    $UserOBJ->beginTransaction();

    // 退会申請情報を更新
    $updateQuitArray["disable"] = 1;

    if (!$QuitRequestOBJ->updateQuitRequestData($updateQuitArray, array("user_id = " . $comUserDataId))) {
        // ロールバック
        $UserOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "退会情報更新処理ができませんでした。<br />お手数ですが<a href=\"mailto:" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "\">" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "</a>までご連絡下さい。<br>";
        header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    // ユーザー情報を更新
    $updateUserArray["regist_status"] = $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"];
    $updateUserArray["quit_datetime"] = date("YmdHis");
    $updateUserArray["update_datetime"] = date("YmdHis");

    if (!$UserOBJ->updateUserData($updateUserArray, array("id = " . $comUserDataId))) {
        // ロールバック
        $UserOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "退会情報更新処理ができませんでした。<br />お手数ですが<a href=\"mailto:" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . ">" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "</a>までご連絡下さい。<br>";
        header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    // コミット
    $UserOBJ->commitTransaction();
    header("Location: ./?action_TaikaiEnd=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
} else {
    $errSessOBJ->errMsg[] = "退会申請データがありません。";
    header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}
?>
