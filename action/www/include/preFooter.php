<?php
/**
 * preFooter.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前フッター処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$footerMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRE_FOOTER_MENU);

$smartyOBJ->assign("footerMenu", $footerMenuData["html_contents_pc"]);

?>
