<?php
/**
 * File Name:   config.php
 * 
 * Description: 設定項目振り分けPHPファイル。
 *              メーラー画面表示PHPファイル(infomailer.php)からrequireされると、
 *              リクエスト送信データにより、変更したい設定項目表示PHPファイルを
 *              指定し、もう一度requireを行う。
 * 
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/27 by hata
 */

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// パッケージパスの設定
// ini_set("include_path", ini_get("include_path").":/usr/local/apache2/htdocs_test/ADMIN/Information/ini");
// パッケージファイル群の読み込み
require_once("./ini/config.php"); // 各種設定ファイル
/**********************************************************************
 * PHP処理セクション
 **********************************************************************/
switch ($_REQUEST[mode]) {
    case "address":     // アドレス帳設定
        $cfgIncFile = "./config_adr.php"; break;
    case "message":     // メッセージルール設定
        $cfgIncFile = "./config_msg.php"; break;
    case "operator":    // 担当者設定
        $cfgIncFile = "./config_opr.php"; break;
    case "folder":      // フォルダ設定
        $cfgIncFile = "./config_fld.php"; break;
    case "message_tmp": // 定型文設定
        $cfgIncFile = "./config_message_tmp.php"; break;
    case "signiture":   // 署名設定
        $cfgIncFile = "./config_sgn.php"; break;
    case "delete":      // DB削除設定
        $cfgIncFile = "./config_del.php"; break;
    default:
        $cfgIncFile = "./config_adr.php";
}

require_once($cfgIncFile);
?>
