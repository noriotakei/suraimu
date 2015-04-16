<?php

/**
 * salesReportWeek.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(週間)リストページ処理ファイル。
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
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
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

$smartyOBJ->assign("dispDateArray", $dispDateArray);

foreach ($dispDateArray as $dispDateKey => $dispDateVal) {

    $defaultWhereArray = "";

    $defaultWhereArray[] = "o.create_datetime >= '" . date("Y-m-d 00:00:00", $dispDateVal["start_date"]) . "'";
    $defaultWhereArray[] = "o.create_datetime <= '" . date("Y-m-d 23:59:59", $dispDateVal["end_date"]) . "'";

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
            $dispDataList[$dispDateKey]["order_cnt"] += $val["order_cnt"];
            $dispDataList[$dispDateKey]["ordering_pay_total"] += $val["ordering_pay_total"];
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
                $dispDataList[$dispDateKey]["user"] += $val["user"];
                $totalDataList["user"] += $val["user"];
            } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
                $dispDataList[$dispDateKey]["quit_user"] += $val["user"];
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
            // 総金額
            $dispDataList[$dispDateKey]["pay_total"] += $val["pay_total"];
            // 入金種別毎の集計
            $dispDataList[$dispDateKey][$val["pay_type"]] += $val["pay_total"];

            $totalDataList["pay_total"] += $val["pay_total"];
            $totalDataList[$val["pay_type"]] += $val["pay_total"];
        }
    }
    foreach ((array)AdmOrdering::$_payType as $key => $val) {
        $jsPaymentDataList[$key][] = "[" . ($dispDataList[$dispDateKey][$key] ? $dispDataList[$dispDateKey][$key] : 0) . "," . ($dispDateKey + 1) . "]";
    }

    // 購入者数
    $columnArray = "";
    $whereArray= "";
    $otherArray= "";

    $columnArray[] = "COUNT(DISTINCT(u.user_id)) as user";
    $columnArray[] = "regist_status";
    $columnArray[] = "CAST(p.create_datetime AS DATE) AS payment_date";

    $whereArray[] = "o.disable = 0";
    $whereArray[] = "o.is_paid = 1";
    $whereArray[] = "o.is_cancel = 0";
    $whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";

    $otherArray[] = "GROUP BY regist_status, payment_date ORDER BY payment_date";

    $whereArray[] = "p.create_datetime >= '" . date("Y-m-d 00:00:00", $dispDateVal["start_date"]) . "'";
    $whereArray[] = "p.create_datetime <= '" . date("Y-m-d 23:59:59", $dispDateVal["end_date"]) . "'";

    $orderingSalesUserDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
    if ($orderingSalesUserDataList) {
        foreach ((array)$orderingSalesUserDataList as $val) {
            if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER"]) {
                $dispDataList[$dispDateKey]["sales_user"] += $val["user"];
                $totalDataList["sales_user"] += $val["user"];
            } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
                $dispDataList[$dispDateKey]["sales_quit_user"] += $val["user"];
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

}

// 合計注文単価
if ($totalDataList["ordering_pay_total"]) {
    $totalDataList["user_price"] = floor($totalDataList["ordering_pay_total"] / ($totalDataList["user"] + $totalDataList["quit_user"]));
}

// 合計客単価
if ($totalDataList["pay_total"]) {
    $totalDataList["sales_user_price"] = floor($totalDataList["pay_total"] / ($totalDataList["sales_user"] + $totalDataList["sales_quit_user"]));
}

foreach ((array)$jsPaymentDataList as $key => $val) {
    $jsDispDataList[$key] = implode(",", $val);
}

foreach ((array)AdmOrdering::$_payType as $key => $val) {
    $jsPayType[$key] = "{label: '" . $val . "'}";
}

$smartyOBJ->assign("weekArray", AdmCalculation::$_weekArray);
$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("totalDataList", $totalDataList);
$smartyOBJ->assign("errMsg", $errMsg);
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
$smartyOBJ->assign("jsPayType", implode(",", $jsPayType));
$smartyOBJ->assign("jsDispDay", "'" . implode("','", $jsDispDay) . "'");
$smartyOBJ->assign("jsDispDataList", "[" . ($jsDispDataList ? implode("], [", $jsDispDataList) : "") . "]");
?>
