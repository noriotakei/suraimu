<?php
/**
 * preCompany.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB会社概要ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preCompanyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_COMPANY);

$smartyOBJ->assign("preCompanyData", $preCompanyData["html_contents_mb"]);

?>
