<?php

/**
 * 新規作成フォーム表示PHPファイル。
 * 新規作成メール文の入力や、担当者の指定、
 * JavaScriptを使った％文字列の入力も可能。
 *
 * @copyright 2007 fraise Corporation
 * @author    fukunaga@wrk.jp
 * @package
 * @version   SVN:$Id: new.php 1498 2009-08-18 01:34:53Z honma $
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

//--------------------------
// フォーム表示用タグの生成
//--------------------------
// 返信後の担当者選択タグの生成
$operatorIdOpt = "<option value=\"".NOT_DEFINED."\">未設定</option>\n";
foreach ($operator_tbl as $key => $value) {
    $isSelected = "";
    if ($operator_tbl[$key]["is_display"] != 0) {
        if($operatorId == $operator_tbl[$key]["id"]){
            $isSelected = " selected";
        }
        $operatorIdOpt .= "<option value=\"".$operator_tbl[$key]["id"]."\"{$isSelected}>".$operator_tbl[$key]["name"]."</option>\n";
    }
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

    if (to.value != "" && sbj.value != "" && bd.value != "") {
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

<!-- 新規作成フォーム表示 -->
<strong>新規作成フォーム</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="30" valign="top">
<form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
<input type="hidden" name="do" value="send_new">
<input type="submit" value="送信" id="submitBtn" disabled="true" onClick="return confirm('送信します。よろしいですか？');">
</td>
</tr>
</table>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td width="80">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="40"><font size="2">宛先：</font></td>
<td>
<div id="adBookLayer" style="display:none; position:absolute; left:245; top:192;">
<table width="230" border="1" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="228" border="0" cellspacing="0" cellpadding="1" bgcolor="white">
<tr>
<td align="right"><strong style="font-size:12; color:gray; cursor:pointer;" onClick="toggleAdBookLayer();">×</strong></td>
</tr>
</table>
<table width="228" border="0" cellspacing="0" cellpadding="0" bgcolor="white" >
<tr>
<!--                        <td width="160" valign="top">
<select name="ad_book_name" size="8" style="width:150; margin-left:4; margin-bottom:4" multiple>
<?php print($adBookNameOpt); ?>
</select>
</td>
-->
<td width="68" valign="top">
<table width="58" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<input type="button" value="宛先 ->" style="width:52; margin-left:6; margin-top: 20; margin-bottom:30" onClick="addToAddress(); checkInputs();">
</td>
</tr>
<tr>
<td>
<input type="button" value="ＣＣ ->" style="width:52; margin-left:6" onClick="addCcAddress();">
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
<!--
<font size="2" color="green" style="cursor:pointer;" onClick="toggleAdBookLayer();"><strong>&gt;&gt;&gt;</strong></font>
-->
</td>
</tr>
</table>
</td>
<td><input type="text" id="to_addressTa" name="to_address" size="97" value="<?php print($infoMail->fromAddress); ?>" onSelect="checkInputs();" onClick="checkInputs();" onKeyUp="checkInputs();"></td>
</tr>
<tr>
<td width="80">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="40"><font size="2">ＣＣ：</font></td>
<td>
<!--
<font size="2" color="green" style="cursor:pointer;" onClick="toggleAdBookLayer();"><strong>&gt;&gt;&gt;</strong></font>
-->
</td>
</tr>
</table>
</td>
<td><input type="text" name="cc_address" size="97" value=""></td>
</tr>
<tr>
<td><font size="2">件名：</font></td>
<td><input type="text" name="subject" size="97" id="subjectTa" onSelect="getCaretPosSJ(); checkInputs();" onClick="getCaretPosSJ(); checkInputs();" onKeyUp="getCaretPosSJ(); checkInputs();">
<table border="1" cellpadding="2" cellspacing="0">
<tr>
<td><font size="2" style="cursor:pointer;" onClick="insertTextSJ('<?php print($site["site_account"][$site["default_info"]]["name"]); ?>'); checkInputs();">サイト名</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextSJ('<?php print($site["site_account"][$site["default_info"]]["domain"]); ?>'); checkInputs();">ドメイン</font></td>
</tr>
</table>
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
<table border="1" cellpadding="0" cellspacing="0" style="margin-bottom:10;">
<tr>
<td style="font-size: 12px;">&nbsp;メッセージテンプレート</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="3" width="150" style="font-size: 12px;">
<?php for($i = 0; $i < $msg_tmp_full; $i++){ ?>
<tr>
<td id="tbl_no_<?php print($i + 1); ?>" onMouseOver="toggleAd2ndLayer(<?php print($i + 1); ?>)" onMouseOut="toggleAd2ndLayer(<?php print($i + 1); ?>);" onClick="document.getElementById('hid_value').value=<?php print($i + 1); ?>" style="border:1px #99bcff solid;" onfocus="focuscolor(<?php print($i + 1); ?>)">
<a href="#" id="txt_no_<?php print($i + 1); ?>" name="Msg_sel_<?php print($i+1);?>" style="color:#000000;" onfocus="focuscolor(<?php print($i + 1); ?>)"><?php print($msg_tmp[$i]["id"] + 1); ?>：<?php print($msg_tmp[$i]["msg_tmp_name"]); ?></a>
</td>
</tr>
<?php } ?>
</table>
<td>
<tr>
</table>
<input type="hidden" id="hid_value" name="hid_value" value="0">
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
<font size="2" color="green" style="cursor:pointer;" onClick="toggleAdMsgLayer();"><strong>&gt;&gt;&gt;</strong></font>
</td>
<td><textarea name="body" cols="76" rows="20" style="font-size: 12px;" id="bodyTa" onSelect="getCaretPosBD(); checkInputs();" onClick="getCaretPosBD(); checkInputs();" onKeyUp="getCaretPosBD(); checkInputs();"></textarea>
<table border="1" cellpadding="2" cellspacing="0">
<tr>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$site["default_info"]]["name"]); ?>'); checkInputs();">ｻｲﾄ名</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$site["default_info"]]["domain"]); ?>'); checkInputs();">ﾄﾞﾒｲﾝ</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$site["default_info"]]["url"]); ?>'); checkInputs();">URL</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print(str_replace("\n", "\\n", $sgn1)); ?>'); checkInputs();">署名1</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print(str_replace("\n", "\\n", $sgn2)); ?>'); checkInputs();">署名2</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print(str_replace("\n", "\\n", $sgn3)); ?>'); checkInputs();">署名3</font></td>
</tr>
</table>
</td>
</tr>
<tr>
<td><font size="2">送信者：</font></td>
<td>
<input type="text" name="fromName" value="<?php print($site["site_account"][$site["default_info"]]["from_name"]); ?>" size="25">
</td>
</tr>
<tr>
<td><font size="2">送信元：</font></td>
<td>
<select name="from_address">
<?php
foreach ($site["site_account"] as $key => $value) {
    print('<option value="' . $key . '">' . $value["from"] . "</option>\n");
}
?>
</select>
</td>
</tr>
<tr>
<td><font size="2">担当者：</font></td>
<td>
<select name="new_operator_id">
<?php print($operatorIdOpt); ?>
</select>
</td>
</tr>
<tr>
<td><font size="2">配信方法選択：</font></td>
<td>
<input type="radio" name="select_send_mail" value="1" checked />通常
<input type="radio" name="select_send_mail" value="2" />メルマガ方式<br />
※メルマガ方式は、配信状況により遅延が発生する場合があります。
</td>
</tr>
<input type="hidden" name="from_account" value="info">
<input type="hidden" name="from_domain" value="0"><?php // 0はhunters.jp ?>
</form>
</table>