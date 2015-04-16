<?php
/**
 * access.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 *  ファイセムファーストアクセス取得ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */


// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}

$param = $requestOBJ->getAllParameter();
$server["HTTP_X_FORWARDED_FOR"] = $requestOBJ->getParameter("HTTP_X_FORWARDED_FOR", "", "server");
$server["HTTP_USER_AGENT"]      = $requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");

// 自社アクセス以外
if (!(array_key_exists($server["HTTP_X_FORWARDED_FOR"], $_config["common_config"]["corporation_ip_address"])
     OR preg_match("/" . implode("|", $_config["web_config"]["crawler_pc"]) . "/", $server["HTTP_USER_AGENT"]))
      OR preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])) {

    $MediaAnalyzeOBJ = MediaAnalyze::getInstance();
    $insertAnalyzeData["analyze_datetime"] = "'" . date("YmdH0000") . "'";
    $insertAnalyzeData["media_cd"] = "'" . $param["ad_code"] . "'";
    $insertAnalyzeData["access_count"] = 1;
    $insertAnalyzeData["create_datetime"] = "'" . date("YmdHis") . "'";
    $updateAnalyzeData["access_count"] = "access_count + 1";
    $MediaAnalyzeOBJ->insertDuplicateMediaAnalyzeData($insertAnalyzeData, $updateAnalyzeData, false);
}

exit();
?>
