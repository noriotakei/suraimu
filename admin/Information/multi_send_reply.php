<?php
/**
 * File Name:   multi_send_reply.php
 *
 * Description: 返信メール一括送信PHPファイル。
 *              一括返信フォーム(reply.php)で入力された情報を元に、
 *              実際に複数の返信メールを送信し、送信したメールデータをDBに格納する。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */

/**
 * インクルードセクション
 */

// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/**
 * PHP処理セクション
 */
for ($i=0; $i<count($operator_tbl); $i++) {
    foreach ($operator_tbl[$i] as $key=>$val) {
        $operator_tbl[$i][$key] = $val;
    }
}

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------

// multi_send_reply.phpを表示するには$_REQUEST[mail_id]が必須
if (empty($_REQUEST["info_id"])) {
    print("表示できません"); exit;
}

// 件名のチェック
if (empty($_REQUEST["subject"])) {
    print("件名を入力してください"); exit;
}

// 本文のチェック
if (empty($_REQUEST["body"])) {
    print("本文を入力してください"); exit;
}

// メールアカウントのチェック
if (empty($site["site_account"][$_REQUEST["from_address"]]["from"])) {
    print("メールアカウントが不正です");
    exit;
}

// 担当者IDのチェック
if (!is_numeric($_REQUEST["new_operator_id"])) {
    print("担当者が不正です"); exit;
}

// 対応状況のチェック
if (!is_numeric($_REQUEST["new_reply_status"])) {
    print("対応状況が不正です"); exit;
}

//------------------------------------------
// 一括返信対象メールデータの取得＆返信処理
//------------------------------------------

//担当者が未設定に設定されている場合はログインしたインフォサクラが担当者！20060401-kiso
if($_REQUEST["new_operator_id"] == "" || $_REQUEST["new_operator_id"] == 0){
    foreach($operator_tbl as $key => $value){
        if($_REQUEST["sakura"] == $operator_tbl[$key]["sakura"]){
            $_REQUEST["new_operator_id"] = $operator_tbl[$key]["id"];
        }
    }
}

//$toAddressStr = "";
$toUserIdStr = "";
$infoIdAry = $_REQUEST["info_id"];

foreach ($infoIdAry as $value) {
    if (is_numeric($value)) {
        // $valueで指定されたメール情報をDBから取得する
        $sql = "SELECT * FROM info_mail"
             . " WHERE info_id = ? ";
        $key = array();
        $key[] = $value;
        $rs = $db->executeSql($sql, $key);

        if ($rs->numRows() > 0) {
            $record = $rs->fetchRow(DB_FETCHMODE_ASSOC);

            // DBから取得したメール情報をオブジェクトとして格納する
            $infoMail = new InfoMail($record, $db);
            // メールアドレスのチェック
            if (ereg("[a-zA-Z0-9_.\-]+@[a-zA-Z0-9_.\-]+", $infoMail->fromAddress)) {
                // 返信したメールの担当者を更新する
                $infoMail->updateOperatorId($_REQUEST["new_operator_id"]);
                // 返信したメールの対応状況を更新する
                $infoMail->updateReplyStatus($_REQUEST["new_reply_status"]);

                //インサート用配列生成
                $params = array(
                    "From"           => $site["from_address"][$_REQUEST["from_address"]]["from"],
                    "FromName"   => $_REQUEST["fromName"],
                    "To"              => $infoMail->fromAddress,
                    "Subject"        => $_REQUEST["subject"],
                    "plain"             => $_REQUEST["body"],
                    "opeId"           => $_REQUEST["new_operator_id"],
                );

                //メールデータ格納
                $infoMail->addInfoMail($params);
                //送信実行処理
                $sendUrlArray = $infoMail->mail_server_array;
                $sendUrl = $sendUrlArray[$_REQUEST["select_send_mail"]];

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
                     "to_address"       => $infoMail->fromAddress,
                     "from_address"     => $site["site_account"][$_REQUEST["from_address"]]["from"],
                     "from_name"        => $_REQUEST["fromName"],
                     "return_path"      => $site["site_account"][$_REQUEST["from_address"]]["return_path"],
                     "subject"          => $_REQUEST["subject"],
                     "text_body"        => $_REQUEST["body"],
                     "select_send_mail" => $_REQUEST["select_send_mail"],
                );

                // 宛先があれば送信
                if ($mailElements["to_address"]) {
                    $infoMail->smtpMailTo($mailElements);
                }

                //$toAddressStr .= "・".htmlspecialchars(stripslashes($infoMail->fromAddress))."<br>\n";

                $toUserIdStr .= ($infoMail->userId?$infoMail->userId:"未登録ユーザー") . "<br>\n";

                if ($_REQUEST["stop_flag"]) {
                    // 配信停止にする
                    if ($infoMail->updateMailStatus($define)) {
                        $userIdArray[] = $record["user_id"];
                        $comment = "配信停止";
                    }
                }
                if ($_REQUEST["taikai_flag"]) {
                    // 退会にする
                    if ($infoMail->updateRetireStatus($define)) {
                        $userIdArray[] = $record["user_id"];
                        $comment = "退会";
                    }
                }
                if ($_REQUEST["danger_flag"]) {
                    // 退会にする
                    if ($infoMail->updateDangerStatus($define)) {
                        $userIdArray[] = $record["user_id"];
                        $comment = "ブラック";
                    }
                }
            }
        } else {
            print("DBからのメールデータ取得に失敗！！"); exit;
        }
    }
}

