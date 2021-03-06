<?php

/**
 * quitCountRegistDateOfMonthGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録日毎退会者数(月間)リストページ処理ファイル。
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
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "COUNT(u.user_id) AS regist_cnt";
$columnArray[] = "COUNT(IF((u.regist_status = " . $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"] . "),1, NULL)) AS quit_cnt";
$columnArray[] = "CAST(u.regist_datetime AS DATE) AS regist_date";

$otherArray[] = "GROUP BY regist_date ORDER BY regist_date";

$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray, $otherArray);
$i = 0;
if ($dataList) {
    foreach ((array)$dataList as $val) {
        $dispDataList[$val["regist_date"]]["regist_cnt"] = $val["regist_cnt"];
        $dispDataList[$val["regist_date"]]["quit_cnt"] = $val["quit_cnt"];
        $dispDataList[$val["regist_date"]]["remain_total_cnt"] = $val["regist_cnt"] - $val["quit_cnt"];
        if ($dispDataList[$val["regist_date"]]["remain_total_cnt"]) {
            $dispDataList[$val["regist_date"]]["survival_rate"] = number_format(($dispDataList[$val["regist_date"]]["remain_total_cnt"] / $dispDataList[$val["regist_date"]]["regist_cnt"]) * 100, 1);
        }

        $i++;
        $jsUserDataList["remain_total_cnt"][] = "[" . ($dispDataList[$val["regist_date"]]["remain_total_cnt"] ? $dispDataList[$val["regist_date"]]["remain_total_cnt"] : 0) . "," . $i . "]";
        $jsUserDataList["quit_cnt"][] = "[" . ($val["quit_cnt"] ? $val["quit_cnt"] : 0) . "," . $i . "]";
        $jsDispDay[] = $val["regist_date"] . "(" . AdmCalculation::$_weekArray[date("w", strtotime($val["regist_date"]))] . ")";
    }

    $jsDispDay = "'" . implode("','", $jsDispDay) . "'";
}

foreach ((array)$jsUserDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

$jsLabel = "{label: '残会員数'},{label: '退会者数'}";

$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
$smartyOBJ->assign("jsLabel", $jsLabel);
$smartyOBJ->assign("jsDispDay", $jsDispDay);
?>
