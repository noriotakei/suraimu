<?php

/**
 * paymentLog.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金ログリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$userData =$AdminUserOBJ->getUserData($param["user_id"]);
$smartyOBJ->assign("userData", $userData);

// ポイントログリスト
$dataList = $AdmPaymentLogOBJ->getPaymentLogList($param, "", "create_datetime DESC", "");

$smartyOBJ->assign("dataList", $dataList);
// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);

?>
