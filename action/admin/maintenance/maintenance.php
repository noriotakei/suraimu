<?php
/**
 * maintenance.php
 *
 * メンテナンス管理
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$currentMaintenance = Maintenance::checkMaintenance();
$smartyOBJ->assign("currentMaintenance", $currentMaintenance);
?>