<?php
/**
 * 返信フォーム表示PHPファイル。
 * 返信メール文の入力や、返信後の担当者・対応状況の
 * 指定などを行う。JavaScriptを使った％文字列の入力も可能。
 *
 * @copyright 2007 fraise Corporation
 * @author    Shinichi Hata <hata@icodw.co.jp>
 * @package
 * @version   SVN:$Id: reply.php 1498 2009-08-18 01:34:53Z honma $
 * @since     2006/02/06
 */

/*
 * インクルードセクション
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/*
 * PHP処理セクション
 */

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------
// reply.phpを表示するには$_REQUEST["info_id"]が必須
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["info_id"])) {
    print("表示できません");
    exit;
}

//ユーザーID取得
$uId = $_REQUEST["uId"];

//----------------------------
// 返信対象メールデータの取得
//----------------------------

// $_REQUEST[mail_id]で指定されたメール情報をDBから取得する
$sql = " SELECT *,SUBSTRING(from_name,1,LOCATE('@',from_name)) as from_name_no_domain"
     . " FROM info_mail"
     . " WHERE info_id = ? ";
$array = array();
$key = array(
    $_REQUEST["info_id"]
);
$rs = $db->executeSql($sql, $key);

$infoMail = NULL;
if ($rs->numRows() > 0) {
    // DBから取得したメール情報をオブジェクトとして格納する
    $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $DB);

    $subject = str_replace("&nbsp;", "", $infoMail->subject);
    $body = str_replace("&nbsp;", "", $infoMail->body);

    // 本文に引用のインデントを追加する
    $body = addIndent($body);

    //アドレス表示制限
    if(!($loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_SYSTEM"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_MANAGE"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_INFORMATION"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_OPERATOR"])){
        $infoMail->fromName ="<アドレス非表示>";
    }

} else {
    print("DBからのメールデータ取得に失敗！！"); exit;
}

//--------------------------
// フォーム表示用タグの生成
//--------------------------

//メッセージテンプレート選択str生成
$msg_tmpStr = "<option value=\"\">-- テンプレートネーム --</option><br>\n<br>\n";
foreach($msg_tmp as $key => $val){
    $msg_tmpStr .= ($msg_tmp[$key]["id"] + 1)." - ".$msg_tmp[$key]["msg_tmp_name"]."<br>\n";
}
//メッセージテンプレートをデコード及びjavascriptで使うために\nを変えておきます。
for ($i=0; $i<$msg_tmp_full; $i++) {
    $msg_tmp[$i]["msg_tmp_name"] = $msg_tmp[$i]["msg_tmp_name"];
    $msg_tmp[$i]["msg_tmp_title"] = $msg_tmp[$i]["msg_tmp_title"];
    $msg_tmp[$i]["msg_tmp_body"] = str_replace("\n", "<LF>",$msg_tmp[$i]["msg_tmp_body"]);
}

$cookie_op_id = $_COOKIE['cookie1'];

// 返信後の担当者選択タグの生成
//担当者が決まっていない場合は返信したサクラを担当者に更新！ 20060331-kiso
$operatorIdOpt = "";
if($infoMail->operatorId == NOT_DEFINED){
    foreach($operator_tbl as $key => $value){
        if ($operator_tbl[$key]["is_display"] == 1) {
            if($_REQUEST["sakura"] == $operator_tbl[$key]["sakura"]){
                $isSelected = " selected";
            }else{
                if($cookie_op_id == $operator_tbl[$key]["sakura"]){
                    $isSelected = "selected";
                }elseif($operatorId == $operator_tbl[$key]["id"]){
                    $isSelected = " selected";
                }else{
                    $isSelected = "";
                }
            }
            $operatorIdOpt .= "<option value=\"".$operator_tbl[$key]["id"]."\"{$isSelected}>".$operator_tbl[$key]["name"]."</option>\n";
        }
    }
}else{
    foreach ($operator_tbl as $key => $value) {
        if ($operator_tbl[$key]["is_display"] == 1) {
            if ($infoMail->operatorId == $operator_tbl[$key]["id"]){
                $isSelected = " selected";
            }else{
                $isSelected = "";
            }
            $operatorIdOpt .= "<option value=\"".$operator_tbl[$key]["id"]."\"{$isSelected}>".$operator_tbl[$key]["name"]."</option>\n";
        }
    }
}


