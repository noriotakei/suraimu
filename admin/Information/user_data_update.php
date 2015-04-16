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
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["user_id"])) {
    die("表示できません");
}

// $_REQUEST[info_id]で指定されたメール情報をDBから取得する
$sql = "SELECT *"
     . " FROM info_mail as im, user as u"
     . " WHERE im.info_id = ?"
     . " AND u.id = ?"
     . " AND u.id = im.user_id" ;

$rs = $db->executeSql($sql, array($_REQUEST["info_id"],$_REQUEST["user_id"]));

//--------------------------------------
// 移動対象メールデータの取得＆移動処理 
//--------------------------------------
$infoMail = NULL;
if ($rs->numRows() > 0) {
    // DBから取得したメール情報をオブジェクトとして格納する
    $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);

        if ($_REQUEST["mode"] == "retire") {
            $infoMail->updateRetireStatus($define);
            $dirName = "退会にしました。";
        } else if ($_REQUEST["mode"] == "stop") {
            $infoMail->updateMailStatus($define);
            $dirName = "配信停止にしました。";
        } else if ($_REQUEST["mode"] == "danger_on") {
            $infoMail->updateDangerStatus($define);
            $dirName = "ブラックを有効にしました。";
        } else if ($_REQUEST["mode"] == "danger_off") {
            $infoMail->updateDangerStatusForRescission($define);
            $dirName = "ブラックを解除しました。";
        }

} else {
    die("DBからのメールデータ取得に失敗！！");
}

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
<strong>ステータス変更完了！</strong>
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
