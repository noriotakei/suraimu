<?php
/**
 * preRegistExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン前仮登録処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$PreRegistOBJ = PreRegist::getInstance();
$UserOBJ = User::getInstance();
$BlackListOBJ        = BlackList::getInstance();
$AllowDomainOBJ      = AllowDomain::getInstance();

// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

$errSessOBJ = new ComSessionNamespace("err_msg");
$param = $requestOBJ->getParameterExcept($exceptArray);

$param["mail_address"] = $param["mail_account"] . "@" . $param["mail_domain"];

//black_userに該当する場合は登録拒否
$dangerFlag = FALSE;

//メールアドレスでチェック
if($BlackListOBJ->searchBlackListByAddress($param["mail_address"])){
    $dangerFlag = TRUE;
}
//ドメインで可否チェック
if($AllowDomainOBJ->searchNonAllowDomain($param["mail_address"])){
	$dangerFlag = TRUE;
} 
if($dangerFlag == TRUE){
    //ここに登録拒否のエラー処理を記述。
    $errSessOBJ->errMsg[] = "Errorになりました。";
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// 登録アドレスドメインのチェック
if (!$UserOBJ->chkRegistUserAddressDomain($param["mail_domain"])) {
    // NGドメインなのでさようなら
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("mail_address", "メールアドレス",
                array("MailAddress" => null));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 過去の「ブラック有効」and「退会者」の『再登録』は弾く
if ($quitBlackUserData = $UserOBJ->chkQuitBlackUser($param["mail_address"])) {
    // さようなら
    //登録エラータグ発行
    //$AffiliateControlOBJ->sendAffiliateData("", $aryAffiliateValue, $affiliateControlSendType, false);
    $errSessOBJ->errMsg[] = "Errorになりました。";
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($param["mail_address"])) {
    $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($param["mail_address"]);
}

//登録時の引数を変数に格納
parse_str($preRegistData["affiliate_value"], $aryAffiliateValue);
//登録タグ返還用にメールアドレスを追加
$aryAffiliateValue["mail_address"] = urlencode($param["mail_address"]);
if ($aryAffiliateValue["ad_code"]) {
    $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
}

//新旧のアドルールで使用するクラスファイルを選択
if(AffiliateControl16::ROUTES_CD_LENGTH == strlen($aryAffiliateValue["advcd"])){
    $firstCd = substr($aryAffiliateValue["advcd"], 0, 4);
    $lastCd  = substr($aryAffiliateValue["advcd"], 4, 4);
    $ymCd    = substr($aryAffiliateValue["advcd"], 8, 2);
    $mediaCd = substr($aryAffiliateValue["advcd"], 10, 6);

    $adCdRule16Flag = true ;
    $AffiliateControlOBJ = AffiliateControl16::getInstance();
} else {
    $adCdRule16Flag = false ;
    $AffiliateControlOBJ = AffiliateControl::getInstance();
}

// アフィリエイトデータの取得
$affiliateData = $AffiliateControlOBJ->getAffiliateDataFromAdvcd($aryAffiliateValue["advcd"]);

// 仮登録用か本登録用か確認
// アフィリエイトデータが無ければとりあえず仮登録
if (!$affiliateData OR $affiliateData["is_pre_regist"]) {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_PRE_REGIST;
    $registStatus = $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"];
} else {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_REGIST;
    $registStatus = $_config["define"]["USER_REGIST_STATUS_MEMBER"];
}

// 重複メアドがあった場合
if ($duplicateUserData) {
    //登録エラータグ発行
    $AffiliateControlOBJ->sendAffiliateData("", $aryAffiliateValue, $affiliateControlSendType, false);
    $errSessOBJ->errMsg[] = "メールアドレスが重複しています。";
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// 指定の媒体からの登録は受信ステータスを『受け取らない』にする
// 以下、そのうち処理毎消します。2010-11-30 hosoda
if ($aryAffiliateValue["advcd"] == "to20016") {
    $param["send_status"] = 0;
}

// 仮登録テーブルの更新
// 配信するにチェックされていなければtrueにする
$updatePreRegistArray["is_no_send_status"] = $param["send_status"] ? $_config["define"]["ADDRESS_SEND_STATUS_DO"] : $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
$updatePreRegistArray["update_datetime"] = date("YmdHis");

if (!$PreRegistOBJ->updatePreRegistData($updatePreRegistArray, array("id=" . $preRegistData["id"]))) {
    $errSessOBJ->errMsg = $PreRegistOBJ->getErrorMsg;
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// 登録処理
// トランザクション開始
$UserOBJ->beginTransaction();

$ComUtilityOBJ = ComUtility::getInstance();

// userデータを仮登録で挿入
$currentDateTime = date("Y-m-d H:i:s");
$accessKey      = $UserOBJ->getNewAccessKey( $currentDateTime );
$remailKey      = $UserOBJ->getNewRemailKey( $currentDateTime );

$password = ComUtility::getRamdomNumber(4);

$userAry = array(
    "login_id"          => $param["mail_address"],
    "password"            => $UserOBJ->createPasswordKey($password),
    "access_key"          => $accessKey,
    "remail_key"          => $remailKey,
    "regist_status"       => $registStatus,
    "media_cd"               => $aryAffiliateValue["advcd"],
    "regist_page_id"        => $preRegistData["regist_page_id"],
    "affiliate_value"         => $preRegistData["affiliate_value"],
    "pre_regist_datetime" => $currentDateTime,
    "update_datetime" => $currentDateTime,
);

if($adCdRule16Flag){
    $userAry["affiliate_first_cd"] = substr($aryAffiliateValue["advcd"], 0, 4);
    $userAry["affiliate_last_cd"]  = substr($aryAffiliateValue["advcd"], 4, 4);
    $userAry["affiliate_ym_cd"]    = substr($aryAffiliateValue["advcd"], 8, 2);
    $userAry["affiliate_media_cd"] = substr($aryAffiliateValue["advcd"], 10, 6);
} 

if ($registStatus == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
    $userAry["regist_datetime"] = $currentDateTime;
}

// 携帯メールアドレスである
if (ComValidation::isMobileAddress($param["mail_address"])) {
    $mbFlag = true;
}

if ($mbFlag) {
    $deviceCd    = $ComUtilityOBJ->getDeviceFromMailAddress($param["mail_address"]);
    $userAry["mb_address"] = $param["mail_address"];
    $userAry["mb_device_cd"] = $deviceCd;
} else {
    $userAry["pc_address"] = $param["mail_address"];
    $userAry["pc_device_cd"] = $_config["define"]["DEVICE_PC"];
    if ($preRegistData) {
        $userAry["pc_user_agent"] = $preRegistData["user_agent"];
        $userAry["pc_ip_address"] = $preRegistData["ip_address"];
    }
}

// 指定の媒体からの登録は、送信ステータスを『しない』にする
// 以下、そのうち処理毎消します。2010-11-30 hosoda
if ($aryAffiliateValue["advcd"] == "to20016") {
    if ($mbFlag) {
        $userAry["mb_send_status"] = 1;
    } else {
        $userAry["pc_send_status"] = 1;
    }
}

// userテーブルへのインサート処理
if (!$UserOBJ->insertUserData($userAry)) {
    $UserOBJ->rollbackTransaction();
    exit();
}

$userId = $UserOBJ->getInsertId();

$profileAry = array(
    "user_id"                 => $userId,
    "by_user_update_datetime" => $currentDateTime,
    "update_datetime"         => $currentDateTime,
);

if (ComValidation::isNumeric($aryAffiliateValue["s"])) {
    $profileAry["sex_cd"] = $aryAffiliateValue["s"];
}
// タイムスタンプで来る
if (ComValidation::isNumeric($aryAffiliateValue["b"])) {
    $profileAry["birth_date"] = date("Y-m-d", $aryAffiliateValue["b"]);
}

if ($mbFlag) {
    $profileAry["mb_is_mailmagazine"] = $param["send_status"] ? $_config["define"]["ADDRESS_SEND_STATUS_DO"] : $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
}else {
    $profileAry["pc_is_mailmagazine"] = $param["send_status"] ? $_config["define"]["ADDRESS_SEND_STATUS_DO"] : $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
}
// profileテーブルへのインサート処理
if (!$UserOBJ->insertProfileData($profileAry)) {
    $UserOBJ->rollbackTransaction();
    exit();
}

if ($preRegistData) {
    $preRegistAry = array(
        "user_id"                 => $userId,
        "is_regist"               => 1,
        "update_datetime"  => $currentDateTime,
    );

    // pre_registテーブルへの更新処理
    if (!$PreRegistOBJ->updatePreRegistData($preRegistAry, array("id = " . $preRegistData["id"]))) {
        $UserOBJ->rollbackTransaction();
        exit();
    }
}

// トランザクションコミット
$UserOBJ->commitTransaction();

// 仮登録用か本登録用か確認
// 本登録
if ($registStatus == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
    // 登録タグ発行 タグがなければNO_TAGを格納
    if (!$AffiliateControlOBJ->sendAffiliateData($userId, $aryAffiliateValue, $affiliateControlSendType)) {
        $userAffiliateUpdateArray= "";
        $userAffiliateUpdateArray["affiliate_tag_url"] = "NO_TAG";
        // userテーブルへの更新処理
        $UserOBJ->updateUserData($userAffiliateUpdateArray, array("id = " . $userId));
    }
// 仮登録
} else {
    // 登録タグ発行
    $AffiliateControlOBJ->sendAffiliateData($userId, $aryAffiliateValue, $affiliateControlSendType);
}

$convAry = array("-%password-" => $password);

// 登録完了メールを送信
// メール文言取得
if ($preRegistData["regist_page_id"]) {
    $RegistPageOBJ = RegistPage::getInstance();
    // リメールデータの取得
    $mailElementsData = $RegistPageOBJ->getRegistPageMailData($preRegistData["regist_page_id"], $param["mail_address"]);
// 直接登録者
} else if ($direct) {
    // リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "direct_regist", $param["mail_address"]);
}

// サイト間登録通信
$RegistSiteOBJ = RegistSite::getInstance();
$RegistSiteOBJ->sendRegistSiteData($param["mail_address"]);
$updateRegistSiteData = "";
$updateRegistSiteData["user_id"] = $userId;
$updateRegistSiteData["update_datetime"] = date("YmdHis");

$whereRegistSiteArray = "";
$whereRegistSiteArray[] = "mail_address = '" . $param["mail_address"] . "'";
$whereRegistSiteArray[] = "disable = 0";
$RegistSiteOBJ->updateRegistSiteLogData($updateRegistSiteData, $whereRegistSiteArray);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userId, $convAry);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $errSessOBJ->errMsg[] = "メール送信ができませんでした。";
    header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}

// 本登録フローなら本登録URLへリダイレクト
if ($preRegistData["regist_page_id"] AND $registStatus == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
    // 登録ページの取得
    $registPageData = $RegistPageOBJ->getRegistPageData($preRegistData["regist_page_id"]);
    if (!$registPageData) {
        $errSessOBJ->errMsg[] = "エラーが発生しました。";
        header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit();
    }
    $KeyConvertOBJ = KeyConvert::getInstance();
    // 変換処理
    $registPageData["regist_url"] = htmlspecialchars_decode($KeyConvertOBJ->execConvert($registPageData["regist_url_pc"], $userId), ENT_QUOTES);
    header("Location: " . $registPageData["regist_url"] . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}
header("Location: ./?action_PreRegistComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit();

?>
