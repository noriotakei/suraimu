<?php

/**
 * informationStatusCntOfDay.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面情報閲覧回数リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "isl.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "isl.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 閲覧日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "isl.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "isl.create_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "DATE_FORMAT(isl.create_datetime,'%Y-%m-%d') AS create_date";
$columnArray[] = "infs.id";
$columnArray[] = "infs.name";
$columnArray[] = "COUNT(isl.id) cnt";

$otherArray[] = "GROUP BY DATE_FORMAT(isl.create_datetime,'%Y-%m-%d'), infs.id";
$otherArray[] = "ORDER BY cnt DESC";

// 情報閲覧回数リスト
$dataList = $AdmCalculationOBJ->getCalcInformationStatusLogList($param, $columnArray, $defaultWhereArray, $otherArray);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("weekArray", AdmCalculation::$_weekArray);
?>
