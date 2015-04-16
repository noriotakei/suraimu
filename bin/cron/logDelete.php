<?php
/**
 * logDelete.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ログ削除。
 * unit_user、ordering_detailはunit、orderingを指定すると自動削除
 * 毎朝4時に回す
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$AdmLogDeleteOBJ = AdmLogDelete::getInstance();

$logSetData = $AdmLogDeleteOBJ->getLogDeleteSetList();

if ($logSetData) {

    foreach ($logSetData as $logVal) {

        $tableAry = explode(",", $logVal["table_name"]);
        $targetDate = date("Ymd235959", strtotime("-" . $logVal["days"] . " days"));

        if ($tableAry) {

            foreach ($tableAry as $tableVal) {

                // 単体削除除外テーブル以外
                if (!in_array($tableVal, AdmLogDelete::$_deleteException)) {
                    $whereAry = "";

                    // 付随する子テーブルも削除と単体削除を分ける
                    switch ($tableVal) {
                        case "unit":
                            $columnArray = "";
                            $whereArray = "";

                            $columnArray[] = "id";
                            $whereArray[] = "create_datetime <= '" . $targetDate . "'";
                            $whereArray[] = "is_stay = 0 OR (is_stay = 1 AND disable = 1)";

                            $sql = $AdmLogDeleteOBJ->makeSelectQuery($tableVal, $columnArray, $whereArray);
                            if (!$dbResultOBJ = $AdmLogDeleteOBJ->executeQuery($sql)) {
                                exit("NG" . __LINE__);
                            }

                            // データリスト取得
                            $dataList = $AdmLogDeleteOBJ->fetchAll($dbResultOBJ);
                            // 削除
                            if (!$AdmLogDeleteOBJ->deleteLogTable($tableVal, $whereArray)) {
                                exit("NG" . __LINE__);
                            }

                            if ($dataList) {
                                // 子テーブルの削除
                                foreach ($dataList as $dataVal) {
                                    $childWhereArray = "";
                                    $childWhereArray[] = "unit_id = " . $dataVal["id"];
                                    if (!$AdmLogDeleteOBJ->deleteLogTable("unit_user", $childWhereArray)) {
                                        exit("NG" . __LINE__);
                                    }
                                }
                            }
                            break;

                        case "ordering":
                            $columnArray = "";
                            $whereArray = "";

                            $columnArray[] = "id";
                            $whereArray[] = "create_datetime <= '" . $targetDate . "'";

                            $sql = $AdmLogDeleteOBJ->makeSelectQuery($tableVal, $columnArray, $whereArray);
                            if (!$dbResultOBJ = $AdmLogDeleteOBJ->executeQuery($sql)) {
                                break;
                            }

                            // データリスト取得
                            $dataList = $AdmLogDeleteOBJ->fetchAll($dbResultOBJ);
                            // 削除
                            if (!$AdmLogDeleteOBJ->deleteLogTable($tableVal, $whereArray)) {
                                exit("NG" . __LINE__);
                            }

                            if ($dataList) {
                                // 子テーブルの削除
                                foreach ($dataList as $dataVal) {
                                    $childWhereArray = "";
                                    $childWhereArray[] = "ordering_id = " . $dataVal["id"];
                                    if (!$AdmLogDeleteOBJ->deleteLogTable("ordering_detail", $childWhereArray)) {
                                        exit("NG" . __LINE__);
                                    }
                                }
                            }
                            break;

                        case "info_mail":
                            $whereArray = "";

                            $whereArray[] = "received_date <= '" . $targetDate . "'";
                            // 削除
                            if (!$AdmLogDeleteOBJ->deleteLogTable($tableVal, $whereArray)) {
                                exit("NG" . __LINE__);
                            }
                            break;

                        default:
                            $whereArray = "";

                            $whereArray[] = "create_datetime <= '" . $targetDate . "'";
                            // 削除
                            if (!$AdmLogDeleteOBJ->deleteLogTable($tableVal, $whereArray)) {
                                exit("NG" . __LINE__);
                            }
                            break;
                    }
                }
            }
        }
    }
}
// 終了
exit("COMPLETE!!");
?>
