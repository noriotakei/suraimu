<?php
/**
 * File Name:   funcs.inc
 *
 * Description: 汎用関数定義ファイル
 *
 * Author       Shinichi Hata <hata@icodw.co.jp>
 * Created      2006/02/06
 * Modified:    2006/03/27 by hata
 *
 * @package     InfoMail
 */

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// include("/usr/local/apache2/PG_test/lib/connect.inc");

// パッケージパスの設定
//ini_set("include_path", ini_get("include_path").":/usr/local/apache2/htdocs_test/ADMIN/Information/ini");
// 設定ファイル群の読み込み
// require_once("admarray.ini");
// パッケージファイル群の読み込み
// require_once("config.ini"); // 各種設定ファイル
require_once("./ini/dir_tbl.php"); // フォルダデータテーブル

/**
 * アクセス認証処理関数
 *
 * infoメーラーアクセス時の認証処理を行う。
 *
 * @param string $user 認証用ユーザー名
 * @param string $pass 認証用パスワード
 * @param object $dbObj DBオブジェクト
 */

/*
function authenticate($user, $pass, $dbObj){
    $sql = "SELECT * FROM sakura WHERE sakura = ".$user." AND pass = '".$pass."'";
    $result = mysql_query($sql); $dbObj->errorCheck($sql);
    $rows = mysql_num_rows($result);

    if($rows == 0){
        exit('<body bgcolor="#ffffff">ログイン却下');
    }else{
        $data = mysql_fetch_object($result) ;

        if($data->flag != "3"){ // インフォ専用アカウントflag==3！
            exit('<body bgcolor="#ffffff">ログイン却下');
        }
    }
}
*/
/**
 * 改行コード変換関数
 *
 * 改行コードをHTMLの改行タグ<br>に変換する。
 *
 * @param string $str 変換対象文字列
 * @return string $rtn 改行コード変換後の文字列
 */
function replaceToBr($str) {
    $rtn = $str;

    $rtn = str_replace("\r\n", "<br>", $rtn);
    $rtn = str_replace("\r", "<br>", $rtn);
    $rtn = str_replace("\n", "<br>", $rtn);
    $rtn = str_replace("<br>", "<br>\n", $rtn); // おまけ

    return $rtn;
}

/**
 * ％文字列変換関数
 *
 * $mIdから登録者のユーザー情報を取得後、
 * $strで渡された文字列内で指定された各％文字列を
 * それぞれ対応したユーザー情報に置換する処理を行う。
 *
 * @param integer $sFlag サイトフラグ
 * @param string $mId メンバーID
 * @param string $str 変換対象文字列
 * @param object $dbObj DBオブジェクト
 * @return string $rtn ％文字列変換後の文字列
 */
function replacePercentStr($sFlag, $mId, $str, &$db) {

    // DBに接続
    global $site_ary; // $site_ary: config.ini内で宣言
    global $sgn1, $sgn2, $sgn3; // $sgn1, $sgn2, $sng3: config.ini内で宣言
    $rtn = $str;

    for($i=1; $i<=3; $i++){
        if(mb_detect_encoding(${sgn.$i},"EUC-JP") == "EUC-JP"){
            ${sgn.$i} = ${sgn.$i};
        }
    }
    // %-s1-, %-s2-, %-s3-をそれぞれ署名1、署名2、署名3に変換　署名も%変換可能にするために先に署名から変換！
    $rtn = str_replace(array('%-s1-', '%-s2-', '%-s3-'), array($sgn1, $sgn2, $sgn3), $rtn);

    // %-a-, %-b-をそれぞれサイト名、ドメインに変換
    $rtn = str_replace(array('%-a-', '%-b-', '%-c-'), array($site_ary[$sFlag][0], $site_ary[$sFlag][1], $site_ary[$sFlag][2]), $rtn);

    // $mIDが指定されていれば登録ユーザー情報の変換処理を行う
    if (!empty($mId) || $mId === "0") {
        if ($mId != "multi") {
            // 個別返信処理の場合
            $sql = "SELECT uid FROM member_mst"
                 . " WHERE uid = '" . $mId . "';";
            $rs = $db->executeSql($sql, array());

            if ($rs->numRows() > 0) {
                $array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                // %-1-, %-2-をそれぞれメンバーID、パスワードに変換
                $rtn = str_replace(array('%-1-', '%-2-', '%-3-'), array($array["uid"]), $rtn);

            }
        } else {
            // 一括返信処理の場合
            $rtn = str_replace(array('%-1-', '%-2-', '%-3-'), array("[各ﾕｰｻﾞID]", "[各ﾕｰｻﾞPW]", "[各ﾕｰｻﾞHASH]"), $rtn);
        }
    } else {
        $rtn = str_replace(array('%-1-', '%-2-', '%-3-'), array("", "", ""), $rtn);
    }

    return $rtn;
}

