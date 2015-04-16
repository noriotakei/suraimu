<?php
/**
 * File Name:   multi_move.php
 *
 * Description: メールの所属フォルダ一括移動PHPファイル。
 *              複数選択されたメールの所属フォルダを変更する。一覧表示から
 *              メールを見えなくさせる完全削除処理もここで一括して行う。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------

if($_REQUEST["mode"] !== "delete_all_folder"){

    // multi_move.phpを表示するには$_REQUEST[mail_id]が必須
    if (empty($_REQUEST["info_id"])) {
        exit("表示できません");
    }
    // multi_move.phpを表示するには$_REQUEST[dir_id]が必須
    if (empty($_REQUEST["dir_id"]) || !is_numeric($_REQUEST["dir_id"])) {
        exit("表示できません");
    }
    // multi_move.phpを表示するには$_REQUEST[new_dir_id]が必須
    if (empty($_REQUEST["new_dir_id"]) || !is_numeric($_REQUEST["new_dir_id"])) {
        exit("表示できません");
    }
}

// 削除済みフォルダにあるメールをさらに削除しようとした場合は完全削除処理を行う
if ($_REQUEST["dir_id"] == DELETE_DIR && $_REQUEST["new_dir_id"] == DELETE_DIR) {
    // 完全削除時は完全削除パス入力が必須
    if (md5($_REQUEST["del_pass"]) != $delPw) {   // $delPw: config.ini内で宣言
        exit("完全削除パスが違います！！");
    }
    $compDel = TRUE;    // 完全削除フラグON
} else {
    $compDel = FALSE;   // 通常のフォルダ移動の場合
}

//------------------------------------------
// 一括移動対象メールデータの取得＆移動処理
//------------------------------------------

if($compDel && $_REQUEST["mode"] == "delete_all_folder"){
    $sql = "UPDATE info_mail SET"
         . " dir_id = 0"
         . " WHERE dir_id = 4";
    $db->executeSql($sql, array());
    exit("削除フォルダを空にしました。");
}
$infoIdAry = $_REQUEST["info_id"];
foreach ($infoIdAry as $value) {
    if (is_numeric($value)) {
        // $valueで指定されたメール情報をDBから取得する
        $sql = "SELECT * FROM info_mail WHERE info_id = " . $value . ";";
        $rs = $db->executeSql($sql, array());

        $infoMail = NULL;

        if ($rs->numRows() > 0) {
            $record = $rs->fetchRow(DB_FETCHMODE_ASSOC);

            // DBから取得したメール情報をオブジェクトとして格納する
            $infoMail = new InfoMail($record, $db);

            if ($compDel) {
                $infoMail->updateDirId(0);
                $dirName = "メールを完全に削除しました。";
            } else if ($_REQUEST["mode"] == "already_all") {
                $infoMail->updateReplyStatus(ALREADY_REPLIED);
                $dirName = "メールを対応済みにしました。";
            } else if ($_REQUEST["mode"] == "retire_all") {
                $infoMail->updateRetireStatus($define);
                $dirName = "退会にしました。";
            } else if ($_REQUEST["mode"] == "stop_all") {
                $infoMail->updateMailStatus($define);
                $dirName = "配信停止にしました。";
            } else if ($_REQUEST["mode"] == "danger_all") {
                $infoMail->updateDangerStatus($define);
                $dirName = "ブラックにしました。";
            } else {
                $new_dir_id = searchTopParentDir($_REQUEST["new_dir_id"]);
                if (!($infoMail->priority < 0 && $new_dir_id == KEEP_DIR)) {
                    if ($new_dir_id == KEEP_DIR || ($new_dir_id != KEEP_DIR && $infoMail->priority < 0 )) {
                        $infoMail->updateDirIdKeep($_REQUEST["new_dir_id"]);
                    } else {
                        $infoMail->updateDirId($_REQUEST["new_dir_id"]);
                    }
                } else {
                    $infoMail->updateDirId($_REQUEST["new_dir_id"]);
                }
                $dirName = getDirName($_REQUEST["new_dir_id"]) . "フォルダに移動しました。";
            }
        } else {
            exit("DBからのメールデータ取得に失敗！！");
        }
    }
}

//----------------
// 各種変数の設定
//----------------

// 表示設定引継ぎ用のパラメータ文字列の生成
$viewSettingParamP = makeRequestParam(array('dir_id', 'offset', 'view_count'), 'post'); // POST送信用

// 絞り込み設定引継ぎ用のパラメータ文字列の生成
$keys = array('search_rd', 'search_to', 'search_dm', 'search_dt', 'search_op', 'search_rp');
$searchParamP = makeRequestParam($keys, 'post');

?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<!-- 結果表示 -->
<?php   if($_REQUEST["mode"] == "retire_all"){ ?>
<strong>一括退会処理完了！</strong>
<?php   }else if($_REQUEST["mode"] == "stop_all"){ ?>
<strong>一括配信停止処理完了！</strong>
<?php   }else{ ?>
<strong>一括移動完了！</strong>
<?php   } ?>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td height="30" valign="top">
    <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
        <input type="hidden" name="do" value="tray">
        <?php print($viewSettingParamP); ?>
        <?php print($searchParamP); ?>
        <input type="submit" value="戻る">
    </form>
    </td>
</tr>
</table>
<font size="2"><?php print($dirName); ?></font>
