<?php
/**
 * File Name:   config_exec.php
 *
 * Description: 設定項目変更処理PHPファイル。
 *              各設定項目の入力フォームで指定された変更内容は
 *              このPHP内ですべて処理され、実際に反映されるようになる。
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

//--------------------------
// アドレス帳設定更新用処理
//--------------------------

if ($_REQUEST["mode"] == "address") {
    // 連絡先の追加処理
    if ($_REQUEST["add_address"]) {
        if (!$_REQUEST["new_name"]) {
            print("名前を入力してください");
            exit;
        } else if (!$_REQUEST["new_mail_address"]) {
            print("メールアドレスを入力してください");
            exit;
        } else {
            // 現在登録されている最大の連絡先ID+1を求める
            $nextId = 0;
            foreach ($ad_book_tbl as $key => $value) {
                if ($ad_book_tbl[$key]["id"] > $nextId) {
                    $nextId = $ad_book_tbl[$key]["id"];
                }
            }
            $nextId++;

            if (get_magic_quotes_gpc()) {
                // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                $_REQUEST["new_name"] = stripslashes($_REQUEST["new_name"]);
                $_REQUEST["new_mail_address"] = stripslashes($_REQUEST["new_mail_address"]);
            } else {
                // offの場合はエスケープ解除なし
                $_REQUEST["new_name"] = $_REQUEST["new_name"];
                $_REQUEST["new_mail_address"] = $_REQUEST["new_mail_address"];
            }

            $newName = htmlspecialchars($_REQUEST["new_name"]);
            $newMailAddress = htmlspecialchars($_REQUEST["new_mail_address"]);
/*
            //EUCにします
            $newName = mb_convert_encoding($newName_tmp, "EUC-JP", "SJIS");
            $newMailAddress = mb_convert_encoding($newMailAddress, "EUC-JP", "SJIS");
*/
            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/ad_book_tbl.php", "./ini/ad_book_tbl.php.old")) {
                exit("バックアップファイルの生成に失敗！");
            }

            if (!($fp = fopen("./ini/ad_book_tbl.php", "w+"))) {
                exit("ファイルオープンに失敗！");
            }

            // アドレス帳データテーブルを更新し、新しい連絡先を追加する
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$ad_book_tbl = array('."\n");
            foreach ($ad_book_tbl as $key => $value) {
                fwrite($fp, "\tarray('id' => ".$ad_book_tbl[$key]["id"].", ");
                fwrite($fp, "'name' => '".$ad_book_tbl[$key]["name"]."', ");
                fwrite($fp, "'mail_address' => '".$ad_book_tbl[$key]["mail_address"]."'),\n");
            }

            fwrite($fp, "\tarray('id' => ".$nextId.", ");
            fwrite($fp, "'name' => '".$newName."', ");
            fwrite($fp, "'mail_address' => '".$newMailAddress."'),\n");
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            $execStr = "新しい連絡先「{$newName}」を追加しました。";
        }
    }

    // 連絡先の削除処理
    if ($_REQUEST["del_address"]) {
        if (is_numeric($_REQUEST["del_address_id"])) {
            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/ad_book_tbl.php", "./ini/ad_book_tbl.php.old")) {
                exit("バックアップファイルの生成に失敗！");
            }

            if (!($fp = fopen("./ini/ad_book_tbl.php", "w+"))) {
                exit("ファイルオープンに失敗！");
            }

            // 指定された連絡先IDが存在すれば、その連絡先データの書き込みをスキップする
            $delName = "";
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$ad_book_tbl = array('."\n");
            foreach ($ad_book_tbl as $key => $value) {
                if ($ad_book_tbl[$key]["id"] == $_REQUEST["del_address_id"]) {
                    $delName = $ad_book_tbl[$key]["name"];
                } else {
                    fwrite($fp, "\tarray('id' => ".$ad_book_tbl[$key]["id"].", ");
                    fwrite($fp, "'name' => '".$ad_book_tbl[$key]["name"]."', ");
                    fwrite($fp, "'mail_address' => '".$ad_book_tbl[$key]["mail_address"]."'),\n");
                }
            }
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            // 実際にデータ削除処理が行われている場合
            if ($delName) {
//              $delName = mb_convert_encoding($delName, "SJIS", "EUC-JP");
                $execStr = "連絡先「{$delName}」を削除しました。";
            } else {
                $execStr = "指定された連絡先NOは存在しません。";
            }
        } else {
            print("連絡先NOを入力してください");
            exit;
        }
    }
}

