<?php
/**
 * status.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後会員ステータス処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */

$SiteContentsOBJ = SiteContents::getInstance();

$menuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_MEMBER_STATUS,$comUserData["user_id"]);

$smartyOBJ->assign("memberStatus", $menuData["html_contents_pc"]);

?>
