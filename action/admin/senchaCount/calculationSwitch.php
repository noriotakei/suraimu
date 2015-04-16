<?php

/**
 * caluculationSwitch.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー登録リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
$param = $requestOBJ->getParameterExcept($exceptArray);
$dataActionFileName = "senchaCount_" . $param["file_name"];
$jsonParam["serialize"] = urlencode(serialize($param));
$param["action_" . $dataActionFileName] = 1;
$jsonParam["action_" . $dataActionFileName] = 1;
$jsonParam = json_encode($jsonParam);
$smartyOBJ->assign("jsonParam", $jsonParam);
$getParam = http_build_query($param);
$smartyOBJ->assign("getParam", $getParam);
$controllerOBJ->setActionName($dataActionFileName);
$smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
?>
