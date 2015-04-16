<?php

/**
 * paymentLogRate.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金割合リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmItemOBJ = AdmItem::getInstance();

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "p.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) as sum_total_payment";

$otherArray[] = "GROUP BY p.pay_type";

// ログリスト
$dataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, $defaultWhereArray, $otherArray);

if ($dataList) {
    foreach ($dataList as $val) {
        $dispDataList[$val["pay_type"]]["sum_total_payment"] = $val["sum_total_payment"];
        $total["total_money"] += $val["sum_total_payment"];
        $pieChartValue[$val["pay_type"]] = "['" . AdmOrdering::$_payType[$val["pay_type"]] . "', " . $val["sum_total_payment"] . "]";
    }
    foreach ($dispDataList as $key => $val) {
        $dispDataList[$key]["rate"] = $val["sum_total_payment"] ? number_format($val["sum_total_payment"] / $total["total_money"] * 100, 1) : 0;
    }
    $total["rate"] = $total["total_money"] ? 100 : 0;
}
foreach (AdmOrdering::$_payType as $key => $val) {
    $dispPieChartValue[] = $pieChartValue[$key] ? $pieChartValue[$key] :"['" . $val . "', 0]";
}
$dispPieChartValue = implode(",", $dispPieChartValue);
$smartyOBJ->assign("dispPieChartValue", $dispPieChartValue);
$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("total", $total);
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
?>
