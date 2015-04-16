<?php
/**
 * preHeaderMenu.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前ヘッダーメニュー処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$menuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRE_CONTENTS_MENU);

$smartyOBJ->assign("menu", $menuData["html_contents_pc"]);

?>
