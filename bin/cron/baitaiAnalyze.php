<?php
/**
 * baitaiAnalyze.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 媒体集計登録処理ファイル。
 * 午前2時にまわす
 * 変更したら、管理画面の媒体CHKの再集計処理も変更を忘れずに。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$param["date"] = date("Y-m-d", strtotime("-1 day"));

// トランザクション開始
$AdmBaitaiOBJ->beginTransaction();

for ($i = 0; $i < 24; $i++) {

    $param["date_hour"] = date("Y-m-d H", mktime($i, 0, 0, date("n", strtotime($param["date"])), date("j", strtotime($param["date"])), date("Y", strtotime($param["date"]))));

    if (!$AdmBaitaiOBJ->execMediaAnalyze($param)) {
        // ロールバック
        $AdmBaitaiOBJ->rollbackTransaction();
        exit("NG");
    }

}

// コミット
$AdmBaitaiOBJ->commitTransaction();
exit("COMPLETE");
?>
