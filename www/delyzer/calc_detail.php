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

if (!$calc->isDate($_REQUEST["date"])) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}

//該当日
$date = $_REQUEST["date"];
//1日後
$tomorrow = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2), substr($date, 6, 2) + 1, substr($date, 0, 4)));
//1日前
$yesterday = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2), substr($date, 6, 2) - 1, substr($date, 0, 4)));
//1週間前
$week_ago = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2), substr($date, 6, 2) - 7, substr($date, 0, 4)));
//当月の最初の日
$current_month = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2), 1, substr($date, 0, 4)));
//1ヶ月前の日
$one_month_ago = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2) - 1, substr($date, 6, 2), substr($date, 0, 4)));
//2ヶ月前の日
$two_month_ago = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2) - 2, substr($date, 6, 2), substr($date, 0, 4)));
//3ヶ月前の日
$three_month_ago = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2) - 3, substr($date, 6, 2), substr($date, 0, 4)));

$month_array["0"] = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2), 1, substr($date, 0, 4)));
// 過去一年分の年月キーを弾き出す
for ($i = 1; $i <= 12; $i++) {
    $month_array[$i] = date("Ymd", mktime(0, 0, 0, substr($date, 4, 2) - $i, 1, substr($date, 0, 4)));
}

/*
// トップページのアクセス数を取得
$access_sql = "SELECT media_cd AS ad_code, COUNT(id) AS access_count FROM page_view_log "
      ."WHERE create_datetime >= ".$date."000000 AND create_datetime <= ".$date."235959 "
      ."GROUP BY media_cd";

$access_result = $calc->calcAccess($access_sql);
*/

//入金ありのアクセス、入金なしのアクセスに変更 20091105 kiso
$access_sql = "SELECT v_user_profile.media_cd AS ad_code,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > ".$week_ago."000000 AND v_user_profile.total_payment > 0 AND v_user_profile.buy_count > 0 THEN 1 ELSE 0 END) AS week_payed,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > ".$one_month_ago."000000  AND v_user_profile.total_payment > 0 AND v_user_profile.buy_count > 0 THEN 1 ELSE 0 END) AS month_payed,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > ".$week_ago."000000  AND v_user_profile.total_payment = 0 AND v_user_profile.buy_count = 0 THEN 1 ELSE 0 END) AS week_nopay,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > ".$one_month_ago."000000 AND v_user_profile.total_payment = 0 AND v_user_profile.buy_count = 0 THEN 1 ELSE 0 END) AS month_nopay "
            . "FROM v_user_profile "
            . "WHERE v_user_profile.user_disable = 0 "
            . "AND v_user_profile.last_access_datetime > ".$one_month_ago."000000 "
            . "GROUP BY ad_code ";
//print $access_sql;
$access_result = $calc->calcAccessDetail($access_sql);


// 本登録人数と仮登録人数の算出
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
           ."FROM user WHERE regist_datetime >= ".$date."000000 AND regist_datetime <= ".$date."235959 "
           ."GROUP BY ".$calc->config["access_column_array"]["1"];

$user_result = $calc->calcNewUser($user_sql);


// 売上構成と入金構成の算出（登録月別で）
$trd_sql = "SELECT user.media_cd AS ad_code,";
$trd_sql .= "SUM(CASE WHEN user.regist_datetime >= ".$month_array["0"]."000000 THEN payment_log.receive_money ELSE 0 END) AS sales_male_0,";
$trd_sql .= "0 AS sales_female_0,";
foreach ($month_array as $key => $value) {
    //最後はそれ以前として全て取得
    if ($key + 1 == 12) {
        $trd_sql .= "SUM(CASE WHEN user.regist_datetime < ".$value."000000 THEN payment_log.receive_money ELSE 0 END) AS sales_male_".($key + 1).",";
        $trd_sql .= "0 AS sales_female_".($key + 1).",";
        break;
    //0ヶ月
    } else {
        $trd_sql .= "SUM(CASE WHEN user.regist_datetime < ".$value."000000 AND user.regist_datetime >= ".$month_array[$key + 1]."000000 THEN payment_log.receive_money ELSE 0 END) AS sales_male_".($key + 1).",";
        $trd_sql .= "0 AS sales_female_".($key + 1).",";
    }
}

$trd_sql .= "SUM(CASE WHEN user.regist_datetime >= ".$month_array["0"]."000000 THEN 1 ELSE 0 END) AS count_male_0,";
$trd_sql .= "0 AS count_female_0,";
foreach ($month_array as $key => $value) {
    //最後はそれ以前として全て取得
    if ($key + 1 == 12) {
        $trd_sql .= "SUM(CASE WHEN user.regist_datetime < ".$value."000000 THEN 1 ELSE 0 END) AS count_male_".($key + 1).",";
        $trd_sql .= "0 AS count_female_".($key + 1)." ";
        break;
    //0ヶ月
    } else {
        $trd_sql .= "SUM(CASE WHEN user.regist_datetime < ".$value."000000 AND user.regist_datetime >= ".$month_array[$key + 1]."000000 THEN 1 ELSE 0 END) AS count_male_".($key + 1).",";
        $trd_sql .= "0 AS count_female_".($key + 1).",";
    }
}

