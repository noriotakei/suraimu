<?php
/**
 * privacy.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBプライバシーステートメントページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$privacyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRIVACY);

$smartyOBJ->assign("privacyData", $privacyData["html_contents_mb"]);

?>
