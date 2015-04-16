<?php
/**
 * hashUpdate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーデータコンバートページ処理ファイル。
 * でもハッシュ値に変換してアップデートする処理だけだよ
 * -20100709-takuro
 * 高配当⇒エージェントへのコンバートに使用しました
 * -20110214-takuro
 * 複数サイトコンバートの為、作業手順を単純化しました
 * @copyright   2010 Fraise, Inc.
 * @author      Norhisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$convStart = "START ⇒" . date("Y-m-d H:i:s");

$UserOBJ = User::getInstance();

ini_set("memory_limit","-1");
ini_set("max_execution_time", 0);

// コンバートユーザーデータ取得
$columnArray = "";
$columnArray[] = "SQL_CALC_FOUND_ROWS *";

$sql = "";
$sql = $UserOBJ->makeSelectQuery("convert_verify_user", $columnArray);

$dbResultOBJ = "";
if (!$dbResultOBJ = $UserOBJ->executeQuery($sql)) {
    exit("userデータ取得エラー");
}

// 全レコード件数
$rows = $UserOBJ->getFoundRows();

// ユーザーカウント
$updateCnt = 0;
// データカウント
$cnt = 0;

$columnArray = "";
$columnArray[] = "id";

while($cnt < $rows) {

    $sql = "";
    $sql = $UserOBJ->makeSelectQuery("convert_verify_user", $columnArray, "", array("LIMIT " . $cnt . ", 10000"));

    $dbResultOBJ = "";
    if (!$dbResultOBJ = $UserOBJ->executeQuery($sql)) {
        exit("userデータ取得エラー");
    }

    $dataList = "";
    $dataList = $dbResultOBJ->fetchAll();

    /************************/
    /*** ハッシュキー登録 ***/
    /************************/
    foreach ($dataList as $val) {

        $updateArray = "";

        // ハッシュキー生成(重複なし)
        $securityKey = ComUtility::getRamdomNumber(6);    //6桁のランダム数値
        $accessKey   = md5($val["id"] . uniqid("",1) . "__" . $securityKey );
        $updateArray["access_key"]   = substr($accessKey,0,16);

        // パスワード生成(重複ありでもOK)
        $password = ComUtility::getRamdomNumber(4);
        $updateArray["password"] = md5($val["id"] . $password . "__" . $_config["define"]["PROJECT_NAME"] ); // [パスワード]+[__]+[プロジェクト名]

        // リメールキー生成(重複なし)
        $securityKey = ComUtility::getRamdomNumber(6);    //6桁のランダム数値
        $remailKey   = md5($val["id"] . uniqid("",1) . "__" . $securityKey );
        $updateArray["remail_key"]  = substr($remailKey, 0, 16);

        // 登録
        $updateWhereArray = "";
        $updateWhereArray[] = "id = " . $val["id"];

        if (!$dbResultOBJ = $UserOBJ->update("convert_verify_user", $updateArray, $updateWhereArray, $autoQuotes = true)) {
            // エラー(処理止めずに先へ)
            print "UPDATET ERROR ID=" . $val["id"];
        }
        $updateCnt++;
    }
    $cnt = $cnt+10000;
}

$convEnd = "END ⇒" . date("Y-m-d H:i:s");

print "<table>";
print "<tr><td>ハッシュ付与開始</td><td>".$convStart."</td></tr>";
print "<tr><td>ハッシュ付与終了</td><td>".$convEnd."</td></tr>";
print "<tr><td>付　与　件　数</td><td>".$updateCnt."</td></tr>";
print "</table>";

exit("COMPLETE");

?>