//--------------------------------
// メッセージルール設定更新用処理
//--------------------------------

if ($_REQUEST["mode"] == "message") {

    if ($_REQUEST["add_rule"]) {
        if ($_POST["column"] == "") {
            print("検索タイプを選択してください！！");
            exit;
        }
        if ($_POST["dir_id"] == "") {
            print("フォルダを選択してください！！");
            exit;
        }
        if ($_POST["str"] == "") {
            print("キーワードを入力してください！！");
            exit;
        }

        $sql = "INSERT INTO info_message_rule SET"
             . " search_type = ?,"
             . " keyword = ?,"
             . " dir_id = ?,"
             . " priority_id = 999,"
             . " disable = 0;";
        $key   = array();
        $key[] = $_POST["column"];
        $key[] = $_POST["str"];
        $key[] = $_POST["dir_id"];

        $db->executeSql($sql, $key);

        $execStr = "新しいメッセージルールを追加しました。";

    }
    // メッセージルールの削除処理(update)
    if ($_REQUEST["del_rule"]) {
        if (is_numeric($_REQUEST["del_rule_id"])) {

            $sql = "UPDATE info_message_rule SET"
                 . " disable = 1"
                 . " WHERE rule_id = ?"
                 . " LIMIT 1;";

            $db->executeSql($sql, array($_REQUEST["del_rule_id"]));

            $execStr = "メッセージルールを削除しました。";

        }
    }

    if ($_REQUEST["update_rule"]) {
     //   $ComDbOBJ = new ComDb() ;
        $priorityIdAry = $_POST["priority_id"] ;

        foreach($priorityIdAry as $key =>$val){
        	if(!is_numeric($val)){
                print("優先順位が適当ではない設定があります！！");
                exit;
        	}
        }

        foreach($priorityIdAry as $key =>$val){
            $sql = "UPDATE info_message_rule SET"
                 . " priority_id = ?"
                 . " WHERE rule_id = ?"
                 . " LIMIT 1;";

            $updateKey   = array();
            $updateKey[] = $val;
            $updateKey[] = $key;

            $db->executeSql($sql, $updateKey);
        }

        $execStr = "メッセージルールを更新しました。";
    }
}

//----------------------
// 担当者設定更新用処理
//----------------------

