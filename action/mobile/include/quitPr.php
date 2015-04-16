<?php
/**
 * quitPr.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB退会PRページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$quitPrData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_QUIT_PR,$comUserData["user_id"]);

$smartyOBJ->assign("quitPrData", $quitPrData["html_contents_mb"]);

?>
