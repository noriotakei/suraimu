<?php

/**
 * basLogList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面銀行振込リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "bas.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "bas.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 登録日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "bas.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "bas.create_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "bas.*";

// 銀行振込リスト
$dataList = $AdmCalculationOBJ->getCalcBasLogList($param, $columnArray, $defaultWhereArray, $otherArray);

$res = array(
          'success' => true,
          'rows' => $dataList
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
