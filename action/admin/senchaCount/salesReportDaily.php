<?php

/**
 * salesReportDaily.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ集計(日毎)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "o.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 注文日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "o.create_datetime <= '" . $param["date"] . " 23:59:59'";
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
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[$val["order_date"]]["quit_user"] += $val["user"];
        }
    }
}

// 注文単価
foreach ((array)$dispDataList as $key => $val) {
    if ($val["ordering_pay_total"]) {
        $dispDataList[$key]["user_price"] = floor($val["ordering_pay_total"] / ($val["user"] + $val["quit_user"]));
    }
}

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $salesWhereArray[] = "p.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $salesWhereArray[] = "p.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $salesWhereArray[] = "p.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $salesWhereArray[] = "p.create_datetime <= '" . $param["date"] . " 23:59:59'";
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
        $dispDataList[$val["payment_date"]]["pay_total"] += $val["pay_total"];
        // 入金種別毎の集計
        $dispDataList[$val["payment_date"]][$val["pay_type"]] += $val["pay_total"];

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
        } else if ($val["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]) {
            $dispDataList[$val["payment_date"]]["sales_quit_user"] += $val["user"];
        }
    }
}

// 客単価
foreach ((array)$dispDataList as $key => $val) {
    if ($val["pay_total"]) {
        $dispDataList[$key]["sales_user_price"] = floor($val["pay_total"] / ($val["sales_user"] + $val["sales_quit_user"]));
    }
}

if ($dispDataList) {
    foreach ((array)$dispDataList as $dispKey => $dispVal) {
        $data = "";

        $date = date("Y-m-d", strtotime($dispKey));
        $data["date"] = date("Y年m月d日", strtotime($date)) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
        $data["order_cnt"] = ($dispVal["order_cnt"] ? $dispVal["order_cnt"] : 0);
        $data["ordering_pay_total"] = ($dispVal["ordering_pay_total"] ? $dispVal["ordering_pay_total"] : 0);
        $data["user"] = ($dispVal["user"] ? $dispVal["user"] : 0) . " | " . ($dispVal["quit_user"] ? $dispVal["quit_user"] : 0);
        $data["user_price"] = ($dispVal["user_price"] ? $dispVal["user_price"] : 0);
        $data["sales_user"] = ($dispVal["sales_user"] ? $dispVal["sales_user"] : 0) . " | " . ($dispVal["sales_quit_user"] ? $dispVal["sales_quit_user"] : 0);
        $data["sales_user_price"] = ($dispVal["sales_user_price"] ? $dispVal["sales_user_price"] : 0);
        $data["pay_total"] = ($dispVal["pay_total"] ? $dispVal["pay_total"] : 0);
        foreach (AdmOrdering::$_payType as $key => $val) {
            $data["pay_type_" . $key] = ($dispVal[$key] ? $dispVal[$key] : 0);
        }
        $jsonData[] = $data;
    }
}

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
