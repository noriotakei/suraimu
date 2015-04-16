<?php

// delyzerからのアクセス認証キー
if (!$_REQUEST["access_key"]) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>a";
    exit();
}
// クラスファイル読み込み
require_once("./Calculation.php");
// 計算オブジェクト精製
$calc = new Calculation($_REQUEST["access_key"]);

//年月日時(yyyymmdd)で渡って来ます
$check_date = $_REQUEST["date"];
if (strlen($_REQUEST["date"]) == 6) {
    // yyyymmで渡ってきた場合
    $check_date = $_REQUEST["date"] . "01";
    $scope = "month";
} else {
    $scope = "day";
}

// リクエストで送ってきた日付の有効性をチェック
if (!$calc->isDate($check_date)) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>b";
    echo "</delyzer>";
    exit();
}




//今月、前月、前々月の年月を取得
list($next_year,    $next_month)    = $calc->getMonthAgoDate($check_date, -1);
list($current_year, $current_month) = $calc->getMonthAgoDate($check_date, 0);
list($two_year,     $two_month)     = $calc->getMonthAgoDate($check_date, 1);
list($three_year,   $three_month)   = $calc->getMonthAgoDate($check_date, 2);

$next_month     = $next_year . $next_month;
$current_month  = $current_year . $current_month;
$two_month      = $two_year . $two_month;
$three_month    = $three_year . $three_month;


if ($scope == "month") {
    $fromDay    = $current_month . "01";
    $toDay      = $next_month . "01";
} else {
    $y = substr($check_date, "0" , "4");
    $m = substr($check_date, "4" , "2");
    $d = substr($check_date, "6" , "2");

    $fromDay   = $check_date;
    $toDay     = date("Ymd", mktime(0, 0, 0, $m, $d + 1, $y));
}

// 登録経過別取得のためのサブクエリ
$sub = "SELECT "
        . " media_cd, "
        . " SUBSTRING(trade_datetime, 1, 10) AS trade_date, "
        // 当月登録ユーザー売上
        . " SUM(IF(user_regist_datetime >= " . $current_month . "01000000 AND user_regist_datetime < " . $next_month . "01000000, trade_amount, 0)) AS current_month_sales_male, "
        // 前月登録ユーザー売上
        . " SUM(IF(user_regist_datetime >= " . $two_month . "01000000 AND user_regist_datetime < " . $current_month . "01000000, trade_amount, 0)) AS two_month_sales_male, "
        // 前々月登録ユーザー売上
        . " SUM(IF(user_regist_datetime >= " . $three_month . "01000000 AND user_regist_datetime < " . $two_month . "01000000, trade_amount, 0)) AS three_month_sales_male, "
        // それ以前登録ユーザー売上
        . " SUM(IF(user_regist_datetime < " . $three_month . "01000000, trade_amount, 0)) AS before_sales_male, "

        // 当月登録ユーザー入金回数
        . " SUM(IF(user_regist_datetime >= " . $current_month . "01000000 AND user_regist_datetime < " . $next_month . "01000000, 1, 0)) AS current_month_count_male, "
        // 前月登録ユーザー入金回数
        . " SUM(IF(user_regist_datetime >= " . $two_month . "01000000 AND user_regist_datetime < " . $current_month . "01000000, 1, 0)) AS two_month_count_male, "
        // 前々月登録ユーザー入金回数
        . " SUM(IF(user_regist_datetime >= " . $three_month . "01000000 AND user_regist_datetime < " . $two_month . "01000000, 1, 0)) AS three_month_count_male, "
        // それ以前登録ユーザー入金回数
        . " SUM(IF(user_regist_datetime < " . $three_month . "01000000, 1, 0)) AS before_count_male, "

        // 当月登録入金ユニークユーザー数
           . " COUNT(DISTINCT(IF(user_regist_datetime >= " . $current_month . "01000000 AND user_regist_datetime < " . $next_month . "01000000, user_id, NULL))) AS current_month_unique_count_male, "
           // 前月登録入金ユニークユーザー数
           . " COUNT(DISTINCT(IF(user_regist_datetime >= " . $two_month . "01000000 AND user_regist_datetime < " . $current_month . "01000000, user_id, NULL))) AS two_month_unique_count_male, "
           // 前々月登録入金ユニークユーザー数
           . " COUNT(DISTINCT(IF(user_regist_datetime >= " . $three_month . "01000000 AND user_regist_datetime < " . $two_month . "01000000, user_id, NULL))) AS three_month_unique_count_male, "
           // それ以前登録入金ユニークユーザー数
           . " COUNT(DISTINCT(IF(user_regist_datetime < " . $three_month . "01000000, user_id, NULL))) AS before_unique_count_male "

    . " FROM v_trade_user "
    . " WHERE trade_datetime >= " . $fromDay . "000000 "
        . " AND trade_datetime < " . $toDay . "000000 "
    . " GROUP BY media_cd, trade_date ";


