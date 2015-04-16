<?php
/**
 * infoMailConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面インフォメールデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$ComCommonOBJ = new ComCommon;

$columnArray = "";
$columnArray[] = "from_address";
$columnArray[] = "from_name";
$columnArray[] = "to_address";
$columnArray[] = "header";
$columnArray[] = "subject";
$columnArray[] = "body";
$columnArray[] = "received_date";
$columnArray[] = "priority";
$columnArray[] = "read_status";
$columnArray[] = "reply_status";
$columnArray[] = "user_id";
$columnArray[] = "operator_id";
$columnArray[] = "dir_id";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.info_mail";
if (!$dbResultOBJ = $ComCommonOBJ->insertSelect("info_mail", $columnArray, $selectSql)) {
    exit("info_mailエラー");
}

$columnArray = "";
$columnArray[] = "search_type";
$columnArray[] = "keyword";
$columnArray[] = "dir_id";
$columnArray[] = "disable";


$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.info_message_rule";
if (!$dbResultOBJ = $ComCommonOBJ->insertSelect("info_message_rule", $columnArray, $selectSql)) {
    exit("info_message_ruleエラー");
}

print("info_mail OK<br>");
print("info_message_rule OK<br>");
exit("COMPLETE");

?>