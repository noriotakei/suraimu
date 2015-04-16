<?php

/**
 * day.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 媒体集計(起点登録月)ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa_hosoda
 */

require_once(D_BASE_DIR . "/common/baitai_agency_common.php");

ini_set("memory_limit", "-1");

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$tags = array(
            "date",
            "start_date",
            "start_date_trade",
            "end_date",
            "end_date_trade",
            "media_cd",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);

$AdmBaitaiAgencyOBJ = AdmBaitaiAgency::getInstance();

// 期間指定(開始)
if ($param["start_date"]) {
    $startDate = $param["start_date"] . " 00:00:00";
} elseif (ComValidation::isDate($param["date"])) {
    $startDate = $param["date"] . " 00:00:00";
}

// 期間指定(終了)
if ($param["end_date"]) {
    $endDate = $param["end_date"] . " 23:59:59";
} elseif (ComValidation::isDate($param["date"])) {
    $endDate = $param["date"] . " 23:59:59";
}

// 入金額、入金者数限定期間指定(開始)
if (ComValidation::isDate($param["start_date_trade"])) {
    $startDateTrade = $param["start_date_trade"] . " 00:00:00";
} 

// 入金額、入金者数限定期間指定(終了)
if (ComValidation::isDate($param["end_date_trade"])) {
    $endDateTrade = $param["end_date_trade"] . " 23:59:59";
} 

//年齢制限
if($param["user_age_from"] OR $param["user_age_to"]){

    $searchAgeSqAry = array();
    $searchAgeSql = "" ;

    // 年齢 ～以上
    if($param["user_age_from"]){
        $userAgeSql[] =  "vup.birth_date <= DATE_SUB(vup.regist_datetime ,interval ".$param["user_age_from"]." year) AND vup.birth_date != '0000-00-00'";
    }
    // 年齢 ～未満
    if($param["user_age_to"]){
        $userAgeTo = $param["user_age_to"]+1 ;
        $userAgeSql[] =  "vup.birth_date > DATE_SUB(vup.regist_datetime ,interval ".$userAgeTo." year)";
    }
}

// 集計結果のタイトル表示
$title = "集計期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$smartyOBJ->assign("title", $title);

/**************************************************/
/***   ログイン代理店毎で閲覧可能な媒体を取得   ***/
/**************************************************/
$adminBaitaiAgencyCdSettingOBJ = AdmBaitaiAgencyCdSetting::getInstance();
if (!$corporation) {
    $whereAryAll = "";
    $otherAryAll = "";
    // 管理IDがない⇒代理店⇒代理店毎に設定した媒体コードを取得
    if ($loginBaitaiUserData) {
        $baitaiAgencyCdSettingWhereArray = "";
        $whereAryAll[] = "baitai_agency_id = " . $loginBaitaiUserData["id"];
        $otherAryAll[] = "ORDER BY media_cd";
        $cdSettingList      = $adminBaitaiAgencyCdSettingOBJ->getBaitaiAgencyCdSettingList($whereAryAll, $otherAryAll);

        foreach ($cdSettingList as $val) {
            $mediaCdList[] = $val["media_cd"];
            $mediaCdNameList[$val["media_cd"]] = $val["media_name"];
        }
    }

    if (!$mediaCdList) {
        // 代理店媒体コード設定が無ければエラーメッセージ作成
        $errMsg = "代理店媒体コードを設定して下さい";
    }
} else {
    // 管理者アクセスは全媒体取得
    $columnAryAll = "";
    $whereAryAll = "";
    $otherAryAll = "";

    $columnAryAll[] = "media_cd";
    $whereAryAll[] = "user_disable = 0";
    $whereAryAll[] = "admin_id = 0";
    $whereAryAll[] = "media_cd regexp '^([a-z][A-z])'";
    $otherAryAll[] = "GROUP BY media_cd";

    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile", $columnAryAll, $whereAryAll, $otherAryAll);
    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        while ($data = $AdmBaitaiAgencyOBJ->fetch($resultOBJ)) {
            $mediaCdList[] = $data["media_cd"];
            $mediaCdNameList[$data["media_cd"]] = $data["media_name"];
        }
    }
}

