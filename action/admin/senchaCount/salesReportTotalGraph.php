<?php

/**
 * salesReportTotalGraph.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ全体集計リストページグラフ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $userDefaultWhereArray[] = "u.pre_regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $userDefaultWhereArray[] = "u.pre_regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 月カウント
$userDataList = $AdmCalculationOBJ->getCalcUserCountGroupMonth($param, "", $userDefaultWhereArray);
if ($userDataList) {
    foreach ((array)$userDataList as $val) {
        $preRegistMonth[] = $val["pre_regist_month"];
    }
}

// 売り上げ総金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

// 登録日数0～30日
$columnArray[] = "SUM(p.receive_money) AS pay_total";
$columnArray[] = "DATE_FORMAT(p.create_datetime, '%Y年%m月') AS payment_month";

$whereArray = $userDefaultWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) < 31";

$otherArray[] = "GROUP BY payment_month ORDER BY payment_month";

$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 総金額
        $dispDataList[$val["payment_month"]]["pay_total_0"] = $val["pay_total"];
    }
}

// 登録日数31～60日
$whereArray= "";

$whereArray = $userDefaultWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) >= 31";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) < 61";

$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 総金額
        $dispDataList[$val["payment_month"]]["pay_total_31"] = $val["pay_total"];
    }
}

// 登録日数61～90日
$whereArray= "";

$whereArray = $userDefaultWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) >= 61";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) < 91";

$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 総金額
        $dispDataList[$val["payment_month"]]["pay_total_61"] = $val["pay_total"];
    }
}

// 登録日数91日～
$whereArray= "";

$whereArray = $userDefaultWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
$whereArray[] = "to_days(p.create_datetime) - to_days(u.pre_regist_datetime) >= 91";

$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 総金額
        $dispDataList[$val["payment_month"]]["pay_total_91"] = $val["pay_total"];
    }
}

$i = 0;

foreach ((array)$preRegistMonth as $key => $val) {
    $jsPaymentDataList["line1"][] = ($dispDataList[$val]["pay_total_0"] ? $dispDataList[$val]["pay_total_0"] : 0);
    $jsPaymentDataList["line2"][] = ($dispDataList[$val]["pay_total_31"] ? $dispDataList[$val]["pay_total_31"] : 0);
    $jsPaymentDataList["line3"][] = ($dispDataList[$val]["pay_total_61"] ? $dispDataList[$val]["pay_total_61"] : 0);
    $jsPaymentDataList["line4"][] = ($dispDataList[$val]["pay_total_91"] ? $dispDataList[$val]["pay_total_91"] : 0);
}
$jsDispLabelList["line1"] = "{label:'登録日時(0-30)'}";
$jsDispLabelList["line2"] = "{label:'登録日時(31-60)'}";
$jsDispLabelList["line3"] = "{label:'登録日時(61-90)'}";
$jsDispLabelList["line4"] = "{label:'登録日時(90-)'}";

foreach ((array)$jsPaymentDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

$jsPaymentKeyList= implode(",", array_keys($jsPaymentDataList));
$jsMonthList= "'" . implode("','", $preRegistMonth) . "'";

$smartyOBJ->assign("jsDispDataList", $jsDispDataList);
$smartyOBJ->assign("jsDispLabelList", implode(",", $jsDispLabelList));
$smartyOBJ->assign("jsPaymentKeyList", $jsPaymentKeyList);
$smartyOBJ->assign("jsMonthList", $jsMonthList);
?>
