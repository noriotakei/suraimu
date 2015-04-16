<?php
/**
 * userMailAddressChangeExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBメールアドレス変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$MailAddressChangeOBJ = MailAddressChange::getInstance();
$UserOBJ = User::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();
$errSessOBJ = new ComSessionNamespace("err_msg");
$AutoMailOBJ = AutoMail::getInstance();

$mailAddressChangeData = $MailAddressChangeOBJ->getMailAddressChangeData($comUserData["user_id"]);
if (!$mailAddressChangeData) {
    $errSessOBJ->errMsg[] = "更新申請がありません。";
    header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}


// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddressChangeData["mail_address"])) {
    $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddressChangeData["mail_address"]);
}
// 重複メアドがあった場合
if ($duplicateUserData) {
    $errSessOBJ->errMsg[] = "メールアドレスが重複しています。";
    header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// トランザクション開始
$UserOBJ->beginTransaction();

// メールステータス等も初期化
if (ComValidation::isMobileAddress($mailAddressChangeData["mail_address"])) {
    $updateUserData["mb_device_cd"] = $ComUtilityOBJ->getDeviceFromMailAddress($mailAddressChangeData["mail_address"]);
    $updateUserData["mb_address"] = $mailAddressChangeData["mail_address"];
    $updateUserData["mb_address_status"] = 0;
    $updateUserData["mb_send_status"] = 0;
    $updateUserData["mb_emsys_count"] = 0;
    $updateProfileData["mb_is_mailmagazine"] = 0;
    // 変更前メアドがログインIDと一緒ならログインIDも変更
    if ($comUserData["mb_address"] == $comUserData["login_id"]) {
        $updateUserData["login_id"] = $mailAddressChangeData["mail_address"];
    }
    // アドレス新規登録か
    if (!$comUserData["mb_address"]) {
        $firstReg = true;
    }
} else {
    $updateUserData["pc_device_cd"]    = $_config["define"]["DEVICE_PC"];
    $updateUserData["pc_address"] = $mailAddressChangeData["mail_address"];
    $updateUserData["pc_address_status"] = 0;
    $updateUserData["pc_send_status"] = 0;
    $updateUserData["pc_emsys_count"] = 0;
    $updateProfileData["pc_is_mailmagazine"] = 0;
    // 変更前メアドがログインIDと一緒ならログインIDも変更
    if ($comUserData["pc_address"] == $comUserData["login_id"]) {
        $updateUserData["login_id"] = $mailAddressChangeData["mail_address"];
    }
    // アドレス新規登録か
    if (!$comUserData["pc_address"]) {
        $firstReg = true;
    }

}

if (!$UserOBJ->updateUserData($updateUserData, array("id=" . $comUserData["user_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}
$updateProfileData["by_user_update_datetime"] = date("YmdHis");
if (!$UserOBJ->updateProfileData($updateProfileData, array("user_id=" . $comUserData["user_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

$updateMailAddressChangeData["disable"] = 1;
$whereMailAddressChangeArray[] = "user_id = " . $comUserData["user_id"];

if (!$MailAddressChangeOBJ->updateMailAddressChangeData($updateMailAddressChangeData, $whereMailAddressChangeArray)) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// コミット
$UserOBJ->commitTransaction();

// リメールデータの取得
$mailElementsData = $AutoMailOBJ->getAutoMailData("mail_change", ($firstReg ? "first_change_end" : "mail_change_end"), $mailAddressChangeData["mail_address"]);
$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"]);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信ができませんでした。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// サイト間登録通信
$RegistSiteOBJ = RegistSite::getInstance();
$RegistSiteOBJ->sendRegistSiteData($mailAddressChangeData["mail_address"]);
$updateRegistSiteData = "";
$updateRegistSiteData["user_id"] = $userId;
$updateRegistSiteData["update_datetime"] = date("YmdHis");

$whereRegistSiteArray = "";
$whereRegistSiteArray[] = "mail_address = '" . $mailAddressChangeData["mail_address"] . "'";
$whereRegistSiteArray[] = "disable = 0";
$RegistSiteOBJ->updateRegistSiteLogData($updateRegistSiteData, $whereRegistSiteArray);

header("Location: ./?action_UserMailAddressChgComp=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit();

?>