$trd_sql .= "FROM payment_log LEFT JOIN user ON payment_log.user_id = user.id AND user.disable = 0 AND payment_log.disable = 0 "
         .  "WHERE payment_log.create_datetime >= ".$date."000000 AND payment_log.create_datetime <= ".$date."235959 "
         .  "GROUP BY ad_code";

$trd_result = $calc->calcTrdDetail($trd_sql);


// 入金ユニーク数の算出（3ヶ月前のユニークに2ヶ月前、1ヶ月前、当月、当日をLeftJoinして一発で算出）
$unique_sql = "SELECT "
              //アドコード別
            . "user.media_cd AS ad_code,"
              //3ヶ月過去のユニーク入金者数
            . "COUNT(DISTINCT user.id) AS three_month_unique,"
              //2ヶ月過去のユニーク入金者数
            . "two.two_month_unique AS two_month_unique,"
              //1ヶ月過去のユニーク入金者数
            . "one.one_month_unique AS one_month_unique,"
              //当月のユニーク入金者数
            . "current.current_month_unique AS current_month_unique,"
              //昨日のユニーク入金者数
            . "yesterday.yesterday_unique AS current_date_unique "
              //tradeテーブルが結合親テーブル
            . "FROM payment_log "
              //userテーブルを結合
            . "LEFT JOIN user ON payment_log.user_id = user.id "
               //2ヶ月過去のユニーク入金者数を結合
            . "LEFT JOIN "
                . "(SELECT "
                . "user.media_cd AS ad_code_two,"
                . "COUNT(DISTINCT user.id) AS two_month_unique "
                . "FROM payment_log "
                . "LEFT JOIN user ON payment_log.user_id = user.id "
                . "WHERE payment_log.disable = 0 "
                . "AND payment_log.create_datetime >= ".$two_month_ago."000000 "
                . "AND payment_log.create_datetime < ".$tomorrow."000000 "
                . "GROUP BY ad_code_two"
                . ") AS two ON user.media_cd = two.ad_code_two "
              //1ヶ月過去のユニーク入金者数を結合
            . "LEFT JOIN "
                . "(SELECT "
                . "user.media_cd AS ad_code_one,"
                . "COUNT(DISTINCT user.id) AS one_month_unique "
                . "FROM payment_log "
                . "LEFT JOIN user ON payment_log.user_id = user.id "
                . "WHERE payment_log.disable = 0 "
                . "AND payment_log.create_datetime >= ".$one_month_ago."000000 "
                . "AND payment_log.create_datetime < ".$tomorrow."000000 "
                . "GROUP BY ad_code_one"
                . ") AS one on user.media_cd = one.ad_code_one "
              //当月登録のユニーク入金者数を結合
            . "LEFT JOIN "
                . "(SELECT "
                . "user.media_cd AS ad_code_current,"
                . "COUNT(DISTINCT user.id) AS current_month_unique "
                . "FROM payment_log "
                . "LEFT JOIN user ON payment_log.user_id = user.id "
                  //当月登録の当月入金ユニークを算出するため、userテーブルをJOIN
                . "WHERE payment_log.disable = 0 "
                . "AND user.disable = 0 "
                . "AND payment_log.create_datetime >= ".$current_month."000000 "
                . "AND payment_log.create_datetime < ".$tomorrow."000000 "
                . "AND user.regist_datetime >= ".$current_month."000000 "
                . "AND user.regist_datetime < ".$tomorrow."000000 "
                . "GROUP BY ad_code_current"
            . ") AS current on user.media_cd  = current.ad_code_current "
              //当日のユニーク入金者数を結合
            . "LEFT JOIN "
                . "(SELECT "
                . "user.media_cd AS ad_code_yesterday,"
                . "COUNT(DISTINCT user.id) AS yesterday_unique "
                . "FROM payment_log "
                . "LEFT JOIN user ON payment_log.user_id = user.id "
                . "WHERE payment_log.disable = 0 "
                . "AND payment_log.create_datetime >= ".$date."000000 "
                . "AND payment_log.create_datetime < ".$tomorrow."000000 "
                . "GROUP BY ad_code_yesterday"
                . ") AS yesterday on user.media_cd = yesterday.ad_code_yesterday "
            . "WHERE payment_log.disable = 0 "
            . "AND payment_log.create_datetime >= ".$three_month_ago."000000 "
            . "AND payment_log.create_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code";