// データ取得
$sql = "SELECT "
        . " media_analyze.media_cd AS ad_code, "
        . " SUBSTRING(media_analyze.analyze_datetime, 1, 10) AS accrual_date, "
        // アクセス数
        . " SUM(media_analyze.access_count) AS access_count, "
        // 登録数
        . " SUM(media_analyze.regist_count) AS regist_male, "
        . " 0 AS regist_female, "
        // 仮登録数
        . " 0 AS non_regist_male, "
        . " 0 AS non_regist_female, "
        // 売上
        . " SUM(media_analyze.trade_amount) AS total_sales_male, "
        . " 0 AS total_sales_female, "
        . " tmp.current_month_sales_male, "
        . " 0 AS current_month_sales_female, "
        . " tmp.two_month_sales_male, "
        . " 0 AS two_month_sales_female, "
        . " tmp.three_month_sales_male, "
        . " 0 AS three_month_sales_female, "
        . " tmp.before_sales_male, "
        . " 0 AS before_sales_female, "
        // 入金回数
        . " tmp.current_month_count_male, "
        . " 0 AS current_month_count_female, "
        . " tmp.two_month_count_male, "
        . " 0 AS two_month_count_female, "
        . " tmp.three_month_count_male, "
        . " 0 AS three_month_count_female, "
        . " tmp.before_count_male, "
        . " 0 AS before_count_female, "
        // 入金人数
        . " tmp.current_month_unique_count_male, "
        . " 0 AS current_month_unique_count_female, "
        . " tmp.two_month_unique_count_male, "
        . " 0 AS two_month_unique_count_female, "
        . " tmp.three_month_unique_count_male, "
        . " 0 AS three_month_unique_count_female, "
        . " tmp.before_unique_count_male, "
        . " 0 AS before_unique_count_female "
    . " FROM media_analyze "
        . " LEFT JOIN ($sub) AS tmp "
            . " ON media_analyze.media_cd = tmp.media_cd "
            . " AND SUBSTRING(media_analyze.analyze_datetime, 1, 10) = tmp.trade_date"
    . " WHERE analyze_datetime >= " . $fromDay . "000000 "
        . " AND analyze_datetime < " . $toDay . "000000 "
    . " GROUP BY accrual_date, ad_code";

//print $sql . "\n<br>";
//exit();
$result = $calc->executeQuery($sql);
if (!$result) {
    echo "<?xml version=\"1.0\"?>";
    echo "<delyzer>";
    echo "<judge>false</judge>";
    echo "</delyzer>";
    exit();
}

echo "<?xml version=\"1.0\"?>\n";
echo "<delyzer>";

$i = 0;
while ($data = $calc->fetchAssoc($result)) {
    echo "<ad_code_".$i.">";

    $xmlData = array();
    foreach ($data as $key => $val) {
        switch ($key) {
            case "ad_code" :
                $xmlData[] = $key . ":" . urlencode($val);
                break;
            case "accrual_date" :
                $xmlData[] = $key . ":" . str_replace("-", "", $val);
                break;
            default :
                $xmlData[] = $key . ":" . (is_null($val) ? 0 : $val);
                break;
        }
    }
    echo implode("___", $xmlData);
    echo "</ad_code_".$i.">\n";

    $i++;

}

echo "<judge>true</judge>";
echo "</delyzer>";

exit();
?>


