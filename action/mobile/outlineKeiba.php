<?php
/**
 * outlineKeiba.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB競馬法に基づく表記ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$outlineKeibaData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_OUTLINE_KEIBA);

$smartyOBJ->assign("outlineKeibaData", $outlineKeibaData["html_contents_mb"]);

?>
