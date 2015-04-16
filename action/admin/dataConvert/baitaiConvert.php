<?php
/**
 * baitaiConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体集計データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$MediaAnalyzeOBJ = MediaAnalyze::getInstance();

$columnArray = "";
$columnArray[] = "analyze_datetime";
$columnArray[] = "media_cd";
$columnArray[] = "access_count";
$columnArray[] = "regist_count";
$columnArray[] = "trade_amount";
$columnArray[] = "create_datetime";

$selectColumnArray = "";
$selectColumnArray[] = "analyze_date";
$selectColumnArray[] = "media_cd";
$selectColumnArray[] = "SUM(access_count) access_count";
$selectColumnArray[] = "SUM(regist_count) regist_count";
$selectColumnArray[] = "SUM(trade_amount) trade_amount";
$selectColumnArray[] = "create_datetime";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.media_analyze where disable = 0 group by analyze_date, media_cd";
if (!$dbResultOBJ = $MediaAnalyzeOBJ->insertSelect("media_analyze", $columnArray, $selectSql)) {
    exit("media_analyzeエラー");
}
print("media_analyze OK<br>");
exit("COMPLETE");

?>