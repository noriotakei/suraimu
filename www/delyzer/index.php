<?php

// delyzerからのアクセス認証キー
if (!$_REQUEST["access_key"]) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}
// クラスファイル読み込み
require_once("./Calculation.php");
// 計算オブジェクト精製
$calc = new Calculation($_REQUEST["access_key"]);
// リクエストで送ってきた日付の有効性をチェック
if (!$calc->isDate($_REQUEST["date"])) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}

//年月日時(例：2007091816)で渡って来ます
$check_date = $_REQUEST["date"];




//今月、前月、前々月の年月を取得
list($next_month_year , $next_month_month) = $calc->getMonthAgoDate($check_date , -1);
list($one_month_year , $one_month_month) = $calc->getMonthAgoDate($check_date , 0);
list($two_month_year , $two_month_month) = $calc->getMonthAgoDate($check_date , 1);
list($three_month_year , $three_month_month) = $calc->getMonthAgoDate($check_date , 2);


//print("next_month_year=".$next_month_year."<br>");
//print("next_month_month=".$next_month_month."<br>");
//print("one_month_year=".$one_month_year."<br>");
//print("one_month_month=".$one_month_month."<br>");
//print("two_month_year=".$two_month_year."<br>");
//print("two_month_month=".$two_month_month."<br>");
//print("three_month_year=".$three_month_year."<br>");
//print("three_month_month=".$three_month_month."<br>");

//トップページのアクセス数を取得
$access_sql = "SELECT media_cd AS ad_code, access_count AS access_count FROM media_analyze "
      ."WHERE analyze_datetime >= ".$check_date."0000 AND analyze_datetime <= ".$check_date."5959 "
      ."AND disable = 0 "
      ."GROUP BY ad_code";

//print("sql=".$access_sql."<br>");
$access_result = $calc->calcAccess($access_sql);

//var_dump($access_result);
//print_r($access_result);

// 1本目SQL文
$user_sql = "SELECT ";
//媒体名
$user_sql .= "media_cd AS ".$calc->config["access_column_array"]["1"].","
//仮登録の集計(男)
           ."SUM(CASE WHEN regist_status = 0 THEN 1 ELSE 0 END) AS ".$calc->config["user_column_array"]["1"].","
//仮登録の集計(女)
           ."0 AS ".$calc->config["user_column_array"]["2"].","
//本登録の集計(男)
           ."SUM(CASE WHEN regist_status = 1 THEN 1 ELSE 0 END) AS ".$calc->config["user_column_array"]["3"].","
//本登録の集計(女)
           ."0 AS ".$calc->config["user_column_array"]["4"]." "
           ."FROM user WHERE regist_datetime >= ".$check_date."0000 AND regist_datetime <= ".$check_date."5959 "
           ."GROUP BY ".$calc->config["access_column_array"]["1"];

//print("<br><br>sql=".$user_sql."<br><br><br><br><br>");
$user_result = $calc->calcNewUser($user_sql);

//print_r($user_result);


$trd_sql = "SELECT user.media_cd AS ad_code,"
/*****************************登録月別売り上げ**********************************/
//３ヶ月以前(男)
     . "SUM(CASE WHEN user.regist_datetime < ".$three_month_year.$three_month_month."01000000 THEN payment_log.receive_money ELSE 0 END) as ".$calc->config["trd_column_array"]["1"].","
//３ヶ月以前(女)
     . "0 as before_sales_female,"
//前々月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$three_month_year.$three_month_month."01000000 AND user.regist_datetime < ".$two_month_year.$two_month_month."01000000 THEN payment_log.receive_money ELSE 0 END) as ".$calc->config["trd_column_array"]["2"].","
//前々月(女)
     . "0 as three_month_sales_female,"
//前月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$two_month_year.$two_month_month."01000000 AND user.regist_datetime < ".$one_month_year.$one_month_month."01000000 THEN payment_log.receive_money ELSE 0 END) as ".$calc->config["trd_column_array"]["3"].","
//前月(女)
     . "0 as two_month_sales_female,"
//当月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$one_month_year.$one_month_month."01000000 AND user.regist_datetime < ".$next_month_year.$next_month_month."01000000 THEN payment_log.receive_money ELSE 0 END) as ".$calc->config["trd_column_array"]["4"].","
//当月(女)
     . "0 as current_month_sales_female,"

