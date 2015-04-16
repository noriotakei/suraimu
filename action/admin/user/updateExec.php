<?php

/**
 * updateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報詳細更新処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$AdmPointLogOBJ = AdmPointLog::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();
$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$userData = $AdminUserOBJ->getUserData($param["user_id"]);

$errSessOBJ = new ComSessionNamespace("err");


// ログインID
if(ComValidation::isValue($param["login_id"])){
    if ($AdminUserOBJ->chkUserDataFromLoginId($param["login_id"], $param["user_id"])) {
        $errMsg[] = "ログインIDが重複しています";
    }
}

// パスワード
/*
if (!ComValidation::isValue($param["password"])) {
    $errMsg[] = "パスワードを入力してください";
}
*/
// ゼロクレジット登録電話番号
if ($param["credit_certify_phone_number"]  AND !ComValidation::isNumeric($param["credit_certify_phone_number"])) {
    $errMsg[] = "ゼロクレジット登録電話番号を数字で入力してください";
}
// ゼロクレジットMB登録電話番号
if ($param["credit_certify_phone_number_mb"]  AND !ComValidation::isNumeric($param["credit_certify_phone_number_mb"])) {
    $errMsg[] = "ゼロクレジットMB登録電話番号を数字で入力してください";
}
// テレコムクレジット登録電話番号
if ($param["telecom_certify_phone_number"]  AND !ComValidation::isNumeric($param["telecom_certify_phone_number"])) {
    $errMsg[] = "テレコムクレジット登録電話番号を数字で入力してください";
}

// 登録ステータス
if (!ComValidation::isValue($param["regist_status"])) {
    $errMsg[] = "登録ステータスを選択してください";
}

// 購入金額合計
if (!ComValidation::isNumeric($param["total_payment"])) {
    $errMsg[] = "購入金額合計を数字で入力してください";
}

// 購入回数
if (!ComValidation::isNumeric($param["buy_count"])) {
    $errMsg[] = "購入回数を数字で入力してください";
}

// キャンセル回数
if (!ComValidation::isNumeric($param["cancel_count"])) {
    $errMsg[] = "キャンセル回数を数字で入力してください";
}

// 仮登録日時
$param["pre_regist_datetime"] = $param["pre_regist_datetime_Date"]
                        . " " . $param["pre_regist_datetime_Time"];
if (!ComValidation::isDateTime($param["pre_regist_datetime"])) {
    $errMsg[] = "仮登録日時を正しく入力してください";
}

// 登録日時
$param["regist_datetime"] = $param["regist_datetime_Date"]
                        . " " . $param["regist_datetime_Time"];
if (($param["regist_datetime_Date"] OR $param["regist_datetime_Time"]) AND !ComValidation::isDateTime($param["regist_datetime"])) {
    $errMsg[] = "登録日時を正しく入力してください";
}

// 初回入金日時
$param["first_pay_datetime"] = $param["first_pay_datetime_Date"]
                        . " " . $param["first_pay_datetime_Time"];
if (($param["first_pay_datetime_Date"] OR $param["first_pay_datetime_Time"]) AND !ComValidation::isDateTime($param["first_pay_datetime"])) {
    $errMsg[] = "初回入金日時を正しく入力してください";
}

// 最終購入日時
$param["last_buy_datetime"] = $param["last_buy_datetime_Date"]
                        . " " . $param["last_buy_datetime_Time"];
if (($param["last_buy_datetime_Date"] OR $param["last_buy_datetime_Time"]) AND !ComValidation::isDateTime($param["last_buy_datetime"])) {
    $errMsg[] = "最終購入日時を正しく入力してください";
}

// 最終ｱｸｾｽ日時
$param["last_access_datetime"] = $param["last_access_datetime_Date"]
                        . " " . $param["last_access_datetime_Time"];
if (($param["last_access_datetime_Date"] OR $param["last_access_datetime_Time"]) AND !ComValidation::isDateTime($param["last_access_datetime"])) {
    $errMsg[] = "最終ｱｸｾｽ日時を正しく入力してください";
}

// ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時
$param["home_access_datetime"] = $param["home_access_datetime_date"]
                        . " " . $param["home_access_datetime_time"];
if (($param["home_access_datetime_date"] OR $param["home_access_datetime_time"]) AND !ComValidation::isDateTime($param["home_access_datetime"])) {
    $errMsg[] = "ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時を正しく入力してください";
}

// 退会日時
$param["quit_datetime"] = $param["quit_datetime_Date"]
                        . " " . $param["quit_datetime_Time"];

if (($param["quit_datetime_Date"] OR $param["quit_datetime_Time"]) AND !ComValidation::isDateTime($param["quit_datetime"])) {
    $errMsg[] = "退会日時を正しく入力してください";
}

// 生年月日
if ($param["birth_date"] AND !ComValidation::isDate($param["birth_date"])) {
    $errMsg[] = "生年月日を正しく入力してください";
}

// PCﾒｰﾙ強行
if (!ComValidation::isNumeric($param["is_pc_reverse"])) {
    $errMsg[] = "PCﾒｰﾙ強行フラグを選択してください";
}

// MBﾒｰﾙ強行
if (!ComValidation::isNumeric($param["is_mb_reverse"])) {
    $errMsg[] = "MBﾒｰﾙ強行フラグを選択してください";
}

// 危険人物フラグ
if (!ComValidation::isNumeric($param["danger_status"])) {
    $errMsg[] = "危険人物フラグを選択してください";
}


// PCﾒｰﾙｱﾄﾞﾚｽ
if (ComValidation::isValue($param["pc_address"]) AND !ComValidation::isMailAddress($param["pc_address"])) {
    $errMsg[] = "PCﾒｰﾙｱﾄﾞﾚｽが正しくありません";
//} else if ($AdminUserOBJ->chkUserDataFromPcMailAddress($param["pc_address"], $param["user_id"])) {
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
//} else if ($AdminUserOBJ->chkUserDataFromMbMailAddress($param["mb_address"], $param["user_id"])) {
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

// PC配信ドメイン
$sendMailDomainArray = array_flip($_config["define"]["SEND_MAIL_DOMAIN"]) ;

if($sendMailDomainArray[$param["pc_mailmagazine_from_domain"]] !== 0 and !$sendMailDomainArray[$param["pc_mailmagazine_from_domain"]]){
    $errMsg[] = "有効なPC配信ﾄﾞﾒｲﾝを選択してください";
} else {
    $pcMailmagazineFromId = $sendMailDomainArray[$param["pc_mailmagazine_from_domain"]] ;
}

// MB配信ドメイン
if($sendMailDomainArray[$param["mb_mailmagazine_from_domain"]] !== 0 and !$sendMailDomainArray[$param["mb_mailmagazine_from_domain"]]){
    $errMsg[] = "有効なMB配信ﾄﾞﾒｲﾝを選択してください";
} else {
    $mbMailmagazineFromId = $sendMailDomainArray[$param["mb_mailmagazine_from_domain"]] ;
}

// 性別
if (!ComValidation::isNumeric($param["sex_cd"])) {
    $errMsg[] = "性別を選択してください";
}

// 血液型
if (!ComValidation::isNumeric($param["blood_type"])) {
    $errMsg[] = "血液型を選択してください";
}

// ポイント
if (!ComValidation::isNumeric($param["point"])) {
    $errMsg[] = "ポイントを入力してください";
}

// 合計付与ポイント
if (!ComValidation::isNumeric($param["total_addition_point"])) {
    $errMsg[] = "合計付与ポイントを入力してください";
}

// 合計使用ポイント
if (!ComValidation::isNumeric($param["total_use_point"])) {
    $errMsg[] = "合計使用ポイントを入力してください";
}

// 引っペ返し回数
if (!ComValidation::isNumeric($param["reverse_mail_status_count"])) {
    $errMsg[] = "引っペ返し回数を入力してください";
}

if (!ComValidation::isNumeric($param["bank_code"]) AND $param["bank_code"]) {
    $errMsg[] = "銀行コードを数字で入力してください";
}

if (!ComValidation::isNumeric($param["branch_code"]) AND $param["branch_code"]) {
    $errMsg[] = "支店コードを数字で入力してください";
}

if (!ComValidation::isNumeric($param["account_number"]) AND $param["account_number"]) {
    $errMsg[] = "口座番号を数字で入力してください";
}

if (mb_strlen($param["account_number"]) != 7 AND $param["account_number"]) {
    $errMsg[] = "口座番号は7桁の数字で入力してください。";
}

if (!ComValidation::isKatakana($param["account_holder_name"]) AND $param["account_holder_name"]) {
    $errMsg[] = "名義人をカタカナで入力してください";
}

if (!ComValidation::isNumeric($param["postal_code"]) AND $param["postal_code"]) {
    $errMsg[] = "郵便番号を数字で入力してください";
}


// 管理ﾎﾞｯｸｽ
if (!ComValidation::isNumeric($param["admin_id"])) {
    $errMsg[] = "管理ﾎﾞｯｸｽを選択してください";
}

if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    header("Location: ./?action_User_detail=1&user_id=" . $param["user_id"]);
    exit;
}

