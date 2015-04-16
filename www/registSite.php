<?php
/**
 * registSite.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * サイト間登録戻り処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

$param = $requestOBJ->getAllParameter();

$RegistSiteOBJ = RegistSite::getInstance();
$UserOBJ = User::getInstance();

$userData = $UserOBJ->getLastUserDataFromMailAddress($param["mail"]);
$registSiteData = $RegistSiteOBJ->getRegistSiteDataFromCd($param["reg_site_cd"]);
if (!$registSiteData) {
    exit("NG");
}
$binRegistSiteId =  pow(2, $param["reg_site_cd"]);
if ($registSiteLogData = $RegistSiteOBJ->getRegistSiteLogDataFromMailAddress($param["mail"])) {

    // 登録済みでなければ更新
    if ((bindec($registSiteLogData["regist_site_data_id"]) & $binRegistSiteId) == 0) {
        // データ10進数にして加算し、2進数の形で格納する
        $updateData["regist_site_data_id"] = decbin(bindec($registSiteLogData["regist_site_data_id"]) + $binRegistSiteId);
        $updateData["user_id"] = $userData["user_id"];
        $updateData["update_datetime"] = date("YmdHis");

        $whereArray[] = "id = " . $registSiteLogData["id"];
        if (!$RegistSiteOBJ->updateRegistSiteLogData($updateData, $whereArray)) {
            exit("NG");
        }
    }
} else {
    // データ10進数にして加算し、2進数の形で格納する
    $insertData["regist_site_data_id"] = decbin($binRegistSiteId);
    $insertData["mail_address"] = $param["mail"];
    $insertData["user_id"] = $userData["user_id"];
    $insertData["update_datetime"] = date("YmdHis");
    if (!$RegistSiteOBJ->insertRegistSiteLogData($insertData)) {
        exit("NG");
    }
}

exit("COMPLETE");
?>
