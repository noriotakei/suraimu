<?php
/**
 * File Name:   read.php
 *
 * Description: 受信メール詳細表示PHPファイル。
 * その他にも表示中メールの返信、削除、保存、移動、
 * 担当者・対応状況の変更、対応ログの表示等を行う。
 * またサイト登録者からのメールの場合はユーザー情報
 * を表示する管理ページへのリンクも表示する。
 *
 * Author:  Shinichi Hata <hata@icodw.co.jp>
 * Created: 2006/02/06
 * Modified:    2006/03/20 by hata
 */

// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/*
 * PHP処理セクション
 **/
// EUC->SJISに operator_tbl
for($i=0; $i<count($operator_tbl); $i++){
    foreach($operator_tbl[$i] as $key=>$val){
        $operator_tbl[$i][$key] = $val;
    }
}
//dir_tbl
for($i=0; $i<count($dir_tbl); $i++){
    foreach($dir_tbl[$i] as $key=>$val){
        $dir_tbl[$i][$key] = $val;
    }
}
//登録済みユーザーかのチェック用
$uId = $_REQUEST["uId"];

// ログ表示タイプ
$displayLogType = 0;
if ($_REQUEST["maillog_from_pc"]) {
    $displayLogType = DISPLAY_LOG_PC;
}
if ($_REQUEST["maillog_from_mb"]) {
    $displayLogType = DISPLAY_LOG_MB;
}
if ($_REQUEST["maillog_from_pc_mb"]) {
	$displayLogType = DISPLAY_LOG_PC_MB;
}

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------
// read.phpを表示するには$_REQUEST[mail_id]が必須
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["info_id"])) {
    print("表示できません");
    exit;
}

// アップデートフラグがONの場合
if (isset($_REQUEST["update"])) {
    // 担当者IDのチェック
    if (isset($_REQUEST["new_operator_id"]) && !is_numeric($_REQUEST["new_operator_id"])) {
        print("担当者が不正です"); exit;
    }
    // 対応状況のチェック
    if (isset($_REQUEST["new_reply_status"]) && !is_numeric($_REQUEST["new_reply_status"])) {
        print("対応状況が不正です"); exit;
    }
}

//------------------------
// 表示メールデータの取得
//------------------------

// $_REQUEST[info_id]で指定されたメール情報をDBから取得する
$sql = " SELECT *,SUBSTRING(from_name,1,LOCATE('@',from_name)) as from_name_no_domain"
     . " FROM info_mail"
     . " WHERE info_id = ? ";
$key = array();
$key[] = $_REQUEST["info_id"];
$rs = $db->executeSql($sql, $key);

