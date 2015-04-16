<?php

/**
 * pointLogList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ポイントログリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmPointLogOBJ = AdmPointLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$userData =$AdminUserOBJ->getUserData($param["user_id"]);
$smartyOBJ->assign("userData", $userData);

// ポイントログリスト
$dataList = $AdmPointLogOBJ->getPointLogList($param, "", "create_datetime DESC", "");

$smartyOBJ->assign("dataList", $dataList);

$smartyOBJ->assign("pointLogType", AdmPointLog::$_pointLogType);

?>
