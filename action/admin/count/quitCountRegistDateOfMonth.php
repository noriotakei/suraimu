<?php

/**
 * quitCountRegistDateOfMonth.php
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


// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
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

        $totalCnt["regist_cnt"] += $val["regist_cnt"];
        $totalCnt["quit_cnt"] += $val["quit_cnt"];
        $totalCnt["remain_total_cnt"] += $dispDataList[$val["regist_date"]]["remain_total_cnt"];
        $i++;
        $jsUserDataList["remain_total_cnt"][] = "[" . ($dispDataList[$val["regist_date"]]["remain_total_cnt"] ? $dispDataList[$val["regist_date"]]["remain_total_cnt"] : 0) . "," . $i . "]";
        $jsUserDataList["quit_cnt"][] = "[" . ($val["quit_cnt"] ? $val["quit_cnt"] : 0) . "," . $i . "]";
        $jsDispDay[] = $val["regist_date"] . "(" . AdmCalculation::$_weekArray[date("w", strtotime($val["regist_date"]))] . ")";
    }

    $totalCnt["avg_regist_cnt"] = $totalCnt["regist_cnt"] ? number_format(floor($totalCnt["regist_cnt"] / count($dataList)), 0) : 0;
    $totalCnt["avg_quit_cnt"] = $totalCnt["quit_cnt"] ? number_format(floor($totalCnt["quit_cnt"] / count($dataList)), 0) : 0;
    $totalCnt["avg_remain_total_cnt"] = $totalCnt["remain_total_cnt"] ? number_format(floor($totalCnt["remain_total_cnt"] / count($dataList)), 0) : 0;
    $totalCnt["avg_survival_rate"] = $totalCnt["regist_cnt"] ? number_format((($totalCnt["remain_total_cnt"] / $totalCnt["regist_cnt"]) * 100), 1) : 0;

    $jsDispDay = "'" . implode("','", $jsDispDay) . "'";
}

foreach ((array)$jsUserDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

$jsLabel = "{label: '残会員数'},{label: '退会者数'}";

$smartyOBJ->assign("totalCnt", $totalCnt);
$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("weekArray", AdmCalculation::$_weekArray);
$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
$smartyOBJ->assign("jsLabel", $jsLabel);
$smartyOBJ->assign("jsDispDay", $jsDispDay);
?>
