<?php
/**
 * outline.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後特定商取引法ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      ryohei murata
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$outLineData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_OUTLINE);

$smartyOBJ->assign("outLineData", $outLineData["html_contents_mb"]);

?>
