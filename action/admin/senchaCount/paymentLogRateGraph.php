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
$AdmItemOBJ = AdmItem::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "p.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) as sum_total_payment";

$otherArray[] = "GROUP BY p.pay_type";

// ログリスト
$dataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, $defaultWhereArray, $otherArray);

if ($dataList) {
    foreach ($dataList as $val) {
        $total += $val["sum_total_payment"];
        $pieChartValue[$val["pay_type"]] = "['" . AdmOrdering::$_payType[$val["pay_type"]] . "', " . $val["sum_total_payment"] . "]";
    }
}
foreach (AdmOrdering::$_payType as $key => $val) {
    $dispPieChartValue[] = $pieChartValue[$key] ? $pieChartValue[$key] :"['" . $val . "', 0]";
}
$dispPieChartValue = implode(",", $dispPieChartValue);
$smartyOBJ->assign("dispPieChartValue", $dispPieChartValue);
$smartyOBJ->assign("total", $total);
?>
