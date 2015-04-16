<?php
/**
 * convertUserDelete.php

 * ｺﾝﾊﾞｰﾄされたﾕｰｻﾞｰ対象。
 *
 * ｺﾝﾊﾞｰﾄ後4週間ｱｸｾｽが無いﾕｰｻﾞｰを論理削除
 *
 * @copyright   2011 Fraise, Inc.
 * @author      takuro ito
 * @author      norihisa hosoda
 */

// 開始時間
$startDatetime = date("Y-m-d H:i:s");
// 処理開始時間
$time1 = microtime();

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$AdmUserOBJ = AdmUser::getInstance();
$SendMailOBJ = SendMail::getInstance();

$columnArray = "";
$whereArray = "";

$columnArray[] = "COUNT(id) as count";
$whereArray[] = "disable = 0";
$whereArray[] = "media_cd LIKE 'zf%'";
$whereArray[] = "media_cd != 'zf00007'";//対象外ｺｰﾄﾞ
$whereArray[] = "pre_regist_datetime <= (DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00' ) - INTERVAL 4 WEEK)";
$whereArray[] = "last_access_datetime = '0000-00-00 00:00:00'";

$sql = $AdmUserOBJ->makeSelectQuery("user", $columnArray, $whereArray);

if (!$dbResultOBJ = $AdmUserOBJ->executeQuery($sql)) {
    exit("DATE COUNT SQL FAILURE!行:".__LINE__);
}

// データカウント取得
$dataCount = array();
$dataCount = $AdmUserOBJ->fetch($dbResultOBJ);

/*
$date = print_r($dataCount["count"], true);
mb_send_mail("norihisa_hosoda@fraise.jp", "test", $date, "");
exit();

$dataList = $AdmUserOBJ->fetchAll($dbResultOBJ);
$deleteCount = count($dataList);
if(count($deleteCount) == 0){
    exit();
}
*/

if($dataCount["count"] < 1){
    // システムにメール送信(テスト、本番環境のみ)
    $mailElements["subject"]     = "アクセス無しコンバートユーザー削除";
    $mailElements["text_body"][] = "更新はありません";
    $mailElements["text_body"][] = "開始時間:" . $startDatetime;
    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
    $SendMailOBJ->debugMailTo($mailElements);
} else {
    // トランザクション
    $AdmUserOBJ->beginTransaction();

    $updateArray = array();
    $updateArray['disable'] = 1;
    $updateArray['update_datetime'] = date("Y-m-d H:i:s");

    if (!$AdmUserOBJ->updateUserData($updateArray, $whereArray)) {
        // ロールバック
        $AdmUserOBJ->rollbackTransaction();
        exit("UPDATE FAILURE!行:".__LINE__);
    }
    $AdmUserOBJ->commitTransaction();

    // 終了時間
    $endDatetime = date("Y-m-d H:i:s");
    // 処理終了時間
    $time2 = microtime();
    // 処理時間計測
    $resultTime = $time2 - $time1;

    // システムにメール送信(テスト、本番環境のみ)
    $mailElements["subject"]     = "アクセス無しコンバートユーザー削除";
    $mailElements["text_body"][] = "更新件数:" . $dataCount["count"];
    $mailElements["text_body"][] = "論理削除しました。";
    $mailElements["text_body"][] = "開始時間:" . $startDatetime;
    $mailElements["text_body"][] = "終了時間:" . $endDatetime;
    $mailElements["text_body"][] = "処理時間:" . $resultTime;
    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
    $SendMailOBJ->debugMailTo($mailElements);
}

exit("UPDATE SUCCESS!");

?>
