<?php
/**
 * orderingDetailConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文詳細データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$OrderingOBJ = Ordering::getInstance();

$columnArray = "";
$columnArray[] = "ordering_id";
$columnArray[] = "item_id";
$columnArray[] = "price";
$columnArray[] = "is_cancel";
$columnArray[] = "create_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.ordering_detail";
if (!$dbResultOBJ = $OrderingOBJ->insertSelect("ordering_detail", $columnArray, $selectSql)) {
    exit("ordering_detailエラー");
}
print("ordering_detail OK<br>");
exit("COMPLETE");

?>