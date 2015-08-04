<?php
/**
 * config-ini.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 設定データファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once("asynchronous-ini.php");

$define["define"] = $asynchronous["define"] + array (
    //--------------------
    // define扱いの設定値
    //--------------------
    "SITE_URL_MOBILE" => "http://" . $asynchronous["define"]["SITE_DOMAIN"] . "/i/",

    // PCデバイス
    "DEVICE_PC"         => 1,

    // MBデバイス
    "DEVICE_DOCOMO"     => 1,
    "DEVICE_AU"         => 2,
    "DEVICE_SOFTBANK"   => 3,
    "DEVICE_DISNEY"     => 4,
    "DEVICE_OTHER"      => 5,

    // ユーザ登録種別
    "USER_REGIST_STATUS_PRE_MEMBER"    => 0,     // '仮登録',
    "USER_REGIST_STATUS_MEMBER"        => 1,     // '本登録会員',
    "USER_REGIST_STATUS_MEMBER_QUIT"   => 2,     // '会員解除',

    // アドレスステータス
    "ADDRESS_STATUS_DO"         => 0, //する
    "ADDRESS_STATUS_NO_ADDR"    => 1, //しない自動(アドレス無し)
    "ADDRESS_STATUS_REFUSAL"    => 2, //しない自動(拒否)
    "ADDRESS_STATUS_NO_DOMAIN"  => 3, //しない自動(ドメイン無し)
    "ADDRESS_STATUS_FAIL_AUTO"  => 4, //しない自動

    // メール送信ステータス
    "ADDRESS_SEND_STATUS_DO"     => 0,
    "ADDRESS_SEND_STATUS_FAIL"   => 1,

    // 危険人物フラグ
    "DANGER_NOT"    => 0,  //無効
    "DANGER_VALID"  => 1,  //有効

    // ｽﾏｰﾄﾌｫﾝOSｺｰﾄﾞ
    "SMART_PHONE_ANDROID"    => 1,  //Android
    "SMART_PHONE_IPHONE"     => 2,  //iPhone
    "SMART_PHONE_OTHER"      => 3,  //その他

    // 強行フラグ
    "REVERSE_NOT"    => 0,  //無効
    "REVERSE_VALID"  => 1,  //有効

    // 論理値
    "FALSE" => 0,
    "TRUE" => 1,

    // 性別
    "SEX_CD_NOT_SELECT" => 0,  // 未登録
    "SEX_CD_FEMALE" => 2,  // 女
    "SEX_CD_MALE"   => 1,  // 男

    //血液型
    "BLOOD_TYPE_NOT_SELECT" => 0,  // 未登録
    "BLOOD_TYPE_A" => 1,  // 未登録
    "BLOOD_TYPE_B" => 2,  // 未登録
    "BLOOD_TYPE_O" => 3,  // 未登録
    "BLOOD_TYPE_AB" => 4,  // 未登録

    // 管理画面のユーザー権限
    "AUTHORITY_TYPE_SYSTEM"        => 0,  // 開発者
    "AUTHORITY_TYPE_MANAGE"        => 1,  // 管理者
    "AUTHORITY_TYPE_OPERATOR"      => 2,  // オペレーター
    "AUTHORITY_TYPE_INFORMATION"   => 3,  // インフォ
    "AUTHORITY_TYPE_ADVERTISING"   => 4,  // 広告
    "AUTHORITY_TYPE_SHUKEI"        => 5,  // 集計
    "AUTHORITY_TYPE_DESIGN"        => 6,  // デザイン

    // コンバートリストのタイプ
    "CONVERT_TYPE_SITE_DEFAULT"   => 0,  // 通常
    "CONVERT_TYPE_USER"   => 1,          // ユーザー情報
    "CONVERT_TYPE_ARRANGE"   => 2,          // ユーザー情報(アレンジ変換)
    "CONVERT_TYPE_NORMAL_ARRANGE"   => 3,          // 通常データアレンジ変換

    // 検索サイトアドコード
    "GOOGLE_AD_CD_PC"    => "t01001",
    "GOOGLE_AD_CD_MB"    => "g01001",
    "YAHOO_AD_CD_PC"     => "t01002",
    "YAHOO2_AD_CD_PC"    => "t01002",
    "YAHOO_AD_CD_MB"     => "g01002",
    "MSN_AD_CD_PC"       => "t01003",
    "MSN_AD_CD_MB"       => "g01003",
    "LIVE_AD_CD_MB"      => "g01003",
    "EZSCH_AD_CD_MB"     => "g01004",
    "SBS_AD_CD_MB"       => "g01005",
    "DIL_YAHOO_AD_CD_MB" => "g01006",
    "WS_YAHOO_AD_CD_MB"  => "g01007",

    "DEFAULT_AD_CD_PC" => "zz99999",
    "DEFAULT_AD_CD_MB" => "zm99999",
);

$config = array (
    //--------------
    // 共通設定項目
    //--------------
    "common_config" => $asynchronous["config"]["common_config"] + array (

        // メルマガ用メールサーバー
        "mail_server_ip" => array (
            "remail" => "127.0.0.1:8080",
            "sendMagic" => "127.0.0.1:8081",
            "reverse" => "127.0.0.1:8082",
        ),
/*
        "smtp_mail_server_ip" => array (
            "remail" => "14.128.17.68:60250",
            "sendMagic" => "14.128.17.68:60251",
            "reverse" => "14.128.17.68:60252",
        ),
*/
/*
        //-20131122-takuro カエデサーバIP
        "smtp_mail_server_ip" => array (
            "remail"    => "df348a277.swlmail.net:25", //競馬ポータル共用リメール
            "sendMagic" => "df348a262.swlmail.net:25", //競馬メルマガ配信用
            "reverse"   => "df348a265.swlmail.net:25", //競馬強行配信用
        ),
*/

        "smtp_mail_server_ip" => array (
            "remail"    => "103.18.100.163:25", //競馬ポータル共用リメール
            "sendMagic" => "103.18.100.163:25", //競馬メルマガ配信用
            "reverse"   => "103.18.100.163:25", //競馬強行配信用
        ),

        "remail_mb_only" => array (
                "remail"    => "158.199.125.53:10025", //競馬ポータル共用リメール
                "sendMagic" => "158.199.125.53:10025", //競馬メルマガ配信用
                "reverse"   => "158.199.125.53:10025", //競馬強行配信用
        ),

        // メアド送信ステータス
        "is_mailmagazine" => array(
           $define["define"]["ADDRESS_SEND_STATUS_DO"]   => "受け取る",
           $define["define"]["ADDRESS_SEND_STATUS_FAIL"] => "受け取らない",
        ),
    ),

    //---------------
    // Web側設定項目
    //---------------
    "web_config" => array (

        // 性別
        "sex_cd" => array(
            $define["define"]["SEX_CD_MALE"]   => "男性",
            $define["define"]["SEX_CD_FEMALE"]   => "女性",
        ),

        // 血液型
        "blood_type" => array(
            $define["define"]["BLOOD_TYPE_A"]   => "A型",
            $define["define"]["BLOOD_TYPE_B"]   => "B型",
            $define["define"]["BLOOD_TYPE_O"]   => "O型",
            $define["define"]["BLOOD_TYPE_AB"]   => "AB型",
        ),

        // メアド送信ステータス
        "address_send_status" => array(
           $define["define"]["ADDRESS_SEND_STATUS_DO"]   => "配信する",
           $define["define"]["ADDRESS_SEND_STATUS_FAIL"] => "配信しない",
        ),

        // モバイル用ドメイン
        "mobile_mail_domain" => array (
            "docomo.ne.jp",
            "ezweb.ne.jp",
            "softbank.ne.jp",
            "i.softbank.jp",
            "disney.ne.jp",
            "d.vodafone.ne.jp",
            "h.vodafone.ne.jp",
            "t.vodafone.ne.jp",
            "r.vodafone.ne.jp",
            "c.vodafone.ne.jp",
            "k.vodafone.ne.jp",
            "n.vodafone.ne.jp",
            "s.vodafone.ne.jp",
            "q.vodafone.ne.jp"
        ),

        // MBクローラー
        "crawler_mb" => array (
            "KDDI-Googlebot-Mobile",
            "SoftBankMobileSearch",
            "DoCoMo\/2\.0 i-robot(c10;TC)",
            "Y!J",
            "Googlebot",
        ),

        // PCクローラー
        "crawler_pc" => array (
            "Baiduspider",
            "Googlebot",
            "BecomeJPBot",
            "Y!J",
            "Yahoo! ",
            "yeti",
            "msnbot",
        ),

        // 登録時のNGドメイン
        "regist_ng_domain" => array (
            ".go.jp"
        ),

        //月
        'month' => array (
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12'
        ),
        //日
        'day' => array (
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
            '31' => '31'
        ),

    ),

    //----------------
    // 管理側設定項目
    //----------------
    "admin_config" => array (

        // 管理画面のユーザー権限
        "authority_type" => array (
            $define["define"]["AUTHORITY_TYPE_SYSTEM"] => "開発者",
            $define["define"]["AUTHORITY_TYPE_MANAGE"] => "管理者",
            $define["define"]["AUTHORITY_TYPE_OPERATOR"] => "オペレーター",
            $define["define"]["AUTHORITY_TYPE_INFORMATION"] => "インフォメーション",
            $define["define"]["AUTHORITY_TYPE_ADVERTISING"] => "広告",
            $define["define"]["AUTHORITY_TYPE_SHUKEI"] => "集計",
            $define["define"]["AUTHORITY_TYPE_DESIGN"] => "デザイン",
            ),

        // 代理店用媒体指定の配列
        "specify_baitai_chk" => array (
            "" => "気にしない",
            "1" => "前方一致",
            "2" => "後方一致",
            "3" => "完全一致",
        ),

        "contents_type_name" => array (
            "0" => "単数",
            "1" => "複数",
        ),

        // コンバートリストのタイプ
        "convert_type_name" => array (
            $define["define"]["CONVERT_TYPE_SITE_DEFAULT"] => "通常",
            $define["define"]["CONVERT_TYPE_USER"] => "ユーザー情報",
            $define["define"]["CONVERT_TYPE_ARRANGE"] => "アレンジ変換(ユーザー情報用)",
            $define["define"]["CONVERT_TYPE_NORMAL_ARRANGE"] => "アレンジ変換(通常)",
        ),

        "display_condition_name" => array (
            "0" => "表示",
            "1" => "非表示",
        ),

        // メールアドレス指定の配列
        "specify_address" => array (
            "" => "気にしない",
            "1" => "前方一致",
            "2" => "後方一致",
            "3" => "完全一致",
            "4" => "あり",
            "0" => "なし",
        ),

        // PCデバイス
        "pc_device" => array (
            $define["define"]["DEVICE_PC"] => "PC",
        ),

        // MBデバイス
        "mb_device" => array (
            $define["define"]["DEVICE_DOCOMO"] => "DOCOMO",
            $define["define"]["DEVICE_AU"] => "AU",
            $define["define"]["DEVICE_SOFTBANK"] => "SOFTBANK",
            $define["define"]["DEVICE_DISNEY"] => "DISNEY",
            $define["define"]["DEVICE_OTHER"] => "その他",
        ),


        // ユーザーステータス
        "regist_status" => array(
            $define["define"]["USER_REGIST_STATUS_PRE_MEMBER"]  => "仮登録",
            $define["define"]["USER_REGIST_STATUS_MEMBER"]      => "本登録",
            $define["define"]["USER_REGIST_STATUS_MEMBER_QUIT"] => "会員解除",
        ),

        // メアドステータス
        "address_status" => array(
            $define["define"]["ADDRESS_STATUS_DO"]        => "する",
            $define["define"]["ADDRESS_STATUS_REFUSAL"]   => "しない自動(拒否)",
            $define["define"]["ADDRESS_STATUS_NO_ADDR"]   => "しない自動(アドレス無し)",
            $define["define"]["ADDRESS_STATUS_NO_DOMAIN"] => "しない自動(ドメイン無し)",
            $define["define"]["ADDRESS_STATUS_FAIL_AUTO"]   => "しない自動",
            ),

        // 管理メアド送信ステータス
        "address_send_status" => array(
           $define["define"]["ADDRESS_SEND_STATUS_DO"]   => "メールする",
           $define["define"]["ADDRESS_SEND_STATUS_FAIL"] => "メールしない",
        ),

        // OR検索用管理メアド送信ステータス
        "is_address_send_status_or" => array(
            "1" => "PCする、もしくはMBする"
        ),

        // OR検索用メアド配信ステータス
        "is_mailmagazine_or" => array(
            "1" => "PC配信する、もしくはMB配信する"
        ),

       "danger_status" => array(
            $define["define"]["DANGER_NOT"]   => "無効",
            $define["define"]["DANGER_VALID"]    => "有効"
       ),

       "smart_phone_os" => array(
            $define["define"]["SMART_PHONE_ANDROID"]   => "Android",
            $define["define"]["SMART_PHONE_IPHONE"]    => "iPhone",
            $define["define"]["SMART_PHONE_OTHER"]   => "その他"
       ),

       "reverse_status" => array(
            $define["define"]["REVERSE_NOT"]   => "無効",
            $define["define"]["REVERSE_VALID"]    => "有効"
       ),

        /** 日付選択プルダウン配列 */
        "specify_date_time_select" => array(
            ""  => "気にしない",
            "2" => "2時間以内",
            "3" => "1日以内",
            "4" => "3日以内",
            "5" => "1週間以内",
            "6" => "1ヶ月以内",
            "7" => "時間指定",
            "1" => "日時指定",
        ),

        /** 日付選択プルダウン配列 */
        "specify_date_select" => array(
            ""  => "気にしない",
            "2" => "1日以内",
            "3" => "3日以内",
            "4" => "1週間以内",
            "5" => "1ヶ月以内",
            "1" => "日時指定",
        ),

       /** month **/
       "specify_month_select" => array(
               "8"=> "2ヶ月以内",
               "9"=> "3ヶ月以内",
               "10" => "4ヶ月以内",
               "11" => "5ヶ月以内",
               "12" => "6ヶ月以内",
               "13" => "7ヶ月",
               "14" => "8ヶ月以内",
               "15" => "9ヶ月以内",
       ),

        "specify_target_select" => array(
            "" => "いずれか含む",
            "1" => "すべて含む",
        ),

        "specify_target_including" => array(
            "1" => "含む",
            "" => "含まない",
        ),


        // 設定あり、なし
        "is_setting" => array(
            "0"     => "なし",
            "1"     => "あり",
        ),

        // 性別
        "sex_cd" => array(
            $define["define"]["SEX_CD_NOT_SELECT"]   => "未登録",
            $define["define"]["SEX_CD_MALE"]   => "男性",
            $define["define"]["SEX_CD_FEMALE"]   => "女性",
        ),

        // 血液型
        "blood_type" => array(
            $define["define"]["BLOOD_TYPE_NOT_SELECT"]   => "未登録",
            $define["define"]["BLOOD_TYPE_A"]   => "A型",
            $define["define"]["BLOOD_TYPE_B"]   => "B型",
            $define["define"]["BLOOD_TYPE_O"]   => "O型",
            $define["define"]["BLOOD_TYPE_AB"]   => "AB型",
        ),

        // メディアコードプルダウン配列
        "specify_media_cd" => array(
            "0"    => "気にしない",
            "1"     => "前方一致",
        ),

        "target_status" => array(
            "0" => "対象",
            "1" => "対象外",
        ),

        // 画像拡張子
        "extension_type" => array(
            "1" => "gif画像",
            "2" => "jpg画像",
            "3" => "png画像",
            "4" => "flash",

        ),

        // 曜日配列
        "week_array" => array(
            "0" => "日曜日",
            "1" => "月曜日",
            "2" => "火曜日",
            "3" => "水曜日",
            "4" => "木曜日",
            "5" => "金曜日",
            "6" => "土曜日",
        ),

        // 曜日配列(短縮)
        "week_array_short" => array(
            "0" => "日",
            "1" => "月",
            "2" => "火",
            "3" => "水",
            "4" => "木",
            "5" => "金",
            "6" => "土",
        ),

        //月額コース期限状態プルダウン
        "specify_monthly_course_select" => array(
            "0"  => "気にしない",
            "1" => "あり(期限中)",
            "2" => "あり(期限中：残り日数指定)",
            "3" => "あり(期限切れのみ)",
            "4" => "あり",
            "5" => "なし",
        ),

        //月額更新プルダウン
        "specify_monthly_update_select" => array(
            "0"  => "気にしない",
            "1" => "あり",
            "2" => "なし",
            "3" => "あり(更新商品ID指定)",
        ),

        // 競馬間コンバート先サイト選択プルダウン
        "specify_to_convert_sites_select" => array(
            "suraimu" => "KH",
            "chimera" => "AG",
            "troll" => "3競",
            "golem" => "OK",
            "gizmo" => "TS",
        ),

        // 競馬間コンバート種類選択プルダウン
        "specify_convert_type_select" => array(
            "1" => "競馬客",
            "2" => "雑誌客",
            "3" => "懸賞客",
            "4" => "成果報酬客",
        ),

        // 競馬間コンバート入金条件指定選択プルダウン
        "specify_payment_input_select" => array(
            "0" => "気にしない",
            "1" => "入なし",
            "2" => "入あり",
        ),

        //生年月日プルダウン
        "specify_birth_day_select" => array(
            ""  => "気にしない",
            "1" => "あり",
            "2" => "なし",
            "3" => "あり(日時指定)",
            "4" => "本日",
        ),

        //干支プルダウン
        "specify_sexagenary_cycle_select" => array(
            "1"  => "子",
            "2" => "丑",
            "3" => "寅",
            "4" => "卯",
            "5" => "辰",
            "6" => "巳",
            "7" => "午",
            "8" => "未",
            "9" => "申",
            "10" => "酉",
            "11" => "戌",
            "12" => "亥",
        ),

        //星座プルダウン
        "specify_constellation_select" => array(
            "1"  => "水瓶座",
            "2" => "魚座",
            "3" => "牡羊座",
            "4" => "牡牛座",
            "5" => "双子座",
            "6" => "蟹座",
            "7" => "獅子座",
            "8" => "乙女座",
            "9" => "天秤座",
            "10" => "蠍座",
            "11" => "射手座",
            "12" => "山羊座",
        ),

    ),
);

return $define + $config;
?>