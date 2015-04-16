<?php
/**
 * privacy.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCプライバシーポリシーページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$privacyData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PRIVACY);

$smartyOBJ->assign("privacyData", $privacyData["html_contents_pc"]);

?>
