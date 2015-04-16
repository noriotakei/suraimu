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

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

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

if ($dataList) {
    foreach ((array)$dataList as $val) {
        $dispDataList[$val["quit_date"]]["quit_cnt"] = $val["quit_cnt"];
        $totalCnt["quit_cnt"] += $val["quit_cnt"];
    }
    $totalCnt["avg_quit_cnt"] = $totalCnt["quit_cnt"] ? number_format(floor($totalCnt["quit_cnt"] / count($dispDataList)), 0) : 0;
}

if ($dispDataList) {
    foreach ((array)$dispDataList as $key => $val) {
        $data = "";
        $data["date"] = date("Y年m月d日", strtotime($key)) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($key))] . ")";
        $data["quit_cnt"] = $val["quit_cnt"] ? $val["quit_cnt"] : 0;
        $jsonData[] = $data;
    }
}
$data = "";
$data["date"] = "平均";
$data["quit_cnt"] = $totalCnt["avg_quit_cnt"] ? $totalCnt["avg_quit_cnt"] : 0;
$jsonData[] = $data;

$data = "";
$data["date"] = "合計";
$data["quit_cnt"] = $totalCnt["quit_cnt"] ? $totalCnt["quit_cnt"] : 0;
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
