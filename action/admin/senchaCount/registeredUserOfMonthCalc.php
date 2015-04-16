<?php

/**
 * registeredUserOfMonthCalc.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー登録数月間リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
unset($param["action_senchaCount_RegisteredUserOfMonth"]);
$serializeParam["serialize"] = urlencode(serialize($param));
$serializeParam["action_senchaCount_" . $param["file_name"] . "Data"] = 1;
$jsonParam = json_encode($serializeParam);
$smartyOBJ->assign("jsonParam", $jsonParam);
$smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
?>
