<?php
/**
 * indexPreview.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * モバイルインデックスプレビューページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/user_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
if ($param[RegistPage::PAGE_CD_NAME]) {
    $userSessOBJ->psd = $param[RegistPage::PAGE_CD_NAME];
}

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
$mailto =  RegistPage::MAILTO_TOADDRESS_FIRST . "@" . $_config["define"]["MAIL_DOMAIN"];
$mailToConvertArray["-%mailto-"] = $mailto . "?subject=" . $mailToSubject . "&body=" . $mailToBody;

// 登録ページの取得
$RegistPageOBJ = RegistPage::getInstance();
$registPageData = $RegistPageOBJ->getRegistPagePreviewDataForRegistCd($userSessOBJ->psd, $mailToConvertArray);
if (!$registPageData) {
    $registPageData = $RegistPageOBJ->getRegistPagePreviewDataForRegistCd("index", $mailToConvertArray);
}
$smartyOBJ->assign("registPageData", $registPageData);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>