// 媒体コード検索あり and 表示媒体コードあり
if ($param["media_cd"]) {
    // 媒体コード検索タイプ毎に検索方法変更
    $searchMediaCdString = "";
    $searchMediaCdString = str_replace(",", "|", $param["media_cd"]);

    // SQL用
    switch($param["specify_baitai_chk"]) {
        case 1;
            // 前方一致
            $searchMediaCdString = "^(" . $searchMediaCdString . ")";
            break;
        case 2;
            // 後方一致
            $searchMediaCdString = "(" . $searchMediaCdString . ")$";
            break;
        case 3;
            // 完全一致
            $searchMediaCdString = "^(" . $searchMediaCdString . ")$";
            break;
        default;
            // 気にしない(=あいまい検索)
            $searchMediaCdString = "(" . $searchMediaCdString . ")";
    }
} else {
    $searchMediaCdString = "";
}

// 媒体コード検索
if ($searchMediaCdString) {
    if ($mediaCdList) {
        foreach ($mediaCdList as $mediaCd) {
            if (preg_match("/" . $searchMediaCdString . "/", $mediaCd)) {
                // 検索媒体コードを反映した表示媒体コード
                $displayMediaCdList[] = $mediaCd;
            }
        }
    }
} else {
    $displayMediaCdList = $mediaCdList;
}

// 代理店媒体コードが設定されていればSQL条件追加
if (!$corporation && $displayMediaCdList) {
    $searchMediaCdArray = array();
    $searchMediaCd = "";
    foreach ($displayMediaCdList as $val) {
        $searchMediaCdArray[] = "'" . $val . "'";
    }
    $searchMediaCd = implode(",", $searchMediaCdArray);
}

