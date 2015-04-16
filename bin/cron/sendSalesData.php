<?php
/**
 * sendSalesData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 当日当月売上データcron処理ファイル。
 *
 * 毎日24時に実行
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norio takei
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

//今日の日付
$todayDay = date("Y-m-d",strtotime("TODAY")) ; //本日
$thisMonthStartDay = date("Y-m",strtotime("TODAY")) ; //月初日
$thisMonthEndDay = date('Y-m-d', mktime(0, 0, 0, date('m') + 1, 0, date('Y')));  //月末日
$salesWhereArray[] = "p.create_datetime >= '".$thisMonthStartDay."-01 00:00:00'";
$salesWhereArray[] = "p.create_datetime <= '".$thisMonthEndDay." 23:59:59'";


// 売り上げ総金額
$columnArray = "";
$whereArray= "";
$otherArray= "";

$columnArray[] = "p.pay_type";
$columnArray[] = "SUM(p.receive_money) AS pay_total";
$columnArray[] = "CAST(p.create_datetime AS DATE) AS payment_date";
$columnArray[] = "u.media_cd";

$whereArray = $salesWhereArray;
$whereArray[] = "o.disable = 0";
$whereArray[] = "o.is_paid = 1";
$whereArray[] = "o.is_cancel = 0";
$whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";

$otherArray[] = "GROUP BY payment_date, o.id ORDER BY payment_date";
//当月の売上を取得
$orderingSalesDataList = $AdmCalculationOBJ->getCalcSalesList($param, $columnArray, $whereArray, $otherArray);

$sendPayMentData = array() ;

foreach((array)$orderingSalesDataList as $val){
    //処理日時当日のデータを取得
    //当日売上、当月売上を配列に追加
    if($val["payment_date"] == $todayDay){
        $sendPayMentData["todayPayMent"] +=  $val["pay_total"] ;
	}
    $sendPayMentData["thisMonthTotalPayMent"] +=  $val["pay_total"] ;

    //Ｚ％の当日売上、当月売上を配列に追加
    if(preg_match("/^ze|^zf|^zr/", $val["media_cd"]) AND $val["payment_date"] == $todayDay ){
      $sendPayMentData["todayPayMentByMediaCdZ"] +=  $val["pay_total"] ;
    }
    if(preg_match("/^ze|^zf|^zr/", $val["media_cd"]) ){
      $sendPayMentData["thisMonthTotalPayMentByMediaCdZ"] +=  $val["pay_total"] ;
    }

    //Ｔ％の当日売上、当月売上を配列に追加
    if(preg_match("/^t/", $val["media_cd"]) AND $val["payment_date"] == $todayDay ){
      $sendPayMentData["todayPayMentByMediaCdT"] +=  $val["pay_total"] ;
    }
    if(preg_match("/^t/", $val["media_cd"]) ){
      $sendPayMentData["thisMonthTotalPayMentByMediaCdT"] +=  $val["pay_total"] ;
    }


}

//サイトコード
$sendPayMentData["siteCd"] = $_config["define"]["BLACK_SITE_CD"] ;

//売上ﾃﾞｰﾀﾒｰﾙ送信処理のパス
$path = "http://tatuya.jp/paymentDateReceive.php" ;

//売上ﾃﾞｰﾀのhttp通信
if($sendPayMentData["thisMonthTotalPayMent"]){
    $httpParam = array (
                    "maxredirects" => 1,
                    "timeout" => 30,
                );
    try {
        // http通信
        $ComHttpOBJ = new ComHttp($path, $httpParam);
        $ComHttpOBJ->setParameterPost($sendPayMentData);
        $result = $ComHttpOBJ->request("POST");
    } catch (Zend_Exception $e) {
        continue;
    }
}
exit("COMPLETE!!");
?>