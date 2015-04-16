<?php
/**
 * preFooterMenu.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前フッターメニューページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

if ($registPageData["cd"] == "index") {
    $preFooterMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRE_FOOTER_MENU);
} else {
    $preFooterMenuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_REGIST_PAGE_FOOTER_MENU);
}

$smartyOBJ->assign("preFooterMenuData", $preFooterMenuData["html_contents_mb"]);

?>
