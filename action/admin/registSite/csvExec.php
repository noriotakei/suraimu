<?php

/**
 * csvExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メアドcsv出力ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmUserOBJ = AdmUser::getInstance();
$AdmUserOBJ->setDebugFlag(false);
$messageSessOBJ = new ComSessionNamespace("exec_msg");

$fileName = "userAddressList_" . date("YmdHis") . ".csv";

if ($param["device_pc"]) {
    $fileName = D_BASE_DIR . "/log/pc_" . $fileName;

    $columnArray[] = "pc_address AS mail_address";
    $whereArray[] = "pc_address != ''";
    $otherArray[] = "GROUP BY mail_address";
} else {
    $fileName = D_BASE_DIR . "/log/mb_" . $fileName;

    $columnArray[] = "mb_address AS mail_address";
    $whereArray[] = "mb_address != ''";
    $otherArray[] = "GROUP BY mail_address";
}

$dispDataList = $AdmUserOBJ->getUserListByFreeSearch($columnArray, $whereArray, $otherArray);

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $fileName);

foreach ($dispDataList as $val) {
    print(mb_convert_encoding($val["mail_address"],"SJIS","UTF-8"));
    print("\n");
}

exit;

?>
