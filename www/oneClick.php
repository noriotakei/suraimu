<?php
/**
 * oneClick.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 *  競馬サイト間つなぎ込み登録処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}

$BlackListOBJ        = BlackList::getInstance();
$AllowDomainOBJ      = AllowDomain::getInstance();

// 登録オブジェクトの作成
$PreRegistOBJ = PreRegist::getInstance();
$UserOBJ = User::getInstance();
// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();
// xml出力
$DOMDocumentOBJ = new DOMDocument("1.0", "UTF-8");
$root = $DOMDocumentOBJ->createElement("result");
$DOMDocumentOBJ->appendChild($root);

$param = $requestOBJ->getAllParameter();
$affiliateValue = http_build_query($param);

// 送信元メアドの取得
$mailAddress = urldecode($param["mail"]);

// 広告コードの引数が違うため格納
if ($param["ad_code"]) {
    $param["advcd"] = $param["ad_code"];
}
// 携帯メールアドレスである
if (ComValidation::isMobileAddress($mailAddress)) {
    $mbFlag = true;
}

//black_userに該当する場合は登録拒否
$dangerFlag = FALSE;
//個体識別でチェック
if( ($mbFlag) && ($param["uid"]) ){
    if($BlackListOBJ->searchBlackListByMbSerialNumber( $param["uid"])){
        $dangerFlag = TRUE;
    }
}
//メールアドレスでチェック
if($BlackListOBJ->searchBlackListByAddress($mailAddress)){
    $dangerFlag = TRUE;
}
//ドメインで可否チェック
if($AllowDomainOBJ->searchNonAllowDomain($mailAddress)){
	$dangerFlag = TRUE;
}
if($dangerFlag == TRUE){
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "Errorになりました。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

if(AffiliateControl16::ROUTES_CD_LENGTH == strlen($param["advcd"])){
    $firstCd = substr($param["advcd"], 0, 4);
    $lastCd  = substr($param["advcd"], 4, 4);
    $ymCd    = substr($param["advcd"], 8, 2);
    $mediaCd = substr($param["advcd"], 10, 6);

    $adCdRule16Flag = true ;
    $AffiliateControlOBJ = AffiliateControl16::getInstance();
} else {
    $adCdRule16Flag = false ;
    $AffiliateControlOBJ = AffiliateControl::getInstance();
}

// ---<初期チェック>
// 登録アドレスドメインのチェック
if ($mailAddress) {
    // @以降の文字列を取得
    $mailHost = substr(strstr($mailAddress, "@"), 1);

    if (!$UserOBJ->chkRegistUserAddressDomain($mailHost)) {
        // NGドメインなのでさようなら
        $rootChild = $DOMDocumentOBJ->createElement("error");
        $root->appendChild($rootChild);
        $errorChild = $DOMDocumentOBJ->createElement("message", "有効なメールアドレスではありません。");
        $rootChild->appendChild($errorChild);
        print($DOMDocumentOBJ->saveXML());
        exit();
    }
}

// 以下の情報が無ければ抜ける
if (!$mailAddress || !ComValidation::isMailAddress($mailAddress)) {
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "メールアドレスがありません。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

// 登録ページの取得
$RegistPageOBJ = RegistPage::getInstance();
$registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd($param["id"]);
if (!$registPageData) {
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "対象データ取得時にエラーが発生しました。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

// 過去の「ブラック有効」and「退会者」の『再登録』は弾く
if ($quitBlackUserData = $UserOBJ->chkQuitBlackUser($mailAddress, $param["uid"])) {
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "Errorになりました。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

// 『メールアドレス』で重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
    // 『ログインID』で重複チェック
    if (!$duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress)) {
        if ($mbFlag) {
            // 『個体識別』で重複チェック
            $duplicateUserData = $UserOBJ->chkUserDataFromMbSerialNumber($param["uid"]);
        }
    }
}

// アフィリエイトデータの取得
$affiliateData = $AffiliateControlOBJ->getAffiliateDataFromAdvcd($param["advcd"]);

$registStatus = $_config["define"]["USER_REGIST_STATUS_MEMBER"];

// 仮登録用か本登録用か確認
if (!$affiliateData OR $affiliateData["is_pre_regist"]) {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_PRE_REGIST;
} else {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_REGIST;
}

// 重複データがあった場合
if ($duplicateUserData) {
    //登録エラータグ発行
    $AffiliateControlOBJ->sendAffiliateData($duplicateUserData["user_id"], $param, $affiliateControlSendType, false);

    // ブラックは「ブラック用重複リメール」データの取得
    if ($duplicateUserData["danger_status"]) {
        $rootChild = $DOMDocumentOBJ->createElement("error");
        $root->appendChild($rootChild);
        $errorChild = $DOMDocumentOBJ->createElement("message", "Errorになりました。");
        $rootChild->appendChild($errorChild);
        print($DOMDocumentOBJ->saveXML());
        exit();
    } else {
        $rootChild = $DOMDocumentOBJ->createElement("error");
        $root->appendChild($rootChild);
        $errorChild = $DOMDocumentOBJ->createElement("message", "既に登録済みです。");
        $rootChild->appendChild($errorChild);
        print($DOMDocumentOBJ->saveXML());
        exit();
    }
}

// トランザクション開始
$UserOBJ->beginTransaction();

$ComUtilityOBJ = ComUtility::getInstance();

// userデータを挿入
$currentDateTime = date("Y-m-d H:i:s");
$accessKey      = $UserOBJ->getNewAccessKey( $currentDateTime );
$remailKey      = $UserOBJ->getNewRemailKey( $currentDateTime );

$password = ComUtility::getRamdomNumber(4);
$server["HTTP_X_FORWARDED_FOR"] = $requestOBJ->getParameter("HTTP_X_FORWARDED_FOR", "", "server");

$userAry = array(
    "login_id"          => $mailAddress,
    "password"            => $UserOBJ->createPasswordKey($password),
    "access_key"          => $accessKey,
    "remail_key"          => $remailKey,
    "regist_status"         => $registStatus,
    "media_cd"               => $param["advcd"],
    "pre_regist_datetime" => $currentDateTime,
    "update_datetime" => $currentDateTime,
);

//アドコードルール16桁用
if($adCdRule16Flag){
	$userAry["affiliate_first_cd"] = $firstCd ;
	$userAry["affiliate_last_cd"] = $lastCd ;
	$userAry["affiliate_ym_cd"] = $ymCd ;
	$userAry["affiliate_media_cd"] = $mediaCd ;
}

if ($registStatus == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
    $userAry["regist_datetime"] = $currentDateTime;
}
$userAry["regist_page_id"] = $registPageData["id"];
$userAry["affiliate_value"] =  $affiliateValue;

if ($mbFlag) {
    $deviceCd    = $ComUtilityOBJ->getDeviceFromMailAddress($mailAddress);
    $userAry["mb_address"] = $mailAddress;
    $userAry["mb_device_cd"] = $deviceCd;
    $userAry["mb_ip_address"] = $param["ip"];
    $userAry["mb_serial_number"] = $param["uid"];
} else {
    $userAry["pc_address"] = $mailAddress;
    $userAry["pc_device_cd"] = $_config["define"]["DEVICE_PC"];
    $userAry["pc_ip_address"] = $server["HTTP_X_FORWARDED_FOR"];
}

// userテーブルへのインサート処理
if (!$UserOBJ->insertUserData($userAry)) {
    $UserOBJ->rollbackTransaction();
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "登録できませんでした。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

$userId = $UserOBJ->getInsertId();

$profileAry = array(
    "user_id"                 => $userId,
    "by_user_update_datetime" => $currentDateTime,
    "update_datetime"         => $currentDateTime,
);

if (ComValidation::isNumeric($param["s"])) {
    $profileAry["sex_cd"] = $param["s"];
}
// タイムスタンプで来る
if (ComValidation::isNumeric($param["b"])) {
    $profileAry["birth_date"] = date("Y-m-d", $param["b"]);
}

if ($mbFlag) {
    $profileAry["mb_is_mailmagazine"] = $_config["define"]["ADDRESS_SEND_STATUS_DO"];
} else {
    $profileAry["pc_is_mailmagazine"] = $_config["define"]["ADDRESS_SEND_STATUS_DO"];
}
// profileテーブルへのインサート処理
if (!$UserOBJ->insertProfileData($profileAry)) {
    $UserOBJ->rollbackTransaction();
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "登録できませんでした。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

$userData = $UserOBJ->getUserData($userId) ;

// トランザクションコミット
$UserOBJ->commitTransaction();

// サイト間登録通信
$RegistSiteOBJ = RegistSite::getInstance();
$RegistSiteOBJ->sendRegistSiteData($mailAddress);
$updateRegistSiteData = "";
$updateRegistSiteData["user_id"] = $userId;
$updateRegistSiteData["update_datetime"] = date("YmdHis");

$whereRegistSiteArray = "";
$whereRegistSiteArray[] = "mail_address = '" . $mailAddress . "'";
$whereRegistSiteArray[] = "disable = 0";
$RegistSiteOBJ->updateRegistSiteLogData($updateRegistSiteData, $whereRegistSiteArray);

//ﾜﾝｸﾘｯｸﾕｰｻﾞｰは問答無用で本登録
// 登録タグ発行
$AffiliateControlOBJ->sendAffiliateData($userId, $param, $affiliateControlSendType);
$rootChild = $DOMDocumentOBJ->createElement("user_ack", $userData["access_key"]);
$root->appendChild($rootChild);
print($DOMDocumentOBJ->saveXML());

exit();
?>

