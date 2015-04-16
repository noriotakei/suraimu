<?php
/**
 * setting.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCメール設定ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$settingData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_MAILSETTING);

$smartyOBJ->assign("settingData", $settingData["html_contents_pc"]);

?>
