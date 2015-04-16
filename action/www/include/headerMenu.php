<?php
/**
 * headerMenu.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後ヘッダーメニュー処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$menuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_CONTENTS_MENU);

$smartyOBJ->assign("menu", $menuData["html_contents_pc"]);

?>
