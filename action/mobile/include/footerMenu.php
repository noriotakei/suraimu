<?php
/**
 * footerMenu.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後フッターメニューページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$footerMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_FOOTER_MENU,$comUserData["user_id"]);

$smartyOBJ->assign("footerMenuData", $footerMenuData["html_contents_mb"]);

?>
