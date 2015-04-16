<?php

/**
 * paymentCountSinceOpenSite.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金回数別集計(全期間)リストページ処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);


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

$dataList = $AdmCalculationOBJ->getCalcOrderingList($param, $columnArray, $whereArray, $otherArray);

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
if ($dispDataList) {
    foreach ($dispDataList as $val) {
        $jsonData[] = $val;
    }
    $data = "";

    $data["order_cnt"] = "合計";
    $data = $data + $totalCnt;
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
