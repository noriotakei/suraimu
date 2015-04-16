<?php
/**
 * testAddressConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録テストアドレスデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$OrderingOBJ = Ordering::getInstance();

$columnArray = "";
$columnArray[] = "name";
$columnArray[] = "is_display";
$columnArray[] = "sort_seq";
$columnArray[] = "create_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.regist_test_category";
if (!$dbResultOBJ = $OrderingOBJ->insertSelect("regist_test_mail_category", $columnArray, $selectSql)) {
    exit("regist_test_mail_categoryエラー");
}

$columnArray = "";
$columnArray[] = "regist_test_mail_category_id";
$columnArray[] = "mail_address";
$columnArray[] = "is_display";
$columnArray[] = "sort_seq";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectColumnArray = "";
$selectColumnArray[] = "regist_test_category_id";
$selectColumnArray[] = "mail_address";
$selectColumnArray[] = "is_display";
$selectColumnArray[] = "sort_seq";
$selectColumnArray[] = "create_datetime";
$selectColumnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.regist_test_mail_address";
if (!$dbResultOBJ = $OrderingOBJ->insertSelect("regist_test_mail_address", $columnArray, $selectSql)) {
    exit("regist_test_mail_addressエラー");
}

print("regist_test_mail_category OK<br>");
print("regist_test_mail_address OK<br>");
exit("COMPLETE");

?>