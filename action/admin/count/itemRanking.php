<?php

/**
 * itemRanking.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面商品ランキングリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "o.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 商品別売り上げの取得
$dataList = $AdmCalculationOBJ->getItemRankingList($param, $defaultWhereArray, "ORDER BY item_cnt DESC LIMIT 100");
$smartyOBJ->assign("dataList", $dataList);

?>
