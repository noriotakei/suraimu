<?php

/**
 * registeredUserOfMonthGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー登録数月間リストページグラフ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));
$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 仮登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.pre_regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.pre_regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

$columnArray[] = "CAST(u.pre_regist_datetime AS DATE) AS pre_regist_date";
$otherArray[] = "GROUP BY pre_regist_date ORDER BY pre_regist_date";

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, $defaultWhereArray, $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["pre_regist_date"]]["pre_user"] = $val["pre_user"];
    $totalCnt += $val["pre_user"];
}

$defaultWhereArray = "";
$columnArray = "";
$otherArray = "";

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "CAST(u.regist_datetime AS DATE) AS regist_date";
$otherArray[] = "GROUP BY regist_date ORDER BY regist_date";

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, $defaultWhereArray, $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["regist_date"]]["user"] = $val["user"];
    $dispDataList[$val["regist_date"]]["quit_user"] = $val["quit_user"];
    $totalCnt += $val["user"] + $val["quit_user"];

}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $dispDay[] = $date;
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $jsDispDataList["pre_user"][] = "[" . ($dispDataList[$date]["pre_user"] ? $dispDataList[$date]["pre_user"] : 0) . "," . $i . "]";
    $jsDispDataList["user"][] = "[" . ($dispDataList[$date]["user"] ? $dispDataList[$date]["user"] : 0) . "," . $i . "]";
    $jsDispDataList["quit_user"][] = "[" . ($dispDataList[$date]["quit_user"] ? $dispDataList[$date]["quit_user"] : 0) . "," . $i . "]";

}

$smartyOBJ->assign("jsDispPreUser", implode(",", $jsDispDataList["pre_user"]));
$smartyOBJ->assign("jsDispUser", implode(",", $jsDispDataList["user"]));
$smartyOBJ->assign("jsDispQuitUser", implode(",", $jsDispDataList["quit_user"]));
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
$smartyOBJ->assign("totalCnt", $totalCnt);
?>
