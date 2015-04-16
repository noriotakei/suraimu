<?php

/**
 * userCount.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面会員数合計リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, "", $defaultWhereArray);
foreach ((array)$dataList as $val) {
    $dispDataList["pre_user"] += $val["pre_user"];
    $dispDataList["user"] += $val["user"];
    $dispDataList["quit_user"] += $val["quit_user"];
    $dispDataList["send_ok_pc"] += $val["send_ok_pc"];
    $dispDataList["send_ok_mb"] += $val["send_ok_mb"];
    $dispDataList["send_ng_pc"] += $val["send_ng_pc"];
    $dispDataList["send_ng_mb"] += $val["send_ng_mb"];

    $dispDataList["all_user"] += $val["pre_user"] + $val["user"] + $val["quit_user"];

}
$smartyOBJ->assign("dispDataList", $dispDataList);

?>
