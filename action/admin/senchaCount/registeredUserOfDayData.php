<?php

/**
 * senchaRegisteredUserOfDayData.php
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

$columnArray = "";

$columnArray[] = "SQL_CALC_FOUND_ROWS *";
$otherArray[] = "LIMIT " . $param["start"] . ", " . $param["limit"];

// ユーザーデータ
$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray, $otherArray);
$totalCount = $AdmCalculationOBJ->getFoundRows();

if ($dataList) {
    foreach ($dataList as $val) {
        $val["pc_device"] = $_config["admin_config"]["pc_device"][$val["pc_device_cd"]];
        $val["mb_device_cd"] = $_config["admin_config"]["mb_device_cd"][$val["mb_device_cd"]];
        $val["regist_status"] = $_config["admin_config"]["regist_status"][$val["regist_status"]];
        $data[] = $val;
    }
}

$res = array(
          'success' => true,
          'total' => $totalCount,
          'rows' => $data
      );

header("Content-Type: text/javascript; charset=utf-8");
echo json_encode($res);
exit;
?>
