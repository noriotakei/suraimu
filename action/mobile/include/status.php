<?php
/**
 * status.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後ユーザー処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$SiteContentsOBJ = SiteContents::getInstance();

$menuData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_MEMBER_STATUS,$comUserData["user_id"]);

$smartyOBJ->assign("memberStatus", $menuData["html_contents_mb"]);

?>
