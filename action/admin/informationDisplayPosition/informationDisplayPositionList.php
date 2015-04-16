<?php
/**
 * informationDisplayPositionList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面表示場所リストページ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// 表示場所名
$smartyOBJ->assign("displayPositionList", AdmInformationDisplayPosition::$_displayPositionName);

?>

