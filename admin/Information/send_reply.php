<?php
/**
 * 返信メール送信PHPファイル。
 * 返信フォーム(reply.php)で入力された情報を元に、
 * 実際に返信メールを送信し、送信したメールデータをDBに格納する。
 *
 * @copyright 2007 fraise Corporation
 * @author    Shinichi Hata <hata@icodw.co.jp>
 * @package
 * @version   SVN:$Id: send_reply.php 1498 2009-08-18 01:34:53Z honma $
 * @since     2006/03/20
 */

/*
 * インクルードセクション
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/**
 * PHP処理セクション
 */
$time = date("Y/m/d H:i ");
$expire = time() + 3600 * 24 * 30;
$cookie_op_id = $_REQUEST["new_operator_id"];
setcookie("cookie1", $cookie_op_id ,$expire);

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------

// send_reply.phpを表示するには$_REQUEST[mail_id]が必須
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["info_id"])) {
    print("表示できません");
    exit;
}

//// 宛先メールアドレスのチェック
//if (empty($_REQUEST["to_address"])) {
//    print("宛先メールアドレスを入力してください");
//    exit;
//}

// 件名のチェック
if (empty($_REQUEST["subject"])) {
    print("件名を入力してください");
    exit;
}

// 本文のチェック
if (empty($_REQUEST["body"])) {
    print("本文を入力してください");
    exit;
}

//配信アドレスの有効性をチェック！
$fromAddrssArray = explode("@",$_REQUEST["from_address"]) ;
$defaultInfoArray = explode("@",$site["default_info"]) ;
$fromAddressForConfig = $defaultInfoArray[0]."@".$fromAddrssArray[1] ;
if($site["site_account"][$fromAddressForConfig]){
    $site["site_account"][$fromAddressForConfig]["from"] = $_REQUEST["from_address"] ;
    $site["site_account"][$fromAddressForConfig]["info"] = $_REQUEST["from_address"] ;
}else{
    print("メールアカウントが不正です");
    exit;
}

// 担当者IDのチェック
if (!is_numeric($_REQUEST["new_operator_id"])) {
    print("担当者が不正です");
    exit;
}

// 対応状況のチェック
if (!is_numeric($_REQUEST["new_reply_status"])) {
    print("対応状況が不正です");
    exit;
}

//--------------------------------------
// 返信対象メールデータの取得＆返信処理
//--------------------------------------

// 宛先とＣＣの送信メールアドレスを配列として格納する
//$toAddressAry = explode(",", $_REQUEST["to_address"]);
//foreach ($toAddressAry as $key => $value) {
//    $toAddressAry[$key] = trim($toAddressAry[$key]);
//}
$ccAddressAry = explode(",", $_REQUEST["cc_address"]);
foreach ($ccAddressAry as $key => $value) {
    $ccAddressAry[$key] = trim($ccAddressAry[$key]);
}
// 上で取得した配列を一つにまとめる
$addressArray = array_merge((array)$toAddressAry, (array)$ccAddressAry);

// $_REQUEST[mail_id]で指定されたメール情報をDBから取得する
$sql = " SELECT *,SUBSTRING(from_name,1,LOCATE('@',from_address)) as from_name_no_domain "
     . " FROM info_mail "
     . " WHERE info_id = ? ";
$key = array(
     $_REQUEST["info_id"],
);
$rs = $db->executeSql($sql, $key);

