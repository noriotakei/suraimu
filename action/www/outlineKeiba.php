<?php
/**
 * outlineKeiba.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC競馬法に基づく表記ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$outlineKeibaData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_OUTLINE_KEIBA);

$smartyOBJ->assign("outlineKeibaData", $outlineKeibaData["html_contents_pc"]);

?>
