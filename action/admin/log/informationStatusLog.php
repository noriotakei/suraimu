<?php

/**
 * informationStatusLog.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面情報ログリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmInformationStatusLogOBJ = AdmInformationStatusLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$userData =$AdminUserOBJ->getUserData($param["user_id"]);
$smartyOBJ->assign("userData", $userData);

// ポイントログリスト
$dataList = $AdmInformationStatusLogOBJ->getInformationStatusLogList($param, "", "log.create_datetime DESC", "");

$smartyOBJ->assign("dataList", $dataList);
?>
