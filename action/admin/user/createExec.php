<?php

/**
 * createExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報詳細登録処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$UserOBJ = User::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err");
$execMsgSessOBJ = new ComSessionNamespace("execMsg");
$returnSessOBJ = new ComSessionNamespace("return");

// 登録ステータス
if (!ComValidation::isValue($param["regist_status"])) {
    $errMsg[] = "登録ステータスを選択してください";
}

// 危険人物フラグ
if (!ComValidation::isNumeric($param["danger_status"])) {
    $errMsg[] = "危険人物フラグを選択してください";
}

// PCﾒｰﾙｱﾄﾞﾚｽ
if (ComValidation::isValue($param["pc_address"]) AND !ComValidation::isMailAddress($param["pc_address"])) {
    $errMsg[] = "PCﾒｰﾙｱﾄﾞﾚｽが正しくありません";
//} else if ($AdminUserOBJ->chkUserDataFromPcMailAddress($param["pc_address"])) {
//    $errMsg[] = "PCﾒｰﾙｱﾄﾞﾚｽが重複しています";
}

// PCｱﾄﾞﾚｽｽﾃ-ﾀｽ
if (!ComValidation::isNumeric($param["pc_address_status"])) {
    $errMsg[] = "PCｱﾄﾞﾚｽｽﾃ-ﾀｽを選択してください";
}

// PC送信ｽﾃ-ﾀｽ
if (!ComValidation::isNumeric($param["pc_send_status"])) {
    $errMsg[] = "PC送信ｽﾃ-ﾀｽを選択してください";
}

// PCﾒｰﾙ受信設定
if (!ComValidation::isNumeric($param["pc_is_mailmagazine"])) {
    $errMsg[] = "PCﾒｰﾙ受信設定を選択してください";
}

// MBﾒｰﾙｱﾄﾞﾚｽ
if (ComValidation::isValue($param["mb_address"]) AND !ComValidation::isMobileAddress($param["mb_address"])) {
     $errMsg[] = "MBﾒｰﾙｱﾄﾞﾚｽが正しくありません";
//} else if ($AdminUserOBJ->chkUserDataFromMbMailAddress($param["mb_address"])) {
//    $errMsg[] = "MBﾒｰﾙｱﾄﾞﾚｽが重複しています";
}

// MBｱﾄﾞﾚｽｽﾃｰﾀｽ
if (!ComValidation::isNumeric($param["mb_address_status"])) {
    $errMsg[] = "MBｱﾄﾞﾚｽｽﾃｰﾀｽを選択してください";
}

// MB送信ｽﾃ-ﾀｽ
if (!ComValidation::isNumeric($param["mb_send_status"])) {
    $errMsg[] = "MB送信ｽﾃ-ﾀｽを選択してください";
}

// MBﾒｰﾙ受信設定
if (!ComValidation::isNumeric($param["mb_is_mailmagazine"])) {
    $errMsg[] = "MBﾒｰﾙ受信設定を選択してください";
}

// 性別
if (!ComValidation::isNumeric($param["sex_cd"])) {
    $errMsg[] = "性別を選択してください";
}

if (!ComValidation::isValue($param["pc_address"]) AND !ComValidation::isValue($param["mb_address"])) {
    $errMsg[] = "ﾒｰﾙｱﾄﾞﾚｽがありません";
}

// PCﾒｰﾙ強行
if (!ComValidation::isNumeric($param["is_pc_reverse"])) {
    $errMsg[] = "PCﾒｰﾙ強行フラグを選択してください";
}

// MBﾒｰﾙ強行
if (!ComValidation::isNumeric($param["is_mb_reverse"])) {
    $errMsg[] = "MBﾒｰﾙ強行フラグを選択してください";
}


if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    $returnSessOBJ->return = $param;
    header("Location: ./?action_user_Create=1");
    exit;
}

$setUserParam["login_id"]         = $param["pc_address"] ? $param["pc_address"] : $param["mb_address"];
$setUserParam["password"]           = $UserOBJ->createPasswordKey(ComUtility::getRamdomNumber(4));
$setUserParam["admin_id"]           = $loginAdminData["id"];
$setUserParam["access_key"]         = $UserOBJ->getNewAccessKey(date("YmdHis"));
$setUserParam["remail_key"]         = $UserOBJ->getNewRemailKey(date("YmdHis"));
$setUserParam["pc_address"]         = $param["pc_address"];
$setUserParam["pc_address_status"]  = $param["pc_address_status"];
$setUserParam["pc_send_status"]     = $param["pc_send_status"];
$setUserParam["pc_user_agent"] = $_SERVER["HTTP_USER_AGENT"];
$setUserParam["pc_ip_address"] = $_SERVER["REMOTE_ADDR"];
$setUserParam["mb_address"]         = $param["mb_address"];
$setUserParam["mb_address_status"]  = $param["mb_address_status"];
$setUserParam["mb_send_status"]     = $param["mb_send_status"];
$setUserParam["regist_status"]      = $param["regist_status"];
$setUserParam["regist_page_id"]     = $param["regist_page_id"];
$setUserParam["description"]        = $param["description"];
$setUserParam["is_pc_reverse"]      = $param["is_pc_reverse"];
$setUserParam["is_mb_reverse"]      = $param["is_mb_reverse"];
$setUserParam["danger_status"]      = $param["danger_status"];
$setUserParam["media_cd"]           = $param["media_cd"];
$setUserParam["update_datetime"]    = date("YmdHis");

// 登録ステータスによって登録時間などを設定する
if ($param["regist_status"] == $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"]) {
    $setUserParam["pre_regist_datetime"] = date("YmdHis");
} else if ($param["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
    $setUserParam["pre_regist_datetime"] = date("YmdHis");
    $setUserParam["regist_datetime"] = date("YmdHis");
} else {
    $setUserParam["pre_regist_datetime"] = date("YmdHis");
    $setUserParam["regist_datetime"] = date("YmdHis");
    $setUserParam["quit_datetime"] = date("YmdHis");
}

if ($param["mb_address"]) {
    $setUserParam["mb_device_cd"] = $ComUtilityOBJ->getDeviceFromMailAddress($param["mb_address"]);
}

if ($param["pc_address"]) {
    $setUserParam["pc_device_cd"] = $_config["define"]["DEVICE_PC"];
}

$setProfileParam["pc_is_mailmagazine"]  = $param["pc_is_mailmagazine"];
$setProfileParam["mb_is_mailmagazine"]  = $param["mb_is_mailmagazine"];
$setProfileParam["sex_cd"]              = $param["sex_cd"];
$setProfileParam["update_datetime"]        = date("YmdHis");

// トランザクション開始
$AdminUserOBJ->beginTransaction();

if(!$AdminUserOBJ->insertUserData($setUserParam)) {
    $errMsg = array("登録できませんでした。");
    // ロールバック
    $AdminUserOBJ->rollbackTransaction();
} else {

    $userId = $AdminUserOBJ->getInsertId();
    $setProfileParam["user_id"]  = $userId;

    if(!$AdminUserOBJ->insertProfileData($setProfileParam)) {
        $errMsg = array("登録できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
}

if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    $returnSessOBJ->return = $param;
    header("Location: ./?action_user_Create=1");
    exit;
}
// コミット
$AdminUserOBJ->commitTransaction();

$execMsgSessOBJ->execMsg = array("登録しました。");
header("Location: ./?action_user_CreateEnd=1");
exit;

?>
