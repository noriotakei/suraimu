<?php

/**
 * quitUserOfMonthGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会者人数(月間)リストグラフページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 退会日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.quit_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.quit_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "COUNT(IF(u.regist_status = " . $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"] . " ,1, NULL)) AS quit_cnt";
$columnArray[] = "CAST(u.quit_datetime AS DATE) AS quit_date";

$otherArray[] = "GROUP BY quit_date ORDER BY quit_date";

$dataList = $AdmCalculationOBJ->getCalcQuitUserList($param, $columnArray, $defaultWhereArray, $otherArray);
$i = 1;
if ($dataList) {
    foreach ((array)$dataList as $val) {
        $jsDispDay[] = $val["quit_date"] . "(" . AdmCalculation::$_weekArray[date("w", strtotime($val["quit_date"]))] . ")";
        $jsDispDataList[] = "[" . ($val["quit_cnt"] ? $val["quit_cnt"] : 0) . ", " . $i++ . "]";
        $totalCnt += $val["quit_cnt"];
    }
    $jsDispDay = "'" . implode("','", $jsDispDay) . "'";
    $jsDispDataList = implode(", ", $jsDispDataList);
}
$smartyOBJ->assign("totalCnt", $totalCnt);
$smartyOBJ->assign("jsDispDataList", "[" . $jsDispDataList . "]");
$smartyOBJ->assign("jsDispDay", $jsDispDay);
?>
