<?php
/**
 * preAbout.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB当サイトについてページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preAboutData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_ABOUT);

$smartyOBJ->assign("preAboutData", $preAboutData["html_contents_mb"]);

?>
