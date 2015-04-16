<?php
/**
 * index.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * モバイルインデックスページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");

header("Location: http://fm.ko-haito.com/?action_FrontDesk=true&id=c255fe6b39&ad_code=zz99999");

// 登録ページの取得
$RegistPageOBJ = RegistPage::getInstance();
$registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd($userSessOBJ->psd, $mailToConvertArray);
if (!$registPageData) {
    $registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd("index", $mailToConvertArray);
}
$smartyOBJ->assign("registPageData", $registPageData);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>
