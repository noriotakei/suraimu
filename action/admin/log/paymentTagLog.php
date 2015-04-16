<?php

/**
 * paymentTagLog.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面情報ログリストページ処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

 $AffiliateControlOBJ = AffiliateControl::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$userData =$AdminUserOBJ->getUserData($param["user_id"]);
$smartyOBJ->assign("userData", $userData);

// 入金発行タグログリスト
$dataList = $AffiliateControlOBJ->getPaymentTagLogData($param["user_id"]);

$smartyOBJ->assign("dataList", $dataList);
?>
