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

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "o.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "o.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);
$ComEmojiOBJ = ComEmoji::getInstance();
// 他キャリアの絵文字を変換する際、半角カナを用いるよう設定
$ComEmojiOBJ->useHalfwidthKatakana();

if ($param["item_id"]) {
    $defaultWhereArray[] = "item.id IN (" . trim($param["item_id"], ",") . ")";
}
if ($param["item_category_id"]) {
    $defaultWhereArray[] = "item.item_category_id IN (" . trim($param["item_category_id"], ",") . ")";
}
if ($param["sort"]) {
    $otherArray[] = "ORDER BY " . $param["sort"] . " " . $param["dir"];
}
if ($param["limit"]) {
    $otherArray[] = "LIMIT " . $param["start"] . ", " . $param["limit"];
}

// 商品別売り上げの取得
$dataList = $AdmCalculationOBJ->getItemRankingList($param, $defaultWhereArray, $otherArray);
$totalCount = $AdmCalculationOBJ->getFoundRows();

if ($dataList) {
    foreach ((array)$dataList as $val) {
        $val["item_name"] = $ComEmojiOBJ->convertCarrier($val["item_name"]);
        $jsonData[] = $val;
    }
}

$res = array(
          'success' => true,
          'total' => $totalCount,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
