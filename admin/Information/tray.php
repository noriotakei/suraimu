<?php
/**
 * File Name:   tray.php
 *
 * Description: 受信メール一覧表示PHPファイル。
 *              フォルダ選択による表示メールデータの切り替えや、
 *              様々な検索条件の指定、並べ替えをすることもできる。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */
/*
 * PHP処理セクション
 */

for ($i = 0 ; $i < count($operator_tbl) ; $i++) {
    foreach ($operator_tbl[$i] as $key => $val) {
        $operator_tbl[$i][$key] = $val;
    }
}
//--------------------------------
// リクエスト送信データのチェック
//--------------------------------

// tray.phpを表示するには$_REQUEST[dir_id]が必須
if (empty($_REQUEST["dir_id"]) || !is_numeric($_REQUEST["dir_id"])) {
    print("表示できません");
    exit;
}

// 表示オフセットのチェック
if (empty($_REQUEST["offset"]) || !is_numeric($_REQUEST["offset"]) || $_REQUEST["offset"] < 0) {
    $_REQUEST["offset"] = 0;
}

// 表示件数のチェック
if (empty($_REQUEST["view_count"]) || !is_numeric($_REQUEST["view_count"]) || $_REQUEST["view_count"] > max($viewCounts)) {
    $_REQUEST["view_count"] = min($viewCounts); // $viewCounts: config.php内で宣言
}
//----------------------
// 検索条件クエリの生成
//----------------------

$searchQuery = "";
// 未読件数取得用クエリ
$unreadQuery = " AND info_mail.read_status = " . UNREAD_MAIL;
// 状態フラグ絞り
if (is_numeric($_REQUEST["search_rd"])) {
    $searchQuery.= " AND info_mail.read_status = " . $_REQUEST["search_rd"];
}
// メールアカウント絞り
if (!empty($_REQUEST["search_ac"]) && $_REQUEST["search_ac"] != "all") {
    $searchQuery.= " AND ("
                 . "   ("
                 . "    info_mail.read_status \!= " . TRANSMIT_DIR
//                 . "    AND info_mail.to_address LIKE " . htmlNET($_REQUEST["search_ac"] . "%", "sql")
                 . "    AND info_mail.to_address LIKE '" . $_REQUEST["search_ac"]."%'"
                 . "   )"
                 . "  OR"
                 . "   ("
                 . "    info_mail.read_status = " . TRANSMIT_DIR
//                 . "    AND info_mail.from_address LIKE " . htmlNET($_REQUEST["search_ac"] . "%", "sql")
                 . "    AND info_mail.from_address LIKE '" . $_REQUEST["search_ac"]."%'"
                 . "   )"
                 . " ) ";
    $unreadQuery.= " AND ("
                 . "   ("
                 . "    info_mail.read_status \!= " . TRANSMIT_DIR
//                 . "    AND info_mail.to_address LIKE " . htmlNET($_REQUEST["search_ac"] . "%", "sql")
                 . "    AND info_mail.to_address LIKE '" . $_REQUEST["search_ac"]."%'"
                 . "   )"
                 . "  OR "
                 . "   ("
                 . "    info_mail.read_status = " . TRANSMIT_DIR
//                 . "    AND info_mail.from_address LIKE " . htmlNET($_REQUEST["search_ac"] . "%", "sql")
                 . "    AND info_mail.from_address LIKE '" . $_REQUEST["search_ac"]."%'"
                 . "   )"
                 . " ) ";
}

// 送受信日時絞り
if ($_REQUEST["search_dt"] == "30m_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*30))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*30))."' ";
} else if ($_REQUEST["search_dt"] == "1h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*1))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*1))."' ";
} else if ($_REQUEST["search_dt"] == "3h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*3))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*3))."' ";
} else if ($_REQUEST["search_dt"] == "6h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*6))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*6))."' ";
} else if ($_REQUEST["search_dt"] == "12h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*12))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*12))."' ";
} else if ($_REQUEST["search_dt"] == "24h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*24*1))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*24*1))."' ";
} else if ($_REQUEST["search_dt"] == "48h_before") {
    $searchQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*24*2))."' ";
    $unreadQuery.= " AND info_mail.received_date >= '".date("Y-m-d H:i:s", time()-(60*60*24*2))."' ";
}

