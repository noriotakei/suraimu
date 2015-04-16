<?php
/**
 * company.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後会社概要ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$companyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_COMPANY);

$smartyOBJ->assign("companyData", $companyData["html_contents_mb"]);

?>
