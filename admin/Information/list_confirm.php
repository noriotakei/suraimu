<?php

/**
 * 新規作成フォーム表示PHPファイル。
 * 新規作成メール文の入力や、担当者の指定、
 * JavaScriptを使った％文字列の入力も可能。
 *
 * @copyright 2007 fraise Corporation
 * @author    fukunaga@wrk.jp
 * @package
 * @version   SVN:$Id: new.php 12561 2009-02-10 08:03:33Z masaki $
 * @since     2006/02/06
 */

/**
 * インクルードセクション
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/**
 * PHP処理セクション
 */

$userList = $_REQUEST["user_id"];

foreach($userList as $value){
    // リストアップしたIDからユーザーを特定する。
    $sql = " SELECT *"
         . " FROM " . $site["user_table"]
         . " WHERE " . $site["user_table_key"] ."  = ? ";
    $key = array();
    $key[] = $value;
    $rs = $db->executeSql($sql, $key);

    if($rs->numRows() > 0) {
        $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
        $userIdList[$array["id"]] = $array;
    }
}

//--------------------------
// フォーム表示用タグの生成
//--------------------------
// 担当者表示用文字列の生成
if ($_REQUEST["new_operator_id"] != NOT_DEFINED) {
    foreach ($operator_tbl as $key => $value) {
        if ($operator_tbl[$key]["is_display"] == DISPLAY) {
            if ($_REQUEST["new_operator_id"] == $operator_tbl[$key]["id"]) {
                $operatorIdStr = mb_convert_encoding($operator_tbl[$key]["name"], "SJIS", "EUC-JP");
                $operatorIdStr = $operator_tbl[$key]["name"];
            }
        } else {
            $operatorIdStr = "未設定";
        }
    }
} else {
    $operatorIdStr = "未設定";
}
/*
// アドレス帳選択タグの生成
$adBookNameOpt = "<option value=\"\">----- アドレス帳 -----</option>\n";
foreach ($ad_book_tbl as $key => $value) {
    $adBookNameOpt .= "<option value=\"".$ad_book_tbl[$key][mail_address]."\">".$ad_book_tbl[$key][name]."</option>\n";
}
*/
//メッセージテンプレート選択str生成
$msg_tmpStr = "<option value=\"\">-- テンプレートネーム --</option><br>\n<br>\n";
foreach ($msg_tmp as $key => $val) {
    $msg_tmpStr .= ($msg_tmp[$key]["id"]+1)." - ".$msg_tmp[$key]["msg_tmp_name"]."<br>\n";
}
//メッセージテンプレートをデコード及びjavascriptで使うために\nを変えておきます。
for ($i=0; $i<$msg_tmp_full; $i++) {
    $msg_tmp[$i]["msg_tmp_name"] = $msg_tmp[$i]["msg_tmp_name"];
    $msg_tmp[$i]["msg_tmp_title"] = $msg_tmp[$i]["msg_tmp_title"];
    $msg_tmp[$i]["msg_tmp_body"] = str_replace("\n", "<LF>",$msg_tmp[$i]["msg_tmp_body"]);
}
?>

<?php
/**
 * HTML表示セクション
 */
// JavaScript定義?>
<script language="Javascript" type="text/javascript">
<!--
function getCaretPosSJ() {
    var ta = document.getElementById("subjectTa");

    if (ta.createTextRange) {
        ta.caretPos = document.selection.createRange().duplicate();
    }
}

function getCaretPosBD() {
    var ta = document.getElementById("bodyTa");

    if (ta.createTextRange) {
        ta.caretPos = document.selection.createRange().duplicate();
    }
}

function insertTextSJ(txt) {
    var ta = document.getElementById("subjectTa");

    document.getElementById("subjectTa").focus();

    // IE
    if (window.navigator.appName.indexOf('Microsoft') != -1) {
        if (ta.createTextRange && ta.caretPos) {
            ta.caretPos.text = txt;
        }
    }

    // fierfox
    if (ta.setSelectionRange) {
        var st = ta.selectionStart;
        var en = ta.selectionEnd;
        var strValue;

        strValue = ta.value.substring(0, st);
        strValue+= txt;
        len = strValue.length;
        strValue+= ta.value.substring(en, ta.value.length);
        ta.value = strValue;
        ta.setSelectionRange(len, len);
    }
}

