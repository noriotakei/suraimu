<?php
/**
 * registSiteSendData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト間登録cron処理ページファイル。
 *
 * 毎日0時に実行
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$UserOBJ = User::getInstance();

$userList = $UserOBJ->getYesterdayRegistUserList();
if (!$userList) {
    exit("NoData");
}

// サイト間登録通信
$RegistSiteOBJ = RegistSite::getInstance();

while (list($key, $val) = each($userList)) {
    if ($val["pc_address"]) {
        $RegistSiteOBJ->sendRegistSiteData($val["pc_address"]);
    }
    if ($val["mb_address"]) {
        $RegistSiteOBJ->sendRegistSiteData($val["mb_address"]);
    }
}

exit("COMPLETE!!");
?>