<?php

/**
 * csvExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体集計csv出力ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$dispDataList = $AdmBaitaiOBJ->getMediaCalculation($param);
foreach ((array)$dispDataList as $val) {
    $totalData["access_count"] += $val["access_count"];
    $totalData["regist_count"] += $val["regist_count"];
    $totalData["trade_amount"] += $val["trade_amount"];
}

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $startDate = $param["start_date"];
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
   $endDate = "_" . $param["end_date"];
}

// 解析日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $startDate = $param["date"];
}

$fileName = "baitai_" . str_replace("-", "", $startDate) . str_replace("-", "", $endDate);
print(mb_convert_encoding("媒体集計," . $startDate . $endDate,"SJIS","UTF-8"));
print("\n");

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $fileName . ".csv");

print(mb_convert_encoding("広告コード,アクセス回数,本登録者数,入金金額","SJIS","UTF-8"));
print("\n");

foreach ($dispDataList as $val) {
    print(mb_convert_encoding($val["media_cd"],"SJIS","UTF-8") . ",");
    print(mb_convert_encoding(($val["access_count"] ? $val["access_count"] : 0) . "アクセス","SJIS","UTF-8") . ",");
    print(mb_convert_encoding(($val["regist_count"] ? $val["regist_count"] : 0) . "件","SJIS","UTF-8") . ",");
    print(mb_convert_encoding(($val["trade_amount"] ? $val["trade_amount"] : 0) . "円","SJIS","UTF-8") . ",");
    print("\n");
}

print(mb_convert_encoding("合計","SJIS","UTF-8") . ",");
print(mb_convert_encoding(($totalData["access_count"] ? $totalData["access_count"] : 0) . "アクセス","SJIS","UTF-8") . ",");
print(mb_convert_encoding(($totalData["regist_count"] ? $totalData["regist_count"] : 0) . "件","SJIS","UTF-8") . ",");
print(mb_convert_encoding(($totalData["trade_amount"] ? $totalData["trade_amount"] : 0) . "円","SJIS","UTF-8") . ",");

exit;

?>
