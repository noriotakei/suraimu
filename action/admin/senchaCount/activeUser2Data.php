<?php

/**
 * activeUser2Data.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面アクティブ会員リストページ処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
//$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$defaultWhereArray[] = "u.regist_status IN (" . $_config["define"]["USER_REGIST_STATUS_MEMBER"] . ")";

$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 > 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 168, 1, NULL)) AS 0week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 168 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 336, 1, NULL)) AS 1week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 336 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 504, 1, NULL)) AS 2week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 >= 504 && TIME_TO_SEC(TIMEDIFF(NOW(), u.last_access_datetime)) / 3600 < 672, 1, NULL)) AS 3week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_access_datetime)) / 3600 >= 672 && (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_access_datetime)) / 3600 < 1344, 1, NULL)) AS 4week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime != 0 && (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_access_datetime)) / 3600 >= 1344, 1, NULL)) AS 8week_cnt";
$columnArray[] = "COUNT(IF(u.last_access_datetime = 0, 1, NULL)) AS not_access_cnt";
$columnArray[] = "COUNT(user_id) AS total_cnt";

$dataList = $AdmCalculationOBJ->getCalcUserList($param, $columnArray, $defaultWhereArray);

while (list($key, $val) = each($dataList)) {
    $jsonData[] = array("name" => "1週間未満", "cnt" => $val["0week_cnt"], "rate" =>  ($val["0week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "1～2週間未満", "cnt" => $val["1week_cnt"], "rate" =>  ($val["1week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "2～3週間未満", "cnt" => $val["2week_cnt"], "rate" =>  ($val["2week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "3～4週間未満", "cnt" => $val["3week_cnt"], "rate" =>  ($val["3week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "4～8週間未満", "cnt" => $val["4week_cnt"], "rate" =>  ($val["3week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "8週間以上", "cnt" => $val["8week_cnt"], "rate" =>  ($val["8week_cnt"] / $val["total_cnt"] * 100));
    $jsonData[] = array("name" => "アクセスなし", "cnt" => $val["not_access_cnt"], "rate" =>  ($val["not_access_cnt"] / $val["total_cnt"] * 100));
}

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
