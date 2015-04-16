<?php

/**
 * salesReportTotalData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面売り上げ全体集計リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $userDefaultWhereArray[] = "u.pre_regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $userDefaultWhereArray[] = "u.pre_regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 月ごとユーザーカウント
$userDataList = $AdmCalculationOBJ->getCalcUserCountGroupMonth($param, "", $userDefaultWhereArray);
if ($userDataList) {
    foreach ((array)$userDataList as $val) {
        $dispDataList[$val["pre_regist_month"]]["pre_user"] = $val["pre_user"];
        $dispDataList[$val["pre_regist_month"]]["user"] = $val["user"];
    }
}

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $quitUserDefaultWhereArray[] = "u.quit_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $quitUserDefaultWhereArray[] = "u.quit_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 月ごと退会ユーザーカウント
$quitUserDataList = $AdmCalculationOBJ->getCalcQuitUserCountGroupMonth($param, "", $quitUserDefaultWhereArray);
if ($quitUserDataList) {
    foreach ((array)$quitUserDataList as $val) {
        $dispDataList[$val["quit_month"]]["quit_user"] = $val["quit_user"];
    }
}

// 売り上げ総金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

// 登録日数0～30日
$columnArray[] = "COUNT(u.user_id) AS sales_count";
$columnArray[] = "COUNT(DISTINCT(u.user_id)) as sales_user";
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
        $dispDataList[$val["payment_month"]]["sales_count_0"] += $val["sales_count"];
        $dispDataList[$val["payment_month"]]["sales_user_0"] += $val["sales_user"];
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
        $dispDataList[$val["payment_month"]]["sales_count_31"] += $val["sales_count"];
        $dispDataList[$val["payment_month"]]["sales_user_31"] += $val["sales_user"];
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
        $dispDataList[$val["payment_month"]]["sales_count_61"] += $val["sales_count"];
        $dispDataList[$val["payment_month"]]["sales_user_61"] += $val["sales_user"];
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
        $dispDataList[$val["payment_month"]]["sales_count_91"] += $val["sales_count"];
        $dispDataList[$val["payment_month"]]["sales_user_91"] += $val["sales_user"];
    }
}

foreach ((array)$dispDataList as $key => $val) {

    $data = "";

    $data["pay_total"] = $val["pay_total_0"] + $val["pay_total_31"] + $val["pay_total_61"] + $val["pay_total_91"];
    $totalDataList["pay_total"] += $data["pay_total"];
    $data["payment_month"] = $key;
    $data["pre_user"] = $val["pre_user"];
    $totalDataList["pre_user"] += $val["pre_user"];
    $data["user"] = $val["user"];
    $totalDataList["user"] += $val["user"];
    $data["quit_user"] = $val["quit_user"];
    $totalDataList["quit_user"] += $val["quit_user"];
    $data["pay_total_0"] = $val["pay_total_0"];
    $totalDataList["pay_total_0"] += $val["pay_total_0"];
    $data["sales_count_0"] = $val["sales_count_0"];
    $totalDataList["sales_count_0"] += $val["sales_count_0"];
    $data["sales_user_0"] = $val["sales_user_0"];
    $totalDataList["sales_user_0"] += $val["sales_user_0"];
    if ($val["pay_total_0"]) {
        $data["sales_user_avg_0"] = $val["pay_total_0"] / $data["pay_total"] * 100;
    }
    $data["pay_total_31"] = $val["pay_total_31"];
    $totalDataList["pay_total_31"] += $val["pay_total_31"];
    $data["sales_count_31"] = $val["sales_count_31"];
    $totalDataList["sales_count_31"] += $val["sales_count_31"];
    $data["sales_user_31"] = $val["sales_user_31"];
    $totalDataList["sales_user_31"] += $val["sales_user_31"];
    if ($val["pay_total_31"]) {
        $data["sales_user_avg_31"] = floor($val["pay_total_31"] / $data["pay_total"] * 100);
    }
    $data["pay_total_61"] = $val["pay_total_61"];
    $totalDataList["pay_total_61"] += $val["pay_total_61"];
    $data["sales_count_61"] = $val["sales_count_61"];
    $totalDataList["sales_count_61"] += $val["sales_count_61"];
    $data["sales_user_61"] = $val["sales_user_61"];
    $totalDataList["sales_user_61"] += $val["sales_user_61"];
    if ($val["pay_total_61"]) {
        $data["sales_user_avg_61"] = floor($val["pay_total_61"] / $data["pay_total"] * 100);
    }
    $data["pay_total_91"] = $val["pay_total_91"];
    $totalDataList["pay_total_91"] += $val["pay_total_91"];
    $data["sales_count_91"] = $val["sales_count_91"];
    $totalDataList["sales_count_91"] += $val["sales_count_91"];
    $data["sales_user_91"] = $val["sales_user_91"];
    $totalDataList["sales_user_91"] += $val["sales_user_91"];
    if ($val["pay_total_91"]) {
        $data["sales_user_avg_91"] = floor($val["pay_total_91"] / $data["pay_total"] * 100);
    }

    $jsonData[] = $data;
}

$data = "";

$data["payment_month"] = "合計";
$data["pre_user"] = $totalDataList["pre_user"];
$data["user"] = $totalDataList["user"];
$data["quit_user"] = $totalDataList["quit_user"];
$data["pay_total_0"] = $totalDataList["pay_total_0"];
$data["sales_count_0"] = $totalDataList["sales_count_0"];
$data["sales_user_0"] = $totalDataList["sales_user_0"];
if ($totalDataList["pay_total_0"]) {
    $data["sales_user_avg_0"] = floor($totalDataList["pay_total_0"] / $totalDataList["pay_total"] * 100);
}
$data["pay_total_31"] = $totalDataList["pay_total_31"];
$data["sales_count_31"] = $totalDataList["sales_count_31"];
$data["sales_user_31"] = $totalDataList["sales_user_31"];
if ($totalDataList["pay_total_31"]) {
    $data["sales_user_avg_31"] = floor($totalDataList["pay_total_31"] / $totalDataList["pay_total"] * 100);
}
$data["pay_total_61"] = $totalDataList["pay_total_61"];
$data["sales_count_61"] = $totalDataList["sales_count_61"];
$data["sales_user_61"] = $totalDataList["sales_user_61"];
if ($totalDataList["pay_total_61"]) {
    $data["sales_user_avg_61"] = floor($totalDataList["pay_total_61"] / $totalDataList["pay_total"] * 100);
}
$data["pay_total_91"] = $totalDataList["pay_total_91"];
$data["sales_count_91"] = $totalDataList["sales_count_91"];
$data["sales_user_91"] = $totalDataList["sales_user_91"];
if ($totalDataList["pay_total_91"]) {
    $data["sales_user_avg_91"] = floor($totalDataList["pay_total_91"] / $totalDataList["pay_total"] * 100);
}

$data["pay_total"] = $totalDataList["pay_total"];

$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
