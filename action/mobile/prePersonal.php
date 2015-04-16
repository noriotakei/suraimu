<?php
/**
 * prePersonal.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MB個人情報保護方針ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$SiteContentsOBJ = SiteContents::getInstance();

$prePersonalData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_PERSONAL);

$smartyOBJ->assign("prePersonalData", $prePersonalData["html_contents_mb"]);

?>
