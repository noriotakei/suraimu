<?php

/**
 * informationStatusCntOfMonth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(月毎)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 閲覧日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "isl.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "isl.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

$columnArray[] = "infs.id";
$columnArray[] = "infs.name";
$columnArray[] = "COUNT(isl.id) cnt";

$otherArray[] = "GROUP BY DATE_FORMAT(isl.create_datetime,'%Y%m'), infs.id";
$otherArray[] = "ORDER BY cnt DESC";

// 情報閲覧回数リスト
$dataList = $AdmCalculationOBJ->getCalcInformationStatusLogList($param, $columnArray, $defaultWhereArray, $otherArray);

$smartyOBJ->assign("dataList", $dataList);
?>
