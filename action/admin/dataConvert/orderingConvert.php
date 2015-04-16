<?php
/**
 * orderingConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$OrderingOBJ = Ordering::getInstance();

// 旧注文データ取得
$columnArray = "";
$columnArray[] = "*";

$sql = "";
$sql = $OrderingOBJ->makeSelectQuery("kohaito.ordering", $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $OrderingOBJ->executeQuery($sql)) {
    exit("orderingデータ取得エラー");
}

// データリスト取得
$dataList = "";
$dataList = $dbResultOBJ->fetchAll();

foreach ($dataList as $val) {

    $i = 0;

    // access_keyがユニークになるまで繰り返す
    do {
        $accessKey   = md5($val["id"] . "__" . time());
        $accessKey   = substr($accessKey,0,16);
        $columnArray = "";
        $columnArray[] = "*";

        $whereArray = "";
        $whereArray[] = "access_key = '" . $accessKey . "'";
        $whereArray[] = "disable = 0";

        $sql = $OrderingOBJ->makeSelectQuery("ordering", $columnArray, $whereArray);

        $i++;

        // ループ回数は100回
        if ($i > 100) {
            return FALSE;
        }

    } while ($data = $OrderingOBJ->executeQuery($sql, "fetchRow"));

    $status = "";

    if ($val["status"] == 1) {
        if ($val["pay_type"] == 1) {
            $status = Ordering::ORDERING_STATUS_WAIT_BAS;
        } else if ($val["pay_type"] == 2) {
            $status = Ordering::ORDERING_STATUS_WAIT_BANK;
        } else if ($val["pay_type"] == 3) {
            $status = Ordering::ORDERING_STATUS_WAIT_CREDIT;
        } else if ($val["pay_type"] == 4) {
            $status = Ordering::ORDERING_STATUS_WAIT_CVD;
        } else if ($val["pay_type"] == 5) {
            $status = Ordering::ORDERING_STATUS_WAIT_BITCASH;
        }
    } else if ($val["status"] == 2) {
        $status = Ordering::ORDERING_STATUS_COMPLETE;
    } else if ($val["status"] == 3) {
        $status = Ordering::ORDERING_STATUS_PRE_COMPLETE;
    } else if ($val["status"] == 4) {
        $status = Ordering::ORDERING_STATUS_REST;
    }

    $insertData = "";
    $insertData["id"] = $val["id"];
    $insertData["access_key"] = $accessKey;
    $insertData["user_id"] = $val["user_id"];
    $insertData["status"] = $status;
    $insertData["pay_type"] = $val["pay_type"];
    $insertData["pay_total"] = $val["pay_total"];
    $insertData["description"] = $val["comment"];
    $insertData["is_paid"] = $val["is_paid"];
    $insertData["is_cancel"] = $val["is_cancel"];
    $insertData["paid_datetime"] = $val["paid_datetime"];
    $insertData["create_datetime"] = $val["create_datetime"];
    $insertData["update_datetime"] = $val["update_datetime"];
    $insertData["disable"] = $val["disable"];

    if (!$dbResultOBJ = $OrderingOBJ->insert("ordering", $insertData)) {
        // エラー
        exit("orderingデータ登録エラー:ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $orderingCnt++;
}

print("ordering:" . $orderingCnt . "件<br>");
exit("COMPLETE");

?>