//----------------
// 各種変数の設定
//----------------

// 表示設定引継ぎ用のパラメータ文字列の生成
$viewSettingParamP = makeRequestParam(array('dir_id', 'offset', 'view_count'), 'post');     // POST送信用

// 絞り込み設定引継ぎ用のパラメータ文字列の生成
$keys = array('search_rd', 'search_to', 'search_dm', 'search_dt', 'search_op', 'search_rp');
$searchParamP = makeRequestParam($keys, 'post');

//----------------
// HTML表示用処理
//----------------

if (get_magic_quotes_gpc()) {
    // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
    $fromAddress = htmlspecialchars(stripslashes($_REQUEST["from_account"]."@".$site_ary[$_REQUEST["from_domain"]][1]));
    $subject = htmlspecialchars(stripslashes($_REQUEST["subject"]));
    $body = htmlspecialchars(stripslashes($_REQUEST["body"]));
} else {
    // offの場合はエスケープ解除なし
    $fromAddress = htmlspecialchars($_REQUEST["from_account"]."@".$site_ary[$_REQUEST["from_domain"]][1]);
    $subject = htmlspecialchars($_REQUEST["subject"]);
    $body = htmlspecialchars($_REQUEST["body"]);
}

// ％文字列の変換処理
$subject = replacePercentStr($_REQUEST["from_domain"], "multi", $subject, $DB);
$body = replacePercentStr($_REQUEST["from_domain"], "multi", $body, $DB);

// html表示用に改行コードを<br>に変換する
$body = replaceToBr($body);

// 担当者表示用文字列の生成
if ($_REQUEST["new_operator_id"] != NOT_DEFINED) {
    foreach ($operator_tbl as $key => $value) {
        if ($operator_tbl[$key]["is_display"] == DISPLAY) {
            if ($_REQUEST["new_operator_id"] == $operator_tbl[$key]["id"]) {
                $operatorIdStr = $operator_tbl[$key]["name"];
            }
        } else {
            $operatorIdStr = "未設定";
        }
    }
} else {
    $operatorIdStr = "未設定";
}

// 対応状況表示用文字列の生成
switch ($_REQUEST["new_reply_status"]) {
    case NOT_REPLIED:
        $replyStatusStr = "未対応"; break;
    case NOW_REPLING:
        $replyStatusStr = "対応中"; break;
    case ALREADY_REPLIED:
        $replyStatusStr = "対応済"; break;
    case IGNORED:
        $replyStatusStr = "無視"; break;
}

?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<!-- 結果表示 -->
<strong>送信完了！</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td height="30" valign="top">
    <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
        <input type="hidden" name="do" value="tray">
        <?php print($viewSettingParamP); ?>
        <?php print($searchParamP); ?>
        <input type="submit" value="戻る">
    </form>
    </td>
</tr>
</table>
<table width="600" border="1" cellpadding="2" cellspacing="0">
    <tr>
        <td width="80"><font size="2">件名：</font></td><td><font size="2"><?php echo  $subject; ?></font></td>
    </tr>
    <tr>
        <td><font size="2">本文：</font></td><td height="300" valign="top"><font size="2"><?php echo  $body; ?></font></td>
    </tr>
    <tr>
        <td><font size="2">送信元：</font></td><td><font size="2"><?php echo  $site["site_account"][$_REQUEST["from_address"]]["from"]; ?></font></td>
    </tr>
    <tr>
        <td><font size="2">返信後の<br>担当者：</font></td><td><font size="2"><?php echo  $operatorIdStr; ?></font></td>
    </tr>
    <tr>
        <td><font size="2">返信後の<br>対応状況：</font></td><td><font size="2"><?php echo  $replyStatusStr; ?></font></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
        <font size="2">
        <strong>以下の宛先にメールを送信しました。</strong><br>
        <?php //echo  $toAddressStr; ?>
        <?php echo  $toUserIdStr; ?>
        </font>
        </td>
    </tr>
<?php
if($comment){
    if(!$userIdArray){    ?>
    <tr>
        <td>&nbsp;</td>
        <td>
        <font size="2"><strong><?php print ($comment . "対象者は居ませんでした。"); ?></strong><br>
<?php } else { ?>
    <tr>
        <td>&nbsp;</td>
        <td>
        <font size="2"><strong>以下の会員に対して<?php print($comment);  ?>処理を行いました。</strong><br>
            <?php print($comment);  ?><br>
            <?php print (implode("<br>", $userIdArray)); ?>
        </font>
        </td>
    </tr>
<?php
    }
}
?>

</table>
