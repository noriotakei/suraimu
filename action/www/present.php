<?php
/**
 * present.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC強行メール変更処理ファイル。
 * ファイル名はアクセスさせるためそそるファイル名で。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// 退会ユーザーもアクセスさせるためuser_commonを読む
require_once(D_BASE_DIR . "/common/user_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$UserOBJ = User::getInstance();

// ユーザー情報の確認
// アクセスキーで確認
$comUserData = $UserOBJ->getRegStatusNotFindUserDataFromAccessKey($accessKey);
if (!$comUserData) {
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

$setUserParam = "";
$setProfileParam = "";

// PCアドがあればメールステータスの変更
if ($comUserData["pc_address"]) {
    $setUserParam["pc_address_status"] = 0;
    $setUserParam["pc_send_status"] = 0;
    $setUserParam["pc_emsys_count"] = 0;
    $setProfileParam["pc_is_mailmagazine"] = 0;
// PCアドがなければPCメールステータスの変更
} else {
    $setUserParam["mb_address_status"] = 0;
    $setUserParam["mb_send_status"] = 0;
    $setUserParam["mb_emsys_count"] = 0;
    $setProfileParam["mb_is_mailmagazine"] = 0;
}

$setProfileParam["reverse_mail_status_count"] = 0;
$setProfileParam["update_datetime"] = date("YmdHis");

// 退会以外で重複ユーザーがいないか確認
// いればそのユーザー情報更新処理
// 個体識別の重複チェック
if (!$duplicateUserData = $UserOBJ->chkUserDataFromMbSerialNumber($mbSerialNo)) {
    // メアドの重複チェック
    $mailAddress = $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"];
    if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
        $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress);
    }
    if ($duplicateUserData) {

        $userWhere = "";
        $userWhere[] = "id = " . $duplicateUserData["user_id"];

        // userテーブルへの更新処理
        if (!$UserOBJ->updateUserData($setUserParam, $userWhere)) {
            $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . "&" . $sessId);
            exit();
        }

        $userProfileWhere = "";
        $userProfileWhere[] = "user_id = " . $duplicateUserData["user_id"];

        // profileテーブルへの更新処理
        if (!$UserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
            $errSessOBJ->errMsg = $UserOBJ->getErrorMsg();
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . "&" . $sessId);
            exit();
        }

        header("Location: ./?action_Information=1&" . Auth::ACCESS_KEY_NAME . "=" . $duplicateUserData["access_key"] . "&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
        exit();
    }
}

// 退会なら登録ステータスの変更
if ($comUserData["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
    if (ComValidation::isDateTime($comUserData["regist_datetime"])) {
        $setUserParam["regist_status"] = $_config["define"]["USER_REGIST_STATUS_MEMBER"];
    } else {
        $setUserParam["regist_status"] = $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"];
    }
    $setUserParam["quit_datetime"] = "0000-00-00 00:00:00";
}

$userWhere = "";
$userWhere[] = "id = " . $comUserData["user_id"];

// userテーブルへの更新処理
if (!$UserOBJ->updateUserData($setUserParam, $userWhere)) {
    $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
    header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
    exit();
}

$userProfileWhere = "";
$userProfileWhere[] = "user_id = " . $comUserData["user_id"];

// profileテーブルへの更新処理
if (!$UserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
    $errSessOBJ->errMsg = $UserOBJ->getErrorMsg();
    header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
    exit();
}

// 引数の情報IDの情報へリダイレクト
header("Location: ./?action_Information=1&" . Auth::ACCESS_KEY_NAME . "=" . $comUserData["access_key"] . "&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
