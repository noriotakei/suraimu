<?php
/**
 * File Name:   config_del.php
 * 
 * Description: DB削除設定表示PHPファイル。
 *              DB上から削除したいメールデータの条件の指定と、
 *              条件に当てはまるメールデータ件数の確認を行う。
 * 
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
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
// DB内メールデータ件数確認用処理 
//--------------------------------

// 確認フラグがONの場合
if ($_REQUEST["check"]) {
    // 検索条件のチェック(年月日)
    if (!checkdate($_REQUEST["month"], $_REQUEST["day"], $_REQUEST["year"])) {
        $msg = "日付が正しくありません。";
    } else {
        $dateQuery = $_REQUEST["year"]."-".str_pad($_REQUEST["month"], 2, "0", STR_PAD_LEFT)."-".str_pad($_REQUEST["day"], 2, "0", STR_PAD_LEFT)." 23:59:59";

        if ($_REQUEST["search_all"]) {
            $searchQuery = "";                      // すべてのメールを検索
            $isChecked = " checked";
        } else {
            $searchQuery = "dir_id = 0 AND";        // 完全削除メールだけを検索
            $isChecked = "";
        }

        if ($_REQUEST["mail_delete"]) {
            $mail_Delete = " AND priority > '0' ";  // 保存メールは削除対象から外す
            $Preservation = " checked";
        } else {
            $mail_Delete = "";                      // 保存メールも削除
            $Preservation = "";
        }

        $sql = "SELECT COUNT(*) AS cnt"
             . " FROM info_mail "
             . "WHERE " . $searchQuery
             . " received_date <= ?"
             .  $mail_Delete . ";";
        $rs = $db->executeSql($sql, array($dateQuery));
        $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
        // データ件数表示用タグの生成
        $countStr = '<table border="1" cellpadding="5" cellspacing="0"'
                  . ' style="margin-top:5; margin-bottom:5; font-size:12"><tr><td>' . "\n"
                  . '指定された条件に当てはまるメールデータ件数は'
                  . '<strong style="color:crimson">' . $row["cnt"] .'</strong>件です。' . "\n"
                  . '</td></tr></table>' . "\n";
        $dsp = "Displaytwo()";

    }
} else {
        $dsp = "Display()";
}

//--------------------------
// フォーム表示用タグの生成 
//--------------------------

// デフォルトは現在の年月日
if (empty($_REQUEST["year"])) {
    $_REQUEST["year"] = date("Y", time());
}
if (empty($_REQUEST["month"])) {
    $_REQUEST["month"] = date("m", time());
}
if (empty($_REQUEST["day"])) {
    $_REQUEST["day"] = date("d", time());
}

// 検索条件指定用タグの生成(年)
$yearOpt = "";
for ($i = 2010; $i <= date("Y", strtotime("+1 year")); $i++) {
    if ($_REQUEST["year"] == $i) {
         $isSelected = " selected";
    } else {
        $isSelected = "";
    }
    $yearOpt .= "<option value=\"{$i}\"{$isSelected}>{$i}年</option>\n";
}

// 検索条件指定用タグの生成(月)
$monthOpt = "";
for ($i = 1; $i <= 12; $i++) {
    if ($_REQUEST["month"] == $i) {
        $isSelected = " selected";
    } else {
        $isSelected = "";
    }
    $monthOpt .= "<option value=\"{$i}\"{$isSelected}>{$i}月</option>\n";
}

// 検索条件指定用タグの生成(日)
$dayOpt = "";
for ($i = 1; $i <= 31; $i++) {
    if ($_REQUEST["day"] == $i) {
        $isSelected = " selected";
    } else {
        $isSelected = "";
    }
    $dayOpt .= "<option value=\"{$i}\"{$isSelected}>{$i}日</option>\n";
}

if($_REQUEST["search_all"]){
    $disp = "";
}else{
    $disp = "none";
}

?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php // JavaScript定義 ?>
<script language="Javascript" type="text/javascript">
<!--
function hideDelForm() {
    var delCnt = document.getElementById("delCount");
    var delFrm = document.getElementById("delForm");
    
    delCnt.style.display = "none";
    delFrm.style.display = "none";
}

function Display(){
    obj = document.getElementById('search_all');

    if(obj.checked){
        document.getElementById('del_check').style.display='';
        document.getElementById('mail_delete').checked = true;
    }else{
        document.getElementById('del_check').style.display='none';
    }
}

function Displaytwo(){
    obj = document.getElementById('search_all');

    if(obj.checked){
        document.getElementById('delForm').style.display='none';
        document.getElementById('delCount').style.display='none';
        document.getElementById('del_check').style.display='';
        document.getElementById('mail_delete').checked = true;
    }else{
        document.getElementById('delForm').style.display='none';
        document.getElementById('delCount').style.display='none';
        document.getElementById('del_check').style.display='none';
    }
}

function Displaythree(){
    var1 = document.getElementById('mail_delete');

    if(var1.checked){
        document.getElementById('delForm').style.display='none';
        document.getElementById('delCount').style.display='none';
    }else{
        document.getElementById('delForm').style.display='none';
        document.getElementById('delCount').style.display='none';
    }
}

// -->
</script>

<!-- 設定フォーム表示 -->
<strong>DB削除設定</strong>
<hr>
<font size="2"><strong>・条件を指定してください</strong></font>
<br>
<?php if ($msg) { ?>
    <font color="#FF0000" size="2"><?php print($msg); ?></font>
<?php } ?>
<form method="post" action="Information.php?do=config&mode=delete" style="margin-top:5; margin-bottom:0;">
<table border="0" cellpadding="0" cellspacing="2" style="margin-bottom:5">
    <tr>
        <td>
        <select name="year" onChange="hideDelForm();">
            <?php print($yearOpt); ?>
        </select>
        </td>
        <td>
        <select name="month" onChange="hideDelForm();">
            <?php print($monthOpt); ?>
        </select>
        </td>
        <td>
        <select name="day" onChange="hideDelForm();">
            <?php print($dayOpt); ?>
        </select>
        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="2">
<tr>
    <td><font size="2">までに受信した完全削除メールに関して、</font></td>
</tr>
</table>
<input type="hidden" name="check" value="1">
<input type="submit" value="メールデータ件数の確認" style="margin-top:10; margin-bottom:5;">
</form>
<div id="delCount" style="display: <?php print($_REQUEST["check"] ? "block": "none"); ?>">
<?php print($countStr); ?>
</div>
<div id="delForm" style="display: <?php print($_REQUEST["check"] && $row["cnt"] ? "block": "none"); ?>">
<form method="post" action="Information.php?do=config_exec&mode=delete" style="margin-top:10; margin-bottom:5;">
    <input type="hidden" name="del_year" value="<?php print($_REQUEST["year"]); ?>">
    <input type="hidden" name="del_month" value="<?php print($_REQUEST["month"]); ?>">
    <input type="hidden" name="del_day" value="<?php print($_REQUEST["day"]); ?>">
    <input type="hidden" name="search_all" value="<?php print($_REQUEST["search_all"]); ?>">
    <input type="hidden" name="mail_delete" value="<?php print($_REQUEST["mail_delete"]); ?>">
    <input type="hidden" name="delete_db_data" value="1">
    <input type="submit" value="<?php print($row["cnt"]); ?>件のメールデータをDBから消去する">
<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5; margin-left:5">
<tr>
    <td><font size="2">DB削除パス：</font></td>
    <td><input type="password" name="db_del_pass" size="8" style="height:19; margin-left:5;"></td>
</tr>
</table>
</form>
</div>
