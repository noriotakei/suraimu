<?php
/**
 * rule.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC利用規約ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$ruleData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_RULE);

$smartyOBJ->assign("ruleData", $ruleData["html_contents_pc"]);

?>