if (!$errMsg AND count($displayMediaCdList)) {
    // 「（代理店 and 入金額を表示）or 管理者 」の場合
    if ($corporation || (!$corporation && $loginBaitaiUserData["is_display_trade_amount"])) {
        /*******************************/
        /*** 表示リスト生成（入金額）***/
        /*******************************/
        $columnArray[] = "vtu.media_cd";
        $columnArray[] = "SUM(CASE WHEN vtu.trade_datetime between '"
                          . $startDate . "' AND '" . $endDate
                          . "' THEN vtu.trade_amount ELSE 0 END) AS trade_amount";

        // 代理店媒体コードが設定されていればSQL条件追加
        if ($searchMediaCd) {
            $whereArray[] = "vtu.media_cd IN (" . $searchMediaCd . ")";
        }

        // 媒体コード検索があればSQL条件追加
        if ($searchMediaCdString) {
            $whereArray[] = "EXISTS (
                                 SELECT * FROM v_trade_user AS vtu_sub
                                 WHERE vtu_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                                 AND vtu_sub.id = vtu.id
                                 )";
        }

        //$whereArray[] = "vtu.disable = 0";
        $whereArray[] = "vtu.media_cd != ''";
        $whereArray[] = "vtu.admin_id = 0";
        $whereArray[] = "vtu.trade_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";

        $searchTradeTable = "v_trade_user AS vtu" ;

        //登録期間があればSQL条件追加
        if ($startDateTrade AND $endDateTrade) {
            $whereArray[] = "vtu.user_id = u.id AND u.regist_datetime BETWEEN '".$startDateTrade."' AND '".$endDateTrade."'" ;
            $searchTradeTable = $searchTradeTable." , user AS u" ;
        }

        $otherArray[] = "GROUP BY vtu.media_cd";
        $otherArray[] = "ORDER BY vtu.media_cd";

        // SQL文生成
        $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery($searchTradeTable, $columnArray, $whereArray, $otherArray);

        // SQL実行
        if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
            $tradeAmountList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
        }

        if ($tradeAmountList) {
            foreach ($tradeAmountList as $val) {
                $payTotalForMediaCd["trade_amount"] += $val["trade_amount"];

                // 表示用リスト(入金額追加)
                $total[$val["media_cd"]]["trade_amount"] = $val["trade_amount"];
            }
        } else {
            $payTotalForMediaCd["trade_amount"] = 0;
        }
        $smartyOBJ->assign("payTotalForMediaCd", $payTotalForMediaCd);

        /*******************************/
        /*** 表示リスト生成（入金者数）***/
        /*******************************/
        // 初期化
        $columnArray = array();
        $whereArray = array();
        $otherArray = array();

        $columnArray[] = "vtu.media_cd";
        $columnArray[] = "count(distinct user_id) AS trade_user_count" ;

        // 代理店媒体コードが設定されていればSQL条件追加
        if ($searchMediaCd) {
            $whereArray[] = "vtu.media_cd IN (" . $searchMediaCd . ")";
        }

        // 媒体コード検索があればSQL条件追加
        if ($searchMediaCdString) {
            $whereArray[] = "EXISTS (
                                 SELECT * FROM v_trade_user AS vtu_sub
                                 WHERE vtu_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                                 AND vtu_sub.id = vtu.id
                                 )";
        }

        //$whereArray[] = "vtu.disable = 0";
        $whereArray[] = "vtu.media_cd != ''";
        $whereArray[] = "vtu.admin_id = 0";
        $whereArray[] = "vtu.trade_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";

        $searchTradeTable = "v_trade_user AS vtu" ;

        //登録期間があればSQL条件追加
        if ($startDateTrade AND $endDateTrade) {
            $whereArray[] = "vtu.user_id = u.id AND u.regist_datetime BETWEEN '".$startDateTrade."' AND '".$endDateTrade."'" ;
            $searchTradeTable = $searchTradeTable." , user AS u" ;
        }

        $otherArray[] = "GROUP BY vtu.media_cd";
        $otherArray[] = "ORDER BY vtu.media_cd";

        // SQL文生成
        $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery($searchTradeTable, $columnArray, $whereArray, $otherArray);

        // SQL実行
        if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
            $tradeUserCountList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
        }

        if ($tradeUserCountList) {
            foreach ($tradeUserCountList as $val) {
                $payUserTotalForMediaCd["trade_user_count"] += $val["trade_user_count"];

                // 表示用リスト(入金額追加)
                $total[$val["media_cd"]]["trade_user_count"] = $val["trade_user_count"];
            }
        } else {
            $payUserTotalForMediaCd["trade_user_count"] = 0;
        }
        $smartyOBJ->assign("payUserTotalForMediaCd", $payUserTotalForMediaCd);

    }

    /****************/
    /***  登録数  ***/
    /****************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";
    $columnArray[] = "SUM(CASE WHEN vup.regist_datetime between '"
                      . $startDate . "' AND '" . $endDate
                      . "' THEN 1 ELSE 0 END) AS regist_count";

    $whereArray[] = "vup.regist_status != 0";
    $whereArray[] = "vup.user_disable = 0";
    $whereArray[] = "vup.profile_disable = 0";
    $whereArray[] = "vup.media_cd != ''";
    $whereArray[] = "vup.regist_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
    $whereArray[] = "vup.admin_id = 0";

    if(count($userAgeSql)){
        $addAgeSql = implode(" AND ",$userAgeSql) ;
        $whereArray[] = $addAgeSql ;
    }

    // 代理店媒体コードが設定されていればSQL条件追加
    if ($searchMediaCd) {
        $whereArray[] = "vup.media_cd IN (" . $searchMediaCd . ")";
    }

    // 媒体コード検索があればSQL条件追加
    if ($searchMediaCdString) {
        $whereArray[] = "EXISTS (
                             SELECT vup_sub.* FROM v_user_profile AS vup_sub
                             WHERE vup_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                             AND vup_sub.user_id = vup.user_id
                             AND vup_sub.user_disable = 0
                             AND vup_sub.profile_disable = 0
                             )";
    }

    $otherArray[] = "GROUP BY vup.media_cd";
    $otherArray[] = "ORDER BY vup.media_cd";

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $registList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    if ($registList) {
        foreach ($registList as $val) {
            $registTotalForMediaCd["regist_count"] += $val["regist_count"];

            // 表示用リスト(登録数追加)
            $total[$val["media_cd"]]["regist_count"] = $val["regist_count"];
        }
        $smartyOBJ->assign("registTotalForMediaCd", $registTotalForMediaCd);
    }

    /****************/
    /***  退会者数  ***/
    /****************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";
    $columnArray[] = "SUM(CASE WHEN vup.quit_datetime between '"
                      . $startDate . "' AND '" . $endDate
                      . "' THEN 1 ELSE 0 END) AS quit_count";

    $whereArray[] = "vup.regist_status != 0";
    $whereArray[] = "vup.user_disable = 0";
    $whereArray[] = "vup.profile_disable = 0";
    $whereArray[] = "vup.media_cd != ''";
    $whereArray[] = "vup.quit_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
    $whereArray[] = "vup.admin_id = 0";

    if(count($userAgeSql)){
        $addAgeSql = implode(" AND ",$userAgeSql) ;
        $whereArray[] = $addAgeSql ;
    }

    // 代理店媒体コードが設定されていればSQL条件追加
    if ($searchMediaCd) {
        $whereArray[] = "vup.media_cd IN (" . $searchMediaCd . ")";
    }

    // 媒体コード検索があればSQL条件追加
    if ($searchMediaCdString) {
        $whereArray[] = "EXISTS (
                             SELECT vup_sub.* FROM v_user_profile AS vup_sub
                             WHERE vup_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                             AND vup_sub.user_id = vup.user_id
                             AND vup_sub.user_disable = 0
                             AND vup_sub.profile_disable = 0
                             )";
    }

    $otherArray[] = "GROUP BY vup.media_cd";
    $otherArray[] = "ORDER BY vup.media_cd";

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $quitList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    if ($quitList) {
        foreach ($quitList as $val) {
            $quitTotalForMediaCd["quit_count"] += $val["quit_count"];

            // 表示用リスト(登録数追加)
            $total[$val["media_cd"]]["quit_count"] = $val["quit_count"];
        }
        $smartyOBJ->assign("quitTotalForMediaCd", $quitTotalForMediaCd);
    }

    /******************/
    /*** アクセス数 ***/
    /******************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "ma.media_cd";
    $columnArray[] = "SUM(CASE WHEN ma.analyze_datetime between '"
                      . $startDate . "' AND '" . $endDate
                      . "' THEN ma.access_count ELSE 0 END) AS access_count";

    $whereArray[] = "ma.disable = 0";
    $whereArray[] = " ma.media_cd != ''";
    $whereArray[] = "ma.analyze_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";

    // 代理店媒体コードが設定されていればSQL条件追加
    if ($searchMediaCd) {
        $whereArray[] = "ma.media_cd IN (" . $searchMediaCd . ")";
    }

    // 媒体コード検索があればSQL条件追加
    if ($searchMediaCdString) {
        $whereArray[] = "EXISTS (
                             SELECT ma_sub.* FROM media_analyze AS ma_sub
                             WHERE ma_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                             AND ma_sub.id = ma.id
                             AND ma_sub.disable = 0
                             )";
    }

    $otherArray[] = "GROUP BY ma.media_cd";
    $otherArray[] = "ORDER BY ma.media_cd";

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("media_analyze AS ma", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $accessList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    if ($accessList) {
        foreach ($accessList as $val) {
            $accessTotalForMediaCd["access_count"] += $val["access_count"];

            // 表示用リスト(アクセス数追加)
            $total[$val["media_cd"]]["access_count"] = $val["access_count"];
        }
        $smartyOBJ->assign("accessTotalForMediaCd", $accessTotalForMediaCd);
    }

    /**********************/
    /***  仮登録リスト  ***/
    /**********************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";
    $columnArray[] = "SUM(CASE WHEN vup.pre_regist_datetime between '"
                      . $startDate . "' AND '" . $endDate
                      . "' THEN 1 ELSE 0 END) AS pre_regist_count";

    $whereArray[] = "vup.regist_status = 0";
    $whereArray[] = "vup.user_disable = 0";
    $whereArray[] = "vup.profile_disable = 0";
    $whereArray[] = "vup.media_cd != ''";
    $whereArray[] = "vup.pre_regist_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
    $whereArray[] = "vup.admin_id = 0";

    // 代理店媒体コードが設定されていればSQL条件追加
    if ($searchMediaCd) {
        $whereArray[] = "vup.media_cd IN (" . $searchMediaCd . ")";
    }

    // 媒体コード検索があればSQL条件追加
    if ($searchMediaCdString) {
        $whereArray[] = "EXISTS (
                             SELECT vup_sub.* FROM v_user_profile AS vup_sub
                             WHERE vup_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                             AND vup_sub.user_id = vup.user_id
                             AND vup_sub.user_disable = 0
                             AND vup_sub.profile_disable = 0
                             )";
    }

    $otherArray[] = "GROUP BY vup.media_cd";
    $otherArray[] = "ORDER BY vup.media_cd";

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $preRegistList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    if ($preRegistList) {
        foreach ($preRegistList as $val) {
            $preRegistTotalForMediaCd["pre_regist_count"] += $val["pre_regist_count"];

            // 表示用リスト(仮登録数追加)
            $total[$val["media_cd"]]["pre_regist_count"] = $val["pre_regist_count"];
        }

    } else {
        $preRegistTotalForMediaCd["pre_regist_count"] = 0;
    }

    $smartyOBJ->assign("preRegistTotalForMediaCd", $preRegistTotalForMediaCd);

    // 表示用生成
    $totalCountList = "";
    if ($displayMediaCdList) {
        foreach ($displayMediaCdList as $key => $val) {
            if ($total[$val]) {
                $totalCountList[$val]["pre_regist_count"] = $total[$val]["pre_regist_count"] ? $total[$val]["pre_regist_count"]:0;
                $totalCountList[$val]["regist_count"] = $total[$val]["regist_count"] ? $total[$val]["regist_count"]:0;
                $totalCountList[$val]["quit_count"] = $total[$val]["quit_count"] ? $total[$val]["quit_count"]:0;
                $totalCountList[$val]["trade_amount"] = $total[$val]["trade_amount"] ? $total[$val]["trade_amount"]:0;
                $totalCountList[$val]["trade_user_count"] = $total[$val]["trade_user_count"] ? $total[$val]["trade_user_count"]:0;
                $totalCountList[$val]["access_count"] = $total[$val]["access_count"] ? $total[$val]["access_count"]:0;
            } else {
                $totalCountList[$val]["pre_regist_count"] = 0;
                $totalCountList[$val]["regist_count"] = 0;
                $totalCountList[$val]["quit_count"] = 0;
                $totalCountList[$val]["trade_amount"] = 0;
                $totalCountList[$val]["trade_user_count"] = 0;
                $totalCountList[$val]["access_count"] = 0;
            }
            $totalCountList[$val]["media_name"] = $mediaCdNameList[$val];
        }
    }

    $smartyOBJ->assign("totalCountList", $totalCountList);

}
// エラーメッセージ
$smartyOBJ->assign("errMsg", $errMsg);

?>
