<?php
/**
 * File Name:   config_message_tmp.php
 * 
 * Description: メッセージテンプレート設定表示PHPファイル。
 *              送信メールに挿入するメッセージテンプレートの入力フォームを表示する。
 * 
 * Author:      Motohiro Hasegawa <hasegawa@icodw.co.jp>
 * Created:     2006/03/02
 * Modified:    2006/03/29
 */

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/**********************************************************************
 * PHP処理セクション
 **********************************************************************/
// 後でJS変数に格納するためのメッセージデータ変換処理
for($i = 0; $i < $msg_tmp_full; $i++){
    $msg_tmp[$i]["msg_tmp_name"] = $msg_tmp[$i]["msg_tmp_name"];
    $msg_tmp[$i]["msg_tmp_title"] = $msg_tmp[$i]["msg_tmp_title"];
    $msg_tmp[$i]["msg_tmp_body"] = $msg_tmp[$i]["msg_tmp_body"];
    $msg_tmp_Js[$i] = str_replace("\n", "<LF>", $msg_tmp[$i]);
}
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php /* JavaScript定義 */ ?>
<script language="Javascript" type="text/javascript">
<!--
<?php
print("var msg_tmp_nameAry = [\n");
    for($i = 0; $i < ($msg_tmp_full - 1); $i++){
        print("\t'".$msg_tmp_Js[$i]["msg_tmp_name"]."',\n");
    }
print("\t'".$msg_tmp_Js[$i]["msg_tmp_name"]."'\n");
print("];\n");
print("var msg_tmp_titleAry = [\n");
    for($i = 0; $i < ($msg_tmp_full - 1); $i++){
        print("\t'".$msg_tmp_Js[$i]["msg_tmp_title"]."',\n");
    }
print("\t'".$msg_tmp_Js[$i]["msg_tmp_title"]."'\n");
print("];\n");
print("var msg_tmp_bodyAry = [\n");
    for($i = 0; $i < ($msg_tmp_full - 1); $i++){
        print("\t'".$msg_tmp_Js[$i]["msg_tmp_body"]."',\n");
    }
print("\t'".$msg_tmp_Js[$i]["msg_tmp_body"]."'\n");
print("];\n");
print("var msg_tmp_timeAry = [\n");
    for($i = 0; $i < ($msg_tmp_full - 1); $i++){
        print("\t'".$msg_tmp_Js[$i]["msg_tmp_time"]."',\n");
    }
print("\t'".$msg_tmp_Js[$i]["msg_tmp_time"]."'\n");
print("];\n");
?>

function setMsg_tmp() {
    var index = document.getElementById("msg_tmp_no").selectedIndex;
    var no = document.getElementById("msg_tmp_no").options[index].value;
    var name_str = msg_tmp_nameAry[(no-1)];
    var title_str = msg_tmp_titleAry[(no-1)];
    var body_str = msg_tmp_bodyAry[(no-1)];
    var time_str = msg_tmp_timeAry[(no-1)];
    
    document.getElementById("msg_name").value = name_str.replace(/<LF>/g, "\n");
    document.getElementById("msg_title").value = title_str.replace(/<LF>/g, "\n");
    document.getElementById("msg_body").value = body_str.replace(/<LF>/g, "\n");
    document.getElementById("msg_time").value = time_str.replace(/<LF>/g, "\n");
    document.getElementById("updateButton").value = "上の内容でテンプレート"+no+"を変更";
}

// -->
</script>

<!-- 設定フォーム表示 -->
<strong>テンプレート設定</strong>
<hr>
<font size="2"><strong>・現在のテンプレート設定</strong></font>

<table border="0" cellpadding="0" cellspacing="0">
<form method="post" action="Information.php?do=config_exec&mode=message_tmp" style="margin-top:0; margin-bottom:0;">
<?php /*  for($i = 1; $i <= $msg_tmp_full; $i++){ ?>
<?php       if($i == 1 || $i == 6){ ?>
<?php                print "<tr>"; ?>
<?php       } ?>
    <td>
    <input type="radio" name="msg_tmp_no" value="<?php print($i); ?>" 
        onClick="setMsg_tmp(<?php print($i); ?>);" <?php if($i == 1){ ?>checked<?php } ?>>
        <font size="2">テンプレート<?php print($i); ?></font>
    </td>
<?php       if($i == 5 || $i == 10){ ?>
<?php                print "</tr>"; ?>
<?php       } ?>
<?php   }*/ ?>
<tr><td>
<select id="msg_tmp_no" name="msg_tmp_no" onChange="setMsg_tmp()">
<?php
for ($i=1; $i <= $msg_tmp_full; $i++) {
    print('<option value="' . $i . '">' . ($msg_tmp[$i-1]["msg_tmp_name"] ? $msg_tmp[$i-1]["msg_tmp_name"] : "未設定") . '</option>' . "\n");
}
?>
</select>
</td></tr>
</table>

<table width="600" border="0" cellpadding="0" cellspacing="0" style="margin-top:2;">
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
    テンプレートネーム
    </td>
</tr>
<tr>
    <td>
    <input type="text" name="msg_tmp_name" id="msg_name" maxlength="36" size="68" value="<?php print($msg_tmp[0]["msg_tmp_name"]); ?>">
    </td>
</tr>
<tr>
    <td>
    一言
    </td>
</tr>
<tr>
    <td>
    <input type="text" name="msg_tmp_title" id="msg_title" maxlength="36" size="68" value="<?php print($msg_tmp[0]["msg_tmp_title"]); ?>">
    </td>
</tr>
<tr>
    <td>
    本文
    </td>
</tr>
<tr>
    <td>
    <textarea name="msg_tmp_body" id="msg_body" cols="68" rows="10"><?php print($msg_tmp[0]["msg_tmp_body"]); ?></textarea>
    </td>
</tr>
<tr>
    <td>
    設定日時(自動挿入)
    </td>
</tr>
<tr>
    <td>
    <input type="text" name="msg_tmp_time" id="msg_time" size="24" value="<?php print($msg_tmp[0]["msg_tmp_time"]); ?>" readonly>
    </td>
</tr>
<tr>
    <td>
    <input type="hidden" name="msg_tmp_full" value="<?php print($msg_tmp_full); ?>">
    <input type="hidden" name="change_msg_tmp" value="1">
    <input type="submit" value="上の内容でテンプレート1を変更" style="margin-top:5;" id="updateButton"></textarea>
    </td>
    </form>
</tr>
</table>
