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

//--------------------------
// フォーム表示用タグの生成
//--------------------------
/*
// 返信後の担当者選択タグの生成
$operatorIdOpt = "<option value=\"".NOT_DEFINED."\">未設定</option>\n";
foreach ($operator_tbl as $key => $value) {
    $operatorIdOpt .= "<option value=\"".$operator_tbl[$key]["id"]."\">".$operator_tbl[$key]["name"]."</option>\n";
}
// アドレス帳選択タグの生成
$adBookNameOpt = "<option value=\"\">----- アドレス帳 -----</option>\n";
foreach ($ad_book_tbl as $key => $value) {
    $adBookNameOpt .= "<option value=\"".$ad_book_tbl[$key][mail_address]."\">".$ad_book_tbl[$key][name]."</option>\n";
}

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
*/
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
<form method="post" action="Information.php" enctype="multipart/form-data">
<!-- 新規作成フォーム表示 -->
<strong>ユーザーリストアップ</strong>
<hr>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td width="80">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="80"><font size="2">ﾌｧｲﾙｱｯﾌﾟ：</font></td>
<td>
<!--
<font size="2" color="green" style="cursor:pointer;" onClick="toggleAdBookLayer();"><strong>&gt;&gt;&gt;</strong></font>
-->
</td>
</tr>
</table>
</td>
<td><input type="file" name="id_file" size="30"></td>
</tr>
</table>
<input type="hidden" name="do" value="list_new">
<input type="submit" value="次へ" onClick="return confirm('抽出します。');">
<input type="hidden" name="from_account" value="info">
<input type="hidden" name="from_domain" value="0">
</form>
</table>