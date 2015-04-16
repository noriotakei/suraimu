<?php
/**
 * preHeader.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前キーワード、ディスクリプション処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$keywordData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_KEYWORD);
$descriptionData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_DESCRIPTION);

$smartyOBJ->assign("keywords", $keywordData["html_contents_mb"]);
$smartyOBJ->assign("description", $descriptionData["html_contents_mb"]);
?>
