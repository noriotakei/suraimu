<?php
/**
 * adminConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面管理ユーザーデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$AdmAdminOBJ = AdmAdmin::getInstance();

$columnArray = "";
$columnArray[] = "*";

$sql = "";
$sql = $AdmAdminOBJ->makeSelectQuery("kohaito.admin", $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmAdminOBJ->executeQuery($sql)) {
    exit("adminデータ取得エラー");
}

// データリスト取得
$dataList = "";
$dataList = $dbResultOBJ->fetchAll();

foreach ($dataList as $val) {

    $insertData = "";

    $insertData["name"] = $val["name"];
    $insertData["login_id"] = $val["login_id"];
    $insertData["password"] =  $AdmAdminOBJ->createPasswordKey($val["password"]);
    $insertData["authority_type"] = $val["permission_type"];
    $insertData["update_datetime"] = $val["update_datetime"];
    $insertData["disable"] = $val["disable"];

    if (!$dbResultOBJ = $AdmAdminOBJ->insert("admin", $insertData)) {
        // エラー
        exit("adminデータ登録エラー:ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $adminCnt++;
}

print("admin:" . $adminCnt . "件<br>");
exit("COMPLETE");

?>