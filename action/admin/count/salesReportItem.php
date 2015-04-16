<?php

/**
 * salesReportItem.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面商品別売り上げ集計(月毎)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

if (ComValidation::isDate($param["date"])) {
    $smartyOBJ->assign("month", date("Y年m", strtotime($param["date"])) . "月期");
}

// 商品別売り上げの取得
$dispDataList = $AdmCalculationOBJ->getCalcItemList($param);
$smartyOBJ->assign("dispDataList", $dispDataList);

// 総合計
if ($dispDataList) {
    foreach ((array)$dispDataList as $val) {
        $totalDataList["ordering_cnt"] += $val["ordering_cnt"];
        $totalDataList["total_pay"] += $val["total_pay"];
    }
}

$smartyOBJ->assign("totalDataList", $totalDataList);
?>
