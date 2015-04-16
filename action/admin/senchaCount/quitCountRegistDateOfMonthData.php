<?php

/**
 * quitCountRegistDateOfMonthData.php
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

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

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
        $data = "";
        $data["date"] = date("Y年m月d日", strtotime($val["regist_date"])) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($val["regist_date"]))] . ")";
        $data["regist_cnt"] = $val["regist_cnt"];
        $data["quit_cnt"] = $val["quit_cnt"];
        $data["remain_total_cnt"] = $val["regist_cnt"] - $val["quit_cnt"];
        if ($data["remain_total_cnt"]) {
            $data["survival_rate"] = number_format(($data["remain_total_cnt"] / $data["regist_cnt"]) * 100, 1);
        }
        $jsonData[] = $data;

        $totalCnt["regist_cnt"] += $val["regist_cnt"];
        $totalCnt["quit_cnt"] += $val["quit_cnt"];
        $totalCnt["remain_total_cnt"] += $data["remain_total_cnt"];
        $i++;
    }

    $totalCnt["avg_regist_cnt"] = $totalCnt["regist_cnt"] ? number_format(($totalCnt["regist_cnt"] / count($dataList)), 1) : 0;
    $totalCnt["avg_quit_cnt"] = $totalCnt["quit_cnt"] ? number_format(($totalCnt["quit_cnt"] / count($dataList)), 1) : 0;
    $totalCnt["avg_remain_total_cnt"] = $totalCnt["remain_total_cnt"] ? number_format(($totalCnt["remain_total_cnt"] / count($dataList)), 1) : 0;
    $totalCnt["avg_survival_rate"] = $totalCnt["regist_cnt"] ? number_format((($totalCnt["remain_total_cnt"] / $totalCnt["regist_cnt"]) * 100), 1) : 0;
}

$data = "";
$data["date"] = "平均";
$data["regist_cnt"] = $totalCnt["avg_regist_cnt"] ? $totalCnt["avg_regist_cnt"] : 0;
$data["quit_cnt"] = $totalCnt["avg_quit_cnt"] ? $totalCnt["avg_quit_cnt"] : 0;
$data["remain_total_cnt"] = $totalCnt["avg_remain_total_cnt"] ? $totalCnt["avg_remain_total_cnt"] : 0;
$data["survival_rate"] = $totalCnt["avg_survival_rate"] ? $totalCnt["avg_survival_rate"] : 0;
$jsonData[] = $data;

$data = "";
$data["date"] = "合計";
$data["regist_cnt"] = $totalCnt["regist_cnt"] ? $totalCnt["regist_cnt"] : 0;
$data["quit_cnt"] = $totalCnt["quit_cnt"] ? $totalCnt["quit_cnt"] : 0;
$data["remain_total_cnt"] = $totalCnt["remain_total_cnt"] ? $totalCnt["remain_total_cnt"] : 0;
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
