<?php

/**
 * salesReportWeekGraph.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(週間)リストグラフページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 注文日
if (ComValidation::isDate($param["date"])) {
    $date["start_date"] = strtotime("last Sunday", strtotime(date("Y-m-01", strtotime($param["date"]))));
    // 月末が土曜日ならその日を入れる
    if (date("w", strtotime(date("Y-m-t", strtotime($param["date"])))) == 6) {
        $date["end_date"] = strtotime(date("Y-m-t", strtotime($param["date"])));
    } else {
        $date["end_date"] = strtotime("next Saturday", strtotime(date("Y-m-t", strtotime($param["date"]))));
    }
}

// 表示する日付の配列
$dispDateArray = array();

$i = 0;
for ($t = $date["start_date"]; $t <= $date["end_date"]; $t += 86400) {
    // 週間開始日
    if (date("w", $t) == 0) {
        $dispDateArray[$i]["start_date"] = $t;
        $jsDispDay[$i] = date("Y-m-d", $t) . "(" . AdmCalculation::$_weekArray[date("w", $t)] . ")";
    }

    // 週間最終日
    // 土曜日なら配列キーのカウントアップ
    if (date("w", $t) == 6) {
        $dispDateArray[$i]["end_date"] = $t;
        $jsDispDay[$i] .= " ～ " . date("Y-m-d", $t) . "(" . AdmCalculation::$_weekArray[date("w", $t)] . ")";
        $i++;
    }

}

foreach ($dispDateArray as $dispDateKey => $dispDateVal) {

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

    $whereArray[] = "p.create_datetime >= '" . date("Y-m-d 00:00:00", $dispDateVal["start_date"]) . "'";
    $whereArray[] = "p.create_datetime <= '" . date("Y-m-d 23:59:59", $dispDateVal["end_date"]) . "'";

    $orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
    if ($orderingSalesDataList) {
        foreach ((array)$orderingSalesDataList as $val) {
            // 入金種別毎の集計
            $dispDataList[$dispDateKey][$val["pay_type"]] += $val["pay_total"];
            $totalPay += $val["pay_total"];
        }
    }
    foreach ((array)AdmOrdering::$_payType as $key => $val) {
        $jsPaymentDataList[$key][] = "[" . ($dispDataList[$dispDateKey][$key] ? $dispDataList[$dispDateKey][$key] : 0) . "," . ($dispDateKey + 1) . "]";
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
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
?>
