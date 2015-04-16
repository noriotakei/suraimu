<?php

/**
 * registMonthPaymentListPayGraph.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面当月登録入金者リスト入金金額グラフページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);
// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-d 00:00:00", strtotime($param["start_date"])) . "'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-d 23:59:59", strtotime($param["end_date"])) . "'";
}

// 登録日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray = "";
$otherArray = "";

$columnArray[] = "CAST(u.first_pay_datetime AS DATE) AS first_pay_date";
$columnArray[] = "SUM(u.total_payment) as sum_total_payment";

$whereArray[] = "u.first_pay_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
$whereArray[] = "u.first_pay_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";

$otherArray[] = "GROUP BY first_pay_date ORDER BY first_pay_date";

// 合計金額
$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["first_pay_date"]]["total_payment"] = $val["sum_total_payment"];
    $totalPayment +=  $val["sum_total_payment"];
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $dispDay[] = $date;
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $jsPaymentDataList[] = "[" . ($dispDataList[$date]["total_payment"] ? $dispDataList[$date]["total_payment"] : 0) . ", " . $i . "]";
}

foreach ((array)$jsUserCountDataList as $key => $val) {
    $jsDispUserCountDataList[$key] = implode(",", $val);
}

$smartyOBJ->assign("totalPayment", $totalPayment);
$smartyOBJ->assign("jsDispPaymentDataList", "[" . ($jsPaymentDataList ? implode(", ", $jsPaymentDataList) : ""). "]");
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
?>
