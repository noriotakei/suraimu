<?
/**
 * File Name:   config.ini
 *
 * Description: infoメーラーに関わるすべてのPHPファイルで読み込む設定ファイル。
 *              設定ツールから設定内容の更新も行うこともできる。
 */

/**********************************************************************
 * 定数定義セクション
 **********************************************************************/
define('RECEIVE_DIR',      1); // 受信トレイ
define('KEEP_DIR',         2); // 保存
define('TRANSMIT_DIR',     3); // 送信済み
define('DELETE_DIR',       4); // 削除済み

define('UNREAD_MAIL',      1); // 未読メール
define('READED_MAIL',      2); // 既読メール
define('TRANSMITTED_MAIL', 3); // 送信メール

define('NOT_REPLIED',      1); // 未対応
define('NOW_REPLING',      2); // 対応中
define('ALREADY_REPLIED',  3); // 対応済
define('IGNORED',          4); // 無視

define('HIGH_PRIOR',       1); // 重要度(高い)
define('NORMAL_PRIOR',     3); // 重要度(通常)
define('LOW_PRIOR',        5); // 重要度(低い)

define('NOT_DEFINED',      0); // 未設定

define('NOT_DISPLAY',      0); // 非表示
define('DISPLAY',          1); // 表示

define('RETIRE',           9); // 退会 member_mst

define('ADDRESS_STATUS_DO',         0); //する
define('ADDRESS_STATUS_NO_ADDR',    1); //しない自動(アドレス無し)
define('ADDRESS_STATUS_REFUSAL',    2); //しない自動(拒否)
define('ADDRESS_STATUS_NO_DOMAIN',  3); //しない自動(ドメイン無し)
define('ADDRESS_STATUS_FAIL_AUTO',  4); //しない自動

define('DISPLAY_LOG_PC',      1); // PC
define('DISPLAY_LOG_MB',      2); // MB
define('DISPLAY_LOG_PC_MB',   3); // PC,MB

// 支払いタイプ種別
define('DEVICE_DOCOMO',   1); // docomo
define('DEVICE_AU',       2); // au
define('DEVICE_SOFTBANK', 3); // softbank
define('DEVICE_DISNEY',   4); // disney
define('DEVICE_OTHER',    5); // other

// WEBメーラーディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

/**********************************************************************
 * 変数定義セクション
 **********************************************************************/
$admUrl = $define["define"]["HTTPS_SITE_URL"] . "/admin"; // 管理URL

$delPw = "6627415e807ee33c7302917216e7da68"; // 完全削除用パスワード[deep]に設定
$dbDelPw = "e74ce144934c733c83bfce9e0cf34305"; // DB削除用パスワード => [kesi]に設定

// 受信メールアカウント指定配列
$mailAccounts = array(
    "info",
    "test",
);
//基本的にあて先に対しての返信なのでinfoアドをkeyに。
$site = array(
    "default_info" => "info@" . $define["define"]["MAIL_DOMAIN"],

    "site_account"     => array(
                          "info@" . $define["define"]["MAIL_DOMAIN"] => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "" . $define["define"]["MAIL_DOMAIN"],
                                                "from"           =>   "info@" . $define["define"]["MAIL_DOMAIN"],
                                                "info"           =>   "info@" . $define["define"]["MAIL_DOMAIN"],
                                                "url"            =>   "http://" . $define["define"]["MAIL_DOMAIN"],
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@tousen-lottery.jp" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "tousen-lottery.jp",
                                                "from"           =>   "info@tousen-lottery.jp",
                                                "info"           =>   "info@tousen-lottery.jp",
                                                "url"            =>   "http://tousen-lottery.jp",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@top-kohaito.net" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "top-kohaito.net",
                                                "from"           =>   "info@top-kohaito.net",
                                                "info"           =>   "info@top-kohaito.net",
                                                "url"            =>   "http://top-kohaito.net",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@high-dividend.net" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "high-dividend.net",
                                                "from"           =>   "info@high-dividend.net",
                                                "info"           =>   "info@high-dividend.net",
                                                "url"            =>   "http://high-dividend.net",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@high-dividend.jp" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "high-dividend.jp",
                                                "from"           =>   "info@high-dividend.jp",
                                                "info"           =>   "info@high-dividend.jp",
                                                "url"            =>   "http://high-dividend.jp",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),

                          "info@precious-benefit.com" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "precious-benefit.com",
                                                "from"           =>   "info@precious-benefit.com",
                                                "info"           =>   "info@precious-benefit.com",
                                                "url"            =>   "http://precious-benefit.com",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@precious-benefit.net" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "precious-benefit.net",
                                                "from"           =>   "info@precious-benefit.net",
                                                "info"           =>   "info@precious-benefit.net",
                                                "url"            =>   "http://precious-benefit.net",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@precious-benefit.jp" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "precious-benefit.jp",
                                                "from"           =>   "info@precious-benefit.jp",
                                                "info"           =>   "info@precious-benefit.jp",
                                                "url"            =>   "http://precious-benefit.jp",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@valuable-allotment.com" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "valuable-allotment.com",
                                                "from"           =>   "info@valuable-allotment.com",
                                                "info"           =>   "info@valuable-allotment.com",
                                                "url"            =>   "http://valuable-allotment.com",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@valuable-allotment.net" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "valuable-allotment.net",
                                                "from"           =>   "info@valuable-allotment.net",
                                                "info"           =>   "info@valuable-allotment.net",
                                                "url"            =>   "http://valuable-allotment.net",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
                          "info@valuable-allotment.jp" => array(
                                                "name"           =>   $define["define"]["SITE_NAME"],
                                                "domain"         =>   "valuable-allotment.jp",
                                                "from"           =>   "info@valuable-allotment.jp",
                                                "info"           =>   "info@valuable-allotment.jp",
                                                "url"            =>   "http://valuable-allotment.jp",
                                                "from_name"      => $define["define"]["SITE_NAME"] . " INFO",
                                                "return_path"    => "bounce@mail." . $define["define"]["MAIL_DOMAIN"],
                                                "teishi"         => "teishi@" . $define["define"]["MAIL_DOMAIN"],
                          ),
    ),

    "user_key" => "user_id",
    "user_file_name" => "?action_User_Detail=1",
    "user_table" => "v_user_profile",
    "user_table_key" => "user_id",

    "user_mail_key" => "mail_address",
    "user_status_key" => "regist_status",
    "user_status_cd" => $config["admin_config"]["regist_status"],

    "regist_server_ipaddress" => array(
        "1" => "http://127.0.0.1:8080/",    //PC
    ),
);

// 表示件数指定配列
$viewCounts = array(
    100,
    200,
    500,
    1000,
    5000,
);

// メッセージルール対象項目指定配列
$targetColumns = array(
    '1' => '送信者',
    '2' => '宛先',
    '3' => '件名',
    '4' => '本文',
    '5' => '媒体ｺｰﾄﾞ',
);

$replyStatus = array(
    NOT_REPLIED     => "未対応",
    NOW_REPLING     => "対応中",
    ALREADY_REPLIED => "対応済",
    IGNORED         => "無視"
);

?>