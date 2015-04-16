<?php

/**
 * paymentLogList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金ログリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmItemOBJ = AdmItem::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "p.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 登録日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "p.create_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "p.*";
$columnArray[] = "o.id ordering_id";
$columnArray[] = "o.status ordering_status";
$columnArray[] = "o.create_datetime ordering_create_datetime";

// ログリスト
$dataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, $defaultWhereArray, $otherArray);
if ($dataList) {
    foreach ($dataList as $val) {
        $total["cnt"]++;
        $total["money"] += $val["receive_money"];
    }

    foreach ((array)$dataList as $key => $val) {
        // 商品詳細の取得
        $itemList[$key] = $AdmItemOBJ->getOrderingDetailItemList($val["ordering_id"]);
    }
}
$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("itemList", $itemList);
$smartyOBJ->assign("total", $total);
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
$smartyOBJ->assign("restStatus", AdmOrdering::ORDERING_STATUS_REST);
?>
