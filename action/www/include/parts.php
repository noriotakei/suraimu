<?php
/**
 * parts.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後表示挿し込み処理ファイル
 * 情報内に{parts}を設置して使用
 *
 * @copyright   2011 Fraise, Inc.
 * @author      ryohei murata
 */

$SiteContentsOBJ = SiteContents::getInstance();

$partsData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PARTS,$comUserData["user_id"]);

$smartyOBJ->assign("parts", $partsData["html_contents_pc"]);

?>