/**
 * 返信用インデント処理関数
 *
 * $strで渡された受信メール本文を
 * 返信用に「>」でインデントする。
 *
 * @param string $str 変換対象文字列
 * @return string $rtn インデント処理後の文字列
 */
function addIndent($str) {
    $rows = explode("\n",$str);
    $rtn = "\n\n";

    foreach ($rows as $value) {
        $rtn .= "> ".$value."\n";
    }

    return $rtn;
}

/**
 * URL自動リンク処理関数
 *
 * $strで渡された文字列内のURL記述部分に
 * リンクタグを追加する。
 *
 * @param string $str 変換対象文字列
 * @return string $rtn URLリンク追加後の文字列
 */
function addUrlLink($str) {
    $rtn = $str;

    $rtn = ereg_replace("(https?|ftp)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>" , $rtn);

    return $rtn;
}

/**
 * フォルダ名取得関数
 *
 * フォルダIDで指定されたフォルダ名を取得する。
 *
 * @param integer $dirId フォルダID
 * @return string $rtn フォルダ名
 */
function getDirName($dirId) {
    global $dir_tbl; // $dir_tbl: dir_tbl.ini内で宣言
    $rtn = "";

    // メッセージルール設定表示の時だけ有効な条件指定
    if ($dirId == NOT_DEFINED) { return "受信しない"; }

    foreach ($dir_tbl as $key => $value) {
        if ($dir_tbl[$key][id] == $dirId) {
            $rtn = $dir_tbl[$key][name]; break; // フォルダ名の取得
        }
    }

    return $rtn;
}

/**
 * 最上位フォルダID取得関数
 *
 * $dirIdで指定されたフォルダが所属する
 * 最上位フォルダ(1階層目)のフォルダIDを
 * 取得する。
 *
 * @param integer $dirId フォルダID
 * @return integer $rtn 最上位フォルダID
 */
function searchTopParentDir($dirId) {
    global $dir_tbl; // $dir_tbl: dir_tbl.ini内で宣言
    $treeLevel;
    $parentId;;
    $rtn = "";

    /* フォルダデータテーブルから$dirIdで指定された
       フォルダの階層データと親フォルダIDを取得する */
    foreach ($dir_tbl as $key => $value) {
        if ($dir_tbl[$key][id] == $dirId) {
            $treeLevel = $dir_tbl[$key][tree_level]; // 階層データの取得
            $parentId = $dir_tbl[$key][parent_id]; // 親フォルダIDの取得
        }
    }

    // 階層データが1階層目だった場合
    if ($treeLevel == 1) {
        $rtn = $dirId;
    // 階層データが2階層目だった場合
    } else if ($treeLevel == 2) {
        $rtn = $parentId;
    // 階層データが3階層目だった場合
    } else {
        foreach ($dir_tbl as $key => $value) {
            if ($dir_tbl[$key][id] == $parentId) {
                $rtn = $dir_tbl[$key][parent_id];
            }
        }
    }

    return $rtn;
}

