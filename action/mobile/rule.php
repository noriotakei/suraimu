<?php
/**
 * rule.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後利用規約ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$SiteContentsOBJ = SiteContents::getInstance();

$ruleData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_RULE);

$smartyOBJ->assign("ruleData", $ruleData["html_contents_mb"]);

?>
