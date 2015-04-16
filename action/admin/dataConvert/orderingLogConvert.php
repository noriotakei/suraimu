<?php
/**
 * orderingLogConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文各種ログデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$OrderingOBJ = Ordering::getInstance();

$columnArray = "";
$columnArray[] = "*";

$sql = "";
$sql = $OrderingOBJ->makeSelectQuery("kohaito.bas_log", $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $OrderingOBJ->executeQuery($sql)) {
    exit("bas_logデータ取得エラー");
}

// データリスト取得
$dataList = "";
$dataList = $dbResultOBJ->fetchAll();

foreach ($dataList as $val) {

    $insertData = "";

    $columnArray = "";
    $columnArray[] = "*";

    $whereArray = "";
    $whereArray[] = "id=" . $val["ordering_id"];

    $sql = "";
    $sql = $OrderingOBJ->makeSelectQuery("kohaito.ordering", $columnArray, $whereArray);

    if ($orderingData = $OrderingOBJ->executeQuery($sql, "fetchRow")) {
        $insertData["user_id"] = $orderingData["user_id"];
    }

    $insertData["ordering_id"] = $val["ordering_id"];
    $insertData["receive_money"] = $val["receive_money"];
    $insertData["telno"] = $val["telno"];
    $insertData["bank_name"] = $val["bank_name"];
    $insertData["branch_name"] = $val["branch_name"];
    $insertData["is_manual"] = $val["is_manual"];
    $insertData["create_datetime"] = $val["create_datetime"];
    $insertData["update_datetime"] = $val["update_datetime"];
    $insertData["disable"] = $val["disable"];

    if (!$dbResultOBJ = $OrderingOBJ->insert("bas_log", $insertData)) {
        // エラー
        exit("bas_logデータ登録エラー:ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $basLogCnt++;
}

$columnArray = "";
$columnArray[] = "ordering_id";
$columnArray[] = "user_id";
$columnArray[] = "pay_money";
$columnArray[] = "sid";
$columnArray[] = "store_cd";
$columnArray[] = "number";
$columnArray[] = "parameter";
$columnArray[] = "is_paid";
$columnArray[] = "pay_datetime";
$columnArray[] = "pay_limit_datetime";
$columnArray[] = "create_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectColumnArray = "";
$selectColumnArray[] = "ordering_id";
$selectColumnArray[] = "user_id";
$selectColumnArray[] = "pay_money";
$selectColumnArray[] = "sid";
$selectColumnArray[] = "store_cd";
$selectColumnArray[] = "number";
$selectColumnArray[] = "parameter";
$selectColumnArray[] = "is_paid";
$selectColumnArray[] = "pay_datetime";
$selectColumnArray[] = "ADDDATE(create_datetime, INTERVAL 14 DAY)";
$selectColumnArray[] = "create_datetime";
$selectColumnArray[] = "update_datetime";
$selectColumnArray[] = "disable";


$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.cvd";
if (!$dbResultOBJ = $OrderingOBJ->insertSelect("convenience_direct", $columnArray, $selectSql)) {
    exit("convenience_directエラー");
}

$columnArray = "";
$columnArray[] = "ordering_id";
$columnArray[] = "user_id";
$columnArray[] = "pay_type";
$columnArray[] = "receive_money";
$columnArray[] = "is_cancel";
$columnArray[] = "is_manual";
$columnArray[] = "create_datetime";
$columnArray[] = "disable";

$selectColumnArray = "";
$selectColumnArray[] = "ordering_id";
$selectColumnArray[] = "user_id";
$selectColumnArray[] = "payment_type";
$selectColumnArray[] = "receive_money";
$selectColumnArray[] = "is_cancel";
$selectColumnArray[] = "is_manual";
$selectColumnArray[] = "create_datetime";
$selectColumnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.payment_log";
if (!$dbResultOBJ = $OrderingOBJ->insertSelect("payment_log", $columnArray, $selectSql)) {
    exit("payment_logエラー");
}


print("bas_log:" . $basLogCnt . "件<br>");
print("convenience_direct OK<br>");
print("payment_log OK<br>");
exit("COMPLETE");

?>