/**
 * 後方オフセット取得関数
 *
 * 受信メール一覧表示画面での現在の表示設定から
 * 後方オフセットが有効かどうかをチェックし、
 * 有効ならば正しい後方オフセットを返す。
 *
 * @param integer $offset 現在の表示オフセット
 * @param integer $viewCount 現在の表示件数
 * @return integer $rtn 後方オフセット(無効時はFALSE)
 */
function getBackOffset($offset, $viewCount) {
    // すでにオフセットが0の場合は問答無用でFALSEを返す
    if ($offset === 0 || $offset === "0") {
        $rtn = FALSE;
    // 現在のオフセット以前のメール件数が表示件数より多い場合
    } else if (($offset - $viewCount) >= 0) {
        $rtn = $offset - $viewCount;    // 後方オフセットをセット
    // 引きすぎてマイナスになってしまったら0を返す
    } else {
        $rtn = 0;
    }

    return $rtn;
}

/**
 * 前方オフセット取得関数
 *
 * 受信メール一覧表示画面での現在の表示設定から
 * 前方オフセットが有効かどうかをチェックし、
 * 有効ならば正しい前方オフセットを返す。
 *
 * @param integer $offset 現在の表示オフセット
 * @param integer $viewCount 現在の表示件数
 * @param integer $dirId 現在表示中のフォルダID
 * @param string $sQuery 絞り込み検索用SQLクエリ
 * @param object $dbObj DBオブジェクト
 * @return integer $rtn 前方オフセット(無効時はFALSE)
 */
function getNextOffset($offset, $viewCount, $dirId, $sQuery, &$db) {

    // 前方オフセットをセット
    $tmpOfs = $offset + $viewCount;

    if ($_REQUEST["search_py"] == "pay" || $_REQUEST["search_py"] == "no_pay" || $_REQUEST["search_se"] == "man" || $_REQUEST["search_se"] == "woman") {
        $table = "member_mst,info_mail";
        $clm = "info_mail.";
    } else {
        //$table = "info_mail";
        $table = "info_mail LEFT JOIN v_user_profile ON info_mail.user_id = v_user_profile.user_id" ;
        $clm = "";
    }

    // 指定された検索条件で正しくメールデータが取得できるかどうか、DBにSQLを発行して問い合わせる
    $sql = " SELECT {$clm}info_id"
         . " FROM " . $table
         . " WHERE {$clm}dir_id = " . $dirId
         . $sQuery
         . " LIMIT " . $tmpOfs . "," . $viewCount;
    $rs = $db->executeSql($sql, array());
    if ($rs->numRows() > 0) {
        return $tmpOfs;
    } else {
        return false;
    }
}

/**
 * リクエスト送信用タグ作成関数
 *
 * $keyAryで指定された$_REQUEST[キー名]のデータを、
 * リクエスト送信用のHTMLタグに変換してそのタグを返す。
 *
 * @param array $keyAry $_REQUESTより取得したいキー配列
 * @param string $getOrPost 作成したいタグ形式の指定
 * @return string $rtn リクエスト送信用タグ
 */
function makeRequestParam($keyAry, $getOrPost) {
    $tmp = array();
    $rtn = "";

    // GET送信用タグの生成
    if ($getOrPost == "get") {
        foreach ($keyAry as $value) {
            if (!empty($_REQUEST[$value])
                    || $_REQUEST[$value] === 0 || $_REQUEST[$value] === "0") {
                $tmp[] = "{$value}={$_REQUEST[$value]}";
            }
        }

        if (count($tmp)) { $rtn = implode("&", $tmp); }
    // POST送信用タグの生成
    } else if ($getOrPost == "post") {
        foreach ($keyAry as $value) {
            if (!empty($_REQUEST[$value])
                    || $_REQUEST[$value] === 0 || $_REQUEST[$value] === "0") {
                $rtn .= "<input type=\"hidden\" name=\"{$value}\" value=\"{$_REQUEST[$value]}\">\n";
            }
        }
    }

    return $rtn;
}
?>