if ($rs->numRows() > 0) {
    // DBから取得したメール情報を格納する
    $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);
    // 返信したメールの担当者を更新する
    $infoMail->updateOperatorId($_REQUEST["new_operator_id"]);
    // 返信したメールの対応状況を更新する
    $infoMail->updateReplyStatus($_REQUEST["new_reply_status"]);

    //宛先を更新
    array_unshift($addressArray,$infoMail->fromAddress);

    //アドレス表示制限
    if($loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_OPERATOR"]){
        $toAddressAry[] = $infoMail->fromNameNoDomain . "<ドメイン非表示>";
    }else if($loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_SYSTEM"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_MANAGE"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_INFORMATION"]){
        $toAddressAry[] = $infoMail->fromAddress;
    }else{
        $toAddressAry[] = "<アドレス非表示>";;
    }

    // 宛先＆ＣＣメールアドレスへの送信処理
    foreach ($addressArray as $key => $value) {
        if (ereg("[a-zA-Z0-9_.+-\/?]+@[a-zA-Z0-9_.\-]+", $addressArray[$key])) {
            // 最初の1通目のみDBに送信メールデータを格納する
            if ($key == 0) {
                //インサート用配列生成
                $params = array(
                    "From"     => $site["site_account"][$fromAddressForConfig]["from"],
                    "FromName" => $_REQUEST["fromName"],
                    "To"       => $addressArray[$key],
                    "Subject"  => $_REQUEST["subject"],
                    "plain"    => $_REQUEST["body"],
                    "opeId"    => $_REQUEST["new_operator_id"],
                );
                //メールデータ格納
                $infoMail->addInfoMail($params);
            }
        } else {
            if($addressArray[$key]) {
                print("不正なアドレスの可能性があります。 => " . $addressArray[$key]);
                exit;
            }
        }

        $convertArray = array(
            "%site_name%" => $site["site_account"][$fromAddressForConfig]["name"],
            "%domain%" => $site["site_account"][$fromAddressForConfig]["domain"],
            "%info_account%" => $site["site_account"][$fromAddressForConfig]["info"],
            "%teishi_account%" => $site["site_account"][$fromAddressForConfig]["teishi"],
        );

        $_REQUEST["body"] = str_replace(array_keys($convertArray), array_values($convertArray), $_REQUEST["body"]);
        $_REQUEST["body"] = str_replace("\r\n", "\n", $_REQUEST["body"]);

        //送信内容セット
        $mailElements = array(
             "to_address"   => $addressArray[$key],
             "from_address" => $site["site_account"][$fromAddressForConfig]["from"],
             "from_name"    => $_REQUEST["fromName"],
             "return_path"  => $site["site_account"][$fromAddressForConfig]["return_path"],
             "subject"      => $_REQUEST["subject"],
             "text_body"    => $_REQUEST["body"],
             "select_send_mail" => 1, // 固定
        );

        // 宛先があれば送信
        if ($mailElements["to_address"]) {
            $infoMail->smtpMailTo($mailElements);
        }
    }
} else {
    print("DBからのメールデータ取得に失敗！！");
    exit;
}

//----------------
// HTML表示用処理
//----------------

if (get_magic_quotes_gpc()) {
    // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
    $toAddress   = htmlspecialchars(stripslashes($_REQUEST["to_address"]));
    $ccAddress   = htmlspecialchars(stripslashes($_REQUEST["cc_address"]));
    $fromAddress = htmlspecialchars(stripslashes($site["site_account"][$fromAddressForConfig]["from"]));
    $subject     = htmlspecialchars(stripslashes($_REQUEST["subject"]));
    $body        = htmlspecialchars(stripslashes($_REQUEST["body"]));
    $fromName    = htmlspecialchars(stripslashes($_REQUEST["fromName"]));
} else {
    // offの場合はエスケープ解除なし
    $toAddress   = htmlspecialchars($_REQUEST["to_address"]);
    $ccAddress   = htmlspecialchars($_REQUEST["cc_address"]);
    $fromAddress = htmlspecialchars($site["site_account"][$fromAddressForConfig]["from"]);
    $subject     = htmlspecialchars($_REQUEST["subject"]);
    $body        = htmlspecialchars($_REQUEST["body"]);
    $fromName    = htmlspecialchars($_REQUEST["fromName"]);
}

// html表示用に改行コードを<br>に変換する
$body = replaceToBr($body);

/**
 * HTML表示セクション
 */
?>
<html>
<head>
<title>メール詳細</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
<meta http-equiv="Cache-Control" content="no-cache">
</head>

<body>
<!-- 結果表示 -->
<strong>送信完了！</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="30" valign="top">
<input type="submit" value="閉じる" onClick="window.close();">
</td>
</tr>
</table>
<font size="2">以下の内容でメールを送信しました。</font>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td width="80"><font size="2">宛先：</font></td><td><font size="2"><?php print(implode("<br>", $toAddressAry)); ?>&nbsp;</font></td>
</tr>
<tr>
<td width="80"><font size="2">ＣＣ：</font></td><td><font size="2"><?php print(implode("<br>", $ccAddressAry)); ?>&nbsp;</font></td>
</tr>
<tr>
<td><font size="2">件名：</font></td><td><font size="2"><?php print($subject); ?></font></td>
</tr>
<tr>
<td><font size="2">本文：</font></td><td height="300" valign="top"><font size="2"><?php print($body); ?></font></td>
</tr>
<tr>
<td><font size="2">送信者：</font></td><td><font size="2"><?php print($_REQUEST["fromName"]); ?></font></td>
</tr>
<tr>
<td><font size="2">送信元：</font></td><td><font size="2"><?php print($fromAddress); ?></font></td>
</tr>
<tr>
<td><font size="2">返信後の<br>担当者：</font></td><td><font size="2"><?php print($infoMail->operatorIdStr); ?></font></td>
</tr>
<tr>
<td><font size="2">返信後の<br>対応状況：</font></td><td><font size="2"><?php print($infoMail->replyStatusStr); ?></font></td>
</tr>
</table>

</body>
</html>