if (array_key_exists("login_id",$param)) {
    $setUserParam["login_id"] = $param["login_id"];
}
if ($param["password"]) {
    $setUserParam["password"] = $UserOBJ->createPasswordKey($param["password"]);
}
$setUserParam["admin_id"]           = $param["admin_id"];
$setUserParam["media_cd"]           = $param["media_cd"];
if (array_key_exists("pc_address",$param)) {
    $setUserParam["pc_address"]         = $param["pc_address"];
}
$setUserParam["pc_address_status"]  = $param["pc_address_status"];
$setUserParam["pc_send_status"]     = $param["pc_send_status"];
$setUserParam["pc_mailmagazine_from_domain_id"]  = $pcMailmagazineFromId;
if (array_key_exists("mb_address",$param)) {
    $setUserParam["mb_address"]         = $param["mb_address"];
}
$setUserParam["mb_address_status"]  = $param["mb_address_status"];
$setUserParam["mb_send_status"]     = $param["mb_send_status"];
$setUserParam["mb_mailmagazine_from_domain_id"]  = $mbMailmagazineFromId;
$setUserParam["regist_status"]      = $param["regist_status"];
$setUserParam["description"]        = $param["description"];
$setUserParam["regist_page_id"]    = $param["regist_page_id"];
$setUserParam["is_pc_reverse"]      = $param["is_pc_reverse"];
$setUserParam["is_mb_reverse"]      = $param["is_mb_reverse"];
$setUserParam["danger_status"]      = $param["danger_status"];
$setUserParam["pre_regist_datetime"]    = $param["pre_regist_datetime"];
$setUserParam["regist_datetime"]    = $param["regist_datetime"];
$setUserParam["quit_datetime"]      = $param["quit_datetime"];
$setUserParam["last_access_datetime"]   = $param["last_access_datetime"];
$setUserParam["home_access_datetime"]   = $param["home_access_datetime"];
$setUserParam["update_datetime"]        = date("YmdHis");

