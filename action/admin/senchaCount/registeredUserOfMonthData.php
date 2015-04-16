<?php

/**
 * registeredUserOfMonthData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー登録数月間リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 仮登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.pre_regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.pre_regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

$columnArray[] = "CAST(u.pre_regist_datetime AS DATE) AS pre_regist_date";
$otherArray[] = "GROUP BY pre_regist_date ORDER BY pre_regist_date";

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, $defaultWhereArray, $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["pre_regist_date"]]["pre_user"] = $val["pre_user"];
    $dispDataList[$val["pre_regist_date"]]["all_user"] += $val["pre_user"];

    $totalData["pre_user"] += $val["pre_user"];
    $totalData["all_user"] += $val["pre_user"];
}

$defaultWhereArray = "";
$columnArray = "";
$otherArray = "";

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "CAST(u.regist_datetime AS DATE) AS regist_date";
$otherArray[] = "GROUP BY regist_date ORDER BY regist_date";

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, $columnArray, $defaultWhereArray, $otherArray);
foreach ((array)$dataList as $val) {
    $dispDataList[$val["regist_date"]]["user"] = $val["user"];
    $dispDataList[$val["regist_date"]]["quit_user"] = $val["quit_user"];
    $dispDataList[$val["regist_date"]]["all_user"] += $val["user"] + $val["quit_user"];

    $totalData["user"] += $val["user"];
    $totalData["quit_user"] += $val["quit_user"];
    $totalData["all_user"] += $val["user"]+ $val["quit_user"];
}

$defaultWhereArray = "";

// 購入日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "o.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

// 注文数
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "COUNT(o.id) AS order_cnt";
$columnArray[] = "SUM(o.pay_total) AS pay_total";
$columnArray[] = "CAST(o.create_datetime AS DATE) AS order_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_cancel = 0";

$otherArray[] = "GROUP BY order_date ORDER BY order_date";

$orderingDataList = $AdmCalculationOBJ->getCalcOrderingList($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
if ($orderingDataList) {
    foreach ((array)$orderingDataList as $val) {
        $dispDataList[$val["order_date"]]["order_cnt"] = $val["order_cnt"];
        $dispDataList[$val["order_date"]]["pay_total"] = $val["pay_total"];
        $totalData["order_cnt"] += $val["order_cnt"];
        $totalData["pay_total"] += $val["pay_total"];
        // 注文単価
        if ($dispDataList[$val["order_date"]]["pay_total"]) {
            $dispDataList[$val["order_date"]]["user_price"] = floor($dispDataList[$val["order_date"]]["pay_total"] / $val["order_cnt"]);
        }
    }
}

// 入金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "SUM(p.receive_money) AS receive_money";
$columnArray[] = "CAST(p.create_datetime AS DATE) AS order_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "p.disable = 0";
$whereArray[] = "p.is_cancel = 0";

$otherArray[] = "GROUP BY order_date ORDER BY order_date";

$orderingDataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
if ($orderingDataList) {
    foreach ((array)$orderingDataList as $val) {
        $dispDataList[$val["order_date"]]["receive_money"] = $val["receive_money"];
        $totalData["receive_money"] += $val["receive_money"];
    }
}

for ($i = 1; $i <= date("t", strtotime($param["date"])); $i++) {
    $data = "";

    $date = date("Y-m-", strtotime($param["date"])) . str_pad($i, 2, "0", STR_PAD_LEFT);
    $data["date"] = date("Y年m月d日", strtotime($date)) . "(" . AdmCalculation::$_weekArray[date("w", strtotime($date))] . ")";
    $data["all_user"] = ($dispDataList[$date]["all_user"] ? $dispDataList[$date]["all_user"] : 0);
    $data["pre_user"] = ($dispDataList[$date]["pre_user"] ? $dispDataList[$date]["pre_user"] : 0);
    $data["user"] = ($dispDataList[$date]["user"] ? $dispDataList[$date]["user"] : 0);
    $data["quit_user"] = ($dispDataList[$date]["quit_user"] ? $dispDataList[$date]["quit_user"] : 0);
    $data["order_cnt"] = ($dispDataList[$date]["order_cnt"] ? $dispDataList[$date]["order_cnt"] : 0);
    $data["pay_total"] = ($dispDataList[$date]["pay_total"] ? number_format($dispDataList[$date]["pay_total"]) : 0) . " / " . ($dispDataList[$date]["receive_money"] ? number_format($dispDataList[$date]["receive_money"]) : 0);
    $data["user_price"] = ($dispDataList[$date]["user_price"] ? $dispDataList[$date]["user_price"] : 0);
    $jsonData[] = $data;
}

$data = "";

$data["date"] = "合計";
$data["all_user"] = ($totalData["all_user"] ? $totalData["all_user"] : 0);
$data["pre_user"] = ($totalData["pre_user"] ? $totalData["pre_user"] : 0);
$data["user"] = ($totalData["user"] ? $totalData["user"] : 0);
$data["quit_user"] = ($totalData["quit_user"] ? $totalData["quit_user"] : 0);
$data["order_cnt"] = ($totalData["order_cnt"] ? $totalData["order_cnt"] : 0);
$data["pay_total"] = ($totalData["pay_total"] ? number_format($totalData["pay_total"]) : 0) . " / " . ($totalData["receive_money"] ? number_format($totalData["receive_money"]) : 0);
$data["user_price"] = (($totalData["pay_total"] && $totalData["order_cnt"]) ? floor($totalData["pay_total"] / $totalData["order_cnt"]) : 0);

$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
