#!/usr/local/bin/php
<?php
/**
 * File Name:   get_infomail.php
 *
 * Description: /home/アカウント名/.qmailの指定により渡された
 *              受信メールデータを解析し、各種変換処理を行った上で、
 *              データ格納用テーブルinfo_mail_tblに対してレコードの追加を行う。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/02/06
 */

//エラーレベルの設定
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// メーラーデーモンは拾わない
if (eregi('MAILER-DAEMON', $_ENV["SENDER"])) {
    exit;
}

// PEAR
require_once '/usr/local/lib/php/Mail/mimeDecode.php';

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// htdocsまでのパス get
$base = dirname(dirname(dirname(dirname(__FILE__))));

require_once($base . "/etc/config-ini.php");
require_once($base . "/admin/Information/lib/InformationDB.php");
$config["dsn"] = "mysqli://"
                .$define["define"]["DATABASE"]["params"]["username"]
                .":" . $define["define"]["DATABASE"]["params"]["password"]
                ."@" . $define["define"]["DATABASE"]["params"]["host"]
                .":3306"
                ."/" . $define["define"]["DATABASE"]["params"]["dbname"];

// MySQLへ接続
$db = new InformationDB($config["dsn"]);

/**********************************************************************
 * 定数定義セクション
 **********************************************************************/
define('RECEIVE_DIR',       1);     // 受信トレイ
define('KEEP_DIR',          2);     // 保存
define('TRANSMIT_DIR',      3);     // 送信済み
define('DELETE_DIR',        4);     // 削除済み

define('UNREAD_MAIL',       1);     // 未読メール
define('READED_MAIL',       2);     // 既読メール
define('TRANSMITTED_MAIL',  3);     // 送信メール

define('NOT_REPLIED',       1);     // 未対応
define('NOW_REPLING',       2);     // 対応中
define('ALREADY_REPLIED',   3);     // 対応済
define('IGNORED',           4);     // 無視

define('HIGH_PRIOR',        1);     // 重要度(高い)
define('NORMAL_PRIOR',      3);     // 重要度(通常)
define('LOW_PRIOR',         5);     // 重要度(低い)

define('NOT_DEFINED',       0);     // 未設定

/**********************************************************************
 * メッセージルール作成
 **********************************************************************/


//現在のメッセージルールを抽出
$sql = "SELECT rule_id,"
     . "       priority_id,"
     . "       search_type,"
     . "       keyword,"
     . "       dir_id"
     . " FROM info_message_rule WHERE disable = 0"
     ." ORDER BY priority_id,rule_id ASC" ;
$rs = $db->executeSql($sql, array());
while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
    //search_typeごとのメッセージルールの配列をつくる
    switch ($row["search_type"]) {
        case 1:
            $msg_rule_from_name_tbl[] = array(
                                            'id'     => $row["rule_id"],
                                            'priority_id' => $row["priority_id"],
                                            'column' => $row["search_type"],
                                            'str'    => $row["keyword"],
                                            'dir_id' => $row["dir_id"]
                                        );
            break;
        case 2:
            $msg_rule_to_address_tbl[] = array(
                                             'id'     => $row["rule_id"],
                                             'priority_id' => $row["priority_id"],
                                             'column' => $row["search_type"],
                                             'str'    => $row["keyword"],
                                             'dir_id' => $row["dir_id"]
                                         );
            break;
        case 3:
            $msg_rule_subject_tbl[] = array(
                                          'id'     => $row["rule_id"],
                                          'priority_id' => $row["priority_id"],
                                          'column' => $row["search_type"],
                                          'str'    => $row["keyword"],
                                          'dir_id' => $row["dir_id"]
                                      );
            break;
        case 4:
            $msg_rule_body_tbl[] = array(
                                       'id'     => $row["rule_id"],
                                       'priority_id' => $row["priority_id"],
                                       'column' => $row["search_type"],
                                       'str'    => $row["keyword"],
                                       'dir_id' => $row["dir_id"]
                                   );
            break;
        case 5:
            $msg_rule_media_cd_tbl[] = array(
                                       'id'     => $row["rule_id"],
                                       'priority_id' => $row["priority_id"],
                                       'column' => $row["search_type"],
                                       'str'    => $row["keyword"],
                                       'dir_id' => $row["dir_id"]
                                   );
            break;
    }
}


