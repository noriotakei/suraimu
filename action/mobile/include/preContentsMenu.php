<?php
/**
 * preContentsMenu.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前コンテンツメニューページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$preContentsMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRE_CONTENTS_MENU);

$smartyOBJ->assign("preContentsMenuData", $preContentsMenuData["html_contents_mb"]);
?>
