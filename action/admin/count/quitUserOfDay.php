<?php

/**
 * quitUserOfDay.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会者人数(退会日)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.quit_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.quit_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 退会日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.quit_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "u.quit_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$dispDataList = $AdmCalculationOBJ->getCalcQuitUserList($param, $columnArray, $defaultWhereArray, $otherArray);
$totalCnt["total_cnt"] = count($dispDataList);

$smartyOBJ->assign("totalCnt", $totalCnt);
$smartyOBJ->assign("dispDataList", $dispDataList);

?>
