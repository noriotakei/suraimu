<?php
/**
 * pointLogConvert.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ポイントログデータのコンバート処理ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . '/common/admin_common.php');
ini_set("memory_limit","256M");
$AdmPointLogOBJ = AdmPointLog::getInstance();

// 高配当参照テーブル名
$tableNameKohaito = "";
$tableNameKohaito = "kohaito.point_log";

// suraimu参照テーブル名(本番時はテーブル名を変更してください)
$tableNameSuraimu = "";
$tableNameSuraimu = "point_log";

// itemテーブル全データ取得
$columnArray   = array();
$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$sql = "";
$sql = $AdmPointLogOBJ->makeSelectQuery($tableNameKohaito, $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmPointLogOBJ->executeQuery($sql)) {
    exit("データ抽出クエリーが失敗しました。");
}

// リスト作成
$pointLogListFromKohaito = array();
$pointLogListFromKohaito = $dbResultOBJ->fetchAll();

// レコード数件数
$rows = "";
$rows = $AdmPointLogOBJ->getFoundRows();

// 処理件数
$cnt = 0;

foreach ($pointLogListFromKohaito as $key => $val) {

    // 初期化
    $insertPointLogToSuraimu = array();

    // ポイントログタイプ
    if ($val["point_type"] == 5) {
        // 管理 ユーザー情報操作
        $insertPointLogToSuraimu["type"] = AdmPointLog::TYPE_ADMIN;
    } else if($val["point_type"] == 6) {
        // 管理 ばら撒き/回収
        $insertPointLogToSuraimu["type"] = AdmPointLog::TYPE_GRANT;
    } else {
        // 通常
        $insertPointLogToSuraimu["type"] = AdmPointLog::TYPE_NORMAL;
    }

    // 更新データ作成
    $insertPointLogToSuraimu["id"]              = $val["id"];
    $insertPointLogToSuraimu["ordering_id"]     = $val["ordering_id"];
    $insertPointLogToSuraimu["user_id"]         = $val["user_id"];
    $insertPointLogToSuraimu["point"]           = ($val["is_plus"] ? $val["point"]:(0 - $val["point"]));
    $insertPointLogToSuraimu["create_datetime"] = $val["create_datetime"];
    $insertPointLogToSuraimu["disable"]         = $val["disable"];

    // インサート
    if (!$AdmPointLogOBJ->insert($tableNameSuraimu, $insertPointLogToSuraimu)) {
        // エラー
        exit("ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $cnt++;
}

// 完了
exit("テーブル名 -> " . $tableNameSuraimu . "->" . $cnt . "件処理/" . $rows . "件中 -> 登録完了しました。");


?>