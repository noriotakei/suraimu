<?php
/**
 * userConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");

$UserOBJ = User::getInstance();
ini_set("memory_limit","256M");
// 旧ユーザーデータ取得
$columnArray = "";
$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$sql = "";
$sql = $UserOBJ->makeSelectQuery("kohaito.user", $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $UserOBJ->executeQuery($sql)) {
    exit("userデータ取得エラー");
}

// レコード数件数
$rows = $UserOBJ->getFoundRows();

for ($cnt = 0; $cnt < $rows;) {

    // 旧ユーザーデータ取得
    $columnArray = "";
    $columnArray[] = "*";

    $sql = "";
    $sql = $UserOBJ->makeSelectQuery("kohaito.user", $columnArray, "", array("LIMIT " . $cnt . ", 10000"));

    $dbResultOBJ = "";
    if (!$dbResultOBJ = $UserOBJ->executeQuery($sql)) {
        exit("userデータ取得エラー");
    }

    // データリスト取得
    $dataList = "";
    $dataList = $dbResultOBJ->fetchAll();
    $currentDateTime = date("Y-m-d H:i:s");

    foreach ($dataList as $val) {

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $securityKey = ComUtility::getRamdomNumber(6);    //6桁のランダム数値
            $remailKey   = md5($currentDateTime . "__" . $securityKey );
            $remailKey   = substr($remailKey, 0, 16);

            $columnArray = "";
            $columnArray[] = "*";

            $whereArray = "";
            $whereArray[] = "remail_key = '" . $remailKey . "'";

            $i++;

            if ($i > 100) {
                exit("リメールキー作成エラー");
            }

            $sql = "";
            $sql = $UserOBJ->makeSelectQuery("user", $columnArray, $whereArray);

        } while ( $data = $UserOBJ->executeQuery($sql, "fetchRow") );

        $insertData = "";
        $insertData["id"] = $val["id"];
        $insertData["login_id"] = $val["mail_address"];
        $insertData["password"] = $val["password"];
        $insertData["access_key"] = $val["access_key"];
        $insertData["remail_key"] = $remailKey;
        $insertData["admin_id"] = $val["admin_id"];
        $insertData["mb_ip_address"] = $val["ip_address"];
        $insertData["mb_user_agent"] = $val["user_agent"];
        $insertData["mb_serial_number"] = $val["mb_serial_number"];
        $insertData["mb_model"] = $val["model"];
        $insertData["mb_address"] = $val["mail_address"];
        $insertData["mb_address_status"] = $val["mail_status"];
        $insertData["regist_status"] = $val["regist_status"];
        $insertData["mb_device_cd"] = ($val["carrier_type"] == 0 ? 5 : $val["carrier_type"]);
        $insertData["regist_page_id"] = $val["regist_page_id"];
        $insertData["media_cd"] = $val["ad_cd"];
        $insertData["affiliate_value"] = $val["affiliate_value"];
        $insertData["affiliate_tag_url"] = $val["affiliate_tag_url"];
        $insertData["danger_status"] = $val["is_black"];
        $insertData["mailmagazine_from_domain_id"] = $val["mailmagazine_from_domain_id"];
        $insertData["pre_regist_datetime"] = $val["pre_regist_datetime"];
        $insertData["regist_datetime"] = $val["regist_datetime"];
        $insertData["last_access_datetime"] = $val["last_access_datetime"];
        $insertData["previous_access_datetime"] = $val["previous_access_datetime"];
        $insertData["quit_datetime"] = $val["quit_datetime"];
        $insertData["description"] = $val["description"];
        $insertData["update_datetime"] = $val["update_datetime"];
        $insertData["disable"] = $val["disable"];

        if (!$dbResultOBJ = $UserOBJ->insert("user", $insertData)) {
            // エラー
            exit("userデータ登録エラー:ID=" . $val["id"] . " が登録できませんでした。処理を中止します。");
        }
        $userCnt++;
    }
    $cnt = $cnt+10000;
}

print("user:" . $userCnt . "件<br>");
exit("COMPLETE");

?>