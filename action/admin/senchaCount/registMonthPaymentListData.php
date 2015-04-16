<?php

/**
 * registMonthPaymentListData .php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面当月登録入金者リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

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
    $dispDataList[$val["first_pay_date"]]["total_payment"] = $val["sum_total_payment"];
    $dispDataList[$val["first_pay_date"]]["all_user"] += $val["user"]  + $val["quit_user"];

    $totalData["user"] += $val["user"];
    $totalData["quit_user"] += $val["quit_user"];
    $totalData["total_payment"] += $val["sum_total_payment"];
    $totalData["all_user"] += $val["user"]  + $val["quit_user"];
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $data = "";

    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $data["date"] = date("Y年m月d日", strtotime($date)) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $data["user"] = ($dispDataList[$date]["user"] ? $dispDataList[$date]["user"] : 0);
    $data["quit_user"] = ($dispDataList[$date]["quit_user"] ? $dispDataList[$date]["quit_user"] : 0);
    $data["total_payment"] = ($dispDataList[$date]["total_payment"] ? $dispDataList[$date]["total_payment"] : 0);
    $data["all_user"] = ($dispDataList[$date]["all_user"] ? $dispDataList[$date]["all_user"] : 0);
    $jsonData[] = $data;
}

$data = "";

$data["date"] = "合計";
$data["user"] = ($totalData["user"] ? $totalData["user"] : 0);
$data["quit_user"] = ($totalData["quit_user"] ? $totalData["quit_user"] : 0);
$data["total_payment"] = ($totalData["total_payment"] ? $totalData["total_payment"] : 0);
$data["all_user"] = ($totalData["all_user"] ? $totalData["all_user"] : 0);
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
