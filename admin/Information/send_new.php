<?php
/**
 * 新規作成メール送信PHPファイル。
 * 新規作成フォーム(new.php)で入力された情報を元に、
 * 実際に新規メールを送信し、送信したメールデータをDBに格納する。
 *
 * @copyright 2007 fraise Corporation
 * @author    Shinichi Hata <hata@icodw.co.jp>
 * @package
 * @version   SVN:$Id: send_new.php 1498 2009-08-18 01:34:53Z honma $
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

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------

// 宛先メールアドレスのチェック
if (empty($_REQUEST["to_address"])) {
    exit("宛先メールアドレスを入力してください");
}

// 件名のチェック
if (empty($_REQUEST["subject"])) {
    exit("件名を入力してください");
}

// 本文のチェック
if (empty($_REQUEST["body"])) {
    exit("本文を入力してください");
}

// メールアカウントのチェック
if (empty($site["site_account"][$_REQUEST["from_address"]]["from"])) {
    print("メールアカウントが不正です");
    exit;
}

// 担当者IDのチェック
if (!is_numeric($_REQUEST["new_operator_id"])) {
    exit("担当者IDが不正です");
}

//------------------------
// メール送信＆DB格納処理
//------------------------

// 宛先とＣＣの送信メールアドレスを配列として格納する
$toAddressAry = explode(",", $_REQUEST["to_address"]);
foreach ($toAddressAry as $key => $value) {
    $toAddressAry[$key] = trim($value);
}
$ccAddressAry = explode(",", $_REQUEST["cc_address"]);
foreach ($ccAddressAry as $key => $value) {
    $ccAddressAry[$key] = trim($value);
}
// 上で取得した配列を一つにまとめる
$addressArray = array_merge($toAddressAry, $ccAddressAry);

// 新規なのでユーザー情報なし
$infoMail = new InfoMail(array(), $db);

// 宛先＆ＣＣメールアドレスへの送信処理
foreach ($addressArray as $key => $value) {
    if (ereg("[a-zA-Z0-9_.+-\/?]+@[a-zA-Z0-9_.\-]+", $addressArray[$key])) {
        // 最初の1通目のみDBに送信メールデータを格納する
        if ($key == 0) {
            //インサート用配列生成
            $params = array(
                "From"     => $site["from_address"][$_REQUEST["from_address"]]["from"],
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
        "%site_name%" => $site["site_account"][$_REQUEST["from_address"]]["name"],
        "%domain%" => $site["site_account"][$_REQUEST["from_address"]]["domain"],
        "%info_account%" => $site["site_account"][$_REQUEST["from_address"]]["info"],
        "%teishi_account%" => $site["site_account"][$_REQUEST["from_address"]]["teishi"],
    );

    $_REQUEST["body"] = str_replace(array_keys($convertArray), array_values($convertArray), $_REQUEST["body"]);
    $_REQUEST["body"] = str_replace("\r\n", "\n", $_REQUEST["body"]);

    //送信内容セット
    $mailElements = array(
         "to_address"          => $addressArray[$key],
         "from_address"        => $site["site_account"][$_REQUEST["from_address"]]["from"],
         "from_name"           => $_REQUEST["fromName"],
         "return_path"         => $site["site_account"][$_REQUEST["from_address"]]["return_path"],
         "subject"             => $_REQUEST["subject"],
         "text_body"           => $_REQUEST["body"],
         "select_send_mail"    => $_REQUEST["select_send_mail"],
    );

    // 宛先があれば送信
    if ($mailElements["to_address"]) {
        $infoMail->smtpMailTo($mailElements);
    }
}
//----------------
// HTML表示用処理
//----------------
if (get_magic_quotes_gpc()) {
    // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
    $toAddress   = htmlspecialchars(stripslashes($_REQUEST["to_address"]));
    $ccAddress   = htmlspecialchars(stripslashes($_REQUEST["cc_address"]));
    $fromAddress = htmlspecialchars(stripslashes($site["site_account"][$_REQUEST["from_address"]]["from"]));
    $subject     = htmlspecialchars(stripslashes($_REQUEST["subject"]));
    $body        = htmlspecialchars(stripslashes($_REQUEST["body"]));
    $fromName    = htmlspecialchars(stripslashes($_REQUEST["fromName"]));
} else {
    // offの場合はエスケープ解除なし
    $toAddress   = htmlspecialchars($_REQUEST["to_address"]);
    $ccAddress   = htmlspecialchars($_REQUEST["cc_address"]);
    $fromAddress = htmlspecialchars($site["site_account"][$_REQUEST["from_address"]]["from"]);
    $subject     = htmlspecialchars($_REQUEST["subject"]);
    $body        = htmlspecialchars($_REQUEST["body"]);
    $fromName    = htmlspecialchars($_REQUEST["fromName"]);
}

// html表示用に改行コードを<br>に変換する
$body = replaceToBr($body);

// 担当者表示用文字列の生成
if ($_REQUEST["new_operator_id"] != NOT_DEFINED) {
    foreach ($operator_tbl as $key => $value) {
        if ($operator_tbl[$key]["is_display"] == DISPLAY) {
            if ($_REQUEST["new_operator_id"] == $operator_tbl[$key]["id"]) {
                $operatorIdStr = mb_convert_encoding($operator_tbl[$key]["name"], "SJIS", "EUC-JP");
                $operatorIdStr = $operator_tbl[$key]["name"];

            } else {
                $operatorIdStr = "未設定";
            }
        }
    }
} else {
    $operatorIdStr = "未設定";
}
/**
 * HTML表示セクション
 */
?>
<!-- 結果表示 -->
<strong>送信完了！</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="30" valign="top">
<form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
<input type="hidden" name="do" value="tray">
<input type="hidden" name="dir_id" value="<?php print(RECEIVE_DIR); ?>">
<input type="submit" value="戻る">
</form>
</td>
</tr>
</table>
<font size="2">以下の内容でメールを送信しました。</font>
<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td width="80"><font size="2">宛先：</font></td><td><font size="2"><?php print(implode("<br>", $toAddressAry)); ?></font></td>
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
<td><font size="2">担当者：</font></td><td><font size="2"><?php print($operatorIdStr); ?></font></td>
</tr>
</table>