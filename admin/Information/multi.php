<?php
/**
 * File Name:   multi.php
 *
 * Description: 一括処理振り分けPHPファイル。
 *              メーラー画面表示PHPファイル(infomailer.php)からrequireされると、
 *              リクエスト送信データにより、行いたい一括処理PHPファイルを指定し、
 *              もう一度requireを行う。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */

/**********************************************************************
 * PHP処理セクション
 **********************************************************************/
switch ($_REQUEST["mode"]) {
    case "reply_all": // 一括返信
        $multiIncFile = "./multi_reply.php";
        break;
    case "delete_all": // 一括削除
    case "delete_all_folder": // 削除フォルダ内一括削除
        $_REQUEST["new_dir_id"] = DELETE_DIR;
        $multiIncFile = "./multi_move.php";
        break;
    case "keep_all": // 一括保存
        $_REQUEST["new_dir_id"] = KEEP_DIR;
        $multiIncFile = "./multi_move.php";
        break;
    case "move_all": // 一括移動
        $multiIncFile = "./multi_move.php";
        break;
    case "already_all": // 一括対応済み
        $multiIncFile = "./multi_move.php";
        break;
    case "stop_all": // 一括配信停止
        $multiIncFile = "./multi_move.php";
        break;
    case "stop_status_all":  // 一括でメール送信後配信停止処理
        $stop_flag = true;
        $multiIncFile = "./multi_reply.php";
        break;
    case "retire_all": // 一括退会
        $multiIncFile = "./multi_move.php";
        break;
    case "taikai_all":  // 一括でメール送信後退会処理
        $taikai_flag = true;
        $multiIncFile = "./multi_reply.php";
        break;
    case "danger_all": // 一括ブラック
        $multiIncFile = "./multi_move.php";
        break;
    case "danger_stauts_all":  // 一括でメール送信後ブラック処理
        $danger_flag = true;
        $multiIncFile = "./multi_reply.php";
        break;

    default:
        $_REQUEST["dir_id"] = RECEIVE_DIR;
        $multiIncFile = "./tray.php";
}

require_once($multiIncFile);
?>
