<?php
/**
 * cushion.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 *  ファイセムつなぎ込み登録処理ファイル。
 *  mail=***&id=ファイセムID&uid=個体識別
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

$AffiliateControlOBJ = AffiliateControl::getInstance();
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

// 個体識別のチェック(個体識別番号が「有るか」or「 無いか」)
if ($mbFlag AND !$param["uid"]) {
    $rootChild = $DOMDocumentOBJ->createElement("error");
    $root->appendChild($rootChild);
    $errorChild = $DOMDocumentOBJ->createElement("message", "個体識別番号がありません。");
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
    $errorChild = $DOMDocumentOBJ->createElement("message", "データが不正です。");
    $rootChild->appendChild($errorChild);
    print($DOMDocumentOBJ->saveXML());
    exit();
}

/*
// 修正前処理
// メアドの重複チェック
if (!$duplicateUserData = $UserOBJ->getUserDataFromMailAddress($mailAddress)) {
    if (!$duplicateUserData = $UserOBJ->chkUserDataFromLoginId($mailAddress)) {
        if ($mbFlag) {
            // 個体識別の重複チェック
            $duplicateUserData = $UserOBJ->chkUserDataFromMbSerialNumber($param["uid"]);
        }
    }
}
*/

// 過去の「ブラック有効」and「退会者」の『再登録』は弾く
if ($quitBlackUserData = $UserOBJ->chkQuitBlackUser($mailAddress, $param["uid"])) {
    if ($mbFlag) {
        // MB
        $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);
        $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $quitBlackUserData["user_id"]);
        // メール送信
        $AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
        exit();
    } else {
        // PC
        $rootChild = $DOMDocumentOBJ->createElement("error");
        $root->appendChild($rootChild);
        $errorChild = $DOMDocumentOBJ->createElement("message", "Errorになりました。");
        $rootChild->appendChild($errorChild);
        print($DOMDocumentOBJ->saveXML());
        exit();
    }
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

// 仮登録用か本登録用か確認
// アフィリエイトデータが無ければとりあえず仮登録
if (!$affiliateData OR $affiliateData["is_pre_regist"]) {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_PRE_REGIST;
    $registStatus = $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"];
} else {
    $affiliateControlSendType = AffiliateControl::SEND_TYPE_REGIST;
    $registStatus = $_config["define"]["USER_REGIST_STATUS_MEMBER"];
}

// 重複データがあった場合
if ($duplicateUserData) {
    //登録エラータグ発行
    $AffiliateControlOBJ->sendAffiliateData($duplicateUserData["user_id"], $param, $affiliateControlSendType, false);

    // ブラックは「ブラック用重複リメール」データの取得
    if ($duplicateUserData["danger_status"]) {
        if ($mbFlag) {
            // リメールデータ取得（MBのみ）
            $mailElementsData = $AutoMailOBJ->getAutoMailData("regist_danger", "registed_danger", $mailAddress);
        } else {
            // PCはメッセージ表示
            $rootChild = $DOMDocumentOBJ->createElement("error");
            $root->appendChild($rootChild);
            $errorChild = $DOMDocumentOBJ->createElement("message", "Errorになりました。");
            $rootChild->appendChild($errorChild);
            print($DOMDocumentOBJ->saveXML());
            exit();
        }
    } else {
        // 「退会者(ブラック)」以外は通常重複リメール（仮・本登録のみ）
        if ($mbFlag) {
            // 通常重複リメールデータの取得（MBのみ）
            $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "registed", $mailAddress);
        } else {
            // PCはメッセージ表示
            $rootChild = $DOMDocumentOBJ->createElement("error");
            $root->appendChild($rootChild);
            $errorChild = $DOMDocumentOBJ->createElement("message", "既に登録済みです。");
            $rootChild->appendChild($errorChild);
            print($DOMDocumentOBJ->saveXML());
            exit();
        }
    }

    // メール配信
    if ($mailElementsData) {
        $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $duplicateUserData["user_id"]);
        // メール送信
        $AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);
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

// 指定の媒体からの登録は送信ステータスを『メールしない』にする
// 以下、そのうち処理毎消します。2010-11-30 hosoda
if ($param["advcd"] == "to20016") {
    if ($mbFlag) {
        $userAry["mb_send_status"] = $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
    } else {
        $userAry["pc_send_status"] = $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
    }
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

// 指定の媒体からの登録は受信ステータスを『受け取らない』にする
// 以下、そのうち処理毎消します。2010-11-30 hosoda
if ($param["advcd"] == "to20016") {
    if ($mbFlag) {
        $profileAry["mb_is_mailmagazine"] = $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
    } else {
        $profileAry["pc_is_mailmagazine"] = $_config["define"]["ADDRESS_SEND_STATUS_FAIL"];
    }
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

// トランザクションコミット
$UserOBJ->commitTransaction();

//-20100701-takuro 『noRemail』がTRUEならﾘﾒｰﾙ送信処理を行わない
if($param["noRemail"] != TRUE){

    $convAry = array("-%password-" => $password);

    // 登録完了メールを送信
    // メール文言取得
    if ($registPageData) {
        // リメールデータの取得
        $mailElementsData = $RegistPageOBJ->getRegistPageMailData($registPageData["id"], $mailAddress);
    } else {
        // リメールデータの取得(本登録完了リメール)
        $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "regist_end", $mailAddress);
    }

    $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userId, $convAry);
    // メール送信
    $AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);

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

// 仮登録用か本登録用か確認
// アフィリエイトデータが無ければとりあえず仮登録
if (!$affiliateData OR $affiliateData["is_pre_regist"]) {
    // 登録タグ発行
    $AffiliateControlOBJ->sendAffiliateData($userId, $param, $affiliateControlSendType);
    $rootChild = $DOMDocumentOBJ->createElement("regist_flow", 1);
    $root->appendChild($rootChild);
    print($DOMDocumentOBJ->saveXML());
// 本登録
} else {
    // 登録タグ発行 タグがなければNO_TAGを格納
    if (!$AffiliateControlOBJ->sendAffiliateData($userId, $param, $affiliateControlSendType)) {
        $userAffiliateUpdateArray= "";
        $userAffiliateUpdateArray["affiliate_tag_url"] = "NO_TAG";
        // userテーブルへの更新処理
        $UserOBJ->updateUserData($userAffiliateUpdateArray, array("id = " . $userId));
    }

    $KeyConvertOBJ = KeyConvert::getInstance();
    // 変換処理
    $registPageData["regist_url"] = $KeyConvertOBJ->execConvert($registPageData["regist_url_pc"], $userId);

    $rootChild = $DOMDocumentOBJ->createElement("regist_flow", 2);
    $root->appendChild($rootChild);
    $rootChild = $DOMDocumentOBJ->createElement("url", $registPageData["regist_url"]);
    $root->appendChild($rootChild);
    print($DOMDocumentOBJ->saveXML());
}
exit();
?>