// 返信後の対応状況選択タグの生成
$replyStatusOpt = "";
if ($infoMail->replyStatus == NOW_REPLING) {
    $isChecked = " checked";
} else {
    $isChecked = "";
}
$replyStatusOpt .= "<input type=\"radio\" name=\"new_reply_status\" value=\"".NOW_REPLING."\"{$isChecked}><font size=\"2\">対応中</font>\n";
if ($infoMail->replyStatus == ALREADY_REPLIED || $infoMail->replyStatus == NOT_REPLIED) {
    $isChecked = " checked";
} else {
    $isChecked = "";
    }
$replyStatusOpt .= "<input type=\"radio\" name=\"new_reply_status\" value=\"".ALREADY_REPLIED."\"{$isChecked}><font size=\"2\">対応済</font>\n";
if ($infoMail->replyStatus == IGNORED) {
    $isChecked = " checked";
} else {
    $isChecked = "";
}
$replyStatusOpt .= "<input type=\"radio\" name=\"new_reply_status\" value=\"".IGNORED."\"{$isChecked}><font size=\"2\">無視</font>\n";

//--------------------------------------------------------------------------
// 取得ユーザーIDが既に削除となっている場合は、リンクは「ユーザー候補の取得」
//--------------------------------------------------------------------------
if ($uId) {
    $sql = " SELECT *"
         . " FROM v_user_profile"
         . " WHERE user_id = " . $uId
         . " AND user_disable = 0 "
         . " AND profile_disable = 0 "
         . " ORDER BY user_id DESC" ;

    $rs = $db->executeSql($sql);

    // 一件も無い
    if ($rs->numRows() < 1) {
        $ngUid = TRUE;
    }
}
//---------------------------------
// アカウントでのユーザー候補の取得
//---------------------------------
if ($ngUid) {
    // ユーザーアカウントからデータを取得する
    $userMailAddress = explode("@", $infoMail->fromAddress);

    // userテーブルからアカウントを元に取得(アカウント完全一致のみ抽出)
    $sql = " SELECT *"
         . " FROM v_user_profile"
         . " WHERE (pc_address REGEXP '^(" . $userMailAddress[0] . ")@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$' OR mb_address REGEXP '^(" . $userMailAddress[0] . ")@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$')"
         . " AND user_disable = 0 "
         . " AND profile_disable = 0 "
         . " ORDER BY user_id DESC" ;

    $rs = $db->executeSql($sql);

    $userInfoList = "";
    $userIdList = "";
    if ($rs->numRows() > 0) {
        while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
            if ($row["user_id"]) {
                $userInfoList[] = $row["user_id"];
            }

        }
    }
    // 重複しているIDは削除(最新のIDのみ残す)
    if ($userInfoList) {
        $userIdList = array_unique($userInfoList);
    }
}

/**
 * HTML表示セクション
 */
?>
<html>
<head>
<title>メール詳細</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
<meta http-equiv="Cache-Control" content="no-cache">

<?php // JavaScript定義 ?>
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
    //var to = document.getElementById("to_address");
    var sbj = document.getElementById("subjectTa");
    var bd = document.getElementById("bodyTa");

    //if (to.value != "" && sbj.value != "" && bd.value != "") {
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
    var to = document.getElementById("to_address");
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
    var to = document.getElementById("to_address");
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
<?php for($i=1; $i<=$msg_tmp_full; $i++){ ?>
        ad_msg[<?php print($i); ?>] = new Array('<?php print($msg_tmp[($i-1)]["msg_tmp_title"]); ?>','<?php print($msg_tmp[($i-1)]["msg_tmp_body"]); ?>');
<?php } ?>
    var hid_value = document.getElementById("hid_value").value;
    var sub = document.getElementById("subjectTa");
    var bod = document.getElementById("bodyTa");

    if(flag == '1' || flag == '3'){
        sub.value = ad_msg[hid_value][0];
    }
    if(flag == '2' || flag == '3'){
        bod.value = ad_msg[hid_value][1].replace(/<LF>/g, "\n");;
    }
}