// 担当者絞り
if (is_numeric($_REQUEST["search_op"])) {
    $searchQuery.= " AND info_mail.operator_id = {$_REQUEST[search_op]} ";
    $unreadQuery.= " AND info_mail.operator_id = {$_REQUEST[search_op]} ";
}
// 対応フラグ絞り
if (is_numeric($_REQUEST["search_rp"])) {
    $searchQuery.= " AND info_mail.reply_status = {$_REQUEST[search_rp]} ";
    $unreadQuery.= " AND info_mail.reply_status = {$_REQUEST[search_rp]} ";
}
//登録状態
if ($_REQUEST["search_regist_status"] != "") {
    if($_REQUEST["search_regist_status"] == 99){
        $searchQuery .= " AND info_mail.user_id = 0 " ;
        $unreadQuery .= " AND info_mail.user_id = 0 " ;
    }else{
        $searchQuery .= " AND v_user_profile.regist_status = ".$_REQUEST["search_regist_status"]." " ;
        $unreadQuery .= " AND v_user_profile.regist_status = ".$_REQUEST["search_regist_status"]." " ;
    }
}
//入金状態
if ($_REQUEST["search_trade_status"] != "") {
    if($_REQUEST["search_trade_status"] == 1){
        $addStr = ">=" ;
    } else {
        $addStr = "=" ;
    }
    $searchQuery .= " AND v_user_profile.total_payment ".$addStr.$_REQUEST["search_trade_status"]." " ;
    $unreadQuery .= " AND v_user_profile.total_payment ".$addStr.$_REQUEST["search_trade_status"]." " ;

}
// 本文文言絞り
if ($_REQUEST["search_body"]) {
    $_REQUEST["search_body"] = mb_ereg_replace("　", " ", $_REQUEST["search_body"]);
    $serch_body_array = explode(" ", $_REQUEST["search_body"]);

    foreach($serch_body_array as $value){
        $searchQuery.= " AND info_mail.body like '%".$value."%' ";
        $unreadQuery.= " AND info_mail.body like '%".$value."%' ";
    }
}
/*
// 男性・女性絞り
if ($_REQUEST[search_se] == "man") {
    $searchQuery .= "AND info_mail.user_id = member_mst.id AND member_mst.sex_cd = 2 ";
    $unreadQuery .= "AND info_mail.user_id = member_mst.id AND member_mst.sex_cd = 2 ";
} else if ($_REQUEST[search_se] == "woman") {
    $searchQuery .= "AND info_mail.user_id = member_mst.id AND member_mst.sex_cd = 1 ";
    $unreadQuery .= "AND info_mail.user_id = member_mst.id AND member_mst.sex_cd = 1 ";
}
*/
//検索フォームからの条件
if ($_REQUEST["src"]) {
    //検索ディレクトリの設定
    if($_REQUEST["sub_dir"]){
        foreach ($dir_tbl as $value_dir) {
            if ($value_dir[id] == $_REQUEST["dir_id"]) {
                $dir_id = $_REQUEST["dir_id"];
                break;
            }
        }
        foreach ($dir_tbl as $value_dir) {
            if ($value_dir["parent_id"] == $dir_id) {
                $dirQuery .= "," . $value_dir["id"];
                $temp_dir_id = $value_dir["id"];
            }
            if ($value_dir["parent_id"] == $temp_dir_id) {
                $dirQuery .= "," . $value_dir["id"];
            }
        }
    }

    //指定日以降
    if ($_REQUEST["src_rcv_date_from"]) {
        $src_date_f_y = sprintf("%04d", $_REQUEST["rcv_date_from_y"]);
        $src_date_f_m = sprintf("%02d", $_REQUEST["rcv_date_from_m"]);
        $src_date_f_d = sprintf("%02d", $_REQUEST["rcv_date_from_d"]);
        $src_date_f_h = sprintf("%02d", $_REQUEST["rcv_date_from_h"]);
        $src_date_f_i = sprintf("%02d", $_REQUEST["rcv_date_from_i"]);
        $src_date_f_s = sprintf("%02d", $_REQUEST["rcv_date_from_s"]);

        if (!checkdate($src_date_f_m,$src_date_f_d,$src_date_f_y)) {
            die("検索用の日付がおかしいです。1");
        }

        if ((0 > $src_date_f_h && $src_date_f_h > 23) || (0 > $src_date_f_i && $src_date_f_i > 59) || (0 > $src_date_f_s && $src_date_f_s > 59)) {
            die("検索用の時間がおかしいです。1");
        }

        $src_date_f = $src_date_f_y . $src_date_f_m . $src_date_f_d . $src_date_f_h . $src_date_f_i . $src_date_f_s;

        $searchQuery .= " AND info_mail.received_date >= " . $src_date_f . " ";
        $unreadQuery .= " AND info_mail.received_date >= " . $src_date_f . " ";
    }

    //指定日以前
    if ($_REQUEST["src_rcv_date_to"]) {
        $src_date_t_y = sprintf("%04d", $_REQUEST["rcv_date_to_y"]);
        $src_date_t_m = sprintf("%02d", $_REQUEST["rcv_date_to_m"]);
        $src_date_t_d = sprintf("%02d", $_REQUEST["rcv_date_to_d"]);
        $src_date_t_h = sprintf("%02d", $_REQUEST["rcv_date_to_h"]);
        $src_date_t_i = sprintf("%02d", $_REQUEST["rcv_date_to_i"]);
        $src_date_t_s = sprintf("%02d", $_REQUEST["rcv_date_to_s"]);

        if (!checkdate($src_date_t_m,$src_date_t_d,$src_date_t_y)) {
            die("検索用の日付がおかしいです。2");
        }

        if ((0 > $src_date_t_h && $src_date_t_h > 23) || (0 > $src_date_t_i && $src_date_t_i > 59) || (0 > $src_date_t_s && $src_date_t_s > 59)) {
            die("検索用の時間がおかしいです。2");
        }

        $src_date_t = $src_date_t_y . $src_date_t_m . $src_date_t_d . $src_date_t_h . $src_date_t_i . $src_date_t_s;

        $searchQuery .= " AND info_mail.received_date <= " . $src_date_t . " ";
        $unreadQuery .= " AND info_mail.received_date <= " . $src_date_t . " ";
    }

    $temp_searchQuery = $searchQuery;
    $temp_unreadQuery = $unreadQuery;

    $union_cnt = 0;
    //送信者アドレス
    if (strlen($_REQUEST["src_from_address"]) > 0) {
        //ここまでのwhere句を格納
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND info_mail.from_address like '%{$_REQUEST['src_from_address']}%' ";
            $unreadunionQuery[$union_cnt]   = $temp_unreadQuery . " AND info_mail.from_address like '%{$_REQUEST['src_from_address']}%' ";
            $union_cnt++;
        } else {
            $searchQuery .= " AND info_mail.from_address like '%{$_REQUEST['src_from_address']}%' ";
            $unreadQuery .= " AND info_mail.from_address like '%{$_REQUEST['src_from_address']}%' ";
        }
    }

    //送信者名
    if (strlen($_REQUEST["src_from_name"]) > 0) {
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND info_mail.from_name like '%{$_REQUEST['src_from_name']}%' ";
            $unreadunionQuery[$union_cnt]   = $temp_unreadQuery . " AND info_mail.from_name like '%{$_REQUEST['src_from_name']}%' ";
            $union_cnt++;
        } else {
            $searchQuery .= " AND info_mail.from_name like '%{$_REQUEST['src_from_name']}%' ";
            $unreadQuery .= " AND info_mail.from_name like '%{$_REQUEST['src_from_name']}%' ";
        }
    }

    //宛先
    if (strlen($_REQUEST["src_to_address"]) > 0) {
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND info_mail.to_address like '%{$_REQUEST['src_to_address']}%' ";
            $unreadunionQuery[$union_cnt]   = $temp_unreadQuery . " AND info_mail.to_address like '%{$_REQUEST['src_to_address']}%' ";
            $union_cnt++;
        } else {
            $searchQuery .= " AND info_mail.to_address like '%{$_REQUEST['src_to_address']}%' ";
            $unreadQuery .= " AND info_mail.to_address like '%{$_REQUEST['src_to_address']}%' ";
        }
    }

    //件名
    if (strlen($_REQUEST["src_subject"]) > 0) {
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND info_mail.subject like '%{$_REQUEST['src_subject']}%' ";
            $unreadunionQuery[$union_cnt]   = $temp_unreadQuery . " AND info_mail.subject like '%{$_REQUEST['src_subject']}%' ";
            $union_cnt++;
        } else {
            $searchQuery .= " AND info_mail.subject like '%{$_REQUEST['src_subject']}%' ";
            $unreadQuery .= " AND info_mail.subject like '%{$_REQUEST['src_subject']}%' ";
        }
    }

    //本文
    if (strlen($_REQUEST["src_body"]) > 0) {
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND info_mail.body like '%{$_REQUEST['src_body']}%' ";
            $unreadunionQuery[$union_cnt]   = $temp_unreadQuery . " AND info_mail.body like '%{$_REQUEST['src_body']}%' ";
            $union_cnt++;
        } else {
            $searchQuery .= " AND info_mail.body like '%{$_REQUEST['src_body']}%' ";
            $unreadQuery .= " AND info_mail.body like '%{$_REQUEST['src_body']}%' ";
        }
    }

    //登録状態
    if ($_REQUEST["src_regist_status"] !== "") {
        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND v_user_profile.regist_status = ".$_REQUEST["src_regist_status"]." " ;
            $unreadunionQuery[$union_cnt]   = $temp_searchQuery . " AND v_user_profile.regist_status = ".$_REQUEST["src_regist_status"]." " ;
            $union_cnt++;
        } else {
            $searchQuery .= $temp_searchQuery . " AND v_user_profile.regist_status = ".$_REQUEST["src_regist_status"]." " ;
            $unreadQuery .= $temp_searchQuery . " AND v_user_profile.regist_status = ".$_REQUEST["src_regist_status"]." " ;
        }
    }

    //入金状態
    if ($_REQUEST["src_trade_status"] !== "") {

        if($_REQUEST["src_trade_status"] == 1){
            $addStr = ">=" ;
        } else {
            $addStr = "=" ;
        }

        //AND検索かOR検索か
        if ($_REQUEST["src_method"]) {
            $unionQuery[$union_cnt]         = $temp_searchQuery . " AND v_user_profile.total_payment ".$addStr.$_REQUEST["src_trade_status"]." " ;
            $unreadunionQuery[$union_cnt]   = $temp_searchQuery . " AND v_user_profile.total_payment ".$addStr.$_REQUEST["src_trade_status"]." " ;
            $union_cnt++;
        } else {
            $searchQuery .= $temp_searchQuery . " AND v_user_profile.total_payment ".$addStr.$_REQUEST["src_trade_status"]." " ;
            $unreadQuery .= $temp_searchQuery . " AND v_user_profile.total_payment ".$addStr.$_REQUEST["src_trade_status"]." " ;
        }
    }

    //検索から来たようにタグ作成
    $src_tag  = "<input type=\"hidden\" name=\"src\" value=\"1\">\n"
        . "<input type=\"hidden\" name=\"sub_dir\" value=\"" . $_REQUEST["sub_dir"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_from_address\" value=\"" . $_REQUEST["src_from_address"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_from_name\" value=\"" . $_REQUEST["src_from_name"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_to_address\" value=\"" . $_REQUEST["src_to_address"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_subject\" value=\"" . $_REQUEST["src_subject"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_body\" value=\"" . $_REQUEST["src_body"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_rcv_date_from\" value=\"" . $_REQUEST["src_rcv_date_from"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_rcv_date_to\" value=\"" . $_REQUEST["src_rcv_date_to"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_y\" value=\"" . $_REQUEST["rcv_date_from_y"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_m\" value=\"" . $_REQUEST["rcv_date_from_m"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_d\" value=\"" . $_REQUEST["rcv_date_from_d"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_h\" value=\"" . $_REQUEST["rcv_date_from_h"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_i\" value=\"" . $_REQUEST["rcv_date_from_i"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_from_s\" value=\"" . $_REQUEST["rcv_date_from_s"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_y\" value=\"" . $_REQUEST["rcv_date_to_y"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_m\" value=\"" . $_REQUEST["rcv_date_to_m"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_d\" value=\"" . $_REQUEST["rcv_date_to_d"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_h\" value=\"" . $_REQUEST["rcv_date_to_h"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_i\" value=\"" . $_REQUEST["rcv_date_to_i"] . "\">\n"
        . "<input type=\"hidden\" name=\"rcv_date_to_s\" value=\"" . $_REQUEST["rcv_date_to_s"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_regist_status\" value=\"" . $_REQUEST["src_regist_status"] . "\">\n"
        . "<input type=\"hidden\" name=\"src_trade_status\" value=\"" . $_REQUEST["src_trade_status"] . "\">\n";

    //検索から来たようにクエリストリング作成
    $src_string  = "&src=1"
        . "&sub_dir=" . $_REQUEST["sub_dir"]
        . "&src_from_address=" . $_REQUEST["src_from_address"]
        . "&src_from_name=" . $_REQUEST["src_from_name"]
        . "&src_to_address=" . $_REQUEST["src_to_address"]
        . "&rc_subject=" . $_REQUEST["src_subject"]
        . "&src_body=" . $_REQUEST["src_body"]
        . "&src_rcv_date_from=" . $_REQUEST["src_rcv_date_from"]
        . "&src_rcv_date_to=" . $_REQUEST["src_rcv_date_to"]
        . "&rcv_date_from_y=" . $_REQUEST["rcv_date_from_y"]
        . "&rcv_date_from_m=" . $_REQUEST["rcv_date_from_m"]
        . "&rcv_date_from_d=" . $_REQUEST["rcv_date_from_d"]
        . "&rcv_date_from_h=" . $_REQUEST["rcv_date_from_h"]
        . "&rcv_date_from_i=" . $_REQUEST["rcv_date_from_i"]
        . "&rcv_date_from_s=" . $_REQUEST["rcv_date_from_s"]
        . "&rcv_date_to_y=" . $_REQUEST["rcv_date_to_y"]
        . "&rcv_date_to_m=" . $_REQUEST["rcv_date_to_m"]
        . "&rcv_date_to_d=" . $_REQUEST["rcv_date_to_d"]
        . "&rcv_date_to_h=" . $_REQUEST["rcv_date_to_h"]
        . "&rcv_date_to_i=" . $_REQUEST["rcv_date_to_i"]
        . "&rcv_date_to_s=" . $_REQUEST["rcv_date_to_s"]
        . "&src_regist_status=" . $_REQUEST["src_regist_status"]
        . "&src_trade_status=" . $_REQUEST["src_trade_status"];
}

//--------------------------
// 並べ替え設定クエリの生成
//--------------------------

// 以下の変数は並べ替え条件指定用タグの生成時に必要
$hrefStrRd = "rd_asc"; // 状態フラグ(昇順)
$hrefStrSj = "sj_asc"; // 件名(昇順)
$hrefStrFm = "bd_asc"; // 本文(昇順)
$hrefStrFm = "fm_asc"; // 送信者(昇順)
$hrefStrTo = "to_asc"; // 宛先(昇順)
$hrefStrDt = "dt_asc"; // 送受信日時(昇順)
$hrefStrOp = "op_asc"; // 担当者(昇順)
$hrefStrRp = "rp_asc"; // 対応状況(昇順)
$hrefStrSt = "st_asc"; // ステータス(昇順)

// 並べ替えのデフォルトは送受信日時(降順)
$orderQuery = "received_date DESC";
// $_REQUEST[order]によって並べ替えを変更する
switch ($_REQUEST["order"]) {
    case "rd_asc": // 状態フラグ(昇順)
        $orderQuery = "info_mail.read_status"; $hrefStrRd = "rd_dsc";
        break;
    case "rd_dsc": // 状態フラグ(降順)
        $orderQuery = "info_mail.read_status DESC";
        break;
    case "sj_asc": // 件名(昇順)
        $orderQuery = "info_mail.subject"; $hrefStrSj = "sj_dsc";
        break;
    case "sj_dsc": // 件名(降順)
        $orderQuery = "info_mail.subject DESC";
        break;
    case "bd_asc": // 本文(昇順)
        $orderQuery = "info_mail.body"; $hrefStrFm = "bd_dsc";
        break;
    case "bd_dsc": // 本文(降順)
        $orderQuery = "info_mail.body DESC";
        break;
    case "fm_asc": // 送信者(昇順)
        $orderQuery = "info_mail.from_name"; $hrefStrFm = "fm_dsc";
        break;
    case "fm_dsc": // 送信者(降順)
        $orderQuery = "info_mail.from_name DESC";
        break;
    case "to_asc": // 宛先(昇順)
        $orderQuery = "info_mail.to_address"; $hrefStrTo = "to_dsc";
        break;
    case "to_dsc": // 宛先(降順)
        $orderQuery = "info_mail.to_address DESC";
        break;
    case "dt_asc": // 送受信日時(昇順)
        $orderQuery = "info_mail.received_date"; $hrefStrDt = "dt_dsc";
        break;
    case "dt_dsc": // 送受信日時(降順)
        $orderQuery = "info_mail.received_date DESC";
        break;
    case "op_asc": // 担当者(昇順)
        $orderQuery = "info_mail.operator_id"; $hrefStrOp = "op_dsc";
        break;
    case "op_dsc": // 担当者(降順)
        $orderQuery = "info_mail.operator_id DESC";
        break;
    case "rp_asc": // 対応状況(昇順)
        $orderQuery = "info_mail.reply_status"; $hrefStrRp = "rp_dsc";
        break;
    case "rp_dsc": // 対応状況(降順)
        $orderQuery = "info_mail.reply_status DESC";
        break;
    case "st_asc": // 対応状況(昇順)
        $orderQuery = "v_user_profile.regist_status"; $hrefStrSt = "st_dsc";
        break;
    case "st_dsc": // 対応状況(降順)
        $orderQuery = "v_user_profile.regist_status DESC";
        break;
}

//------------------------
// 表示メールデータの取得
//------------------------

$table = "info_mail LEFT JOIN " . $site["user_table"] . " ON info_mail.user_id = v_user_profile." . $site["user_table_key"] ;
/* $_REQUEST[dir_id]で指定されたメールフォルダに
   振り分けられているメールのデータをDBから取得する */
$sql = " SELECT info_mail.info_id,"
     . "        info_mail.header,"
     . "        info_mail.from_name,"
     . "        SUBSTRING(from_name,1,LOCATE('@',from_name)) as from_name_no_domain,"
     . "        info_mail.to_address,"
     . "        info_mail.subject,"
     . "        info_mail.body,"
     . "        info_mail.received_date,"
     . "        info_mail.read_status,"
     . "        info_mail.reply_status,"
     . "        info_mail.operator_id,"
     . "        info_mail.user_id , "
     . "        v_user_profile.regist_status,  "
     . "        v_user_profile.total_payment,  "
     . "        v_user_profile.media_cd  "
     . " FROM " . $table
     . " WHERE info_mail.dir_id in (" . $_REQUEST["dir_id"] . $dirQuery . ")"
     . $searchQuery
     . " ORDER BY ". $orderQuery
     . " LIMIT ". $_REQUEST["offset"] . "," . $_REQUEST["view_count"];
$rs  = $db->executeSql($sql, array());
$recCnt = $rs->numRows($rs);
$infoMail = array();
if ($recCnt > 0) {
    //for ($i = 0 ; $i < $recCnt ; $i++) {
    while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {

        // DBから取得したメール情報を1件ずつオブジェクト配列に格納する
        $infoMail[$i] = new InfoMail($array, $conn);

        // 件名が空だった場合(DB格納時、&nbsp;が末尾に自動追加されるようになっているので)
        if (trim($infoMail[$i]->subject) == "&nbsp;") {
            $infoMail[$i]->subject = "[件名なし]";
        }
        $subject[$i] = str_replace("&nbsp;", "", $infoMail[$i]->subject);

        if ($infoMail[$i]->userId) {
            $user_id[$i] = $infoMail[$i]->userId;
            $user_id_regist_only[$i] = $infoMail[$i]->userId;
        }else{
            $user_id[$i] = "登録なし";
        }

        //アドレス表示制限
        if(!($loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_SYSTEM"]
                OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_MANAGE"]
                OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_INFORMATION"]
                OR $loginAdminData["authority_type"] == $define["define"]["AUTHORITY_TYPE_OPERATOR"])){
            $infoMail[$i]->fromName = "<アドレス非表示>";
        }

        $i++;
    }
} else {
    print("<strong>".getDirName($_REQUEST["dir_id"])."</strong>\n<hr>\nメールデータはありません");
    exit;
}

if (count($user_id_regist_only) > 0) {
    $sql_mail = "select user_id ,pc_address, pc_address_status, mb_address, mb_address_status from v_user_profile where user_id in (" . implode(",", $user_id_regist_only) . ")";
    if ($rs = $db->executeSql($sql_mail)) {
        while ($data_mail = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {

            if (!$data_mail["pc_address"]) {
                $usermail_status = false;
            } else {
                switch ($data_mail["pc_address_status"]) {
                    case ADDRESS_STATUS_DO :
                        $usermail_status = "する";
                        break;
                    case ADDRESS_STATUS_NO_ADDR :
                    case ADDRESS_STATUS_REFUSAL :
                    case ADDRESS_STATUS_NO_DOMAIN :
                    case ADDRESS_STATUS_FAIL_AUTO :
                    case ADDRESS_STATUS_TIME_OUT :

                        $usermail_status = "(自動)";
                        break;
                    default:
                        $usermail_status = "システムへ連絡";
                        break;
                }
            }

            if (!$data_mail["mb_address"]) {
                $mobilemail_status = false;
            } else {
                switch ($data_mail["mb_address_status"]) {
                    case ADDRESS_STATUS_DO :
                        $mobilemail_status = "する";
                        break;
                    case ADDRESS_STATUS_NO_ADDR :
                    case ADDRESS_STATUS_REFUSAL :
                    case ADDRESS_STATUS_NO_DOMAIN :
                    case ADDRESS_STATUS_FAIL_AUTO :
                    case ADDRESS_STATUS_TIME_OUT :
                        $mobilemail_status = "(自動)";
                        break;
                    default:
                        $usermail_status = "システムへ連絡";
                        break;
                }
            }

            $user_mail_status_array[$data_mail["user_id"]]   =$usermail_status;
            $mobilemail_status_array[$data_mail["user_id"]]  = $mobilemail_status;
        }
    }
}

//----------------
// 各種変数の設定
//----------------

// 全メール件数の取得
$sql = " SELECT COUNT(*) AS cnt"
     . " FROM ". $table
     . " WHERE info_mail.dir_id = ". $_REQUEST["dir_id"]
     . $searchQuery;
$rs = $db->executeSql($sql, array());
$array = array();
$array = $rs->fetchRow(DB_FETCHMODE_ASSOC);
$total = $array["cnt"];

// 未読メール件数の取得
if (empty($_REQUEST["search_rd"]) || $_REQUEST["search_rd"] == "all" || $_REQUEST["search_rd"] == UNREAD_MAIL) {
    $sql = "SELECT COUNT(*) AS cnt"
         . " FROM " . $table
         . " WHERE info_mail.dir_id in (" . $_REQUEST["dir_id"] . $dirQuery . ")"
         . $unreadQuery;
    $rs = $db->executeSql($sql, array());
    $array  = $rs->fetchRow(DB_FETCHMODE_ASSOC);
    $unread = $array["cnt"];
} else {
    // 未読メール以外で検索絞りをかけている場合は0件に
    $unread = 0;
}

// メールフォルダ名の取得
$dirName = getDirName($_REQUEST["dir_id"]);

// 現在表示しているフォルダが所属する最上位フォルダを取得する
$topParentDir = searchTopParentDir($_REQUEST["dir_id"]);

// 表示設定引継ぎ用のパラメータ文字列の生成
$viewSettingParamG = "&" . makeRequestParam(array('offset', 'view_count'), 'get');    // GET送信用
$viewSettingParamP = makeRequestParam(array('offset', 'view_count'), 'post');       // POST送信用

// 絞り込み設定引継ぎ用のパラメータ文字列の生成
$keys = array('search_rd', 'search_ac', 'search_dm', 'search_dt', 'search_op', 'search_rp', 'search_py', 'search_se');
$searchParamG = makeRequestParam($keys, 'get');
if ($searchParamG != "") {
    $searchParamG = "&".$searchParamG;
}
$searchParamP = makeRequestParam($keys, 'post');

$orderParamG = makeRequestParam(array('order'), 'get');
if ($orderParamG != "") {
    $orderParamG = "&".$orderParamG;
}
$orderParamP = makeRequestParam(array('order'), 'post');

// メール一覧表示オフセットを取得する
$backOffset = getBackOffset($_REQUEST["offset"], $_REQUEST["view_count"]);
$nextOffset = getNextOffset($_REQUEST["offset"], $_REQUEST["view_count"], $_REQUEST["dir_id"], $searchQuery, $db);
//--------------------------
// フォーム表示用タグの生成
//--------------------------

// 表示件数選択タグの生成
$valueStr = "Information.php?do=tray"
          . "&dir_id=" . $_REQUEST["dir_id"]
          . "&offset=" . $_REQUEST["offset"]
          . "&view_count=";
$viewCountOpt = "";
foreach ($viewCounts as $key => $value) { // $viewCounts: config.php内で宣言
    if ($_REQUEST["view_count"] == $viewCounts[$key]) {
        $isSelected = " selected";
    } else {
        $isSelected = "";
    }
    $viewCountOpt.= "<option value=\"{$valueStr}{$viewCounts[$key]}{$searchParamG}{$orderParamG}{$src_string}\"{$isSelected}>{$viewCounts[$key]}件ずつ表示</option>\n";
}

// 一括処理選択タグの生成
$procOpt = "";
if ($topParentDir == RECEIVE_DIR || $topParentDir == KEEP_DIR) {
    $procOpt .= "<option value=\"reply_all\">まとめて返信</option>\n"
              . "<option value=\"delete_all\">まとめて削除</option>\n"
              . "<option value=\"keep_all\">まとめて保存</option>\n"
              . "<option value=\"move_all\">まとめて移動</option>\n"
              . "<option value=\"already_all\">まとめて対応済み</option>\n"
              . "<option value=\"stop_status_all\">まとめて配信停止</option>\n"
              . "<option value=\"stop_all\">まとめて配信停止ステータスのみ</option>\n"
              . "<option value=\"taikai_all\">まとめて退会</option>\n"
              . "<option value=\"retire_all\">まとめて退会ステータスのみ</option>\n"
              . "<option value=\"danger_stauts_all\">まとめてブラック</option>\n"
              . "<option value=\"danger_all\">まとめてブラックステータスのみ</option>\n";

} else if ($topParentDir == TRANSMIT_DIR) {
    $procOpt .= "<option value=\"delete_all\">まとめて削除</option>\n"
              . "<option value=\"move_all\">まとめて移動</option>\n";
} else {
    $procOpt .= "<option value=\"delete_all\">まとめて完全削除</option>\n"
              . "<option value=\"move_all\">まとめて移動</option>\n"
              . "<option value=\"delete_all_folder\">削除済みフォルダを空にする</option>\n";
}

// 移動先フォルダ選択タグの生成
$dirIdOpt = "";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($dir_tbl[$key]["tree_level"] == 1 && !($_REQUEST["dir_id"] == DELETE_DIR && $dir_tbl[$key]["id"] == DELETE_DIR)) {
        // 削除済みフォルダから削除済みフォルダへの移動選択はできない
        $dirIdOpt .= "<option value=\"{$dir_tbl[$key][id]}\">{$dir_tbl[$key][name]}</option>\n";

        foreach ($dir_tbl as $key2 => $value2) {
            // 2階層目フォルダデータの取得
            if ($dir_tbl[$key2]["tree_level"] == 2 && $dir_tbl[$key2]["parent_id"] == $dir_tbl[$key]["id"]) {
                // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                $dirIdOpt .= "<option value=\"{$dir_tbl[$key2][id]}\">　+{$dir_tbl[$key2][name]}</option>\n";

                foreach ($dir_tbl as $key3 => $value3) {
                    // 3階層目フォルダデータの取得
                    if ($dir_tbl[$key3]["tree_level"] == 3 && $dir_tbl[$key3]["parent_id"] == $dir_tbl[$key2]["id"]) {
                        // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        $dirIdOpt .= "<option value=\"{$dir_tbl[$key3][id]}\">　　+{$dir_tbl[$key3][name]}</option>\n";
                    }
                }
            }
        }
    }
}

// 検索条件指定用タグの生成(状態フラグ)
$searchRdOpt = "";
if ($_REQUEST["search_rd"] == "all" || empty($_REQUEST["search_rd"])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRdOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
if (intval($_REQUEST["search_rd"]) == UNREAD_MAIL) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRdOpt .= "<option value=\"".UNREAD_MAIL."\"{$isSelected}>未読</option>\n";
if (intval($_REQUEST["search_rd"]) == READED_MAIL) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRdOpt .= "<option value=\"".READED_MAIL."\"{$isSelected}>既読</option>\n";
if (intval($_REQUEST["search_rd"]) == TRANSMITTED_MAIL) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRdOpt .= "<option value=\"".TRANSMITTED_MAIL."\"{$isSelected}>送信</option>\n";

// 検索条件指定用タグの生成(メールアカウント)
$searchAcOpt = "";
if ($_REQUEST["search_ac"] == "all" || empty($_REQUEST["search_ac"])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchAcOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
foreach ($mailAccounts as $key => $value) {
    if ($_REQUEST["search_ac"] == $value) { $isSelected = " selected"; } else { $isSelected = ""; }
    $searchAcOpt .= "<option value=\"{$value}\"{$isSelected}>{$value}</option>\n";
}

// 検索条件指定用タグの生成(サイトドメイン)
$searchDmOpt = "";
if ($_REQUEST["search_dm"] == "all" || (empty($_REQUEST["search_dm"]) && $_REQUEST["search_dm"] != "0"))
    { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDmOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
/*
foreach ($site_ary as $key => $value) {
    if ($_REQUEST[search_dm] == "{$key}") { $isSelected = " selected"; } else { $isSelected = ""; }
    $searchDmOpt .= "<option value=\"{$key}\"{$isSelected}>{$site_ary[$key][1]}</option>\n";
}
*/
// 検索条件指定用タグの生成(送受信日時)
$searchDtOpt = "";
if ($_REQUEST["search_dt"] == "all" || empty($_REQUEST["search_dt"])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
if ($_REQUEST["search_dt"] == "30m_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"30m_before\"{$isSelected}>30分前まで</option>\n";
if ($_REQUEST["search_dt"] == "1h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"1h_before\"{$isSelected}>1時間前まで</option>\n";
if ($_REQUEST["search_dt"] == "3h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"3h_before\"{$isSelected}>3時間前まで</option>\n";
if ($_REQUEST["search_dt"] == "6h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"6h_before\"{$isSelected}>6時間前まで</option>\n";
if ($_REQUEST["search_dt"] == "12h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"12h_before\"{$isSelected}>12時間前まで</option>\n";
if ($_REQUEST["search_dt"] == "24h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"24h_before\"{$isSelected}>24時間前まで</option>\n";
if ($_REQUEST["search_dt"] == "48h_before") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchDtOpt .= "<option value=\"48h_before\"{$isSelected}>48時間前まで</option>\n";

// 検索条件指定用タグの生成(担当者)
$searchOpOpt = "";
if ($_REQUEST["search_op"] == "all" || empty($_REQUEST["search_op"])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchOpOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
if ($_REQUEST["search_op"] == strval(NOT_DEFINED)) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchOpOpt .= "<option value=\"".NOT_DEFINED."\"{$isSelected}>未設定</option>\n";
foreach ($operator_tbl as $key => $value) {
    if ($operator_tbl[$key]["is_display"] == DISPLAY) {
        if (intval($_REQUEST["search_op"]) == $operator_tbl[$key]["id"]) { $isSelected = " selected"; } else { $isSelected = ""; }
            $searchOpOpt .= "<option value=\"{$operator_tbl[$key][id]}\"{$isSelected}>{$operator_tbl[$key][name]}</option>\n";
    }
}

// 検索条件指定用タグの生成(対応状況)
$searchRpOpt = "";
if ($_REQUEST["search_rp"] == "all" || empty($_REQUEST["search_rp"])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRpOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
if (intval($_REQUEST["search_rp"]) == NOT_REPLIED) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRpOpt .= "<option value=\"".NOT_REPLIED."\"{$isSelected}>未対応</option>\n";
if (intval($_REQUEST["search_rp"]) == NOW_REPLING) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRpOpt .= "<option value=\"".NOW_REPLING."\"{$isSelected}>対応中</option>\n";
if (intval($_REQUEST["search_rp"]) == ALREADY_REPLIED) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRpOpt .= "<option value=\"".ALREADY_REPLIED."\"{$isSelected}>対応済</option>\n";
if (intval($_REQUEST["search_rp"]) == IGNORED) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchRpOpt .= "<option value=\"".IGNORED."\"{$isSelected}>無視</option>\n";

/*
// 検索条件指定用タグの生成(男・女)
$searchSeOpt = "";
if ($_REQUEST[search_se] == "all" || empty($_REQUEST[search_se])) { $isSelected = " selected"; } else { $isSelected = ""; }
$searchSeOpt .= "<option value=\"all\"{$isSelected}>すべて</option>\n";
if ($_REQUEST[search_se] == "man") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchSeOpt .= "<option value=\"man\"{$isSelected}>男性</option>\n";
if ($_REQUEST[search_se] == "woman") { $isSelected = " selected"; } else { $isSelected = ""; }
$searchSeOpt .= "<option value=\"woman\"{$isSelected}>女性</option>\n";
*/

// 検索条件指定用タグの生成(登録状態)
$selectedForAllMember == "" ;
$selectedForPreMember = "" ;
$selectedForMember = "" ;
$selectedForMemberQuit = "" ;
if($_REQUEST["search_regist_status"] == ""){
    $selectedForAllMember = "selected" ;
}else if($_REQUEST["search_regist_status"] == $define["define"]["USER_REGIST_STATUS_PRE_MEMBER"]){
    $selectedForPreMember = "selected" ;
}else if($_REQUEST["search_regist_status"] == $define["define"]["USER_REGIST_STATUS_MEMBER"]){
    $selectedForMember = "selected" ;
}else if($_REQUEST["search_regist_status"] == $define["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]){
    $selectedForMemberQuit = "selected" ;
}else if($_REQUEST["search_regist_status"] ==99){
    $selectedForUnMember = "selected" ;
}
$searchRegistStatusOpt = "";
$searchRegistStatusOpt .= "<option value='' {$selectedForAllMember}>気にしない</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_PRE_MEMBER"]."' {$selectedForPreMember}>仮登録</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_MEMBER"]."' {$selectedForMember}>本登録</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]."' {$selectedForMemberQuit}>会員解除</option>\n";
$searchRegistStatusOpt .= "<option value='99' {$selectedForUnMember}>非会員</option>\n";

// 検索条件指定用タグの生成(入金状態)
$selectedForAllTrade == "" ;
$selectedForNotTrade = "" ;
$selectedForTrade = "" ;
if($_REQUEST["search_trade_status"] == ""){
    $selectedForAllTrade = "selected" ;
}else if($_REQUEST["search_trade_status"] == 0){
    $selectedForNotTrade = "selected" ;
}else if($_REQUEST["search_trade_status"] == 1){
    $selectedForTrade = "selected" ;
}
$searchTradeStatusOpt = "";
$searchTradeStatusOpt .= "<option value='' {$selectedForAllTrade}>気にしない</option>\n";
$searchTradeStatusOpt .= "<option value='0' {$selectedForNotTrade}>入金無し</option>\n";
$searchTradeStatusOpt .= "<option value='1' {$selectedForTrade}>入金有り</option>\n";


// 並べ替え条件指定用タグの生成
$hrefStr = "Information.php?do=tray&dir_id={$_REQUEST[dir_id]}&order=";
$hrefStrRd = $hrefStr.$hrefStrRd.$src_string; // 状態フラグ
$hrefStrSj = $hrefStr.$hrefStrSj.$src_string; // 件名
$hrefStrBd = $hrefStr.$hrefStrBd.$src_string; // 本文
$hrefStrFm = $hrefStr.$hrefStrFm.$src_string; // 送信者
$hrefStrTo = $hrefStr.$hrefStrTo.$src_string; // 宛先
$hrefStrDt = $hrefStr.$hrefStrDt.$src_string; // 送受信日時
$hrefStrOp = $hrefStr.$hrefStrOp.$src_string; // 担当者
$hrefStrRp = $hrefStr.$hrefStrRp.$src_string; // 対応状況
$hrefStrSt = $hrefStr.$hrefStrSt.$src_string; // ステータス
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php // JavaScript定義 ?>
<script language="Javascript" type="text/javascript">
<!--
function update(sel) {
    if (sel.options[sel.selectedIndex].value != "noselect") {
        location.href = sel.options[sel.selectedIndex].value + "<?php print("&" . SID); ?>";
    }
}

function toggleForm(sel) {
    var fldSel = document.getElementById("folderSelection");
    var pasFrm = document.getElementById("passForm");

    if (sel.options[sel.selectedIndex].value == "move_all") {
        fldSel.style.display = "block";
    } else {
        fldSel.style.display = "none";
    }

    if (sel.options[sel.selectedIndex].value == "delete_all" || sel.options[sel.selectedIndex].value == "delete_all_folder") {
        pasFrm.style.display = "block";
    } else {
        pasFrm.style.display = "none";
    }
}

function checkAll() {
    var i;

    if (document.mainForm.checkTrigger.checked == true) {
       for (i=0; i<<?php print($recCnt); ?>; i++) {
            document.getElementById("check_id[" + i + "]").checked = true;
        }
    }

    if (document.mainForm.checkTrigger.checked == false) {
        for (i=0; i<<?php print($recCnt); ?>; i++) {
            document.getElementById("check_id[" + i + "]").checked = false;
        }
    }
}
// -->
</script>

<!-- フォルダ名表示 -->
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td><strong style="margin-right:10"><?php print($dirName); ?></strong></td>
    <td><font size="2">全<?php print($total); ?>件中（未読<?php print($unread); ?>件）&nbsp;&nbsp;<?php print($_REQUEST["offset"] + 1); ?>～<?php print($_REQUEST["offset"] + $recCnt); ?>番目のメッセージを表示</font></td>
</table>

<hr>
<!-- メール一覧表示 -->
<table border="0" cellpadding="0" cellspacing="5">
<tr>
    <td width="800" height="55" valign="top">
    <table border="0" cellpadding="0" cellspacing="2">
    <tr>
        <td><font color="#555555" size="2"><strong>未/既</strong></font></td>
        <td><font color="#555555" size="2"><strong>アカウント</strong></font></td>
<!--        <td><font color="#555555" size="2"><strong>ドメイン</strong></font></td>-->
        <td><font color="#555555" size="2"><strong>送受信日時</strong></font></td>
        <td><font color="#555555" size="2"><strong>担当者</strong></font></td>
        <td><font color="#555555" size="2"><strong>対応状況</strong></font></td>
        <td><font color="#555555" size="2"><strong>登録ｽﾃｰﾀｽ</strong></font></td>
        <td><font color="#555555" size="2"><strong>入金状態</strong></font></td>
        <td><font color="#555555" size="2"><strong>本文検索</strong></font></td>
<!--        <td><font color="#555555" size="2"><strong>男・女</strong></font></td>-->
        <td>&nbsp;</td>
    </tr>
    <tr>
        <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
        <input type="hidden" name="do" value="tray">
        <input type="hidden" name="dir_id" value="<?php print($_REQUEST["dir_id"]); ?>">
        <td valign="top">
        <select name="search_rd">
            <?php print($searchRdOpt); ?>
        </select>
        </td>
        <td valign="top">
        <select name="search_ac">
            <?php print($searchAcOpt); ?>
        </select>
        </td>
<!--
        <td valign="top">
        <select name="search_dm">
            <?php print($searchDmOpt); ?>
        </select>
        </td>
-->
        <td valign="top">
        <select name="search_dt">
            <?php print($searchDtOpt); ?>
        </select>
        </td>

        <td valign="top">
        <select name="search_op">
            <?php print($searchOpOpt); ?>
        </select>
        </td>
        <td valign="top">
        <select name="search_rp">
            <?php print($searchRpOpt); ?>
        </select>
        </td>
        <td valign="top">
        <select name="search_regist_status">
            <?php print($searchRegistStatusOpt); ?>
        </select>
        </td>
        <td valign="top">
        <select name="search_trade_status">
            <?php print($searchTradeStatusOpt); ?>
        </select>
        </td>
        <td valign="top">
            <input type="text" name="search_body" value="<?php print($_REQUEST["search_body"]); ?>">
        </td>
<!--

        <td valign="top">
        <select name="search_py">
            <?php print($searchPyOpt); ?>
        </select>
        </td>
        <td valign="top">
        <select name="search_se">
            <?php print($searchSeOpt); ?>
        </select>
        </td>
-->
        <td valign="top">
        <?php print($src_tag); ?>
        <input type="submit" value="更新" style="margin-left:8;">
        </form>
        </td>
    </tr>
    </table>
    </td>
</tr>
<tr>
    <td>
    <table border="0" cellpadding="0" cellspacing="0" align="left">
    <tr>
        <td valign="top">
            <select name="view_count" onChange="update(this)" style="margin-right:10;">
                <?php print($viewCountOpt); ?>
            </select>
        </td>
<?php if ($backOffset !== FALSE) { ?>
        <td valign="top">
        <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
            <input type="hidden" name="do" value="tray">
            <input type="hidden" name="dir_id" value="<?php print($_REQUEST["dir_id"]); ?>">
            <input type="hidden" name="offset" value="<?php print($backOffset); ?>">
            <input type="hidden" name="view_count" value="<?php print($_REQUEST["view_count"]); ?>">
            <?php print($searchParamP); ?>
            <?php print($orderParamP); ?>
            <?php print($src_tag); ?>
            <input type="submit" value="前の<?php print($_REQUEST["view_count"]); ?>件">
        </form>
        </td>
<?php } ?>
<?php if ($nextOffset !== FALSE) { ?>
        <td valign="top">
        <form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
            <input type="hidden" name="do" value="tray">
            <input type="hidden" name="dir_id" value="<?php print($_REQUEST["dir_id"]); ?>">
            <input type="hidden" name="offset" value="<?php print($nextOffset); ?>">
            <input type="hidden" name="view_count" value="<?php print($_REQUEST["view_count"]); ?>">
            <?php print($searchParamP); ?>
            <?php print($orderParamP); ?>
            <?php print($src_tag); ?>
            <input type="submit" value="次の<?php print($_REQUEST["view_count"]); ?>件">
        </form>
        </td>
<?php } ?>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" align="right">
    <tr>
        <td valign="top">
        <form method="post" action="Information.php" name="mainForm" style="margin-top:0; margin-bottom:0;">
            <input type="hidden" name="do" value="multi">
            <input type="hidden" name="dir_id" value="<?php print($_REQUEST["dir_id"]); ?>">
            <?php print($viewSettingParamP); ?>
            <?php print($searchParamP); ?>
            <?php print($src_tag); ?>
            <select name="mode" onChange="toggleForm(this)" style="margin-right:10;">
                <?php print($procOpt); ?>
            </select>
        </td>
        <td valign="top">
        <div id="passForm" style="display: block;">
<?php if ($topParentDir == DELETE_DIR) { ?>
        <input type="password" name="del_pass" size="8" style="height:19; margin-right:10;">
<?php } ?>
        </div>
        </td>
        <td valign="top">
        <div id="folderSelection" style="display: none;">
        <select name="new_dir_id" style="margin-right:10;">
            <?php print($dirIdOpt); ?>
        </select>
        </div>
        </td>
        <td valign="top">
            <input  type="submit" value="一括でGO!">
        </td>
    </tr>
    </table>
    </td>
</tr>
</table>
<?php // 最上位フォルダによって表示を切り替えます ?>
<style type="text/css">
<!--
#trayTable {width:1110px;overflow:auto;}
#trayTitleTr  {clear:left;height:10px;}
#trayTitleTd  {word-wrap:break-word;float:left;width:30px;padding:1px;}
#trayTitleTd2 {word-wrap:break-word;float:left;width:50px;padding:1px;}
#trayTitleTd3 {word-wrap:break-word;float:left;width:70px;padding:1px;}
#trayTitleTd4 {word-wrap:break-word;float:left;width:150px;padding:1px;}
#trayTitleTd5 {word-wrap:break-word;float:left;width:200px;padding:1px;}

#trayPayTr    {clear:left;background-color:#ffff4c;height:70px;}
#trayNoPayTr  {clear:left;background-color:#ffffff;height:70px;}

#trayTd    {word-wrap:break-word;float:left;width:30px;padding:1px;}
#trayTd2   {word-wrap:break-word;float:left;width:50px;padding:1px;}
#trayTd3   {word-wrap:break-word;float:left;width:70px;padding:1px;}
#trayTd4   {word-wrap:break-word;float:left;width:150px;padding:1px;}
#trayTd5   {word-wrap:break-word;float:left;width:200px;padding:1px;}

-->
</style>
<div id="trayTable">
    <div id="trayTitleTr">
        <div id="trayTitleTd"><input type="checkbox" name="checkTrigger" onClick="checkAll()"></div>
        <div id="trayTitleTd2"><a href="<?php print($hrefStrRd); ?>"><font color="midnightblue" size="2"><strong>未/既</strong></font></a></div>
        <div id="trayTitleTd2"><a href="<?php print($hrefStrSj); ?>"><font color="midnightblue" size="2"><strong>件名</strong></font></a></div>
        <div id="trayTitleTd5"><a href="<?php print($hrefStrBd); ?>"><font color="midnightblue" size="2"><strong>本文</strong></font></a></div>
        <div id="trayTitleTd4"><a href="<?php print($hrefStrFm); ?>"><font color="midnightblue" size="2"><strong>送信者</strong></font></a></div>
<!--        <div id="trayTitleTd4"><a href="<?php print($hrefStrTo); ?>"><font color="midnightblue" size="2"><strong>宛先</strong></font></a></div>-->
        <div id="trayTitleTd2"><a href="<?php print($hrefStrDt); ?>"><font color="midnightblue" size="2"><strong><?php print($topParentDir != TRANSMIT_DIR ? "受信":"送信"); ?>日時</strong></font></a></div>
        <div id="trayTitleTd2"><a href="<?php print($hrefStrOp); ?>"><font color="midnightblue" size="2"><strong>担当者</strong></font></a></div>
        <div id="trayTitleTd3"><a href="<?php print($hrefStrRp); ?>"><font color="midnightblue" size="2"><strong>対応状況</strong></font></a></div>
        <div id="trayTitleTd3"><font color="midnightblue" size="2"><strong>会員ID</strong></font></div>
        <div id="trayTitleTd3"><a href="<?php print($hrefStrSt); ?>"><font color="midnightblue" size="2"><strong>ステータス</strong></font></a></div>
        <div id="trayTitleTd3"><font color="midnightblue" size="2"><strong>媒体ｺｰﾄﾞ</strong></font></div>
        <div id="trayTitleTd3"><a href="<?php print($hrefStrSt); ?>"><font color="midnightblue" size="2"><strong>入金状態</strong></font></a></div>
        <div id="trayTitleTd3"><font color="midnightblue" size="2"><strong>メール受信</strong></font></a></div>
<!--        <div id="trayTitleTd3"><font color="midnightblue" size="2"><strong>性別</strong></font></a></div>-->

    </div>
<?php $check_key = 0; // JavaScript checkAll()用 check_id ?>
<?php foreach ($infoMail as $key => $value) { // start foreach ?>
<?php     // 表示用のための色を変えます。 ?>
<?php     if($infoMail[$key]->replyStatusStr == "未対応"){ ?>
<?php         $font = "<font size=2 color =FF0000>"; ?>
<?php     }else if($infoMail[$key]->replyStatusStr == "対応中"){ ?>
<?php         $font = "<font size=2 color =0000FF>"; ?>
<?php     }else if($infoMail[$key]->replyStatusStr == "対応済"){ ?>
<?php         $font = "<font size=2 color= 000000>"; ?>
<?php     }else if($infoMail[$key]->replyStatusStr == "無視"){ ?>
<?php         $font = "<font size=2 color =000000>"; ?>
<?php     } ?>
<?php    //モバイル、PCアドレスで表示色を変更
         $check_addr = $infoMail[$key]->fromName;
         if(strpos($check_addr,"@docomo.ne.jp") || strpos($check_addr,"@ezweb.ne.jp")|| strpos($check_addr,"vodafone.ne.jp") || strpos($check_addr,"@softbank.ne.jp")){
             $addr_mark = "<span style=\"background-color: #0000FF; border: solid 1px #000000; color: #ffffff; font-weight: bold;\">M</span>";
         }else{
             $addr_mark = "<span style=\"background-color: #ff0033; border: solid 1px #000000; color: #ffffff; font-weight: bold;\">P</span>";
         }
?>
<?php     $font_toji = "</font>"; ?>
    <div id="<?php print($infoMail[$key]->total_payment ? "trayPayTr" : "trayNoPayTr") ?>">
        <div id="trayTd"><input type="checkbox" name="info_id[<?php print($key); ?>]" id="check_id[<?php print($check_key); ?>]" value="<?php print($infoMail[$key]->infoId); ?>"></div>
        <div id="trayTd2"><font size="2"<?php print($infoMail[$key]->readStatus == UNREAD_MAIL ? " style=\"color: crimson;\"":""); ?>><?php print($infoMail[$key]->readStatusStr); ?></font></div>
        <div id="trayTd2"><font size="2"><a href="javascript:void(0)" onClick="window.open('read.php?info_id=<?php print($infoMail[$key]->infoId); ?>&uId=<?php if(is_numeric($user_id[$key])){print($user_id[$key]);} ?>&PHPSESSID=<?php print($_REQUEST["PHPSESSID"]); ?>', 'detail', 'width=800, height=750, toolbar=no, scrollbars=yes, resizable=yes');" <?php print($infoMail[$key]->readStatus == UNREAD_MAIL ? " style=\"color: blue;\"":" style=\"color: black;\""); ?>><?php print($subject[$key]); ?></a></font></div>
        <div id="trayTd5"><font size="2"<?php print($infoMail[$key]->readStatus != TRANSMITTED_MAIL && $infoMail[$key]->mmbId ? " style=\"color: green;\"":""); ?>><?php print(mb_strimwidth(htmlspecialchars(preg_replace("/&nbsp;/"," ",$infoMail[$key]->body)), 0, 100, "...", utf8)); ?></font></div>
        <div id="trayTd4"><?php print($addr_mark); ?><font size="2"<?php print($infoMail[$key]->readStatus != TRANSMITTED_MAIL && $infoMail[$key]->mmbId ? " style=\"color: green;\"":""); ?>><?php print($infoMail[$key]->fromName); ?></font></div>
<!--        <div id="trayTd4"><font size="2"<?php print($infoMail[$key]->readStatus == TRANSMITTED_MAIL && $infoMail[$key]->mmbId ? " style=\"color: green;\"":""); ?>><?php print($infoMail[$key]->toAddress); ?></font></div>-->
        <div id="trayTd2"><font size="2"><?php print(substr($infoMail[$key]->receivedDate, 5, 11)); ?></font></div>
        <div id="trayTd2"><font size="2"><?php print($infoMail[$key]->operatorIdStr); ?></font></div>
        <div id="trayTd3"><?php print($font); ?><?php print($infoMail[$key]->replyStatusStr); ?><?php print($font_toji); ?></div>
        <div id="trayTd3"><font size="2"><?php print($user_id[$key]); ?></font></div>
        <div id="trayTd3"><?php print($infoMail[$key]->status_cdStr); ?></div>
        <div id="trayTd3"><?php print($infoMail[$key]->media_cd ? $infoMail[$key]->media_cd:"　"); ?></div>
        <div id="trayTd3"><font  size="2" color="<?php print($infoMail[$key]->total_payment ? "red" : "black") ?>"><?php print($infoMail[$key]->total_payment ? number_format($infoMail[$key]->total_payment / 10000, 1)  : "ナシ"); ?></font></div>
        <?php if( ($mobilemail_status_array[$infoMail[$key]->userId]) && ($user_mail_status_array[$infoMail[$key]->userId]) ){  ?>
        <div id="trayTd3"><font size="2"  color="red">携帯：<?php print($mobilemail_status_array[$infoMail[$key]->userId]); ?><br>ＰＣ  ：<?php print($user_mail_status_array[$infoMail[$key]->userId]); ?></font></div>
        <?php }elseif( ($mobilemail_status_array[$infoMail[$key]->userId]) && (!$user_mail_status_array[$infoMail[$key]->userId]) ){?>
        <div id="trayTd3"><font size="2">携帯：<?php print($mobilemail_status_array[$infoMail[$key]->userId]); ?></font></div>
        <?php }elseif( (!$mobilemail_status_array[$infoMail[$key]->userId]) && ($user_mail_status_array[$infoMail[$key]->userId]) ){?>
        <div id="trayTd3"><font size="2">ＰＣ：<?php print($user_mail_status_array[$infoMail[$key]->userId]); ?></font></div>
        <?php }else{ ?>
        <div id="trayTd3"><font size="2" color="midnightblue">非会員</font></div>
        <?php } ?>
    </div>
<?php $check_key++; // JavaScript checkAll()用 check_id用 ?>
<?php } // end foreach ?>
    </form>
</div>

