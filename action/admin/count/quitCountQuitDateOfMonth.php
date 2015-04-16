<?php

/**
 * quitCountQuitDateOfMonth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会日毎退会者数(月間)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();


// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.quit_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.quit_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

$columnArray = "";
$whereArray = "";
$otherArray = "";

$columnArray[] = "COUNT(IF((u.regist_status = " . $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"] . "),1, NULL)) AS quit_cnt";
$columnArray[] = "CAST(u.quit_datetime AS DATE) AS quit_date";

$otherArray[] = "GROUP BY quit_date ORDER BY quit_date";

$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray, $otherArray);
if ($dataList) {
    foreach ((array)$dataList as $val) {
        $dispDataList[$val["quit_date"]]["quit_cnt"] = $val["quit_cnt"];
        $totalCnt["quit_cnt"] += $val["quit_cnt"];
    }
    $totalCnt["avg_quit_cnt"] = $totalCnt["quit_cnt"] ? number_format(floor($totalCnt["quit_cnt"] / count($dispDataList)), 0) : 0;
}

$i = 1;
if ($dispDataList) {
    foreach ((array)$dispDataList as $val) {
        $jsQuitUserCountDataList[] = "[" . ($val["quit_cnt"] ? $val["quit_cnt"] : 0) . ", " . $i++ . "]";
    }
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
}

$smartyOBJ->assign("totalCnt", $totalCnt);
$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("weekArray", AdmCalculation::$_weekArray);
$smartyOBJ->assign("jsQuitUserCountDataList", "[" . ($jsQuitUserCountDataList ? implode(", ", $jsQuitUserCountDataList) : "") . "]");
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
?>
