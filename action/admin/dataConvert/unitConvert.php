<?php
/**
 * unitConvert.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユニットデータのコンバート処理ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . '/common/admin_common.php');
ini_set("memory_limit","256M");
$AdmUnitOBJ = AdmUnit::getInstance();

/***************** unitテーブル *****************/

// 高配当参照テーブル名
$tableNameKohaito1 = "";
$tableNameKohaito1 = "kohaito.unit";

// suraimu参照テーブル名(本番時はテーブル名を変更してください)
$tableNameSuraimu1 = "";
$tableNameSuraimu1 = "test_unit";

// itemテーブル全データ取得
$columnArray   = array();
$columnArray[] = "*";

$sql = "";
$sql = $AdmUnitOBJ->makeSelectQuery($tableNameKohaito1, $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmUnitOBJ->executeQuery($sql)) {
    exit("データ抽出クエリーが失敗しました。");
}

// リスト作成
$unitListFromKohaito = array();
$unitListFromKohaito = $dbResultOBJ->fetchAll();

// レコード数件数
$rows = "";
$rows = $AdmUnitOBJ->getFoundRows();

// 処理件数
$cnt = 0;

foreach ($unitListFromKohaito as $key => $val) {

    // 初期化
    $insertUnitToSuraimu = array();

    // 更新データ作成
    $insertUnitToSuraimu["id"]               = $val["id"];
    $insertUnitToSuraimu["comment"]          = htmlspecialchars($val["comment"], ENT_QUOTES);
    $insertUnitToSuraimu["search_condition"] = htmlspecialchars($val["search_condition"], ENT_QUOTES);
    $insertUnitToSuraimu["sql_part"]         = htmlspecialchars($val["sql_part"], ENT_QUOTES);
    $insertUnitToSuraimu["is_stay"]          = $val["is_stay"];
    $insertUnitToSuraimu["create_datetime"]  = $val["create_datetime"];
    $insertUnitToSuraimu["update_datetime"]  = $val["update_datetime"];
    $insertUnitToSuraimu["disable"]          = $val["disable"];

    // インサート
    if (!$AdmUnitOBJ->insert($tableNameSuraimu1, $insertUnitToSuraimu)) {
        // エラー
        exit("ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $cnt++;
}

// 完了
$msg1 = "";
$msg1 = "テーブル名 -> " . $tableNameSuraimu1 . "->" . $cnt . "件処理/" . $rows . "件中 -> 登録完了しました。";

/***************** unit_userテーブル *****************/

// 高配当参照テーブル名
$tableNameKohaito2 = "";
$tableNameKohaito2 = "kohaito.unit_user";

// suraimu参照テーブル名(本番時はテーブル名を変更してください)
$tableNameSuraimu2 = "";
$tableNameSuraimu2 = "test_unit_user";

// itemテーブル全データ取得
$columnArray   = array();
$columnArray[] = "*";

$sql = "";
$sql = $AdmUnitOBJ->makeSelectQuery($tableNameKohaito2, $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmUnitOBJ->executeQuery($sql)) {
    exit("データ抽出クエリーが失敗しました。");
}

// リスト作成
$unitUserListFromKohaito = array();
$unitUserFromKohaito = $dbResultOBJ->fetchAll();

// レコード数件数
$rows = "";
$rows = $AdmUnitOBJ->getFoundRows();

// 処理件数
$cnt = 0;

foreach ($unitUserFromKohaito as $key => $val) {

    // 初期化
    $insertUnitUserToSuraimu = array();

    // 更新データ作成
    $insertUnitUserToSuraimu["id"]              = $val["id"];
    $insertUnitUserToSuraimu["unit_id"]         = $val["unit_id"];
    $insertUnitUserToSuraimu["user_id"]         = $val["user_id"];
    $insertUnitUserToSuraimu["create_datetime"] = $val["create_datetime"];
    $insertUnitUserToSuraimu["disable"]         = $val["disable"];

    // インサート
    if (!$AdmUnitOBJ->insert($tableNameSuraimu2, $insertUnitUserToSuraimu)) {
        // エラー
        exit("ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $cnt++;
}

$msg2 = "";
$msg2 = "テーブル名 -> " . $tableNameSuraimu2 . "->" . $cnt . "件処理/" . $rows . "件中 -> 登録完了しました。";

// 完了
exit($msg1 . "<br>" . $msg2);

?>