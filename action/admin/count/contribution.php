<?php

/**
 * contribution.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面購入回数別集計(月間)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "o.paid_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "o.paid_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

// 注文数
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "u.user_id";
$columnArray[] = "u.regist_status";
$columnArray[] = "COUNT(o.id) AS order_cnt";
$columnArray[] = "SUM(o.pay_total) AS pay_total";
$columnArray[] = "CAST(o.paid_datetime AS DATE) AS paid_date";

$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";

$otherArray[] = "GROUP BY u.user_id ORDER BY order_cnt DESC";

$dataList = $AdmCalculationOBJ->getCalcOrderingList($param, $columnArray, (array_merge($defaultWhereArray, $whereArray)), $otherArray);
if ($dataList) {
    foreach ((array)$dataList as $val) {
        $dispDataList[$val["order_cnt"]]["user_id"][] = $val["user_id"];
        $dispDataList[$val["order_cnt"]]["order_cnt"] = $val["order_cnt"];
        switch ($val["regist_status"]) {

            case $_config["define"]["USER_REGIST_STATUS_MEMBER"]:
                $dispDataList[$val["order_cnt"]]["user"]++;
                $totalCnt["user"]++;
                break;
            case $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]:
                $dispDataList[$val["order_cnt"]]["quit_user"]++;
                $totalCnt["quit_user"]++;
                break;
            default:
                break;

        }

        $dispDataList[$val["order_cnt"]]["user_cnt"]++;
        $totalCnt["user_cnt"]++;
        $dispDataList[$val["order_cnt"]]["pay_total"] += $val["pay_total"];
        $totalCnt["pay_total"] += $val["pay_total"];

    }

    foreach ((array)$dispDataList as $key => $val) {
        // 客単価
        if ($val["pay_total"]) {
            $dispDataList[$key]["user_price"] = floor($val["pay_total"] / $val["user_cnt"]);
        }
        $dispDataList[$key]["user_id"] = implode(", ", $val["user_id"]);
        $dispDataList[$key]["pay_total_rate"] = $val["pay_total"] ? number_format($val["pay_total"] / $totalCnt["pay_total"] * 100, 1) : 0;
        $dispDataList[$key]["user_cnt_rate"] = $val["user_cnt"] ? number_format($val["user_cnt"] / $totalCnt["user_cnt"] * 100, 1) : 0;
        $dispDataList[$key]["quit_user_rate"] = $val["quit_user"] ? number_format($val["quit_user"] / $totalCnt["quit_user"] * 100, 1) : 0;
    }
    $totalCnt["user_price"] = $totalCnt["pay_total"] ? $totalCnt["pay_total"] / $totalCnt["user_cnt"] : 0;
    $totalCnt["pay_total_rate"] = $totalCnt["pay_total"] ? 100 : 0;
    $totalCnt["user_cnt_rate"] = $totalCnt["user_cnt"] ? 100 : 0;
    $totalCnt["quit_user_rate"] = $totalCnt["quit_user"] ? 100 : 0;
}

$smartyOBJ->assign("dispDataList", $dispDataList);
$smartyOBJ->assign("totalCnt", $totalCnt);
?>
