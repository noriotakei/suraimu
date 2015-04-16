<?php
/**
 * File Name:   dir_tree.php
 *
 * Description: フォルダツリー表示PHPファイル。
 *              フォルダデータテーブル(dir_tbl.ini)からデータを読み出し、
 *              各フォルダ名をツリー上に表示する。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 * @version     SVN:$Id: dir_tree.php 1498 2009-08-18 01:34:53Z honma $
 */

/*
 * PHP処理セクション
 *
 * フォルダツリー表示用データの生成
 *  (フォルダ階層は最大で3階層目まで)
 */
$dirTree = "<table style=\"font-size: 12; id=\"center\"><tr><td nowrap><strong><font color=\"red\">未読</font></strong></td><td nowrap><strong><font color=\"red\">未対応</font></strong></td><td nowrap>&nbsp;</td></tr>";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($dir_tbl[$key]["tree_level"] == 1) {
        // フォルダの未読件数検索（親フォルダ）
        $sql = "SELECT SUM(CASE WHEN read_status = " . UNREAD_MAIL . " THEN 1 ELSE 0 END) as read_cnt, SUM(CASE WHEN reply_status = " . NOT_REPLIED . " THEN 1 ELSE 0 END) as reply_cnt"
             . " FROM info_mail"
             . " WHERE (read_status = 1"
             . " OR reply_status = 1)"
             . " AND dir_id = ? ";

        $rs = $db->executeSql($sql, array($dir_tbl[$key]["id"]));
        $array = array();
        $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
        $readCnt = $array["read_cnt"];
        $replyCnt = $array["reply_cnt"];

        // 未読件数が0件だったら、表示しないようにします
        if ($readCnt == 0) {
            $midoku = 0;
        } else {
            $midoku = "&nbsp;<font color=\"blue\">" . $readCnt . "</font>";
        }

        // 未対応件数が0件だったら、表示しないようにします
        if ($replyCnt == 0) {
            $reply = 0;
        } else {
            $reply = "&nbsp;<font color=\"blue\">" . $replyCnt . "</font>";
        }

        // 表示用配列に格納する
        if ($_REQUEST["dir_id"] == $dir_tbl[$key]["id"]) {
            // 強調表示
            $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key][id]}\"><strong>{$dir_tbl[$key][name]}</strong></a></td></tr>";
        } else {
            $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key][id]}\">{$dir_tbl[$key][name]}</a></td></tr>";
        }

        foreach ($dir_tbl as $key2 => $value) {
            // 2階層目フォルダデータの取得
            if ($dir_tbl[$key2]["tree_level"] == 2 && $dir_tbl[$key2]["parent_id"] == $dir_tbl[$key]["id"]) {
                // フォルダの未読件数検索（子フォルダ）
                $sql = "SELECT SUM(CASE WHEN read_status = " . UNREAD_MAIL . " THEN 1 ELSE 0 END) as read_cnt, SUM(CASE WHEN reply_status = " . NOT_REPLIED . " THEN 1 ELSE 0 END) as reply_cnt"
                     . " FROM info_mail"
                     . " WHERE (read_status = 1"
                     . " OR reply_status = 1)"
                     . " AND dir_id = ? ";
                $rs = $db->executeSql($sql, array($dir_tbl[$key2]["id"]));
                $array = array();
                $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                $readCnt = $array["read_cnt"];                $replyCnt = $array["reply_cnt"];

                // 未読件数が0件だったら、表示しないようにします
                if ($readCnt == 0) {
                    $midoku = 0;
                } else {
                    $midoku = "&nbsp;<font color=\"blue\">" . $readCnt . "</font>";
                }

                // 未対応件数が0件だったら、表示しないようにします
                if ($replyCnt == 0) {
                    $reply = 0;
                } else {
                    $reply = "&nbsp;<font color=\"blue\">" . $replyCnt . "</font>";
                }

                // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                if ($_REQUEST["dir_id"] == $dir_tbl[$key2]["id"]) {
                    // 強調表示
                    $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key2]["id"]}\" style=\"margin-left: 10;\">+<strong>{$dir_tbl[$key2]["name"]}</strong></a></td></tr>";
                } else {
                    $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key2]["id"]}\" style=\"margin-left: 10;\">+{$dir_tbl[$key2]["name"]}</a></td></tr>";
                }

                foreach ($dir_tbl as $key3 => $value) {
                    // 3階層目フォルダデータの取得
                    if ($dir_tbl[$key3]["tree_level"] == 3 && $dir_tbl[$key3]["parent_id"] == $dir_tbl[$key2]["id"]) {
                        // フォルダの未読件数検索（孫フォルダ）
                    $sql = "SELECT SUM(CASE WHEN read_status = " . UNREAD_MAIL . " THEN 1 ELSE 0 END) as read_cnt, SUM(CASE WHEN reply_status = " . NOT_REPLIED . " THEN 1 ELSE 0 END) as reply_cnt"
                             . " FROM info_mail"
                             . " WHERE (read_status = 1"
                             . " OR reply_status = 1)"
                             . " AND dir_id = ? ";
                        $rs = $db->executeSql($sql, array($dir_tbl[$key3]["id"]));
                        $array = array();
                        $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                        $readCnt = $array["read_cnt"];
                        $replyCnt = $array["reply_cnt"];

                        // 未読件数が0件だったら、表示しないようにします
                        if ($readCnt == 0) {
                            $midoku = 0;
                        } else {
                            $midoku = "&nbsp;<font color=\"blue\">" . $readCnt . "</font>";
                        }

                        // 未対応件数が0件だったら、表示しないようにします
                        if ($replyCnt == 0) {
                            $reply = 0;
                        } else {
                            $reply = "&nbsp;<font color=\"blue\">" . $replyCnt . "</font>";
                        }

                        // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        if ($_REQUEST["dir_id"] == $dir_tbl[$key3]["id"]) {
                            // 強調表示
                            $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key3]["id"]}\" style=\"margin-left: 20;\">+<strong>{$dir_tbl[$key3]["name"]}</strong></a></td></tr>";
                        } else {
                            $dirTree .= "<tr><td nowrap align =\"center\">".$midoku."</td><td nowrap align =\"center\">".$reply."</td><td nowrap><a href=\"Information.php?do=tray&dir_id={$dir_tbl[$key3]["id"]}\" style=\"margin-left: 20;\">+{$dir_tbl[$key3]["name"]}</a></td></tr>";
                        }
                    }
                }
            }
        }
    }
}
$dirTree .= "</table>";

/**
 * HTML表示セクション
 */
?>
<!-- フォルダ一覧表示 -->
<strong>フォルダ一覧</strong>
<hr>
<font size="2"><?php print($dirTree); ?></font>

<br>
<?php /*
<font size="2">
置換一覧<br /><br>
%site_name%<br>
⇒サイト名<br><br>
%domain%<br>
⇒ドメイン<br><br>
%info_account%<br>
⇒infoアカウント<br><br>
%teishi_account%<br>
⇒停止アカウント<br><br>
</font>
*/ ?>