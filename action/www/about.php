<?php
/**
 * about.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC当サイトについてページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$aboutData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_ABOUT);

$smartyOBJ->assign("aboutData", $aboutData["html_contents_pc"]);

?>
