<?php

/**
 * salesReportMonthGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(月毎)リストページグラフ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 売り上げ総金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) AS pay_total";
$columnArray[] = "CAST(p.create_datetime AS DATE) AS payment_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";

$otherArray[] = "GROUP BY payment_date, o.id ORDER BY payment_date";

if (ComValidation::isDate($param["date"])) {
    $whereArray[] = "p.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $whereArray[] = "p.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 入金種別毎の集計
        $dispDataList[$val["payment_date"]][$val["pay_type"]] += $val["pay_total"];
        $totalPay += $val["pay_total"];
    }
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $dispDay[] = $date;
    $jsDispDay[] = $date . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    foreach ((array)AdmOrdering::$_payType as $key => $val) {
        $jsPaymentDataList[$key][] = "[" . ($dispDataList[$date][$key] ? $dispDataList[$date][$key] : 0) . "," . $i . "]";
    }
}

foreach ((array)$jsPaymentDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

foreach ((array)AdmOrdering::$_payType as $key => $val) {
    $jsPayType[$key] = "{label: '" . $val . "'}";
}

$smartyOBJ->assign("totalPay", $totalPay);
$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
$smartyOBJ->assign("jsPayType", implode(",", $jsPayType));
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");

?>
