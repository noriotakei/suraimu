<?php
/**
 * regist.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 仮登録完了処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

mb_send_mail("norihisa_hosoda@gdmm.co.jp", "test", "test1", "");

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}

// 標準入力からメール情報を取得し、解析する
$ComMimeParserMailOBJ = ComMimeParserMail::getInstance();
$BlackListOBJ        = BlackList::getInstance();
$AllowDomainOBJ      = AllowDomain::getInstance();

// 登録オブジェクトの作成
$PreRegistOBJ = PreRegist::getInstance();
$UserOBJ = User::getInstance();
// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

$headers = $ComMimeParserMailOBJ->getHeaders();

// 携帯メールアドレスである
if (ComValidation::isMobileAddress($headers["from"])) {
    $mbFlag = true;
}
// 送信元メアドの取得
$mailAddress = $headers["from"];

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
    //ここに登録拒否のエラー処理を記述。
    $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);
    $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"]);
    // メール送信
    //$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
	$AutoMailOBJ->smtpMailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
    exit();
}

// ---<初期チェック>
// 登録アドレスドメインのチェック
if ($mailAddress) {
    // @以降の文字列を取得
    $mailHost = substr(strstr($mailAddress, "@"), 1);

    if (!$UserOBJ->chkRegistUserAddressDomain($mailHost)) {
        // NGドメインなのでさようなら
        exit();
    }
}

// 以下の情報が無ければ抜ける
if (!$mailAddress AND !ComValidation::isMailAddress($mailAddress)) {
    exit();
}

// 識別キーの取得
$matches = array();

if (preg_match("/^regist-([0-9a-f]+)@.*/", $headers["to"], $matches)) {
    $remailKey = $matches[1];
} else {
    $direct = true;
}

// リメールキーがあれば仮登録テーブルを調べる
if ($remailKey) {

    $preRegistData = $PreRegistOBJ->getPreRegistDataFromRemailKey($remailKey);
    if (!$preRegistData) {
        exit();
    }

    //登録時の引数を変数に格納
    parse_str($preRegistData["affiliate_value"], $aryAffiliateValue);
    //登録タグ返還用にメールアドレスを追加
    $aryAffiliateValue["mail_address"] = urlencode($mailAddress);
    if ($aryAffiliateValue["ad_code"]) {
        $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
    }

    //新旧のアドルールで使用するクラスファイルを選択
    if(AffiliateControl16::ROUTES_CD_LENGTH == strlen($aryAffiliateValue["advcd"])){
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

    if ($mbFlag) {
        // 個体識別の重複チェック(「退会者」以外)
        $userData = $UserOBJ->chkUserDataFromMbSerialNumber($preRegistData["mb_serial_number"]);

        // 重複個体識別があった場合
        if ($userData) {
            // 初期化
            $mailElementsData = "";
            // リメールデータの取得
            if ($userData["danger_status"]) {
                // ブラックはブラック用重複リメールデータの取得
                $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);
            } else {
                // 通常重複リメールデータの取得
                $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "registed", $mailAddress);
            }

            if ($mailElementsData) {
                //登録エラータグ発行
                $AffiliateControlOBJ->sendAffiliateData($userData["user_id"], $aryAffiliateValue, $affiliateControlSendType, false);

                // 個体識別重複登録メール送信
                $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"]);
                // メール送信
                //$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
                $AutoMailOBJ->smtpMailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
                exit();
            }
        }
    }
} else {

    if($directRegistData = $PreRegistOBJ->getDirectRegistData($headers["to"])){
        $aryAffiliateValue["advcd"] = $directRegistData["media_cd"];
    }else{
        $aryAffiliateValue["advcd"] = $_config["define"]["DIRECT_AD_CD"];
    }

    //新旧のアドルールで使用するクラスファイルを選択
    if(AffiliateControl16::ROUTES_CD_LENGTH == strlen($aryAffiliateValue["advcd"])){
        $adCdRule16Flag = true ;
        $AffiliateControlOBJ = AffiliateControl16::getInstance();
    } else {
        $adCdRule16Flag = false ;
        $AffiliateControlOBJ = AffiliateControl::getInstance();
    }

    $affiliateControlSendType = AffiliateControl::SEND_TYPE_PRE_REGIST;
    $registStatus = $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"];

}

// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
    // メールアドレスで取得出来なかったら、「ログインID」で取得
    $duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress);
}