if ($_REQUEST["mode"] == "operator") {
    // 担当者の追加処理
    if ($_REQUEST["add_operator"]) {
        if ($_REQUEST["new_operator_name"]) {
            // 現在登録されている最大の担当者ID+1を求める
            $nextId = 0;
            foreach ($operator_tbl as $key => $value) {
                if ($operator_tbl[$key]["id"] > $nextId) {
                    $nextId = $operator_tbl[$key]["id"];
                }
            }
            $nextId++;

            if (get_magic_quotes_gpc()) {
                // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                $_REQUEST["new_operator_name"] = stripslashes($_REQUEST["new_operator_name"]);
            } else {
                // offの場合はエスケープ解除なし
                $_REQUEST["new_operator_name"] = $_REQUEST["new_operator_name"];
            }

            $newOprName_tmp = htmlspecialchars($_REQUEST["new_operator_name"]);
            //EUCにします
            $newOprName = mb_convert_encoding($newOprName_tmp, "EUC-JP", "SJIS");

            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/operator_tbl.php", "./ini/operator_tbl.php.old")) { exit("バックアップファイルの生成に失敗！"); }

            if (!($fp = fopen("./ini/operator_tbl.php", "w+"))) { exit("ファイルオープンに失敗！"); }

            // 担当者データテーブルを更新し、新しい担当者を追加する
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$operator_tbl = array('."\n");
            foreach ($operator_tbl as $key => $value) {
                fwrite($fp, "\tarray('id' => ".$operator_tbl[$key]["id"].", ");
                fwrite($fp, "'name' => '".$operator_tbl[$key]["name"]."'),\n");
            }

            fwrite($fp, "\tarray('id' => ".$nextId.", ");
            fwrite($fp, "'name' => '".$newOprName."'),\n");
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            $execStr = "新しい担当者「{$newOprName_tmp}」を追加しました。";
        } else {
            print("担当者名を入力してください");
            exit;
        }
    }

    // 担当者の削除処理
    if ($_REQUEST["del_operator"]) {
        if (is_numeric($_REQUEST["del_operator_id"])) {
            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/operator_tbl.php", "./ini/operator_tbl.php.old")) { exit("バックアップファイルの生成に失敗！"); }

            if (!($fp = fopen("./ini/operator_tbl.php", "w+"))) { exit("ファイルオープンに失敗！"); }

            // 指定された担当者IDが存在すれば、その担当者データの書き込みをスキップする
            $delOprName = "";
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$operator_tbl = array('."\n");
            foreach ($operator_tbl as $key => $value) {
                if ($operator_tbl[$key]["id"] == $_REQUEST["del_operator_id"]) {
                    $delOprName = $operator_tbl[$key]["name"];
                } else {
                    fwrite($fp, "\tarray('id' => ".$operator_tbl[$key]["id"].", ");
                    fwrite($fp, "'name' => '".$operator_tbl[$key]["name"]."'),\n");
                }
            }
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            // 実際にデータ削除処理が行われている場合
            if ($delOprName) {
                $mysql = new mysql;
                $mysql->connect($db_address,$db_user,$db_pass,$db_name);

                /* DB内メールデータから、削除された担当者IDが担当者カラムに
                   指定されているものを、すべて未設定に戻しておく */
                $sql = "UPDATE info_mail_tbl SET operator_id = 0 "
                     . "WHERE operator_id = {$_REQUEST[del_operator_id]};";
                $result = $mysql->query($sql); //$mysql->errorCheck($sql);

                $mysql->close();
                unset($mysql);

                $delOprName = mb_convert_encoding($delOprName, "SJIS", "EUC-JP");
                $execStr = "担当者「{$delOprName}」を削除しました。";
            } else {
                $execStr = "指定された担当者IDは存在しません。";
            }
        } else {
            print("担当者IDを入力してください");
            exit;
        }
    }
}

//------------------------
// フォルダ設定更新用処理
//------------------------

if ($_REQUEST["mode"] == "folder") {
    // フォルダ名の変更処理
    if ($_REQUEST["change_dir_name"]) {
        if ($_REQUEST["new_dir_name"]) {

            if (get_magic_quotes_gpc()) {
                // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                $_REQUEST["new_dir_name"] = stripslashes($_REQUEST["new_dir_name"]);
            } else {
                // offの場合はエスケープ解除なし
                $_REQUEST["new_dir_name"] = $_REQUEST["new_dir_name"];
            }

            $newDirName = htmlspecialchars($_REQUEST["new_dir_name"]);

            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/dir_tbl.php", "./ini/dir_tbl.php.old")) {
                exit("バックアップファイルの生成に失敗！");
            }

            if (!($fp = fopen("./ini/dir_tbl.php", "w+"))) {
                exit("ファイルオープンに失敗！");
            }

            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$dir_tbl = array('."\n");
            foreach ($dir_tbl as $key => $value) {
                fwrite($fp, "\tarray('id' => ".$dir_tbl[$key]["id"].", ");
                // 指定されたフォルダの書き込み時には、新しいフォルダ名を使用する
                if ($dir_tbl[$key]["id"] == $_REQUEST["dir_id"]) {
                    fwrite($fp, "'name' => '".$newDirName."', ");
                } else {
                    fwrite($fp, "'name' => '".$dir_tbl[$key]["name"]."', ");
                }
                fwrite($fp, "'tree_level' => ".$dir_tbl[$key]["tree_level"].", ");
                fwrite($fp, "'parent_id' => ".$dir_tbl[$key]["parent_id"]."),\n");
            }
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            $execStr = "フォルダ名を変更しました。";
        } else {
            print("フォルダ名を入力してください");
            exit;
        }
    }

    // サブフォルダ追加処理
    if ($_REQUEST["add_subdir"]) {
        if ($_REQUEST["new_subdir_name"]) {
            // 現在登録されている最大のフォルダID+1を求める
            $nextId = 0; $subTreeLevel = 0;
            foreach ($dir_tbl as $key => $value) {
                if ($dir_tbl[$key]["id"] > $nextId) {
                    $nextId = $dir_tbl[$key]["id"];
                }
                if ($dir_tbl[$key]["id"] == $_REQUEST["dir_id"]) {
                    $subTreeLevel = $dir_tbl[$key][tree_level] + 1;
                }
            }
            $nextId++;

            if (get_magic_quotes_gpc()) {
                // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                $_REQUEST["new_subdir_name"] = stripslashes($_REQUEST["new_subdir_name"]);
            } else {
                // offの場合はエスケープ解除なし
                $_REQUEST["new_subdir_name"] = $_REQUEST["new_subdir_name"];
            }

//          $newSubdirName_tmp = htmlspecialchars($_REQUEST["new_subdir_name"]);
            $newSubdirName = htmlspecialchars($_REQUEST["new_subdir_name"]);

            //EUCにします
            //$newSubdirName = mb_convert_encoding($newSubdirName_tmp, "EUC-JP", "SJIS");

            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/dir_tbl.php", "./ini/dir_tbl.php.old")) {
                exit("バックアップファイルの生成に失敗！");
            }

            if (!($fp = fopen("./ini/dir_tbl.php", "w+"))) {
                exit("ファイルオープンに失敗！");
            }

            // フォルダデータテーブルを更新し、新しいサブフォルダを追加する
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$dir_tbl = array('."\n");
            foreach ($dir_tbl as $key => $value) {
                fwrite($fp, "\tarray('id' => ".$dir_tbl[$key]["id"].", ");
                fwrite($fp, "'name' => '".$dir_tbl[$key]["name"]."', ");
                fwrite($fp, "'tree_level' => ".$dir_tbl[$key]["tree_level"].", ");
                fwrite($fp, "'parent_id' => ".$dir_tbl[$key]["parent_id"]."),\n");
            }

            fwrite($fp, "\tarray('id' => ".$nextId.", ");
            fwrite($fp, "'name' => '".$newSubdirName."', ");
            fwrite($fp, "'tree_level' => ".$subTreeLevel.", ");
            fwrite($fp, "'parent_id' => ".$_REQUEST["dir_id"]."),\n");

            fwrite($fp, ");\n?>\n");

            fclose($fp);

            $execStr = "サブフォルダ「{$newSubdirName}」を追加しました。";
        } else {
            print("サブフォルダ名を入力してください");
            exit;
        }
    }

    // フォルダ削除処理
    if ($_REQUEST["del_dir"]) {
        if (is_numeric($_REQUEST["del_dir_id"])) {
            // ファイル変更前にバックアップを取っておく
            if (!copy("./ini/dir_tbl.php", "./ini/dir_tbl.php.old")) { exit("バックアップファイルの生成に失敗！"); }

            if (!($fp = fopen("./ini/dir_tbl.php", "w+"))) { exit("ファイルオープンに失敗！"); }

            // 指定されたフォルダIDが存在すれば、そのフォルダデータの書き込みをスキップする
            $delDirName = "";
            flock($fp,LOCK_EX);
            fwrite($fp, "<?php\n".'$dir_tbl = array('."\n");
            foreach ($dir_tbl as $key => $value) {
                if ($dir_tbl[$key]["id"] == $_REQUEST["del_dir_id"] &&
                         $dir_tbl[$key][tree_level] != 1) {
                    $delDirName = $dir_tbl[$key]["name"];
                } else {
                    fwrite($fp, "\tarray('id' => ".$dir_tbl[$key]["id"].", ");
                    fwrite($fp, "'name' => '".$dir_tbl[$key]["name"]."', ");
                    fwrite($fp, "'tree_level' => ".$dir_tbl[$key]["tree_level"].", ");
                    fwrite($fp, "'parent_id' => ".$dir_tbl[$key]["parent_id"]."),\n");
                }
            }
            fwrite($fp, ");\n?>\n");

            fclose($fp);

            // 実際にデータ削除処理が行われている場合
            if ($delDirName) {

                /* DB内メールデータから、削除されたフォルダIDがフォルダカラムに
                   指定されているものを、すべて削除済みフォルダに移動させる */

                $sql = "UPDATE info_mail SET"
                     . " dir_id = " . DELETE_DIR
                     . " WHERE dir_id = ?"
                     . " LIMIT 1;";
                $db->executeSql($sql, array($_REQUEST["del_dir_id"]));

                $execStr = "フォルダ「{$delDirName}」を削除しました。";
            } else {
                $execStr = "指定されたフォルダは削除できません。";
            }
        } else {
            print("フォルダIDを入力してください");
            exit;
        }
    }
}

//---------------------
// 定型文設定更新用処理
//---------------------

if($_REQUEST["mode"] == "message_tmp") {
    if($_REQUEST["change_msg_tmp"]) {
        $msg_tmp_full = $_REQUEST["msg_tmp_full"];
        $data = file_get_contents("./ini/msg_tmp.php");
        $data = str_replace(array("<?php","?>"),array("",""),$data);
        eval($data);

        $str = "<?php\n"
             . "\$msg_tmp_full = $msg_tmp_full;\n\n"
             . "\$msg_tmp = array(\n";

        for($i=0; $i<$msg_tmp_full; $i++){
            if($_REQUEST["msg_tmp_no"] - 1 == $i){
                if (get_magic_quotes_gpc()) {
                    // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                    $msg_tmp_name[$i] = stripslashes($_REQUEST["msg_tmp_name"]);
                    $msg_tmp_title[$i] = stripslashes($_REQUEST["msg_tmp_title"]);
                    $msg_tmp_body[$i] = stripslashes($_REQUEST["msg_tmp_body"]);
                } else {
                    // offの場合はエスケープ解除なし
                    $msg_tmp_name[$i] = $_REQUEST["msg_tmp_name"];
                    $msg_tmp_title[$i] = $_REQUEST["msg_tmp_title"];
                    $msg_tmp_body[$i] = $_REQUEST["msg_tmp_body"];
                }

                $msg_tmp_name[$i] = htmlspecialchars($msg_tmp_name[$i]);
                //$msg_tmp_name[$i] = mb_convert_encoding($msg_tmp_name[$i], "EUC-JP", "SJIS");
                $msg_tmp_name[$i] = str_replace(array("'","\\"), array("’","￥"), $msg_tmp_name[$i]);
                $msg_tmp_name[$i] = str_replace("\r\n", "\n", $msg_tmp_name[$i]);

                $msg_tmp_title[$i] = htmlspecialchars($msg_tmp_title[$i]);
                //$msg_tmp_title[$i] = mb_convert_encoding($msg_tmp_title[$i], "EUC-JP", "SJIS");
                $msg_tmp_title[$i] = str_replace(array("'","\\"), array("’","￥"), $msg_tmp_title[$i]);
                $msg_tmp_title[$i] = str_replace("\r\n", "\n", $msg_tmp_title[$i]);

                $msg_tmp_body[$i] = htmlspecialchars($msg_tmp_body[$i]);
                //$msg_tmp_body[$i] = mb_convert_encoding($msg_tmp_body[$i], "EUC-JP", "SJIS");
                $msg_tmp_body[$i] = str_replace(array("'","\\"), array("’","￥"), $msg_tmp_body[$i]);
                $msg_tmp_body[$i] = str_replace("\r\n", "\n", $msg_tmp_body[$i]);

                $str .= "\tarray('id'=>'$i','msg_tmp_name'=>'$msg_tmp_name[$i]',"
                      . "'msg_tmp_title'=>'$msg_tmp_title[$i]',"
                      . "'msg_tmp_body'=>'$msg_tmp_body[$i]',"
                      . "'msg_tmp_time'=>'".date('Y/m/d H:i:s')."')";
            }else{
                $str .= "\tarray('id'=>'$i','msg_tmp_name'=>'".$msg_tmp[$i]["msg_tmp_name"]."',"
                      . "'msg_tmp_title'=>'".$msg_tmp[$i]["msg_tmp_title"]."',"
                      . "'msg_tmp_body'=>'".$msg_tmp[$i]["msg_tmp_body"]."',"
                      . "'msg_tmp_time'=>'".$msg_tmp[$i]["msg_tmp_time"]."')";
            }
            if($i < $msg_tmp_full - 1){
                $str .= ",\n";
            }
        }
        $str .= "\n);\n"
              . "?>\n";

        // ファイル変更前にバックアップを取っておく
        if (!copy("./ini/msg_tmp.php", "./ini/msg_tmp.php.old")) {
            exit("バックアップファイルの生成に失敗！");
        }

        if (!($fp = fopen("./ini/msg_tmp.php","w+"))) {
            exit("ファイルオープンに失敗！");
        }

        flock($fp,LOCK_EX);
        fwrite($fp, $str);
        flock($fp,LOCK_UN);
        fclose($fp);

        $execStr = "メッセージテンプレート{$_REQUEST[msg_tmp_no]}を変更しました。";
    }
}

//--------------------
// 署名設定更新用処理
//--------------------

if ($_REQUEST["mode"] == "signiture") {
    if ($_REQUEST[change_sign]) {
        // 署名1を更新する場合
        if (intval($_REQUEST["sgn_no"]) == 1) {
            if (get_magic_quotes_gpc()) {
                // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
                $sgn1 = stripslashes($_REQUEST["sgn_body"]);
            } else {
                // offの場合はエスケープ解除なし
                $sgn1 = $_REQUEST["sgn_body"];
            }
            $sgn1 = htmlspecialchars($sgn1);
            //$sgn1 = mb_convert_encoding($sgn1, "EUC-JP", "SJIS");
            $sgn1 = str_replace("'", "’", $sgn1);
            $sgn1 = str_replace("\r\n", "\n", $sgn1);
        // 署名2を更新する場合
        } else if (intval($_REQUEST["sgn_no"]) == 2) {
            if (get_magic_quotes_gpc()) {
                $sgn2 = stripslashes($_REQUEST["sgn_body"]);
            } else {
                $sgn2 = $_REQUEST["sgn_body"];
            }
            $sgn2 = htmlspecialchars($sgn2);
            //$sgn2 = mb_convert_encoding($sgn2, "EUC-JP", "SJIS");
            $sgn2 = str_replace("'", "’", $sgn2);
            $sgn2 = str_replace("\r\n", "\n", $sgn2);
        // 署名3を更新する場合
        } else if (intval($_REQUEST["sgn_no"]) == 3) {
            if (get_magic_quotes_gpc()) {
                $sgn3 = stripslashes($_REQUEST["sgn_body"]);
            } else {
                $sgn3 = $_REQUEST["sgn_body"];
            }
            $sgn3 = htmlspecialchars($sgn3);
            $sgn3 = str_replace("'", "’", $sgn3);
            $sgn3 = str_replace("\r\n", "\n", $sgn3);
        }

        // ファイル変更前にバックアップを取っておく
        if (!copy("./ini/signature.php", "./ini/signature_backup.php")) {
            exit("バックアップファイルの生成に失敗！");
        }

        if (!($fp = fopen("./ini/signature.php", "w+"))) {
            exit("ファイルオープンに失敗！");
        }

        // 新しい署名設定の書き込み処理
        flock($fp, LOCK_EX);
        fwrite($fp, "<?php" . "\n");
        fwrite($fp, "// 署名1" . "\n");
        fwrite($fp, '$sgn1 = <<<EOD'."\n");
        fwrite($fp, "{$sgn1}\n");
        fwrite($fp, "EOD;\n");
        fwrite($fp, "// 署名2" ."\n");
        fwrite($fp, '$sgn2 = <<<EOD'."\n");
        fwrite($fp, "{$sgn2}\n");
        fwrite($fp, "EOD;\n");
        fwrite($fp, "// 署名3" . "\n");
        fwrite($fp, '$sgn3 = <<<EOD'."\n");
        fwrite($fp, "{$sgn3}\n");
        fwrite($fp, "EOD;\n");
        fwrite($fp, "?>");
        flock($fp, LOCK_UN);
        fclose($fp);

        $execStr = "署名{$_REQUEST[sgn_no]}を変更しました。";
    }
}

//------- --------------
// DB削除設定更新用処理
//----------------------

if ($_REQUEST["mode"] == "delete") {

    if ($_REQUEST["delete_db_data"]) {

        // 検索条件のチェック(年月日)
        if (!checkdate($_REQUEST["del_month"], $_REQUEST["del_day"], $_REQUEST["del_year"])) {
            die("日付が正しくありません。");
        }

        // DB削除時はDB削除パス入力が必須
        if (md5($_REQUEST["db_del_pass"]) != $dbDelPw) {    // $dbDelPw: config.ini内で宣言
            print("DB削除パスが違います！！");
            exit;
        }

        $key   = array();
        $key[] = $_REQUEST["del_year"]
               . "-"
               . str_pad($_REQUEST["del_month"], 2, "0", STR_PAD_LEFT)
               . "-"
               . str_pad($_REQUEST["del_day"], 2, "0", STR_PAD_LEFT)
               . " 23:59:59";

        $sql = "DELETE FROM info_mail"
             . " WHERE dir_id = 0"
             . " AND received_date <= ?";
        $db->executeSql($sql, $key);

        $execStr = $_REQUEST["del_year"] . "年"
                 . $_REQUEST["del_month"] . "月"
                 . $_REQUEST["del_day"] . "日"
                 . "までのメールデータをDBから消去しました。";
    }

//print("データは削除はしません");
//exit;

}
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<!-- 結果表示 -->
<strong>設定完了！</strong>
<hr>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td height="30" valign="top">
    <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
        <input type="hidden" name="do" value="config">
        <input type="hidden" name="mode" value="<?php print($_REQUEST["mode"]); ?>">
        <input type="submit" value="戻る">
    </form>
    </td>
</tr>
</table>
<font size="2"><?php print($execStr); ?></font>
