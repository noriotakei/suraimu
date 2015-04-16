<?php

/**
 * salesReportMonth.php
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

// 注文日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "o.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

// 注文数
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "COUNT(o.id) AS order_cnt";
$columnArray[] = "SUM(o.pay_total) AS ordering_pay_total";
$columnArray[] = "CAST(o.create_datetime AS DATE) AS order_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_cancel = 0";

$otherArray[] = "GROUP BY order_date ORDER BY order_date";

$orderingDataList = $AdmCalculationOBJ->getCalcOrderingList($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
if ($orderingDataList) {
    foreach ((array)$orderingDataList as $val) {
        $dispDataList[$val["order_date"]]["order_cnt"] = $val["order_cnt"];
        $dispDataList[$val["order_date"]]["ordering_pay_total"] = $val["ordering_pay_total"];
        $totalDataList["order_cnt"] += $val["order_cnt"];
        $totalDataList["ordering_pay_total"] += $val["ordering_pay_total"];
    }
}
// 注文者数
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "COUNT(DISTINCT(u.user_id)) as user";
$columnArray[] = "regist_status";
$columnArray[] = "CAST(o.create_datetime AS DATE) AS order_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_cancel = 0";

$otherArray[] = "GROUP BY regist_status, order_date ORDER BY order_date";

$orderingUserDataList = $AdmCalculationOBJ->getCalcOrderingList($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
if ($orderingUserDataList) {
    foreach ((array)$orderingUserDataList as $val) {
        if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
            $dispDataList[$val["order_date"]]["user"] += $val["user"];
            $totalDataList["user"] += $val["user"];
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[$val["order_date"]]["quit_user"] += $val["user"];
            $totalDataList["quit_user"] += $val["user"];
        }
    }
}

// 注文単価
foreach ((array)$dispDataList as $key => $val) {
    if ($val["ordering_pay_total"]) {
        $dispDataList[$key]["user_price"] = floor($val["ordering_pay_total"] / ($val["user"] + $val["quit_user"]));
    }
}

// 合計注文単価
if ($totalDataList["ordering_pay_total"]) {
    $totalDataList["user_price"] = floor($totalDataList["ordering_pay_total"] / ($totalDataList["user"]  + $totalDataList["quit_user"]));
}

if (ComValidation::isDate($param["date"])) {
    $salesWhereArray[] = "p.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $salesWhereArray[] = "p.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

// 売り上げ総金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) AS pay_total";
$columnArray[] = "CAST(p.create_datetime AS DATE) AS payment_date";

$whereArray = $salesWhereArray;
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
        // 総金額
        $dispDataList[$val["payment_date"]]["pay_total"] += $val["pay_total"];
        // 入金種別毎の集計
        $dispDataList[$val["payment_date"]][$val["pay_type"]] += $val["pay_total"];

        $totalDataList["pay_total"] += $val["pay_total"];
        $totalDataList[$val["pay_type"]] += $val["pay_total"];
    }
}

// 購入者数
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "COUNT(DISTINCT(u.user_id)) as user";
$columnArray[] = "regist_status";
$columnArray[] = "CAST(p.create_datetime AS DATE) AS payment_date";

$whereArray = $salesWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";

$otherArray[] = "GROUP BY regist_status, payment_date ORDER BY payment_date";

$orderingSalesUserDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesUserDataList) {
    foreach ((array)$orderingSalesUserDataList as $val) {
        if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
            $dispDataList[$val["payment_date"]]["sales_user"] += $val["user"];
            $totalDataList["sales_user"] += $val["user"];
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[$val["payment_date"]]["sales_quit_user"] += $val["user"];
            $totalDataList["sales_quit_user"] += $val["user"];
        }
    }
}

// 客単価
foreach ((array)$dispDataList as $key => $val) {
    if ($val["pay_total"]) {
        $dispDataList[$key]["sales_user_price"] = floor($val["pay_total"] / ($val["sales_user"] + $val["sales_quit_user"]));
    }
}

// 合計客単価
if ($totalDataList["pay_total"]) {
    $totalDataList["sales_user_price"] = floor($totalDataList["pay_total"] / ($totalDataList["sales_user"]  + $totalDataList["sales_quit_user"]));
}

$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("totalDataList", $totalDataList);
$smartyOBJ->assign("errMsg", $errMsg);
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
$smartyOBJ->assign("weekArray", AdmCalculation::$_weekArray);

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

$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
$smartyOBJ->assign("jsPayType", implode(",", $jsPayType));
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
$smartyOBJ->assign("dispDay", $dispDay);
?>
