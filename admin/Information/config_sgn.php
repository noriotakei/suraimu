<?php
/**
 * File Name:   config_sgn.php
 * 
 * Description: 署名設定表示PHPファイル。
 *              送信メールに挿入する署名の入力フォームを表示する。
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
/*
//EUC->SJISに
for($i=1; $i<=3; $i++){
    ${sgn.$i} = mb_convert_encoding(${sgn.$i}, "SJIS", "EUC-JP");
}
*/
// 後でJS変数に格納するための署名データ変換処理
$sgn1Js = str_replace("\n", "<LF>", $sgn1);
$sgn2Js = str_replace("\n", "<LF>", $sgn2);
$sgn3Js = str_replace("\n", "<LF>", $sgn3);
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php // JavaScript定義 ?>
<script language="Javascript" type="text/javascript">
<!--
<?php
print("var sgnAry = [\n");
print("\t'{$sgn1Js}',\n");
print("\t'{$sgn2Js}',\n");
print("\t'{$sgn3Js}'\n");
print("];\n");
?>

function setSigniture(no) {
    var str = sgnAry[(no-1)];
    
    document.getElementById("sgn_body").value = str.replace(/<LF>/g, "\n");
    document.getElementById("updateButton").value = "上の内容で署名"+no+"を変更";
}
// -->
</script>

<!-- 設定フォーム表示 -->
<strong>署名設定</strong>
<hr>
<font size="2"><strong>・現在の署名設定</strong></font>

<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td>
<form method="post" action="Information.php?do=config_exec&mode=signiture" style="margin-top:0; margin-bottom:0;">
    <input type="radio" name="sgn_no" value="1" onClick="setSigniture(1);" checked><font size="2">署名1</font>
    </td>
    <td>
    <input type="radio" name="sgn_no" value="2" onClick="setSigniture(2);"><font size="2">署名2</font>
    </td>
    <td>
    <input type="radio" name="sgn_no" value="3" onClick="setSigniture(3);"><font size="2">署名3</font>
    </td>
</tr>
</table>

<table width="600" border="0" cellpadding="0" cellspacing="0" style="margin-top:2;">
<tr>
    <td>
    <textarea name="sgn_body" id="sgn_body" cols="68" rows="10"><?php print($sgn1); ?></textarea>
    </td>
</tr>
<tr>
    <td>
    <input type="hidden" name="change_sign" value="1">
    <input type="submit" value="上の内容で署名1を変更" style="margin-top:5;" id="updateButton"></textarea>
    </td>
    </form>
</tr>
</table>
