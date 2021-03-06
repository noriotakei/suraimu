<?php

/**
 * salesReportDay.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(曜日ごと)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 注文日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "o.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
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
        $dispDataList[date("w", strtotime($val["order_date"]))]["order_cnt"] += $val["order_cnt"];
        $dispDataList[date("w", strtotime($val["order_date"]))]["ordering_pay_total"] += $val["ordering_pay_total"];
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
            $dispDataList[date("w", strtotime($val["order_date"]))]["user"] += $val["user"];
            $totalDataList["user"] += $val["user"];
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[date("w", strtotime($val["order_date"]))]["quit_user"] += $val["user"];
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
foreach ((array)$_config["admin_config"]["week_array"] as $key => $val) {
    if ($dispDataList[$key]["ordering_pay_total"]) {
        $dispDataList[$key]["user_price"] = floor($dispDataList[$key]["ordering_pay_total"] / ($dispDataList[$key]["user"] + $dispDataList[$key]["quit_user"]));
    }
}

// 合計注文単価
if ($totalDataList["ordering_pay_total"]) {
    $totalDataList["user_price"] = floor($totalDataList["ordering_pay_total"] / ($totalDataList["user"] + $totalDataList["quit_user"]));
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


$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);
if ($orderingSalesDataList) {
    foreach ((array)$orderingSalesDataList as $val) {
        // 総金額
        $dispDataList[date("w", strtotime($val["payment_date"]))]["pay_total"] += $val["pay_total"];
        // 入金種別毎の集計
        $dispDataList[date("w", strtotime($val["payment_date"]))][$val["pay_type"]] += $val["pay_total"];

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
            $dispDataList[date("w", strtotime($val["payment_date"]))]["sales_user"] += $val["user"];
            $totalDataList["sales_user"] += $val["user"];
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[date("w", strtotime($val["payment_date"]))]["sales_quit_user"] += $val["user"];
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
foreach ((array)$_config["admin_config"]["week_array"] as $key => $val) {
    if ($dispDataList[$key]["pay_total"]) {
        $dispDataList[$key]["sales_user_price"] = floor($dispDataList[$key]["pay_total"] / ($dispDataList[$key]["sales_user"] + $dispDataList[$key]["sales_quit_user"]));
    }
}

// 合計客単価
if ($totalDataList["pay_total"]) {
    $totalDataList["sales_user_price"] = floor($totalDataList["pay_total"] / ($totalDataList["sales_user"] + $totalDataList["sales_quit_user"]));
}


foreach ($_config["admin_config"]["week_array"] as $dispKey => $dispVal) {
    $data["day"] = $dispVal;
    $data["order_cnt"] = ($dispDataList[$dispKey]["order_cnt"] ? $dispDataList[$dispKey]["order_cnt"] : 0);
    $data["ordering_pay_total"] = ($dispDataList[$dispKey]["ordering_pay_total"] ? $dispDataList[$dispKey]["ordering_pay_total"] : 0);
    $data["user"] = ($dispDataList[$dispKey]["user"] ? $dispDataList[$dispKey]["user"] : 0) . " | " . ($dispDataList[$dispKey]["quit_user"] ? $dispDataList[$dispKey]["quit_user"] : 0);
    $data["user_price"] = ($dispDataList[$dispKey]["user_price"] ? $dispDataList[$dispKey]["user_price"] : 0);
    $data["sales_user"] = ($dispDataList[$dispKey]["sales_user"] ? $dispDataList[$dispKey]["sales_user"] : 0) . " | " . ($dispDataList[$dispKey]["sales_quit_user"] ? $dispDataList[$dispKey]["sales_quit_user"] : 0);
    $data["sales_user_price"] = ($dispDataList[$dispKey]["sales_user_price"] ? $dispDataList[$dispKey]["sales_user_price"] : 0);
    $data["pay_total"] = ($dispDataList[$dispKey]["pay_total"] ? $dispDataList[$dispKey]["pay_total"] : 0);
    foreach (AdmOrdering::$_payType as $key => $val) {
        $data["pay_type_" . $key] = ($dispDataList[$dispKey][$key] ? $dispDataList[$dispKey][$key] : 0);
    }
    $jsonData[] = $data;
}

$data = "";

$data["day"] = "合計";
$data["order_cnt"] = ($totalDataList["order_cnt"] ? $totalDataList["order_cnt"] : 0);
$data["ordering_pay_total"] = ($totalDataList["ordering_pay_total"] ? $totalDataList["ordering_pay_total"] : 0);
$data["user"] = ($totalDataList["user"] ? $totalDataList["user"] : 0) . " | " . ($totalDataList["quit_user"] ? $totalDataList["quit_user"] : 0);
$data["user_price"] = ($totalDataList["user_price"] ? $totalDataList["user_price"] : 0);
$data["sales_user"] = ($totalDataList["sales_user"] ? $totalDataList["sales_user"] : 0) . " | " . ($totalDataList["sales_quit_user"] ? $totalDataList["sales_quit_user"] : 0);
$data["sales_user_price"] = ($totalDataList["sales_user_price"] ? $totalDataList["sales_user_price"] : 0);
$data["pay_total"] = ($totalDataList["pay_total"] ? $totalDataList["pay_total"] : 0);
foreach (AdmOrdering::$_payType as $key => $val) {
    $data["pay_type_" . $key] = ($totalDataList[$key] ? $totalDataList[$key] : 0);
}
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
