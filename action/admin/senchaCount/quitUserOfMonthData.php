<?php

/**
 * quitUserOfMonthData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会者人数(月間)リストデータページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

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

if ($dataList) {
    foreach ((array)$dataList as $val) {
        $dispDataList[$val["quit_date"]]["quit_cnt"] = $val["quit_cnt"];
        $totalCnt += $val["quit_cnt"];
    }
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $data = "";

    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $data["date"] = date("Y年m月d日", strtotime($date)) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $data["quit_cnt"] = $dispDataList[$date]["quit_cnt"] ? $dispDataList[$date]["quit_cnt"] : 0;
    $jsonData[] = $data;
}

$data = "";
$data["date"] = "合計";
$data["quit_cnt"] = $totalCnt ? $totalCnt : 0;
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
