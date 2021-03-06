<?php

/**
 * paymentLogRateGraph.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金割合リストグラフページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$defaultWhereArray[] = "u.regist_status IN (" . $_config["define"]["USER_REGIST_STATUS_MEMBER"] . ")";

$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 672, 1, NULL)) AS 4week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 504 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 672, 1, NULL)) AS 3week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 336 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 504, 1, NULL)) AS 2week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 168 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 336, 1, NULL)) AS 1week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 72 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 168, 1, NULL)) AS 3day_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 48 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 72, 1, NULL)) AS 2day_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 24 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 48, 1, NULL)) AS 1day_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 12 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 24, 1, NULL)) AS 12hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 6 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 12, 1, NULL)) AS 6hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 3 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 6, 1, NULL)) AS 3hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 2 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 3, 1, NULL)) AS 2hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 1 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 2, 1, NULL)) AS 1hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 > 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 1, 1, NULL)) AS 0hour_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime = 0, 1, NULL)) AS not_access_cnt";
$columnArray[] = "COUNT(user_id) AS total_cnt";

$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray);
while (list($key, $val) = each($dataList)) {
    $data[] = array("name" => "1時間未満", "cnt" => $val["0hour_cnt"]);
    $data[] = array("name" => "1～2時間未満", "cnt" => $val["1hour_cnt"]);
    $data[] = array("name" => "2～3時間未満", "cnt" => $val["2hour_cnt"]);
    $data[] = array("name" => "3～6時間未満", "cnt" => $val["3hour_cnt"]);
    $data[] = array("name" => "6～12時間未満", "cnt" => $val["6hour_cnt"]);
    $data[] = array("name" => "12～24時間未満", "cnt" => $val["12hour_cnt"]);
    $data[] = array("name" => "1～2日未満", "cnt" => $val["1day_cnt"]);
    $data[] = array("name" => "2～3日未満", "cnt" => $val["2day_cnt"]);
    $data[] = array("name" => "3～7日未満", "cnt" => $val["3day_cnt"]);
    $data[] = array("name" => "1～2週間未満", "cnt" => $val["1week_cnt"]);
    $data[] = array("name" => "2～3週間未満", "cnt" => $val["2week_cnt"]);
    $data[] = array("name" => "3～4週間未満", "cnt" => $val["3week_cnt"]);
    $data[] = array("name" => "4週間以上", "cnt" => $val["4week_cnt"]);
    $data[] = array("name" => "アクセスなし", "cnt" => $val["not_access_cnt"]);
    $totalCnt = $val["total_cnt"];
}

while (list($key, $val) = each($data)) {
    $jsDataList[] = "[" . ($key + 1) . ", " . ($val["cnt"] ? $val["cnt"] : 0) . "]";
    $jsDispName[] = $val["name"];
}

$smartyOBJ->assign("jsDataList", "[" . ($jsDataList ? implode(", ", $jsDataList) : "") . "]");
$smartyOBJ->assign("jsDispName", "'" . implode("','", $jsDispName) . "'");
$smartyOBJ->assign("total", $totalCnt);
?>