//--------------------
// メールデータの取得
//--------------------
/*
// 標準入力からメールデータを格納する
$mailData = "";
while (!feof(STDIN)) {
    $mailData .= fgets(STDIN);
}
fclose(STDIN);

// header抽出
list($header, $body) = explode("\n\n", $mailData, 2);
$header = mb_ereg_replace("\n[\t ]+", " ", $header);
$header = trim($header);

// 添付ファイル付のメールは無視する
// とりあえず一時的に…  ほんとは添付をはじいてtextだけ入れたい。
if (eregi("Content-Disposition: attachment;", $body)) {
    exit;
}

// MINE分解
$decoder = new Mail_mimeDecode($mailData);
$params["include_bodies"] = true;
$params["decode_headers"] = true;
$structure = $decoder->decode($params);

/*
// body抽出 textのみ拾う
$body = "";
$ctype = strtolower($structure->ctype_primary);
switch ($ctype) {
    case "text":
        $body = $structure->body;
        break;
    case "multipart":
        foreach ($structure->parts as $parts) {
            $primary = strtolower($parts->ctype_primary);
            $secondary = strtolower($parts->ctype_secondary);
            // HTMLメール時の plain 側のみ拾う
            if ($primary == "text" && $secondary == "plain") {
                $body = $parts->body;
            }
        }
        break;
    default:
        $body = $structure->body;
        break;
}
*/
// 標準入力からメールデータを格納する
// メール解析＆画像の格納＆ファイル名取得とか
$mailData = "";
$fp = fopen("php://stdin", "r");
while (!feof($fp)) {
    $mailData.= fgets($fp, 4096);
}
fclose($fp);

// メールヘッダおよび本文取得
$structure = null;
$params["include_bodies"] = true;
$params["decode_bodies"] = true;
$params["decode_headers"] = true;
$decoder = new Mail_mimeDecode($mailData);
$structure = $decoder->decode($params);

// subject抽出
$subject = $structure->headers["subject"];
$subject = mb_convert_encoding(mb_convert_encoding($subject, "SJIS-win", "ISO-2022-JP, SJIS, eucJP-win, EUC-JP"), "UTF-8", "SJIS-win");

// SJIS特有の文字化け対策のため追加らしい
$subject .= "&nbsp;";

// 送信者
$from_address = addslashes(htmlspecialchars($_ENV['SENDER']));
//送信者が決済会社はバイバイ。
$regexStr = "/@(telecomcredit\.co\.jp|digitalcheck\.co\.jp|zeroweb\.co\.jp)$/";
if (preg_match($regexStr, $from_address)){
    exit;
}
// 受信者
//$to_address = $_ENV["RECIPIENT"];
//list($address, $domain) = explode("@", $_ENV["RECIPIENT"], 2);
//$to_address = str_replace($domain . "-", "", $_ENV["RECIPIENT"]);
$to_address = addslashes($structure->headers["to"]);
$to_address = str_replace('"','',$to_address);
$to_address = preg_replace('/(^.*<|>$)/', '', $to_address);

// 添付ファイル取得
$attach = array();

$body = "";

$i = 0;

// 添付ファイルを探す
switch (strtolower($structure->ctype_primary)) {
    case "text": // シングルパートのみ（テキスト）
        $body = $structure->body;
        break;
    case "multipart":
        foreach ($structure->parts as $part) {
            switch(strtolower($part->ctype_primary)){
                case "text": // テキスト
                    $ctype_secondary = strtolower($part->ctype_secondary);
                    if ($ctype_secondary == "plain") {
                        $body = $part->body;
                    }
                    break;
                case "multipart": // あぁ・・・もう一段だけは見てあげるね。でも、プレーンテキストしか探さないよ。。
                    $ctype_secondary = strtolower($part->ctype_secondary);
                    if ($ctype_secondary == "alternative") {
                        $alternative = mb_convert_encoding("\n\n\n\nこのメールには添付ファイルがある可能性があります", "ISO-2022-JP");
                    }
                    foreach ($part->parts as $part_) {
                        switch(strtolower($part_->ctype_primary)){
                            case "text": // テキスト
                                $ctype_secondary = strtolower($part_->ctype_secondary);
                                if ($ctype_secondary == "plain") {
                                    $body = $part_->body;
                                }
                                break;
                            case "multipart": // あぁ・・・さらにもう一段だけは見てあげるね。でも、プレーンテキストしか探さないよ。。（作り、わる・・・）
                                foreach ($part_->parts as $part__) {
                                    switch(strtolower($part__->ctype_primary)){
                                        case "text": // テキスト
                                            $ctype_secondary = strtolower($part__->ctype_secondary);
                                            if ($ctype_secondary == "plain") {
                                                $body = $part__->body;
                                            }
                                            break;
                                        case "image": // 添付データ
                                        case "application": // 添付データ
                                            if(!$alternative){
                                                $alternative = mb_convert_encoding("\n\n\n\nこのメールには添付ファイルがある可能性があります", "ISO-2022-JP");
                                            }
                                            break;
                                        default:
                                            break;
                                    }
                                }
                                break;
                            case "image": // 添付データ
                            case "application": // 添付データ
                                if(!$alternative){
                                    $alternative = mb_convert_encoding("\n\n\n\nこのメールには添付ファイルがある可能性があります", "ISO-2022-JP");
                                }
                                break;
                            default:
                                break;
                        }
                    }
                    break;
                case "image": // 添付データ
                case "application": // 添付データ
                    if(!$alternative){
                        $alternative = mb_convert_encoding("\n\n\n\nこのメールには添付ファイルがある可能性があります", "ISO-2022-JP");
                    }
                    break;
                default:
                    break;
            }
            $i++;
        }
        break;
    default:
        break;
}