if ($rs->numRows() > 0) {
    $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);

    // DBから取得したメール情報をオブジェクトとして格納する
    $infoMail = null;
    $infoMail = new InfoMail($array, $db);
    // 状態フラグが未読なら既読に変更する
    if ($infoMail->readStatus == UNREAD_MAIL) {
        $infoMail->updateReadStatus(READED_MAIL);
    }

    // 更新用フラグが送られていれば、担当者or対応状況を更新する
    if (isset($_REQUEST["update"])) {
        if (isset($_REQUEST["new_operator_id"])) {
            $infoMail->updateOperatorId($_REQUEST["new_operator_id"]);
        }
        if (isset($_REQUEST["new_reply_status"])) {
            $infoMail->updateReplyStatus($_REQUEST["new_reply_status"]);
        }
    } /*else {
        // 表示メールデータの担当者が未対応の場合、ログインユーザーを設定（更新）する
        if (!$infoMail->operatorId && $operatorId) {
            $infoMail->updateOperatorId($operatorId);
        }
    }*/
    //アドレス表示制限
    if(!($loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_SYSTEM"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_MANAGE"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_INFORMATION"]
            OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_OPERATOR"])){
        $infoMail->fromName = "<アドレス非表示>";
    }

    $fromName = str_replace("&nbsp;", "", $infoMail->fromName);
    $subject = str_replace("&nbsp;", "", $infoMail->subject);
    $body = str_replace("&nbsp;", "", $infoMail->body);

    // 本文内のURLに自動リンクをつける
    $body = addUrlLink($body);
    // html表示用に改行コードを<br>に変換する
    $body = replaceToBr($body);
} else {
    print("DBからのメールデータ取得に失敗！！"); exit;
}

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
if (!$uId || $ngUid) {
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

//----------------
// 各種変数の設定
//----------------

// メールフォルダ名の取得
$dirName = getDirName($infoMail->dirId);

// 現在表示しているメールが所属するフォルダの最上位フォルダを取得する
$topParentDir = searchTopParentDir($infoMail->dirId);

//
// フォーム表示用タグの生成
//

// 移動先フォルダ選択タグの生成
$valueStr = "move.php?info_id={$infoMail->infoId}&new_dir_id=";
// JSによる自動ロケーション用文字列
$dirIdOpt = "<option value=\"noselect\">フォルダ移動</option>\n";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($dir_tbl[$key]["tree_level"] == 1 && !($infoMail->dirId == DELETE_DIR && $dir_tbl[$key]["id"] == DELETE_DIR)) {
        // 削除済みフォルダから削除済みフォルダへの移動選択はできない
        $dirIdOpt .= "<option value=\"{$valueStr}{$dir_tbl[$key]["id"]}\">{$dir_tbl[$key]["name"]}</option>\n";

        foreach ($dir_tbl as $key2 => $value2) {
            // 2階層目フォルダデータの取得
            if ($dir_tbl[$key2]["tree_level"] == 2 && $dir_tbl[$key2]["parent_id"] == $dir_tbl[$key]["id"]) {
    // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                $dirIdOpt.= "<option value=\"{$valueStr}{$dir_tbl[$key2]["id"]}\">　+{$dir_tbl[$key2]["name"]}</option>\n";
                foreach ($dir_tbl as $key3 => $value3) {
                    // 3階層目フォルダデータの取得
                    if ($dir_tbl[$key3]["tree_level"] == 3 && $dir_tbl[$key3]["parent_id"] == $dir_tbl[$key2]["id"]) {
           // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        $dirIdOpt .= "<option value=\"{$valueStr}{$dir_tbl[$key3][id]}\">　　+{$dir_tbl[$key3][name]}</option>\n";
                    }
                }
            }
        }
    }
}

//危険人物の指定、解除
$dangerFlag = false;
if ($infoMail->userId) {

    $danger_search_sql = "SELECT * FROM user WHERE danger_status = 1 AND disable = 0 AND id = " . $infoMail->userId;
    $rs = $db->executeSql($danger_search_sql) ;

    //ﾃﾞｰﾀ取得出来たら
    if($rs->numRows() > 0) {
        $dangerFlag = TRUE;
    }

}
/*
 * HTML表示セクション
 */
?>
<html>
<head>
<title>メール詳細</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
<meta http-equiv="Cache-Control" content="no-cache">