function insertTextBD(txt) {
    var ta = document.getElementById("bodyTa");

    document.getElementById("bodyTa").focus();

    // IE
    if (window.navigator.appName.indexOf('Microsoft') != -1) {
        if (ta.createTextRange && ta.caretPos) {
            ta.caretPos.text = txt;
        }
    }

    // fierfox
    if (ta.setSelectionRange) {
        var st = ta.selectionStart;
        var en = ta.selectionEnd;
        var strValue;

        strValue = ta.value.substring(0, st);
        strValue+= txt;
        len = strValue.length;
        strValue+= ta.value.substring(en, ta.value.length);
        ta.value = strValue;
        ta.setSelectionRange(len, len);
    }
}

function checkInputs() {
    var btn = document.getElementById("submitBtn");
    var to = document.getElementById("to_addressTa");
    var sbj = document.getElementById("subjectTa");
    var bd = document.getElementById("bodyTa");

    if (sbj.value != "" && bd.value != "") {
        btn.disabled = false;
    } else {
        btn.disabled = true;
    }
}

function toggleAdBookLayer() {
    var layer = document.getElementById("adBookLayer");

    if (layer.style.display == "none") {
        layer.style.display = "block";
    } else {
        layer.style.display = "none";
    }
}

function addToAddress() {
    var abNm = document.getElementById("ad_book_name");
    var to = document.getElementById("to_addressTa");
    var len;

    for (i=0; i<abNm.options.length; i++) {
        if (abNm.options[i].selected && abNm.options[i].value != "") {
            len = to.value.length;
            if (to.value == "" || to.value.substring(len-1) == ";") {
        to.value += abNm.options[i].value;
            } else {
                to.value += "; " + abNm.options[i].value;
            }
        }
    }
}

function addCcAddress() {
    var abNm = document.getElementById("ad_book_name");
    var cc = document.getElementById("cc_address");
    var len;

    for (i=0; i<abNm.options.length; i++) {
        if (abNm.options[i].selected && abNm.options[i].value != "") {
            len = cc.value.length;
            if (cc.value == "" || cc.value.substring(len-1) == ";") {
                cc.value += abNm.options[i].value;
            } else {
                cc.value += "; " + abNm.options[i].value;
            }
        }
    }
}

function toggleAdMsgLayer(){
    var layer = document.getElementById("adMsgLayer");

    if (layer.style.display == "none") {
        layer.style.display = "block";
    } else {
        layer.style.display = "none";
    }
}

function toggleAd2ndLayer(num){
    var box_layer = document.getElementById("Msg_box_"+num);

    if (box_layer.style.display == "none") {
        box_layer.style.display = "block";
    } else {
        box_layer.style.display = "none";
    }
}

function addTemp(flag){
    var ad_msg = new Array(<?php print($msg_tmp_full); ?>);
<?php for($i = 1; $i <= $msg_tmp_full; $i++) { ?>
    ad_msg[<?php print($i); ?>] = new Array('<?php echo $msg_tmp[($i-1)]["msg_tmp_title"];?>','<?php echo $msg_tmp[($i-1)]["msg_tmp_body"];?>');
<?php } ?>
    var hid_value = document.getElementById("hid_value").value;
    var sub = document.getElementById("subjectTa");
    var bod = document.getElementById("bodyTa");

    if (flag == '1' || flag == '3') {
        sub.value = ad_msg[hid_value][0];
    }
    if(flag == '2' || flag == '3'){
        bod.value = ad_msg[hid_value][1].replace(/<LF>/g, "\n");;
    }
}

function focuscolor(val){
    var tbl_val = document.getElementById("tbl_no_"+val);
    var full = <?php print($msg_tmp_full); ?>;
    for(i = 1; i <= full; i++){
        if(val == i){
            tbl_val.style.backgroundColor = "#3366FF";
        } else {
            document.getElementById("tbl_no_"+i).style.backgroundColor = "#FFFFFF";
        }
    }
}

// -->
</script>

