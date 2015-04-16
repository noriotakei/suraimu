<?php

/**
 * quitCountQuitDateOfMonthQuitGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会日毎退会者数(月間)リスト退会数グラフページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.quit_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.quit_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray = "";
$whereArray = "";
$otherArray = "";

$columnArray[] = "COUNT(IF((u.regist_status = " . $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"] . "),1, NULL)) AS quit_cnt";
$columnArray[] = "CAST(u.quit_datetime AS DATE) AS quit_date";

$otherArray[] = "GROUP BY quit_date ORDER BY quit_date";

$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray, $otherArray);
$i = 1;
if ($dataList) {
    foreach ((array)$dataList as $val) {
        $jsDispDay[] = $val["quit_date"] . "(" . AdmCalculation::$_weekArray[date("w", strtotime($val["quit_date"]))] . ")";
        $jsQuitUserCountDataList[] = "[" . ($val["quit_cnt"] ? $val["quit_cnt"] : 0) . ", " . $i++ . "]";
    }
    $smartyOBJ->assign("jsQuitUserCountDataList", "[" . ($jsQuitUserCountDataList ? implode(", ", $jsQuitUserCountDataList) : "") . "]");
    $smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
}


?>
