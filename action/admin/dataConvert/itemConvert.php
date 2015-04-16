<?php
/**
 * itemConvert.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 商品データのコンバート処理ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . '/common/admin_common.php');
ini_set("memory_limit","256M");
$AdmItemOBJ = AdmItem::getInstance();

/***************** itemテーブル *****************/

// 高配当参照テーブル名
$tableNameKohaito1 = "";
$tableNameKohaito1 = "kohaito.item";

// suraimu参照テーブル名(本番時はテーブル名を変更してください)
$tableNameSuraimu1 = "";
$tableNameSuraimu1 = "item";

// itemテーブル全データ取得
$columnArray   = array();
$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$sql = "";
$sql = $AdmItemOBJ->makeSelectQuery($tableNameKohaito1, $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmItemOBJ->executeQuery($sql)) {
    exit("データ抽出クエリーが失敗しました。");
}

// リスト作成
$itemListFromKohaito = array();
$itemListFromKohaito = $dbResultOBJ->fetchAll();

// レコード数件数
$rows = "";
$rows = $AdmItemOBJ->getFoundRows();

// 処理件数
$cnt = 0;

foreach ($itemListFromKohaito as $key => $val) {

    // ハッシュ値変換
    $i = 0;
    do {
        // 初期化
        $accessKey   = "";
        $columnArray = array();
        $whereArray  = array();
        $sql         = "";

        $accessKey   = md5($val["id"] . "__" . time());
        $accessKey   = substr($accessKey,0,16);

        $columnArray[] = "*";

        $whereArray[] = "access_key = '" . $accessKey . "'";

        $sql = $AdmItemOBJ->makeSelectQuery($tableNameSuraimu1, $columnArray, $whereArray);

        $i++;

        // ループ回数は100回
        if ($i > 100) {
            exit("アクセスキー作成エラー");
        }

    } while ($data = $AdmItemOBJ->executeQuery($sql, "fetchRow"));

    // 初期化
    $insertItemToSuraimu = array();

    // 更新データ作成
    $insertItemToSuraimu["id"]                   = $val["id"];
    $insertItemToSuraimu["access_key"]           = $accessKey;
    $insertItemToSuraimu["name"]                 = $val["name"];
    $insertItemToSuraimu["html_text_name_mb"]    = htmlspecialchars($val["html_text_name"], ENT_QUOTES);
    $insertItemToSuraimu["remail_name"]          = $val["remail_item_name"];
    $insertItemToSuraimu["item_category_id"]     = $val["item_category_id"];
    $insertItemToSuraimu["is_display"]           = $val["is_display"];
    $insertItemToSuraimu["sales_start_datetime"] = $val["display_start_datetime"];
    $insertItemToSuraimu["sales_end_datetime"]   = $val["display_end_datetime"];
    $insertItemToSuraimu["payment_status"]       = $val["payment_status"];
    $insertItemToSuraimu["unit_id"]              = $val["unit_id"];
    $insertItemToSuraimu["except_unit_id"]       = $val["not_display_unit_id"];
    $insertItemToSuraimu["item_id"]              = $val["display_item_id"];
    $insertItemToSuraimu["except_item_id"]       = $val["not_display_item_id"];
    $insertItemToSuraimu["price"]                = $val["price"];
    $insertItemToSuraimu["point"]                = $val["point"];
    $insertItemToSuraimu["comment"]              = $val["comment"];
    $insertItemToSuraimu["is_self_order"]        = $val["is_self_order"];
    $insertItemToSuraimu["sort_seq"]             = $val["sort_seq"];
    $insertItemToSuraimu["create_datetime"]      = $val["create_datetime"];
    $insertItemToSuraimu["update_datetime"]      = $val["update_datetime"];
    $insertItemToSuraimu["disable"]              = $val["disable"];

    // インサート
    if (!$AdmItemOBJ->insert($tableNameSuraimu1, $insertItemToSuraimu)) {
        // エラー
        exit("ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $cnt++;
}

// 完了
$msg1 = "";
$msg1 = "テーブル名 -> " . $tableNameSuraimu1 . "->" . $cnt . "件処理/" . $rows . "件中 -> 登録完了しました。";

/***************** item_categoryテーブル *****************/

// 高配当参照テーブル名
$tableNameKohaito2 = "";
$tableNameKohaito2 = "kohaito.item_category";

// suraimu参照テーブル名(本番時はテーブル名を変更してください)
$tableNameSuraimu2 = "";
$tableNameSuraimu2 = "item_category";

// itemテーブル全データ取得
$columnArray   = array();
$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$sql = "";
$sql = $AdmItemOBJ->makeSelectQuery($tableNameKohaito2, $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $AdmItemOBJ->executeQuery($sql)) {
    exit("データ抽出クエリーが失敗しました。");
}

// リスト作成
$itemListFromKohaito = array();
$itemListFromKohaito = $dbResultOBJ->fetchAll();

// レコード数件数
$rows = "";
$rows = $AdmItemOBJ->getFoundRows();

// 処理件数
$cnt = 0;

foreach ($itemListFromKohaito as $key => $val) {

    // 初期化
    $insertItemCategoryToSuraimu = array();

    // 更新データ作成
    $insertItemCategoryToSuraimu["id"]              = $val["id"];
    $insertItemCategoryToSuraimu["is_display"]      = $val["is_display"];
    $insertItemCategoryToSuraimu["name"]            = $val["name"];
    $insertItemCategoryToSuraimu["sort_seq"]        = $val["sort_seq"];
    $insertItemCategoryToSuraimu["create_datetime"] = $val["create_datetime"];
    $insertItemCategoryToSuraimu["update_datetime"] = $val["update_datetime"];
    $insertItemCategoryToSuraimu["disable"]         = $val["disable"];

    // インサート
    if (!$AdmItemOBJ->insert($tableNameSuraimu2, $insertItemCategoryToSuraimu)) {
        // エラー
        exit("ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
    }
    $cnt++;
}

// 完了
$msg2 = "";
$msg2 = "テーブル名 -> " . $tableNameSuraimu2 . "->" . $cnt . "件処理/" . $rows . "件中 -> 登録完了しました。";

// 完了
exit($msg1 . "<br>" . $msg2);


?>