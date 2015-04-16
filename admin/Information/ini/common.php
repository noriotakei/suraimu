<?php
/**
 * File Name:   common.php
 *
 * Description: 読み込む用
 */
//エラーレベルの設定
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("../../common/__autoload.php");
require_once("../../etc/config-ini.php");

$config["dsn"] = "mysqli://"
                .$define["define"]["DATABASE"]["params"]["username"]
                .":" . $define["define"]["DATABASE"]["params"]["password"]
                ."@" . $define["define"]["DATABASE"]["params"]["host"]
                .":3306"
                ."/" . $define["define"]["DATABASE"]["params"]["dbname"];
$config["domain"] = $define["define"]["SITE_DOMAIN"];
require_once("./func/InfoMail.php");

// DB接続
require_once("./lib/InformationDB.php");
$db = new InformationDB($config["dsn"]);

?>