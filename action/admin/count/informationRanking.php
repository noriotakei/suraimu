<?php

/**
 * informationRanking.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面情報ランキングページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "isl.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "isl.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$columnArray[] = "infs.id";
$columnArray[] = "infs.name";
$columnArray[] = "COUNT(isl.id) cnt";
$columnArray[] = "infs.display_start_datetime";
$columnArray[] = "infs.display_end_datetime";

$otherArray[] = "GROUP BY infs.id";
$otherArray[] = "ORDER BY cnt DESC";
$otherArray[] = "LIMIT 100";

// 情報閲覧回数リスト
$dataList = $AdmCalculationOBJ->getCalcInformationStatusLogList($param, $columnArray, $defaultWhereArray, $otherArray);

$smartyOBJ->assign("dataList", $dataList);
?>
