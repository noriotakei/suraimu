<?php

/**
 * informationRanking.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面情報ランキングページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);
$ComEmojiOBJ = ComEmoji::getInstance();
// 他キャリアの絵文字を変換する際、半角カナを用いるよう設定
$ComEmojiOBJ->useHalfwidthKatakana();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "isl.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "isl.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$columnArray[] = "SQL_CALC_FOUND_ROWS infs.id";
$columnArray[] = "infs.name";
$columnArray[] = "COUNT(isl.id) cnt";
$columnArray[] = "infs.display_start_datetime";
$columnArray[] = "infs.display_end_datetime";

if ($param["id"]) {
    $defaultWhereArray[] = "infs.id IN (" . trim($param["id"], ",") . ")";
}

$otherArray[] = "GROUP BY infs.id";
if ($param["sort"]) {
    $otherArray[] = "ORDER BY " . $param["sort"] . " " . $param["dir"];
}
if ($param["limit"]) {
    $otherArray[] = "LIMIT " . $param["start"] . ", " . $param["limit"];
}

// 情報閲覧回数リスト
$dataList = $AdmCalculationOBJ->getCalcInformationStatusLogList($param, $columnArray, $defaultWhereArray, $otherArray);
$totalCount = $AdmCalculationOBJ->getFoundRows();

if ($dataList) {
    foreach ((array)$dataList as $val) {
        $val["name"] = $ComEmojiOBJ->convertCarrier($val["name"]);
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
