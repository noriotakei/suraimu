<?php

/**
 * firstPayDailyList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面初入金者集計(日毎)リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.first_pay_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.first_pay_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 入金日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.first_pay_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "u.first_pay_datetime <= '" . $param["date"] . " 23:59:59'";
}

// 初回入金者数
$columnArray = "";
$otherArray= "";

$columnArray[] = "u.*";

$otherArray[] = "ORDER BY u.first_pay_datetime";

$dispDataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray, $otherArray);

$smartyOBJ->assign("dispDataList", $dispDataList);

?>
