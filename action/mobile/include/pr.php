<?php
/**
 * pr.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後アフィリエイト情報ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$prData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PR);

$smartyOBJ->assign("prData", $prData["html_contents_mb"]);

?>
