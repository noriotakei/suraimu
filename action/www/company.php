<?php
/**
 * company.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC会社概要ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$companyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_COMPANY);

$smartyOBJ->assign("companyData", $companyData["html_contents_pc"]);

?>
