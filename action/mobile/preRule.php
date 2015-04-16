<?php
/**
 * preRule.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB利用規約ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preRuleData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_RULE);

$smartyOBJ->assign("preRuleData", $preRuleData["html_contents_mb"]);

?>
