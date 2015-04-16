<?php

/**
 * paymentLogRateData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金割合リストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 登録日
if (ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
    $defaultWhereArray[] = "p.create_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
}

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) as sum_total_payment";

$otherArray[] = "GROUP BY p.pay_type";

// ログリスト
$dataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, $defaultWhereArray, $otherArray);

foreach ($dataList as $val) {
    $dispDataList[$val["pay_type"]]["sum_total_payment"] = $val["sum_total_payment"];
}
foreach (AdmOrdering::$_payType as $key => $val) {
    $data = "";
    $data["pay_type"] = $val;
    $data["sum_total_payment"] = $dispDataList[$key]["sum_total_payment"] ? $dispDataList[$key]["sum_total_payment"] : 0;
    $total += $data["sum_total_payment"];
    $jsonData[] = $data;
}
foreach ($jsonData as $key => $val) {
    $data = "";
    $jsonData[$key]["rate"] = $val["sum_total_payment"] ? ($val["sum_total_payment"] / $total * 100) : 0;
}
$data = "";

$data["pay_type"] = "合計";
$data["sum_total_payment"] = ($total ? $total : 0);
$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