//登録月別入金回数は返す値（SUMするものは1)
/******************************登録月別入金回数*********************************/
//３ヶ月以前(男)
     . "SUM(CASE WHEN user.regist_datetime < ".$three_month_year.$three_month_month."01000000 THEN 1 ELSE 0 END) as ".$calc->config["trd_column_array"]["5"].","
//３ヶ月以前(女)
     . "0 as before_count_female,"
//前々月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$three_month_year.$three_month_month."01000000 AND user.regist_datetime < ".$two_month_year.$two_month_month."01000000 THEN 1 ELSE 0 END) as ".$calc->config["trd_column_array"]["6"].","
//前々月(女)
     . "0 as three_month_count_female,"
//前月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$two_month_year.$two_month_month."01000000 AND user.regist_datetime < ".$one_month_year.$one_month_month."01000000 THEN 1 ELSE 0 END) as ".$calc->config["trd_column_array"]["7"].","
//前月(女)
     . "0 as two_month_count_female,"
//当月(男)
     . "SUM(CASE WHEN user.regist_datetime >= ".$one_month_year.$one_month_month."01000000 AND user.regist_datetime < ".$next_month_year.$next_month_month."01000000 THEN 1 ELSE 0 END) as ".$calc->config["trd_column_array"]["8"].","
//当月(女)
     . "0 as one_month_count_female "

     . "FROM payment_log LEFT JOIN user ON payment_log.user_id = user.id AND user.disable = 0 AND user.admin_id = 0 AND payment_log.disable = 0"
     . " LEFT JOIN ordering ON  payment_log.ordering_id = ordering.id AND ordering.disable = 0 AND ordering.is_paid = 1 AND ordering.is_cancel = 0"
     . " AND ordering.status IN (11, 12, 13)"
     . " WHERE payment_log.create_datetime >= ".$check_date."0000 AND payment_log.create_datetime <= ".$check_date."5959 "
     . "GROUP BY user.media_cd";


//print("<br><br>sql=".$trd_sql."<br><br><br><br><br>");


$trd_result = $calc->calcTrd($trd_sql);
//print_r($trd_result);
//exit;

//print("<br><br><br><br><br><br><br>");

if (!is_array($user_result) || !is_array($access_result) || !is_array($trd_result)) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}


//3配列のkeyが全てないと困るのでマージします
$roop_array = array_merge($user_result , $access_result , $trd_result);

//print_r($roop_array);

echo "<?xml version=\"1.0\"?>\n";
echo "<delyzer>";
// XML作成

$i = 0;
foreach ($roop_array as $ad_code_key => $ad_code_value) {
    echo "<ad_code_".$i.">";

    $ad_code_data[] = "ad_code:".urlencode($ad_code_key);

    //アクセス数の展開
    if(is_array($access_result[$ad_code_key])){
        foreach ($access_result[$ad_code_key] as $access_key => $access_value) {
            if($access_value == ""){
                $access_value = 0;
            }
            $ad_code_data[] = $access_key.":".$access_value;
        }
    }else{
        $ad_code_data[] = $calc->config["access_column_array"]["2"].":0";
    }

    //登録数の展開
    if(is_array($user_result[$ad_code_key])){
        foreach ($user_result[$ad_code_key] as $user_key => $user_value) {
            if($user_value == ""){
                $user_value = 0;
            }
            $ad_code_data[] = $user_key.":".$user_value;
        }
    }else{
        foreach($calc->config["user_column_array"] as $user_key){
            $ad_code_data[] = $user_key.":0";
        }
    }
    //入金の展開
    if(is_array($trd_result[$ad_code_key])){
        foreach ($trd_result[$ad_code_key] as $trd_key => $trd_value) {
            if($trd_value == ""){
                $trd_value = 0;
            }
            $ad_code_data[] = $trd_key.":".$trd_value;
        }
    }else{
        foreach($calc->config["trd_column_array"] as $trd_key){
            $ad_code_data[] = $trd_key.":0";
        }
    }
    echo implode("___", $ad_code_data);
    echo "</ad_code_".$i.">\n";
    unset($ad_code_data);
    $i++;

}

echo "<judge>true</judge>";
echo "</delyzer>";

exit();
?>


