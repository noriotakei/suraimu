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

$easyLoginData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_EASY_LOGIN);

$smartyOBJ->assign("easyLoginData", $easyLoginData["html_contents_mb"]);

?>
