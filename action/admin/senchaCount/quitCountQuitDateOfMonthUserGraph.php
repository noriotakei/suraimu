<?php

/**
 * quitCountQuitDateOfMonthUserGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会日毎退会者数(月間)リスト全ユーザーグラフページ処理ファイル。
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

// 全会員取得
$columnArray = "";

$columnArray[] = "COUNT(u.user_id) cnt";
for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $whereArray = "";

    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $whereArray[] = "u.regist_datetime <= '" . $date . " 23:59:59'";
    $dataList = $AdmCalculationOBJ->getCalcUserList("", $columnArray, $whereArray);
    foreach ((array)$dataList as $val) {
        $jsUserCountDataList[] = "[" . ($val["cnt"] ? $val["cnt"] : 0) . ", " . $i . "]";
    }
}

$smartyOBJ->assign("jsUserCountDataList", "[" . ($jsUserCountDataList ? implode(", ", $jsUserCountDataList) : "") . "]");
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
?>