// 添付ファイル文言追加
if ($alternative) {
    $body = $body . $alternative;
}

// ヘッダー情報とメール本文を分割する
list($header, $tmp_body) = explode("\n\n", $mailData, 2);
$header = mb_ereg_replace("\n[\t ]+"," ",$header);
$header = trim($header);
$body = trim($body);

// ヘッダー情報から必要な項目を抜き出してそれぞれ変数に格納する
$headerRows = explode("\n",$header);
if (is_array($headerRows)) {
        foreach ($headerRows as $row) {
                list($key, $value) = explode(":", $row, 2);
                $key = strtolower(trim($key)); $value = trim($value);

                switch ($key) {
                        case "from":                    // 送信者名
                                $from_name = $value;
                                break;
//                        case "to":                              // 宛先メールアドレス
//                                $to_address = $value;
//                                break;
//                        case "subject":                 // 件名
//                                $subject = $value;
//                                break;
//                        case "content-type":    // メール本文のデータ形式
//                                $content_type = $value;
//                                break;
//                        case "content-transfer-encoding":       // メール本文のエンコード形式
//                                $content_encoding = $value;
//                                break;
                        case "x-priority":              // メールの重要度
                                $priority = $value;
                                break;
                }
        }
}

$body = mb_convert_encoding(mb_convert_encoding($body, "SJIS-win", "ISO-2022-JP, SJIS, eucJP-win, EUC-JP"), "UTF-8", "SJIS-win");

// SJIS特有の文字化け対策のため追加らしい
$body .= "&nbsp;";

// from抽出
$from_name = $from_name;
if (eregi("iso-2022-jp", $from_name)) {
    $from_name = addslashes(htmlspecialchars(mb_decode_mimeheader(mb_convert_encoding($from_name, "UTF-8", mb_detect_encoding($from_name)))));
} else {
    $from_name = addslashes(htmlspecialchars(mb_convert_encoding($from_name, "UTF-8", mb_detect_encoding($from_name))));
}
$from_name = str_replace("\'", "", $from_name);
$from_name = str_replace("&gt;", "", $from_name);
$from_name = str_replace("&lt;", "", $from_name);

// priorityセット
if (empty($structure->headers["x-priority"])) {
    $priority = NORMAL_PRIOR;
} else {
    $priority = substr($structure->headers["x-priority"], 0, 1);
}

// 送信元メールアドレスをもとに、サイト登録者からのメールかどうかをチェック
if($from_address){
    $sql = "SELECT id,media_cd FROM user"
         . " WHERE (pc_address = ? "
         . " OR mb_address = ?) "
         . " AND disable = 0 "
         . " ORDER BY id DESC LIMIT 0, 1;";
    $rs  = $db->executeSql($sql, array($from_address, $from_address));
    $mem_id = null;
    if ($rs->numRows()) {
        $row    = $rs->fetchRow(DB_FETCHMODE_ASSOC);
        $mem_id = $row["id"];
        $mem_media_cd = $row["media_cd"];
    } else {
        $mem_id = "";
        $mem_media_cd = "" ;
	}
}else {
    $mem_id = "";
}

//------------------------
// メッセージルールの適応
//------------------------
mb_regex_encoding("UTF-8");    // SJISで一致検索