$setProfileParam["pc_is_mailmagazine"]  = $param["pc_is_mailmagazine"];
$setProfileParam["mb_is_mailmagazine"]  = $param["mb_is_mailmagazine"];
if (array_key_exists("credit_certify_phone_number",$param)) {
    $setProfileParam["credit_certify_phone_number"] = $param["credit_certify_phone_number"];
}
if (array_key_exists("credit_certify_phone_number_mb",$param)) {
    $setProfileParam["credit_certify_phone_number_mb"] = $param["credit_certify_phone_number_mb"];
}
if (array_key_exists("telecom_certify_phone_number",$param)) {
    $setProfileParam["telecom_certify_phone_number"] = $param["telecom_certify_phone_number"];
}
$setProfileParam["total_payment"]       = $param["total_payment"];
$setProfileParam["buy_count"]           = $param["buy_count"];
$setProfileParam["cancel_count"]        = $param["cancel_count"];
$setProfileParam["point"]               = $param["point"];
$setProfileParam["total_addition_point"] = $param["total_addition_point"];
$setProfileParam["total_use_point"]     = $param["total_use_point"];
$setProfileParam["first_pay_datetime"]   = $param["first_pay_datetime"];
$setProfileParam["last_buy_datetime"]   = $param["last_buy_datetime"];
$setProfileParam["sex_cd"]              = $param["sex_cd"];
$setProfileParam["blood_type"]              = $param["blood_type"];
$setProfileParam["reverse_mail_status_count"]     = $param["reverse_mail_status_count"];
$setProfileParam["birth_date"]     = $param["birth_date"];
$setProfileParam["update_datetime"]     = date("YmdHis");
$setProfileParam["user_profile_flag_code"]     = $param["user_profile_flag_code_update"];

// 指定あれば個体識別削除
if ($param["serial_number_delete"]) {
    $setUserParam["mb_serial_number"] = "";
}

// モバイルメールアドレスが
if (array_key_exists("mb_address",$param)) {
    if ($param["mb_address"]) {
        $setUserParam["mb_device_cd"] = $ComUtilityOBJ->getDeviceFromMailAddress($param["mb_address"]);
    // メールアドレスがないか、変わっていれば初期化
    } else if (!$param["mb_address"] OR $param["mb_address"] != $userData["mb_address"]) {
        $setUserParam["mb_device_cd"] = 0;
        $setUserParam["mb_address_status"] = 0;
        $setUserParam["mb_send_status"] = 0;
        $setUserParam["mb_emsys_count"] = 0;
        $setProfileParam["mb_is_mailmagazine"] = 0;
    }
}

if (array_key_exists("pc_address",$param)) {
    if ($param["pc_address"]) {
        $setUserParam["pc_device_cd"]    = $_config["define"]["DEVICE_PC"];
        // メールアドレスがないか、変わっていれば初期化
    } else if (!$param["pc_address"] OR $param["pc_address"] != $userData["pc_address"]) {
        $setUserParam["pc_device_cd"] = 0;
        $setUserParam["pc_address_status"] = 0;
        $setUserParam["pc_send_status"] = 0;
        $setUserParam["pc_emsys_count"] = 0;
        $setProfileParam["pc_is_mailmagazine"] = 0;
    }
}

$userWhere[] = "id = " . $param["user_id"];
$userProfileWhere[] = "user_id = " . $param["user_id"];

// トランザクション開始
$AdminUserOBJ->beginTransaction();

