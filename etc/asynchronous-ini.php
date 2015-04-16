<?php
/**
 * asynchronous-ini.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */
/**
 * 固定設定データファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

$asynchronous = array (
    //--------------------
    // define扱いの設定値
    //--------------------
    "define" => array (
        // DB接続情報
        "DATABASE" => array(
            "adapter" => "Mysqli",
            "params"  => array(
                "host"     => "localhost",
                "dbname"   => "suraimu",
                "username" => "suraimu",
                "password" => "50po100po",
                'profiler' => true,
            )
        ),

        // セッション情報
        "SESSION_NAME" => "KOHAITOSID",
        "ADMIN_SESSION_NAME" => "ADMINKOHAITOSID",
        "BAITAI_SESSION_NAME" => "BAITAIKOHAITOSID",
        "BAITAI_AGENCY_SESSION_NAME" => "BAITAIAGENCYKOHAITOSID",

        // サイト情報
        // ローカルの場合はディレクトリを変えてね
        "PROJECT_NAME" => "suraimu",
        "SITE_NAME" => "高配当.com",
        "SITE_URL" => "http://ko-haito.com/",
        "SITE_DOMAIN" => "ko-haito.com",
        "MAIL_DOMAIN" => "ko-haito.com",
        "HTTPS_SITE_URL" => "https://ko-haito.com",     // 本番環境はhttpsのURLを記載する
        "BAITAI_AGENCY_URL" => "http://media.ko-haito.com/",
        "CAMPANY" => "Best Media",

        // テスト環境フラグ
        "TEST_DEVELOPMENT_FLAG" => false,


        // 直接登録時の固定情報
        "DIRECT_AD_CD"  => "te20040",
        "DIRECT_REGIST" =>array(
            //デフォルト
            "a@ko-haito.com" => array(
                "media_cd"       => "tb03011",
                "regist_page_id" => 0,
            ),
            //雑誌広告2010/10
            "a@khg.jp" => array(
                "media_cd"       => "te20001",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/10
            "m@khg.jp" => array(
                "media_cd"       => "te20002",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/11
            "w@khg.jp" => array(
                "media_cd"       => "te20003",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/11
            "k@khg.jp" => array(
                "media_cd"       => "te20005",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/11
            "g@khg.jp" => array(
                "media_cd"       => "te20004",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/11
            "p@khg.jp" => array(
                "media_cd"       => "te20006",
                "regist_page_id" => 22,
            ),
            //雑誌広告2010/12
            "t@khg.jp" => array(
                "media_cd"       => "te20007",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "j@khg.jp" => array(
                "media_cd"       => "te20008",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "d@khg.jp" => array(
                "media_cd"       => "te20009",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "am@khg.jp" => array(
                "media_cd"       => "te20010",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "aw@khg.jp" => array(
                "media_cd"       => "te20011",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "ag@khg.jp" => array(
                "media_cd"       => "te20012",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "ak@khg.jp" => array(
                "media_cd"       => "te20013",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/01
            "ap@khg.jp" => array(
                "media_cd"       => "te20014",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/02
            "ak@khg.jp" => array(
                "media_cd"       => "te20015",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/03
            "aj@khg.jp" => array(
                "media_cd"       => "te20016",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/03
            "ad@khg.jp" => array(
                "media_cd"       => "te20017",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/03
            "ma@khg.jp" => array(
                "media_cd"       => "te20018",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/03
            "da@khg.jp" => array(
                "media_cd"       => "te20019",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/08
            "wa@khg.jp" => array(
                "media_cd"       => "te20021",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/08
            "ga@khg.jp" => array(
                "media_cd"       => "te20022",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/09
            "ka@khg.jp" => array(
                "media_cd"       => "te20023",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/10
            "d-king@ko-haito.com" => array(
                "media_cd"       => "to20116",
                "regist_page_id" => 23,
            ),
            //雑誌広告2011/11
            "kawada@ko-haito.com" => array(
                "media_cd"       => "to20128",
                "regist_page_id" => 23,
            ),
            //雑誌広告2011/11
            "auc@ko-haito.com" => array(
                "media_cd"       => "to20133",
                "regist_page_id" => 23,
            ),
            //雑誌広告2011/11
            "a@khw.jp" => array(
                "media_cd"       => "te20033",
                "regist_page_id" => 22,
            ),
            //雑誌広告2011/11
            "a@55a.jp" => array(
                "media_cd"       => "te20032",
                "regist_page_id" => 22,
            ),
            //雑誌広告2014/07
            "regist1407a@ko-haito.com" => array(
            		"media_cd"       => "tb20212",
            		"regist_page_id" => 22,
            ),
        ),

        "SYSTEM_IP_ADDRESS" => "219.111.2.137",

        // サイトコード
        "SITE_CD"  => 5,
        "BLACK_SITE_CD" => 5,

        // メルマガ対応用ドメイン
        "SEND_MAIL_DOMAIN" => array(
            "0" => "ko-haito.com",
            //"1" => "high-dividend.net",
            //"2" => "high-dividend.jp",
            //"3" => "precious-benefit.com",
            //"4" => "precious-benefit.net",
            //"5" => "precious-benefit.jp",
            //"6" => "valuable-allotment.com",
            //"7" => "valuable-allotment.net",
            //"8" => "valuable-allotment.jp",
            //"9" => "valuable-allotment.jp",
            //"10" => "valuable-allotment.com",
        ),

        // 懸賞用入り口(ｴｰｼﾞｪﾝﾄ以外は使わない予定)
        "REGIST_PAGE_PRIZE" => array(
            "0" => "1000",
            "1" => "1000",
        ),

        "COMPANY_NAME"    => "MAY",
        "COMPANY_ADDRESS" => "東京都渋谷区代々木3-36-8-212",
        "COMPANY_FAX"     => "03-6674-2857",
        "COMPANY_TEL"     => "03-3351-6501",
        "COMPANY_NAVI"    => "0570-011180",

        // 決済飛び先URL
        "DIRECT_SETTLE_TYPE" => array(
            "not_select" => "設定無し",
            "SettleBank" => "銀行振込",
            "SettleNetBank" => "ネット銀行",
            "SettleTelecom" => "クレジット決済",
            "SettleBitcash" => "ビットキャッシュ",
            "SettleCvd" => "コンビニ決済",
        ),

    )

);

$asynchronous = $asynchronous + array (

    "config" => array (

        "common_config" => array (
            // 社内IPアドレス
            "corporation_ip_address" => array (
                $asynchronous["define"]["SYSTEM_IP_ADDRESS"] => "フレーズ システム部",
                "203.141.146.104" => "バルデザイン",
                "116.58.171.31"   => "バルデザイン",
                "219.111.1.208"   => "バルデザイン",
                "202.212.121.74"  => "WING木村旧ノーパ",
                "219.111.1.135"   => "WING土屋ビル",
                "202.171.131.87"  => "ハリキリ",
                "219.111.1.124"   => "新都心",
                "219.117.216.235" => "FIVEMARK",
                "203.141.152.152" => "ベストメディア_20101129",
                "192.168.2.203"   => "AOI",
            ),

            // 社内個体識別
            "mb_serial_number" => array (
                "a2C4bB1Q8BglAbEk"  => "運営デバック携帯",
                "D6Q0s04"  => "運営デバック携帯",
                "05004018621774_vd.ezweb.ne.jp"  => "開発デバック携帯",
                "b2IL6affKKmiisLd"  => "開発デバック携帯",
                "NX22W5i"  => "開発デバック携帯",
            ),

            // アクセス解析(各サイトごとに変更する)
            "tracking_url" => array("dio" => "http://dioserver.com/4704acc6394e57fe/url=%s/ref=%s/blank.gif?guid=ON"),

        )

    )
);

?>