/*
$unique_sql = "SELECT "
              //アドコード別
            . "trade.media_cd AS ad_code,"
              //入金種別
            . "trade.trade_type AS trade_type,"
              //3ヶ月過去のユニーク入金者数
            . "COUNT(DISTINCT trade.user_id) AS three_month_unique,"
              //2ヶ月過去のユニーク入金者数
            . "two.two_month_unique AS two_month_unique ,"
              //1ヶ月過去のユニーク入金者数
            . "one.one_month_unique AS one_month_unique ,"
              //当月のユニーク入金者数
            . "current.current_month_unique AS current_month_unique ,"
              //昨日のユニーク入金者数
            . "yesterday.yesterday_unique AS current_date_unique "
              //tradeテーブルが結合親テーブル
            . "FROM trade "
               //2ヶ月過去のユニーク入金者数を結合
           . "LEFT JOIN "
            . "(SELECT "
            . "two.media_cd AS ad_code_two,"
            . "two.trade_type AS trade_type_two,"
            . "COUNT(DISTINCT two.user_id) AS two_month_unique "
            . "FROM trade AS two "
            . "WHERE two.disable = 0 "
            . "AND two.trade_datetime >= ".$two_month_ago."000000 "
            . "AND two.trade_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code_two,trade_type_two"
            . ") AS two on trade.media_cd = two.ad_code_two AND trade.trade_type = two.trade_type_two "
              //1ヶ月過去のユニーク入金者数を結合
            . "LEFT JOIN "
            . "(select "
            . "one.media_cd AS ad_code_one,"
            . "one.trade_type AS trade_type_one,"
            . "COUNT(DISTINCT one.user_id) AS one_month_unique "
            . "FROM trade AS one "
            . "WHERE one.disable = 0 "
            . "AND one.trade_datetime >= ".$one_month_ago."000000 "
            . "AND one.trade_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code_one,trade_type_one"
            . ") AS one on trade.media_cd = one.ad_code_one AND trade.trade_type = one.trade_type_one "
              //当月登録のユニーク入金者数を結合
            . "LEFT JOIN "
            . "(select "
            . "current.media_cd AS ad_code_current,"
            . "current.trade_type AS trade_type_current,"
            . "COUNT(DISTINCT current.user_id) AS current_month_unique "
            . "FROM trade AS current "
              //当月登録の当月入金ユニークを算出するため、userテーブルをJOIN
            . "LEFT JOIN user on current.user_id = user.id "
            . "WHERE current.disable = 0 "
            . "AND user.disable = 0 "
            . "AND current.trade_datetime >= ".$current_month."000000 "
            . "AND current.trade_datetime < ".$tomorrow."000000 "
            . "AND user.regist_datetime >= ".$current_month."000000 "
            . "AND user.regist_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code_current,trade_type_current"
            . ") AS current on trade.media_cd  = current.ad_code_current AND trade.trade_type = current.trade_type_current "
              //当日のユニーク入金者数を結合
            . "LEFT JOIN "
            . "(select "
            . "yesterday.media_cd AS ad_code_yesterday,"
            . "yesterday.trade_type AS trade_type_yesterday,"
            . "COUNT(DISTINCT yesterday.user_id) AS yesterday_unique "
            . "FROM trade AS yesterday "
            . "WHERE yesterday.disable = 0 "
            . "AND yesterday.trade_datetime >= ".$date."000000 "
            . "AND yesterday.trade_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code_yesterday,trade_type_yesterday "
            . ") AS yesterday on trade.media_cd = yesterday.ad_code_yesterday AND trade.trade_type = yesterday.trade_type_yesterday "
            . "WHERE trade.disable = 0 "
            . "AND trade.trade_datetime >= ".$three_month_ago."000000 "
            . "AND trade.trade_datetime < ".$tomorrow."000000 "
            . "GROUP BY ad_code,trade_type";
*/

$unique_result = $calc->calcTradeUniqueCount($unique_sql);

if (!is_array($user_result) || !is_array($access_result) || !is_array($trd_result) ||  !is_array($unique_result)) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}

//3配列のkeyが全てないと困るのでマージします
$roop_array = array_merge($user_result , $access_result , $trd_result, $unique_result);

echo "<?xml version=\"1.0\"?>\n";
echo "<delyzer>";

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
        $ad_code_data[] = "week_payed".":0";
        $ad_code_data[] = "month_payed".":0";
        $ad_code_data[] = "week_nopay".":0";
        $ad_code_data[] = "month_nopay".":0";
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
        for ($j = 0; $j <= 12; $j++) {
            $ad_code_data[] = "sales_male_".$j.":0";
            $ad_code_data[] = "sales_female_".$j.":0";
            $ad_code_data[] = "count_male_".$j.":0";
            $ad_code_data[] = "count_female_".$j.":0";
        }
    }
    //ユニークの展開
    if(is_array($unique_result[$ad_code_key])){
        foreach ($unique_result[$ad_code_key] as $unique_key => $unique_value) {
            if(empty($unique_value)){
                $unique_value = 0;
            }
            $ad_code_data[] = $unique_key.":".$unique_value;
        }
    } else {
        $ad_code_data[] = "three_month_unique:0";
        $ad_code_data[] = "two_month_unique:0";
        $ad_code_data[] = "one_month_unique:0";
        $ad_code_data[] = "current_month_unique:0";
        $ad_code_data[] = "current_date_unique:0";
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