<?php
/**
 * File Name:   config_msg.php
 *
 * Description: メッセージルール設定表示PHPファイル。
 *              新しいメッセージルールの追加、削除用フォームを表示する。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/16
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

//現在のメッセージルールを抽出
$sql = "SELECT rule_id,"
     . "       priority_id,"
     . "       search_type,"
     . "       keyword,"
     . "       dir_id"
     . " FROM info_message_rule"
     . " WHERE disable = 0"
     . " ORDER BY priority_id ,rule_id ASC";
$rs  = $db->executeSql($sql, array());

if ($rs->numRows()) {
    //表示用にメッセージルールの配列作成
    $msgRuleArray = array();
    while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
        $msgRuleArray[] = $row;
    }
}
// 対象項目選択タグの生成
$columnOpt = "";
foreach ($targetColumns as $key => $value) {
    $columnOpt .= '<option value="' . $key . '">' . $value . '</option>' . "\n";
}

// 移動先フォルダ選択タグの生成
$dirIdOpt = "";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($value["tree_level"] == 1) {
        $dirIdOpt .= '<option value="' . $value["id"] . '">' . $value["name"] . '</option>' . "\n";

        foreach ($dir_tbl as $key2 => $value2) {
            // 2階層目フォルダデータの取得
            if ($value2["tree_level"] == 2 && $value2["parent_id"] == $value["id"]) {
                // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                $dirIdOpt .= '<option value="' . $value2["id"] . '">　+' . $value2["name"] . '</option>' . "\n";

                foreach ($dir_tbl as $key3 => $value3) {
                    // 3階層目フォルダデータの取得
                    if ($value3["tree_level"] == 3 && $value3["parent_id"] == $value2["id"]) {
                        // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        $dirIdOpt .= '<option value="' . $value3["id"] . '">　　+' . $value3["name"] . '</option>' . "\n";
                    }
                }
            }
        }
    }
}
$dirIdOpt .= '<option value="' . NOT_DEFINED . '">受信しない</option>' . "\n";
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php // JavaScript定義 ?>
<script language="Javascript" type="text/javascript">
<!--
function toggleMoveStr() {
    var dir = document.getElementById("dir_id");
    var mStr = document.getElementById("moveStr");

    if (dir.options[dir.selectedIndex].value == "0") {
        mStr.style.display = "none";
    } else {
        mStr.style.display = "block";
    }
}
// -->
</script>

<!-- 設定フォーム表示 -->
<strong>メッセージルール設定</strong>
<hr>

<form method="post" action="Information.php?do=config_exec&mode=message" style="margin-top:0; margin-bottom:0;">

<font size="2"><strong>・メッセージルール一覧</strong></font>
<?php if ($msgRuleArray) { ?>
    <table border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td width="30"><font size="2">NO</font></td>
            <td width="90"><font size="2">対象項目(～に)</font></td>
            <td width="210"><font size="2">検索文字列(～があったら)</font></td>
            <td width="170"><font size="2">移動先フォルダ(～に移動する)</font></td>
            <td width="30"><font size="2">優先順位</font></td>
        </tr>
    <?php   foreach ($msgRuleArray as $key => $msgRule) { ?>
        <tr>
            <td><font size="2"><?php print($msgRule["rule_id"]); ?></font></td>
            <td><font size="2"><?php print($targetColumns[$msgRule["search_type"]]); ?></font></td>
            <td><font size="2"><?php print($msgRule["keyword"]); ?></font></td>
            <td><font size="2"><?php print(getDirName($msgRule["dir_id"])); ?></font></td>
            <td><font size="2"><input type="text" name="priority_id[<?php print $msgRule['rule_id'] ;?>]" size="3" value="<?php print($msgRule['priority_id']); ?>"></font></td>
        </tr>
    <?php   } ?>
    </table>
    <br>
    <font size="2"><strong>・メッセージルールの更新</strong></font>
    <input type="submit" value="更新">
    <input type="hidden" name="update_rule" value="1">
    <br>
    <br>
<?php } ?>

</form>

<font size="2"><strong>・メッセージルールの追加</strong></font>
<table border="0" cellpadding="0" cellspacing="5">
    <form method="post" action="Information.php?do=config_exec&mode=message" style="margin-top:0; margin-bottom:0;">
    <tr>
        <td>
        <select name="column">
            <?php print($columnOpt); ?>
        </select>
        <font size="2">に</font>
        </td>
        <td><input type="text" name="str" size="25" style="margin-right:5"><font size="2">があったら</font></td>
        <td>
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
            <select name="dir_id" onChange="toggleMoveStr();" style="margin-right:5">
                <?php print($dirIdOpt); ?>
            </select>
            </td>
            <td valign="bottom">
            <div id="moveStr" style="margin-right:2">
            <font size="2">に移動する</font>
            </div>
            </td>
            <td>
            <input type="submit" value="追加">
            <input type="hidden" name="add_rule" value="1">
            </td>
        </tr>
        </table>
        </td>
    </tr>
    </form>
</table>
<br>
<font size="2"><strong>・メッセージルールの削除</strong></font>
<table border="0" cellpadding="0" cellspacing="0">
    <form method="post" action="Information.php?do=config_exec&mode=message" style="margin-top:0; margin-bottom:0;">
    <tr>
        <td width="172"><font size="2">削除するメッセージルールNO：</font></td>
        <td width="35"><input type="text" name="del_rule_id" size="3"></td>
        <td>
        <input type="hidden" name="del_rule" value="1">
        <input type="submit" value="削除">
        </td>
    </tr>
    </form>
</table>