<strong>内容を確認してください。</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="30" valign="top">
<form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
<input type="hidden" name="do" value="send_list">
<input type="hidden" name="new_operator_id" value="<?php print($_REQUEST["new_operator_id"]); ?>">
<input type="hidden" name="subject" value="<?php print($_REQUEST["subject"]); ?>">
<input type="hidden" name="body" value="<?php print($_REQUEST["body"]); ?>">
<input type="hidden" name="from_address" value="<?php print($_REQUEST["from_address"]); ?>">
<input type="submit" value="送信" id="submitBtn" onClick="return confirm('送信します。よろしいですか？');">
</td>
</tr>
</table>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td><font size="2">件名：</font></td>
<td><?php print($_REQUEST["subject"]); ?>
</td>
</tr>
<tr>
<td><font size="2">本文：</font>
<div id="adMsgLayer" style="display:none; position:absolute; left:245; top:300;">
<table width="230" border="1" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="228" border="0" cellspacing="0" cellpadding="1" bgcolor="white">
<tr>
<td align="right"><strong style="font-size:12; color:gray; cursor:pointer;" onClick="toggleAdMsgLayer();">×</strong></td>
</tr>
</table>
<table width="228" border="0" cellspacing="0" cellpadding="0" bgcolor="white" >
<tr>
<td width="6" valign="top">&nbsp;</td>
<td width="154" valign="top">
</td>
<td width="68" valign="top">
<table width="58" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<input type="button" value="セット ->" style="width:52; margin-left:6; margin-top: 10; margin-bottom:10" onClick="addTemp('3'); checkInputs();">
</td>
</tr>
<tr>
<td>
<input type="button" value="件名 ->" style="width:52; margin-left:6; margin-top: 10; margin-bottom:10" onClick="addTemp('1'); checkInputs();">
</td>
</tr>
<tr>
<td>
<input type="button" value="本文 ->" style="width:52; margin-left:6; margin-top: 10; margin-bottom:10" onClick="addTemp('2'); checkInputs();">
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php for($i = 0; $i < $msg_tmp_full; $i++) { ?>
<DIV id="Msg_box_<?php print($i + 1); ?>" style="display:none; position:absolute; left:245; top:0;">
<table width="400" border="1" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="400" border="0" bgcolor="#FFFDDD" cellspacing="0" cellpadding="1">
<tr>
<td><font size="2">一言</font></td>
</tr>
<tr>
<td><font size="2"><?php print($msg_tmp[$i]["msg_tmp_title"]); ?></font></td>
</tr>
<tr>
<td><font size="2">本文</font></td>
</tr>
<tr>
<td><font size="2"><?php print(str_replace("<LF>","<BR>",$msg_tmp[$i]["msg_tmp_body"]));?></font></td>
</tr>
</table>
</td>
</tr>
</table>
</DIV>
<?php } ?>
</div>
</td>
<td><?php print($_REQUEST["body"]); ?>
</td>
</tr>
<tr>
<td><font size="2">送信者：</font></td>
<td>
<?php print($site["site_account"][$site["default_info"]]["from_name"]); ?>
</td>
</tr>
<tr>
<td><font size="2">送信元：</font></td>
<td>
<?php print($_REQUEST["from_address"]); ?>
</td>
</tr>
<tr>
<td><font size="2">担当者：</font></td>
<td>
<?php print($operatorIdStr); ?>
</td>
</tr>

</table>

<table border="0" cellpadding="2" cellspacing="0">
<font color="red"><strong>以下のIDに対してメール送信します。<br />問題なければ送信ボタンを押してください。</strong></font>
<tr>
<td></td>
    <td><font size="2"><strong>会員ID</strong></font></td>
    <td><font size="2"><strong>ステータス</strong></font></td>
</tr>
<?php foreach($userIdList as $key => $value){ ?>
<tr>
    <td><input type="checkbox" name="user_address[]"  value="<?php print($value[$site["user_mail_key"]]); ?>" <?php print($value[$site["user_status_key"]] == 1 ? 'checked' : ''); ?>></td>
    <td><font size="2"><?php print($value[$site["user_table_key"]]); ?></font></td>
    <td><font size="2"><?php print($site["user_status_cd"][$value[$site["user_status_key"]]]); ?></font></td>
</tr>
<?php } // end foreach ?>
</tr>
<input type="hidden" name="from_account" value="info">
<input type="hidden" name="from_domain" value="0">
</form>
</table>