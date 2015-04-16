<?php

/**
 * monthly.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面日ごと別媒体集計(月間)ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$columnArray[] = "DATE_FORMAT(analyze_datetime, '%Y-%m-%d') analyze_datetime";
$columnArray[] = "media_cd";
$columnArray[] = "SUM(access_count) as access_count";
$columnArray[] = "SUM(regist_count) as regist_count";
$columnArray[] = "SUM(trade_amount) as trade_amount";

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $whereArray[] = "analyze_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $whereArray[] = "analyze_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 解析日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $whereArray[] = "analyze_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $whereArray[] = "analyze_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

/** 媒体コード */
if($param["media_cd"]){
    $whereArray[] = "media_cd LIKE '" . $param["media_cd"] . "%'";
}

$otherArray[] = "GROUP BY DATE_FORMAT(analyze_datetime, '%Y-%m-%d'), media_cd";
$otherArray[] = "ORDER BY DATE_FORMAT(analyze_datetime, '%Y-%m-%d'), media_cd";

$dispDataList = $AdmBaitaiOBJ->getMediaCalculation($columnArray, $whereArray, $otherArray);
foreach ((array)$dispDataList as $val) {
    $totalData["access_count"] += $val["access_count"];
    $totalData["regist_count"] += $val["regist_count"];
    $totalData["trade_amount"] += $val["trade_amount"];
}

$tags = array(
            "date",
            "start_date",
            "end_date",
            "media_cd",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("totalData", $totalData);
$smartyOBJ->assign("POSTparam", $POSTparam);
?>
