<?php
/**
 * quitPrStart.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB退会スタートPRページ処理ファイル。
 *
 * @copyright   2011 Fraise, Inc.
 * @author      norihisa hosoda
 */

 $SiteContentsOBJ = SiteContents::getInstance();

$quitPrStartData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_QUIT_START_PR,$comUserData["user_id"]);

$smartyOBJ->assign("quitPrStartData", $quitPrStartData["html_contents_mb"]);

?>