if (count($msg_rule_subject_tbl) > 0) {
    //次はsubjectから
    foreach ($msg_rule_subject_tbl as $value) {
        if (mb_ereg($value["str"], $subject)) {
            // 対象項目に検索文字列が含まれる場合は、指定フォルダに振り分ける
            if(!$save_dir[$value["priority_id"]]["id"]  OR ($save_dir[$value["priority_id"]]["id"]  AND $save_dir[$value["priority_id"]]["id"] > $value["id"]) ){
                $save_dir[$value["priority_id"]]["dir_id"] = $value["dir_id"];           	
                $save_dir[$value["priority_id"]]["id"] = $value["id"];           	
            } 
        }
    }
}


if (count($msg_rule_body_tbl) > 0) {
    //次はbodyから
    foreach ($msg_rule_body_tbl as $value) {
        if (mb_ereg($value["str"], $body)) {
            // 対象項目に検索文字列が含まれる場合は、指定フォルダに振り分ける
            if(!$save_dir[$value["priority_id"]]["id"]  OR ($save_dir[$value["priority_id"]]["id"]  AND $save_dir[$value["priority_id"]]["id"] > $value["id"]) ){
                $save_dir[$value["priority_id"]]["dir_id"] = $value["dir_id"];           	
                $save_dir[$value["priority_id"]]["id"] = $value["id"];           	
            } 
        }
    }
}

if (count($msg_rule_from_name_tbl) > 0) {
    foreach ($msg_rule_from_name_tbl as $value) {
        if (mb_ereg($value["str"], $from_name)) {
            // 対象項目に検索文字列が含まれる場合は、指定フォルダに振り分ける
            if(!$save_dir[$value["priority_id"]]["id"]  OR ($save_dir[$value["priority_id"]]["id"]  AND $save_dir[$value["priority_id"]]["id"] > $value["id"]) ){
                $save_dir[$value["priority_id"]]["dir_id"] = $value["dir_id"];           	
                $save_dir[$value["priority_id"]]["id"] = $value["id"];           	
            } 
        }
    }
}

if (count($msg_rule_to_address_tbl) > 0) {
    //次はto_addressから
    foreach ($msg_rule_to_address_tbl as $value) {
        if (mb_ereg($value["str"], $to_address)) {
            // 対象項目に検索文字列が含まれる場合は、指定フォルダに振り分ける
            if(!$save_dir[$value["priority_id"]]["id"]  OR ($save_dir[$value["priority_id"]]["id"]  AND $save_dir[$value["priority_id"]]["id"] > $value["id"]) ){
                $save_dir[$value["priority_id"]]["dir_id"] = $value["dir_id"];           	
                $save_dir[$value["priority_id"]]["id"] = $value["id"];           	
            } 
        }
    }
}

if($mem_media_cd){
    if (count($msg_rule_media_cd_tbl) > 0) {
        //次はﾕｰｻﾞｰの媒体コードから
        foreach ($msg_rule_media_cd_tbl as $value) {
            if (mb_ereg($value["str"], $mem_media_cd)) {
                // 対象項目に検索文字列が含まれる場合は、指定フォルダに振り分ける
                if(!$save_dir[$value["priority_id"]]["id"]  OR ($save_dir[$value["priority_id"]]["id"]  AND $save_dir[$value["priority_id"]]["id"] > $value["id"]) ){
                    $save_dir[$value["priority_id"]]["dir_id"] = $value["dir_id"];           	
                    $save_dir[$value["priority_id"]]["id"] = $value["id"];           	
                } 
            }
        }
    }
}

if(count($save_dir) > 0){
    ksort($save_dir) ;
    foreach($save_dir as $val){
        $save_dir = $val["dir_id"] ;
        break ;
    }
}

//--------------------------------
// メールデータのDBインサート処理
//--------------------------------

if (!$save_dir) {
    $save_dir = RECEIVE_DIR;// デフォルトの振り分け先フォルダは受信トレイ
}

if ($save_dir) {
    // INSERTテーブルカラムの指定
    $key = array(
        $from_address,
        $from_name,
        $to_address,
        $header,
        $subject,
        $body,
        $priority,
        $mem_id,
        $save_dir,
    );

    $sql = "INSERT INTO info_mail SET"
         . " from_address = ?"
         . " ,from_name = ?"
         . " ,to_address = ?"
         . " ,header = ?"
         . " ,subject = ?"
         . " ,body = ?"
         . " ,received_date = now()"
         . " ,priority = ?"
         . " ,read_status = " . UNREAD_MAIL
         . " ,reply_status = " . NOT_REPLIED
         . " ,user_id = ?"
         . " ,operator_id = " . NOT_DEFINED
         . " ,dir_id = ?";
    $db->executeSql($sql, $key);
}

?>
