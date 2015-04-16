<?php
/**
 * preOn.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB固体識別ONの説明ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$preOnData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_MOBILE_SERIAL_NUMBER);

$smartyOBJ->assign("preOnData", $preOnData["html_contents_mb"]);

?>