// ポイントログ挿入
if ($param["point"] != $userData["point"]) {
    $columnArray[] = $param["point"] - $userData["point"];
    $columnArray[] = "user_id";
    $columnArray[] = AdmPointLog::TYPE_ADMIN;
    $columnArray[] = "NOW()";

    $whereArray[] = "user_id=" . $param["user_id"];

    $listSql = $AdminUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

    $insertColmun[] = "point";
    $insertColmun[] = "user_id";
    $insertColmun[] = "type";
    $insertColmun[] = "create_datetime";

    if (!$AdmPointLogOBJ->insertSelectPointLogData($insertColmun, $listSql)) {
        $messageSessOBJ->message = array("ポイントログ登録できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
        $errSessOBJ->errMsg = $errorMsg;
    }
}

if(!$AdminUserOBJ->updateUserData($setUserParam, $userWhere)) {
    $errSessOBJ->errMsg = array("更新できませんでした。");
    // ロールバック
    $AdminUserOBJ->rollbackTransaction();
} else {
    if(!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere)) {
        $errSessOBJ->errMsg = array("更新できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    } else {
        $errSessOBJ->errMsg = array("更新しました。");
    }
}

// 銀行振込情報登録
if (array_key_exists("bank_name",$param)) {
    $bankAccountData["bank_name"] = $param["bank_name"];
}
if (array_key_exists("bank_code",$param)) {
    $bankAccountData["bank_code"] = mb_convert_kana($param["bank_code"], a);
}
if (array_key_exists("branch_name",$param)) {
    $bankAccountData["branch_name"] = $param["branch_name"];
}
if (array_key_exists("branch_code",$param)) {
    $bankAccountData["branch_code"] = mb_convert_kana($param["branch_code"], a);
}
if (array_key_exists("type",$param)) {
    $bankAccountData["type"] = $param["type"];
}
if (array_key_exists("account_number",$param)) {
    $bankAccountData["account_number"] = mb_convert_kana($param["account_number"], a);
}
if (array_key_exists("account_holder_name",$param)) {
    $bankAccountData["name"] = $param["account_holder_name"];
}
$bankAccountData["update_datetime"] = date("YmdHis");

if (!$data = $UserOBJ->getBankDetailData($param["user_id"])) {
    $bankAccountData["user_id"] = $param["user_id"];
    if (!$UserOBJ->insertBankDetailData($bankAccountData)) {
        $errSessOBJ->errMsg = array("銀行振込口座を登録できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
} else {
    if (!$UserOBJ->updateBankDetailData($bankAccountData, array("id = " . $data["id"]))) {
        $errSessOBJ->errMsg = array("銀行振込口座を更新できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
}

// 住所情報登録
if (array_key_exists("postal_code",$param)) {
    $addressDetailData["postal_code"] = $param["postal_code"];
}
if (array_key_exists("address",$param)) {
    $addressDetailData["address"] = $param["address"];
}
if (array_key_exists("address_name",$param)) {
    $addressDetailData["name"] = $param["address_name"];
}
if (array_key_exists("phone_number",$param)) {
    $addressDetailData["phone_number"] = $param["phone_number"];
}

if (array_key_exists("phone_number2",$param)) {
    $addressDetailData["phone_number2"] = $param["phone_number2"];
}
if (array_key_exists("phone_number3",$param)) {
    $addressDetailData["phone_number3"] = $param["phone_number3"];
}
if (array_key_exists("phone_is_use",$param)) {
    $addressDetailData["phone_is_use"] = $param["phone_is_use"];
}

$addressDetailData["update_datetime"] = $param["update_datetime"];

if (!$data = $UserOBJ->getAddressDetailData($param["user_id"])) {
    $addressDetailData["user_id"] = $param["user_id"];
    if (!$UserOBJ->insertAddressDetailData($addressDetailData)) {
        $errSessOBJ->errMsg = array("住所を登録できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
} else {
    if (!$UserOBJ->updateAddressDetailData($addressDetailData, array("id = " . $data["id"]))) {
        $errSessOBJ->errMsg = array("住所を更新できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
}

$changePayTotal = $param["total_payment"] - $userData["total_payment"];

if ($changePayTotal != 0) {
    $insertPaymentLog["user_id"]            = $param["user_id"];
    $insertPaymentLog["receive_money"]      = $changePayTotal;
    $insertPaymentLog["pay_type"]           = AdmOrdering::PAY_TYPE_ADMIN;
    $insertPaymentLog["is_manual"]          = 1;
    $insertPaymentLog["create_datetime"]    = date("YmdHis");
    // paymentLogにインサート
    if (!$AdmPaymentLogOBJ->insertPaymentLogData($insertPaymentLog)) {
        $errSessOBJ->errMsg = array("データ更新できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
    }
}

// コミット
$AdminUserOBJ->commitTransaction();

header("Location: ./?action_User_detail=1&user_id=" . $param["user_id"]);
exit;

?>