function focuscolor(val){
    var tbl_val = document.getElementById("tbl_no_"+val);
    var full = <?php print($msg_tmp_full); ?>;
    for(i=1; i<=full; i++){
        if(val == i){
            tbl_val.style.backgroundColor = "#3366FF";
        } else {
            document.getElementById("tbl_no_"+i).style.backgroundColor = "#FFFFFF";
        }
    }
}
function toggleLog() {
    var mLog = document.getElementById("mailLog");
    var lbtn = document.getElementById("logButton");

    if (mLog.style.display == "block") {
        mLog.style.display = "none";
        lbtn.value = "対応ログを表示";
    } else {
        mLog.style.display = "block";
        lbtn.value = "対応ログを非表示";
    }
}

// -->
</script>
</head>

<body onLoad="checkInputs();">

<!-- 返信フォーム表示 -->
<strong>返信フォーム</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="30" valign="top">
<form method="post" action="send_reply.php" style="margin-top:0; margin-bottom:0;">
<table width="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="30" valign="top">
            <input type="hidden" name="info_id" value="<?php print($infoMail->infoId); ?>">
            <input type="submit" value="送信" id="submitBtn" disabled="true" onClick="return confirm('送信します。よろしいですか？');">
        </td>
    </tr>
    <?php /* 登録済みユーザーからのメールの場合は、更新画面へのリンクを表示 */ ?>
    <?php if(!$ngUid) {?>
    <tr>
        <td width="150" valign="top" align="left">
            <font size="2"><a href="javascript:void(0)" onClick="window.open('<?php print($site["site_account"]["info@test.world-agent.jp"]["url"]); ?>/admin/?action_User_Detail=1&<?php print($site["user_key"]); ?>=<?php print $uId; ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>', '_blank', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" >この登録済みユーザーの更新画面へ＞＞</a></font>
        </td>
    </tr>
    <?php }?>
    <?php if ($ngUid) {?>
    <tr>
        <td width="150" valign="top" align="left">
        <?php if ($userIdList) {
                  foreach ($userIdList as $key => $val) { ?>
                      <a href="javascript:void(0)" onClick="window.open('<?php print($site["site_account"]["info@test.world-agent.jp"]["url"]); ?>/admin/?action_User_Detail=1&<?php print($site["user_key"]); ?>=<?php print($val); ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>', '_blank', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" ><font size="2" color="#ff0000">候補ユーザーの更新画面へ＞＞ユーザーID：<?php print($val); ?></font></a><br />
        <?php     }
              } else {
                  /* 候補がなければメッセージ表示 */ ?>
                  <font size="2">他のユーザー候補は有りません</font>
        <?php } ?>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td width="150" valign="top" align="left">
            <font size="2"><a href="read.php?do=read&info_id=<?php print($infoMail->infoId); ?>&uId=<?php print($uId);?>">メール詳細に戻る＞＞</a></font>
        </td>
    </tr>
</table>
<br>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
    <td width="80">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr><td width="40"><font size="2">宛先：</font></td></tr>
        </table>
    </td>
    <td><?php print($infoMail->fromName); ?></td>
</tr>
<tr>
    <td>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr><td width="40"><font size="2">ＣＣ：</font></td></tr>
        </table>
    </td>
    <td><input type="text" name="cc_address" size="97" value=""></td>
</tr>
<tr>
    <td><font size="2">件名：</font></td>
    <td>
        <input type="text" name="subject" size="97" value="Re: <?php print($subject); ?>" id="subjectTa" onSelect="getCaretPosSJ(); checkInputs();" onClick="getCaretPosSJ(); checkInputs();" onKeyUp="getCaretPosSJ(); checkInputs();">
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <td><font size="2" style="cursor:pointer;" onClick="insertTextSJ('<?php print($site["site_account"][$infoMail->toAddress]["name"]); ?>'); checkInputs();">サイト名</font></td>
                <td><font size="2" style="cursor:pointer;" onClick="insertTextSJ('<?php print($site["site_account"][$infoMail->toAddress]["domain"]); ?>'); checkInputs();">ドメイン</font></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
<td width="80">
<font size="2">本文：</font>
<div id="adMsgLayer" style="display:none; position:absolute; left:200; top:150;">
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
<?php for($i=0; $i<$msg_tmp_full; $i++){ ?>
<tr>
<td id="tbl_no_<?php print($i + 1); ?>" onMouseOver="toggleAd2ndLayer(<?php print($i + 1); ?>)" onMouseOut="toggleAd2ndLayer(<?php print($i+1); ?>);" onClick="document.getElementById('hid_value').value=<?php print($i+1); ?>" style="border:1px #99bcff solid;" onfocus="focuscolor(<?php print($i+1); ?>)">
<a href="#" id="txt_no_<?php print($i+1); ?>" name="Msg_sel_<?php print($i+1); ?>" style="color:#000000;" onfocus="focuscolor(<?php print($i+1); ?>)"><?php print($msg_tmp[$i]["id"] + 1); ?>：<?php print($msg_tmp[$i]["msg_tmp_name"]); ?></a>
</td>
</tr>
<?php } ?>
</table>
</td>
</tr>
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
<?php for($i = 0; $i<$msg_tmp_full; $i++){ ?>
<DIV id="Msg_box_<?php print($i+1); ?>" style="display:none; position:absolute; left:245; top:0;">
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
<td><font size="2"><?php print(str_replace("<LF>","<BR>",$msg_tmp[$i]["msg_tmp_body"])); ?></font></td>
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
<td>
<textarea name="body" cols="76" rows="20" id="bodyTa" style="font-size: 12px;" onSelect="getCaretPosBD(); checkInputs();" onClick="getCaretPosBD(); checkInputs();" onKeyUp="getCaretPosBD(); checkInputs();"><?php print($body); ?></textarea>
<table border="1" cellpadding="2" cellspacing="0">
<tr>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$infoMail->toAddress]["name"]); ?>'); checkInputs();">ｻｲﾄ名</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$infoMail->toAddress]["domain"]); ?>'); checkInputs();">ﾄﾞﾒｲﾝ</font></td>
<td><font size="2" style="cursor:pointer;" onClick="insertTextBD('<?php print($site["site_account"][$infoMail->toAddress]["url"]); ?>'); checkInputs();">URL</font></td>
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
<input type="text" name="fromName" value="<?php print($site["site_account"][$infoMail->toAddress]["from_name"]); ?>" size="25">
</td>
</tr>
<tr>
<td><font size="2">送信元：</font></td>
<td>
<input type="text" name="from_address" value="<?php print $infoMail->toAddress; ?>" size="35">
<input type="hidden" name="staff" value="0">
</td>
</tr>
<tr>
<td><font size="2">返信後の<br>担当者は？</font></td>
<td>
<select name="new_operator_id">
<?php print($operatorIdOpt); ?>
</select>
</td>
</tr>
<tr>
<td><font size="2">返信後の<br>対応状況は？</font></td>
<td>
<select name="new_reply_status">
<?php // 対応状況選択タグの生成(「未対応」の場合はデフォルトは「対応済み」)
foreach ($replyStatus as $key => $value) {
    if ($infoMail->replyStatus == 1 || $infoMail->replyStatus == 3) {
        print('<option value="' . $key  . '"' . ($key == 3 ? " selected" : "") . ">" . $value . "</option>\n");
    } else {
        print('<option value="' . $key  . '"' . ($infoMail->replyStatus == $key ? " selected" : "") . ">" . $value . "</option>\n");
    }
}
?>
</select>
</td>
</tr>
</table>
</form>
</td>
<td valign="top">
<input type="submit" name="logButton" value="対応ログを非表示" onClick="toggleLog();" style="margin-left:10;">
<div style="display: block;" id="mailLog">
<iframe src="maillog.php?info_id=<?php print($_REQUEST["info_id"]); ?>" name="ogift" width="500" height="500" style="margin-bottom: 10;"></iframe>
        </div>
    </td>
</tr>
</table>

</body>
</html>
