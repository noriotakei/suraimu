<?php
/**
 * taikaiConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面退会予約データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$UserOBJ = User::getInstance();

$columnArray = "";
$columnArray[] = "user_id";
$columnArray[] = "create_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.taikai_request";
if (!$dbResultOBJ = $UserOBJ->insertSelect("quit_request", $columnArray, $selectSql)) {
    exit("quit_requestエラー");
}
print("quit_request OK<br>");
exit("COMPLETE");

?>