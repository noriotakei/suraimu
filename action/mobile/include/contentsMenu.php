<?php
/**
 * contentsMenu.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後コンテンツメニューページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$contentsMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_CONTENTS_MENU);

$smartyOBJ->assign("contentsMenuData", $contentsMenuData["html_contents_mb"]);

?>
