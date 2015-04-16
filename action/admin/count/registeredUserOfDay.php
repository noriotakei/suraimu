<?php

/**
 * registeredUserOfDay.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー登録リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.pre_regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.pre_regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 仮登録日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.pre_regist_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "u.pre_regist_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "CAST(u.pre_regist_datetime AS DATE) AS pre_regist_date";
$otherArray[] = "GROUP BY pre_regist_date ORDER BY pre_regist_date";

// 人数
$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, $defaultWhereArray, $otherArray);
foreach ((array)$dataList as $val) {
    $totalData["pre_user"] += $val["pre_user"];
    $totalData["user"] += $val["user"];
    $totalData["quit_user"] += $val["quit_user"];
    $totalData["all_user"] += $val["pre_user"] + $val["user"]  + $val["quit_user"];
}

$columnArray = "";

$columnArray[] = "SQL_CALC_FOUND_ROWS *";

// ユーザーデータ
$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray);

$smartyOBJ->assign("errMsg", $errMsg);
$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalData", $totalData);
?>
