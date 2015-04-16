<?php

/**
 * registMonthPaymentListUserGraph.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面当月登録入金者リスト入金者グラフページ処理ファイル。
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

// 人数
$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["first_pay_date"]]["user"] = $val["user"];
    $dispDataList[$val["first_pay_date"]]["quit_user"] = $val["quit_user"];
    $totalUser +=  $val["user"] +  $val["quit_user"];
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $dispDay[] = $date;
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $jsUserCountDataList["user"][] = "[" . ($dispDataList[$date]["user"] ? $dispDataList[$date]["user"] : 0) . ", " . $i . "]";
    $jsUserCountDataList["quit_user"][] = "[" . ($dispDataList[$date]["quit_user"] ? $dispDataList[$date]["quit_user"] : 0) . ", " . $i . "]";
}

foreach ((array)$jsUserCountDataList as $key => $val) {
    $jsDispUserCountDataList[$key] = implode(",", $val);
}

$jsLabel = "{label: '本登録入金会員人数'},{label: '登録解除入金会員人数'}";

$smartyOBJ->assign("dispDay", $dispDay);
$smartyOBJ->assign("jsDispUserCountDataList", "[" . ($jsDispUserCountDataList ? implode("], [", $jsDispUserCountDataList) : "") . "]");
$smartyOBJ->assign("jsLabel", $jsLabel);
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
$smartyOBJ->assign("totalUser", $totalUser);
?>
