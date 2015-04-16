<?php

/**
 * salesReportDayGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(曜日ごと)リストグラフページ処理ファイル。
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
        $dispDataList[date("w", strtotime($val["payment_date"]))][$val["pay_type"]] += $val["pay_total"];
        $totalPay += $val["pay_total"];
    }

    foreach ((array)$_config["admin_config"]["week_array"] as $weekKey => $weekVal) {
        foreach ((array)AdmOrdering::$_payType as $key => $val) {
            $jsPaymentDataList[$key][] = "[" . ($dispDataList[$weekKey][$key] ? $dispDataList[$weekKey][$key] : 0) . "," . ($weekKey + 1)  . "]";
        }
    }
}

foreach ((array)$jsPaymentDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

foreach ((array)AdmOrdering::$_payType as $key => $val) {
    $jsPayType[$key] = "{label: '" . $val . "'}";
}

$smartyOBJ->assign("totalPay", $totalPay);
$smartyOBJ->assign("jsPayType", implode(",", $jsPayType));
$smartyOBJ->assign("jsDispWeek", "'" . implode("','", $_config["admin_config"]["week_array"]) . "'");
$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");

?>