<?php /* JavaScript定義 */ ?>
<script language="Javascript" type="text/javascript">
<!--
function update(sel) {
    if (sel.options[sel.selectedIndex].value != "noselect") {
        location.href = sel.options[sel.selectedIndex].value;
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

<body>
<!-- メール詳細表示 -->
<strong>メール詳細</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <?php /* 最上位フォルダによって表示を切り替えます */ ?>
        <?php if ($topParentDir == RECEIVE_DIR || $topParentDir == KEEP_DIR) { ?>
        <td valign="top">
            <form method="post" action="reply.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="info_id" value="<?php echo  $infoMail->infoId; ?>">
                <input type="hidden" name="uId" value="<?php echo  $uId; ?>">
                <input type="submit" value="返信">
            </form>
        </td>
        <?php } ?>
        <td height="30" valign="top">
            <form method="post" action="move.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="info_id" value="<?php echo  $infoMail->infoId; ?>">
                <input type="hidden" name="new_dir_id" value="<?php echo  DELETE_DIR; ?>">
                <input type="submit" value="<?php echo  $topParentDir == DELETE_DIR ? "完全":"" ?>削除">
                </td>
                <?php if ($topParentDir == DELETE_DIR) { ?>
                <td valign="top">
                    <input type="password" name="del_pass" size="8" style="height:19; margin-left:9;">
                </td>
                <?php } ?>
            </form>
        <?php if ($topParentDir == RECEIVE_DIR || $topParentDir == KEEP_DIR) { ?>
        <td valign="top">
            <form method="post" action="move.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="info_id" value="<?php echo  $infoMail->infoId; ?>">
                <input type="hidden" name="new_dir_id" value="<?php echo  KEEP_DIR; ?>">
                <input type="submit" value="保存">
            </form>
        </td>
        <?php } ?>
        <td valign="top">
            <select name="sel1" onChange="update(this)" style="margin-left:10;">
                <?php echo  $dirIdOpt; ?>
            </select>
        </td>
        <td valign="top">
            <input type="button" id="logButton" value="対応ログを非表示" onClick="toggleLog();" style="margin-left:10;">
        </td>
<?php if($dangerFlag == true){ ?>
        <td valign="top">
            <form method="post" action="user_data_update.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="user_id" value="<?php print $uId; ?>">
                <input type="hidden" name="info_id" value="<?php print $infoMail->infoId; ?>">
                <input type="hidden" name="mode" value="danger_off">
                <input type="submit" value="危険人物指定解除">
            </form>
        </td>
<?php }elseif($infoMail->userId){ ?>
        <td valign="top">
            <form method="post" action="user_data_update.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="user_id" value="<?php print $uId; ?>">
                <input type="hidden" name="info_id" value="<?php print $infoMail->infoId; ?>">
                <input type="hidden" name="mode" value="danger_on">
                <input type="submit" value="危険人物指定">
            </form>
        </td>
<?php } ?>
        <td valign="top">
            <form method="post" action="user_data_update.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="user_id" value="<?php print $uId; ?>">
                <input type="hidden" name="info_id" value="<?php print $infoMail->infoId; ?>">
                <input type="hidden" name="mode" value="retire">
                <input type="submit" value="退会指定">
            </form>
        </td>
        <td valign="top">
            <form method="post" action="user_data_update.php" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="user_id" value="<?php print $uId; ?>">
                <input type="hidden" name="info_id" value="<?php print $infoMail->infoId; ?>">
                <input type="hidden" name="mode" value="stop">
                <input type="submit" value="メールしない指定">
            </form>
        </td>
    </tr>
</table>

<table width="600" border="0" cellpadding="0" cellspacing="2" style="margin-bottom: 10;">
    <?php /* 登録済みユーザーからのメールの場合は、更新画面へのリンクを表示 */ ?>
    <?php if (!empty($infoMail->mmbId) || $infoMail->mmbId === 0) { ?>
    <tr>
        <td width="250">
            <a href="javascript:void(0)" onClick="window.open('<?php print($site["site_account"]["info@test.world-agent.jp"]["url"]); ?>/admin/?action_User_ListDo=1&s_status_id=<?php print($infoMail->mmbId); ?>&page=0', '_blank', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" ><font size="2">この登録済みユーザーの更新画面へ＞＞</font></a><br>
        </td>
    </tr>
    <?php } ?>
    <?php if($uId && !$ngUid) {?>
    <tr>
        <td>
            <a href="javascript:void(0)" onClick="window.open('<?php print($site["site_account"]["info@test.world-agent.jp"]["url"]); ?>/admin/?action_User_Detail=1&<?php print($site["user_key"]); ?>=<?php print $uId; ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>', '_blank', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" ><font size="2">この登録済みユーザーの更新画面へ＞＞</font></a><br>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td>
        <?php /* ユーザー候補のリンクを表示(ユーザー詳細画面へ)*/
        if (!$uId || $ngUid) {
            if ($userIdList) {
                foreach ($userIdList as $key => $val) { ?>
                    <a href="javascript:void(0)" onClick="window.open('<?php print($site["site_account"]["info@test.world-agent.jp"]["url"]); ?>/admin/?action_User_Detail=1&<?php print($site["user_key"]); ?>=<?php print($val); ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>', '_blank', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" ><font size="2" color="#ff0000">候補ユーザーの更新画面へ＞＞ユーザーID：<?php print($val); ?></font></a><br />
            <?php
                }
            } else {
                /* 候補がなければメッセージ表示 */ ?>
                <font size="2">他のユーザー候補は有りません</font>
            <?php
            }
        }
        ?>
        </td>
    <tr>
        <td>
            <a href="../" target="_blank"><font size="2">管理画面トップへ＞＞</font></a>
        </td>
    </tr>
</table>
<div style="display: block;" id="mailLog">
<?php if ($uId && !$ngUid) { ?>
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <form method="post" action="read.php?uId=<?php print $infoMail->userId; ?>&info_id=<?php print $infoMail->infoId; ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="maillog_from_pc" value="1">
                <input type="hidden" name="mode" value="stop">
                <input type="submit" value="PCログ表示">
            </form>
        </td>
        <td valign="top">
            <form method="post" action="read.php?uId=<?php print $infoMail->userId; ?>&info_id=<?php print $infoMail->infoId; ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="maillog_from_mb" value="1">
                <input type="hidden" name="mode" value="stop">
                <input type="submit" value="MBログ表示">
            </form>
        </td>
        <td valign="top">
            <form method="post" action="read.php?uId=<?php print $infoMail->userId; ?>&info_id=<?php print $infoMail->infoId; ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>" style="margin-top:0; margin-bottom:0;">
                <input type="hidden" name="maillog_from_pc_mb" value="1">
                <input type="hidden" name="mode" value="stop">
                <input type="submit" value="PC＆MBログ表示">
            </form>
        </td>
    </tr>
</table>
<br>
<?php } ?>
<iframe src="maillog.php?info_id=<?php echo  $_REQUEST["info_id"]; ?>&display_log_type=<?php echo $displayLogType; ?>" name="ogift" width="650" height="500" style="margin-bottom: 10;"></iframe>
</div>

<table width="600" border="1" cellpadding="2" cellspacing="0">
<tr>
<td width="80"><font size="2">送信者：</font></td><td><font size="2"><?php echo  $fromName; ?></font></td>
</tr>
<tr>
<td><font size="2">宛先：</font></td><td><font size="2"><?php echo  $infoMail->toAddress; ?></font></td>
</tr>
<tr>
<td><font size="2">日時：</font></td><td><font size="2"><?php echo  $infoMail->receivedDate; ?></font></td>
</tr>
<tr>
<td><font size="2">件名：</font></td><td><font size="2"><?php echo  $subject; ?></font></td>
</tr>
<tr>
<td><font size="2">本文：</font></td><td height="300" valign="top"><font size="2"><?php echo  $body; ?></font></td>
</tr>
<?php if ($topParentDir != TRANSMIT_DIR) { ?>
<tr>
<td><font size="2">担当者：</font></td>
<td>
<select name="sel2" onChange="update(this)">
<option value="$valueStr" . NOT_DEFINED . "\"{$isSelected}>未設定</option>
<?php
foreach ($operator_tbl as $key => $value) {
    if ($operator_tbl[$key]["is_display"] == DISPLAY) {
        print('<option value="./read.php?info_id='. $infoMail->infoId . "&update=1" . "&new_operator_id=" . $operator_tbl[$key]["id"] . "&" . SID . '"' . ($infoMail->operatorId == $operator_tbl[$key]["id"] ? " selected" : "") . '>' . $operator_tbl[$key]["name"] . "</option>\n");
    }
}
?>
</select>
</td>
</tr>
<tr>
<td><font size="2">対応状況：</font></td>
<td>
<select name="sel3" onChange="update(this)">
<?php
// 対応状況選択タグの生成
foreach ($replyStatus as $key => $value) {
    print('<option value="' . "./read.php?info_id=" . $infoMail->infoId . "&update=1&new_reply_status=". $key . "&" . SID . '"' . ($infoMail->replyStatus == $key ? " selected" : "") . ">" . $value . "</option>\n");
}
?>
</select>
</td>
</tr>
<?php } else { ?>
<tr>
<td><font size="2">担当者：</font></td>
<td><font size="2"><?php print($infoMail->operatorIdStr); ?></font></td>
</tr>
<?php } ?>
</table>

</body>
</html>
