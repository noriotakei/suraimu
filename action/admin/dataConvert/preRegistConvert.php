<?php
/**
 * preRegistConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面仮登録データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$PreRegistOBJ = PreRegist::getInstance();
/*
$columnArray = "";
$columnArray[] = "regist_page_category_id";
$columnArray[] = "is_use";
$columnArray[] = "name";
$columnArray[] = "cd";
$columnArray[] = "page_html_mb";
$columnArray[] = "from_address";
$columnArray[] = "from_name";
$columnArray[] = "mb_subject";
$columnArray[] = "mb_text_body";
$columnArray[] = "mb_html_body";
$columnArray[] = "return_path";
$columnArray[] = "sort_seq";
$columnArray[] = "create_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectColumnArray = "";
$selectColumnArray[] = 1;
$selectColumnArray[] = "is_display";
$selectColumnArray[] = "name";
$selectColumnArray[] = "page_cd";
$selectColumnArray[] = "page_html_body";
$selectColumnArray[] = "from_address";
$selectColumnArray[] = "from_name";
$selectColumnArray[] = "subject";
$selectColumnArray[] = "text_body";
$selectColumnArray[] = "html_body";
$selectColumnArray[] = "return_path";
$selectColumnArray[] = "sort_seq";
$selectColumnArray[] = "create_datetime";
$selectColumnArray[] = "update_datetime";
$selectColumnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.regist_page";
if (!$dbResultOBJ = $PreRegistOBJ->insertSelect("regist_page", $columnArray, $selectSql)) {
    exit("regist_pageエラー");
}
*/

$columnArray = "";
$columnArray[] = "user_id";
$columnArray[] = "remail_key";
$columnArray[] = "regist_page_id";
$columnArray[] = "user_agent";
$columnArray[] = "mb_serial_number";
$columnArray[] = "ip_address";
$columnArray[] = "affiliate_value";
$columnArray[] = "is_regist";
$columnArray[] = "create_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.pre_regist WHERE disable = 0";
if (!$dbResultOBJ = $PreRegistOBJ->insertSelect("pre_regist", $columnArray, $selectSql)) {
    exit("pre_registエラー");
}

print("pre_regist OK<br>");
//print("regist_page OK<br>");
exit("COMPLETE");

?>