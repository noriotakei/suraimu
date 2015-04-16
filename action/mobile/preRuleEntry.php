<?php
/**
 * preRuleEntry.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB応募規約についてページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preRuleEntryData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_RULE_ENTRY);

$smartyOBJ->assign("preRuleEntryData", $preRuleEntryData["html_contents_mb"]);

?>
