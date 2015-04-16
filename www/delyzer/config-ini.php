<?php
$config = array(
    // DBのアクセスユーザ
    "mysql" => array(
            "DATABASE_USER"    => "suraimu",
            "DATABASE_PASS"    => "50po100po",
            "DATABASE_ADDRESS" => "10.7.15.52",
            "DATABASE_NAME"    => "suraimu",
    ),
    // ドメインをハッシュしたもの(例 v-gas.jp)
    "access_key"   => "862a9704860338ee1581a8bfc4a6dcc3",
    // 取るデータ(アクセス数)
    "access_column_array" => array(
        "1" => "ad_code",                   //媒体コード
        "2" => "access_count",              //アクセスのべ
    ),
    // 取るデータ(新規数)
    "user_column_array" => array(
        "1" => "no_regist_male",                //仮登録男
        "2" => "no_regist_female",              //仮登録女
        "3" => "regist_male",                   //本登録男
        "4" => "regist_female",                 //本登録女
    ),
    // 取るデータ(入金)
    "trd_column_array" => array(
        "1" => "before_sales_male",                 //3ヶ月以上前登録のユーザの入金総額
        "2" => "three_month_sales_male",            //2ヶ月前登録のユーザの入金総額
        "3" => "two_month_sales_male",              //1ヶ月前登録のユーザの入金総額
        "4" => "current_month_sales_male",          //当月登録ユーザの入金総額
        "5" => "before_count_male",                 //3ヶ月以上前登録のユーザの入金回数
        "6" => "three_month_count_male",            //2ヶ月前登録のユーザの入金回数
        "7" => "two_month_count_male",              //1ヶ月前登録のユーザの入金回数
        "8" => "current_month_count_male",          //当月登録ユーザの入金回数
    ),

);

?>