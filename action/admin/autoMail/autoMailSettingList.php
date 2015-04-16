<?php
/**
 * autoMailSettingList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面リメール設定リストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admAutoMailOBJ = AdmAutoMail::getInstance();

$dataList = $admAutoMailOBJ->getAutoMailContentsList();

$smartyOBJ->assign("dataList", $dataList);
// 使用状況フラグ
$smartyOBJ->assign("isUse", AdmAutoMail::$_isUse);
?>
