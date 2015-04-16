<?php
/**
 * File Name:   move.php
 * 
 * Description: メールの所属フォルダ移動PHPファイル。
 *              指定されたメールの所属フォルダを変更する。一覧表示から
 *              メールを見えなくさせる完全削除処理もここで行う。
 * 
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/27 by hata
 */

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// 共通ファイル部分の読み込み
require_once("./ini/common.php");
/**********************************************************************
 * PHP処理セクション
 **********************************************************************/
//--------------------------------
// リクエスト送信データのチェック 
//--------------------------------
// move.phpを表示するには$_REQUEST[mail_id]が必須
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["info_id"])) {
    die("表示できません");
}
// move.phpを表示するには$_REQUEST[new_dir_id]が必須
if (empty($_REQUEST["new_dir_id"]) || !is_numeric($_REQUEST["new_dir_id"])) {
    die("表示できません");
}

// $_REQUEST[mail_id]で指定されたメール情報をDBから取得する
$sql = "SELECT *"
     . " FROM info_mail"
     . " WHERE info_id = ?";
$rs = $db->executeSql($sql, array($_REQUEST["info_id"]));

//--------------------------------------
// 移動対象メールデータの取得＆移動処理 
//--------------------------------------
$infoMail = NULL;
if ($rs->numRows() > 0) {
    // DBから取得したメール情報をオブジェクトとして格納する
    $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);

    // 削除済みフォルダにあるメールをさらに削除しようとした場合は完全削除処理を行う
    if ($infoMail->dirId == DELETE_DIR && $_REQUEST["new_dir_id"] == DELETE_DIR) {
        // 完全削除時は完全削除パス入力が必須
        if (md5($_REQUEST["del_pass"]) != $delPw) { // $delPw: config.ini内で宣言
            die("完全削除パスが違います！！");
        }
        $compDel = TRUE;    // 完全削除フラグON
    } else {
        $compDel = FALSE;   // 通常のフォルダ移動の場合
    }

    // 移動前のフォルダIDを残しておく
    $oldDirId = $infoMail->dirId;
    
    if ($compDel) {
        $infoMail->updateDirId(0);
        $dirName = "メールを完全に削除しました。";
    } else {
        $new_dir_id = searchTopParentDir($_REQUEST["new_dir_id"]);
        if (!$infoMail->priority < 0 && $new_dir_id == KEEP_DIR) {
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
    die("DBからのメールデータ取得に失敗！！");
}

//----------------
// 各種変数の設定 
//----------------

// 表示設定引継ぎ用のパラメータ文字列の生成
$viewSettingParamP = makeRequestParam(array('offset', 'view_count'), 'post'); // POST送信用

?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<html>
<head>
<title>メール詳細</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
<meta http-equiv="Cache-Control" content="no-cache">
</head>

<body>

<!-- 結果表示 -->
<strong>移動完了！</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td height="30" valign="top">
        <input type="submit" value="閉じる" onClick="window.close();">
    </td>
</tr>
</table>
<font size="2"><?php print($dirName); ?></font>

</body>
</html>
