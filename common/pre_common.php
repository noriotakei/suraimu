<?php
/**
 * web MBログイン前共通処理
 */

require_once(D_BASE_DIR . "/common/user_common.php");

// 登録時のQUERY_STRINGを配列に格納
parse_str($userSessOBJ->affiliate_value, $parseAffiliateData);

// リメールキーの格納
if ($parseAffiliateData[PreRegist::REMAIL_KEY_NAME]) {
    $userSessOBJ->remail_key = $parseAffiliateData[PreRegist::REMAIL_KEY_NAME];
}
// ページコードの格納
if ($parseAffiliateData[RegistPage::PAGE_CD_NAME]) {
    $userSessOBJ->psd = $parseAffiliateData[RegistPage::PAGE_CD_NAME];
}

$PreRegistOBJ = PreRegist::getInstance();
$preRegistData = $PreRegistOBJ->getPreRegistDataFromRemailKey($userSessOBJ->remail_key);

if (!$preRegistData) {

    // 仮登録テーブルに追加
    $currentDateTime = date("YmdHis");
    $remailKey = $PreRegistOBJ->getNewRemailKey( $currentDateTime );

    $setArray["remail_key"] = $remailKey;
    $setArray["user_agent"] = $server["HTTP_USER_AGENT"] ;
    $setArray["mb_serial_number"] = $mbSerialNo;
    $setArray["ip_address"] = $server["REMOTE_ADDR"];
    $setArray["affiliate_value"] = $userSessOBJ->affiliate_value;
    $setArray["create_datetime"] = date("YmdHis");
    $RegistPageOBJ = RegistPage::getInstance();
    $registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd($userSessOBJ->psd, $mailToConvertArray);
    if (!$registPageData) {
        $registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd("index", $mailToConvertArray);
    }
    $setArray["regist_page_id"] = $registPageData["id"];

    if (!$PreRegistOBJ->insertPreRegistData($setArray)) {
        $ComErrSessOBJ->errMsg = $PreRegistOBJ->getErrorMsg;
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam : "") . ($sessId ? "&" . $sessId : ""));
        exit();
    }
    $userSessOBJ->remail_key = $remailKey;
    $preRegistData = $PreRegistOBJ->getPreRegistDataFromRemailKey($userSessOBJ->remail_key);

}

if ($userSessOBJ->remail_key) {
    if (!$userSessOBJ->psd OR $userSessOBJ->psd == "index" OR $userSessOBJ->psd == "PR") {
        // maito文言
        $SiteContentsOBJ = SiteContents::getInstance();
        $mailToBodyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_INDEX_MAILBODY);
        // デフォルトページの空メール文言を変える 改行コードは\r\nでないと、docomoが対応しません
        $mailToBody = ComUtility::mailtoEncode(str_replace("\n", "\r\n", ($isURIMobile ? $mailToBodyData["html_contents_mb"] : $mailToBodyData["html_contents_pc"])),$isSmartPhone);
    } else {
        $mailToBody = ComUtility::mailtoEncode("このまま送信してください",$isSmartPhone);
    }
    $mailToSubject = ComUtility::mailtoEncode($_config["define"]["SITE_NAME"],$isSmartPhone);
    $mailto =  RegistPage::MAILTO_TOADDRESS_FIRST . $userSessOBJ->remail_key . "@" . $_config["define"]["MAIL_DOMAIN"];
    $mailToConvertArray["-%mailto-"] = $mailto . "?subject=" . $mailToSubject . "&body=" . $mailToBody;
}

?>