// 重複メアドがあった場合
if ($duplicateUserData) {
    // 初期化
    $mailElementsData = "";
    if ($duplicateUserData["danger_status"]) {
        // ブラック用重複リメールデータの取得
        $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);
    } else {
        // 通常重複リメールデータの取得
        $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "registed", $mailAddress);
    }

    if ($mailElementsData) {
        //登録エラータグ発行
        $AffiliateControlOBJ->sendAffiliateData($duplicateUserData["user_id"], $aryAffiliateValue, $affiliateControlSendType, false);

        // メアド重複登録メール送信
        $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $duplicateUserData["user_id"]);
        // メール送信
        //$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
        $AutoMailOBJ->smtpMailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
        exit();
    }
}

// 「メールアドレス」,「個体識別」を元に、「退会者」で「ブラック」かチェック
if ($quitBlackUserData = $UserOBJ->chkQuitBlackUser($mailAddress, $preRegistData["mb_serial_number"])) {
    // 初期化
    $mailElementsData = "";

    // ブラックはブラック用重複リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);

    // リメール送信
    if ($mailElementsData) {
        //登録エラータグ発行
        $AffiliateControlOBJ->sendAffiliateData($quitBlackUserData["user_id"], $aryAffiliateValue, $affiliateControlSendType, false);

        // 個体識別重複登録メール送信
        $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $quitBlackUserData["user_id"]);
        // メール送信
        //$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
        $AutoMailOBJ->smtpMailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
        exit();
    }
}

// トランザクション開始
$UserOBJ->beginTransaction();

$ComUtilityOBJ = ComUtility::getInstance();

// userデータを仮登録で挿入
$currentDateTime = date("Y-m-d H:i:s");
$accessKey      = $UserOBJ->getNewAccessKey( $currentDateTime );
$remailKey      = $UserOBJ->getNewRemailKey( $currentDateTime );

$password = ComUtility::getRamdomNumber(4);

$userAry = array(
    "login_id"          => $mailAddress,
    "password"            => $UserOBJ->createPasswordKey($password),
    "access_key"          => $accessKey,
    "remail_key"          => $remailKey,
    "regist_status"       => $registStatus,
    "media_cd"               => $aryAffiliateValue["advcd"],
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

if ($preRegistData) {
    $userAry["regist_page_id"] = $preRegistData["regist_page_id"];
    $userAry["affiliate_value"] = $preRegistData["affiliate_value"];
}else if($directRegistData){
    $userAry["regist_page_id"] = $directRegistData["regist_page_id"];
}

if ($mbFlag) {
    $deviceCd    = $ComUtilityOBJ->getDeviceFromMailAddress($mailAddress);
    $userAry["mb_address"] = $mailAddress;
    $userAry["mb_device_cd"] = $deviceCd;
    if ($preRegistData) {
        $userAry["mb_user_agent"] = $preRegistData["user_agent"];
        $userAry["mb_ip_address"] = $preRegistData["ip_address"];
        $userAry["mb_serial_number"] = $preRegistData["mb_serial_number"];
    }
} else {
    $userAry["pc_address"] = $mailAddress;
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

// 指定の媒体からの登録は受信ステータスを『受け取らない』にする
// 以下、そのうち処理毎消します。2010-11-30 hosoda
if ($aryAffiliateValue["advcd"] == "to20016") {
    $preRegistData["is_no_send_status"] = 1;
}

if ($mbFlag) {
    $profileAry["mb_is_mailmagazine"] = $preRegistData["is_no_send_status"] ? $_config["define"]["ADDRESS_SEND_STATUS_FAIL"] : $_config["define"]["ADDRESS_SEND_STATUS_DO"];
}else {
    $profileAry["pc_is_mailmagazine"] = $preRegistData["is_no_send_status"] ? $_config["define"]["ADDRESS_SEND_STATUS_FAIL"] : $_config["define"]["ADDRESS_SEND_STATUS_DO"];
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

    // 指定の媒体からの登録は受信ステータスを『受け取らない』にする
    // 以下、そのうち処理毎消します。2010-11-30 hosoda
    if ($aryAffiliateValue["advcd"] == "to20016") {
        $preRegistAry["is_no_send_status"] = 1;
    }

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
if ($userAry["regist_page_id"]) {
    $RegistPageOBJ = RegistPage::getInstance();
    // リメールデータの取得
    $mailElementsData = $RegistPageOBJ->getRegistPageMailData($userAry["regist_page_id"], $mailAddress);
// 直接登録者
} else {
    // リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "direct_regist", $mailAddress);
}

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

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userId, $convAry);

// メール送信
/*
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    exit();
}
*/
if (!$AutoMailOBJ->smtpMailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    exit();
}


exit("COMPLETE");
?>
