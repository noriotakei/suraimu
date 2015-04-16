<?php
/**
 * preOutLine.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB特定商取引法による表記ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preOutLineData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_OUTLINE);

$smartyOBJ->assign("preOutLineData", $preOutLineData["html_contents_mb"]);

?>
