<?php
/**
 * outLine.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC特定商取引法による表記ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$outLineData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_OUTLINE);

$smartyOBJ->assign("outLineData", $outLineData["html_contents_pc"]);

?>
