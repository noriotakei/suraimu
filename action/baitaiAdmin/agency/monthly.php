<?php

/**
 * monthly.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */
/**
 * 管理画面 媒体集計(起点登録月)ページ処理ファイル。テスト用
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa_hosoda
 */

require_once(D_BASE_DIR . "/common/baitai_agency_common.php");

ini_set("memory_limit", "-1");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errMsg = "";

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
if (ComValidation::isDate($param["start_date"])) {
    $startDate = $param["start_date"] . " 00:00:00";
} elseif (ComValidation::isDate($param["date"])) {
    $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m",strtotime($param["date"])), 1, date("Y", strtotime($param["date"]))));
}

// 期間指定(終了)
if (ComValidation::isDate($param["end_date"])) {
    $endDate = $param["end_date"] . " 23:59:59";
} elseif (ComValidation::isDate($param["date"])) {
    $endDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m",strtotime($param["date"]))+1, 0, date("Y", strtotime($param["date"]))));
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
$registTitle = "本登録期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$preRegistTitle = "仮登録期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$quitUserTitle = "退会期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$payTitle = "入金期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$accessTitle = "アクセス期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$advertiseTitle = "広告期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$cvrTitle = "CVR期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$cpcTitle = "CPC期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$cpaTitle = "CPA期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));
$roiTitle = "ROI期間:" . date("Y年m月d日", strtotime($startDate)) . "～" . date("Y年m月d日", strtotime($endDate));

$smartyOBJ->assign("registTitle", $registTitle);
$smartyOBJ->assign("preRegistTitle", $preRegistTitle);
$smartyOBJ->assign("payTitle", $payTitle);
$smartyOBJ->assign("accessTitle", $accessTitle);
$smartyOBJ->assign("advertiseTitle", $advertiseTitle);
$smartyOBJ->assign("cvrTitle", $cvrTitle);
$smartyOBJ->assign("cpcTitle", $cpcTitle);
$smartyOBJ->assign("cpaTitle", $cpaTitle);
$smartyOBJ->assign("roiTitle", $roiTitle);

/**************************************************/
/***   ログイン代理店毎で閲覧可能な媒体を取得   ***/
/**************************************************/
$adminBaitaiAgencyCdSettingOBJ = AdmBaitaiAgencyCdSetting::getInstance();
if (!$corporation) {
    $whereAryAll = "";
    $otherAryAll = "";
    // 管理IDがない⇒代理店⇒代理店毎に設定した媒体コードを取得
    if ($loginBaitaiUserData) {
        $whereAryAll[] = "baitai_agency_id = " . $loginBaitaiUserData["id"];
        $otherAryAll[] = "ORDER BY media_cd";
        $cdSettingList = $adminBaitaiAgencyCdSettingOBJ->getBaitaiAgencyCdSettingList($whereAryAll, $otherAryAll);
        foreach ($cdSettingList as $val) {
            $mediaCdList[] = $val["media_cd"];
            $mediaCdNameList[$val["media_cd"]] = $val["media_name"];
        }
    }

    if (!$mediaCdList) {
        // 代理店媒体コード設定が無ければエラーメッセージ作成
        $errMsg = "表示する媒体コードを設定して下さい";
    }
} else if ($param["advertise_all"]){
    //全代理店媒体コード取得
    $otherAryAll = "";

    $otherAryAll[] = "ORDER BY media_cd";
    $cdSettingList = $adminBaitaiAgencyCdSettingOBJ->getBaitaiAgencyCdSettingList("", $otherAryAll);
    foreach ($cdSettingList as $val) {
        $mediaCdList[] = $val["media_cd"];
        $mediaCdNameList[$val["media_cd"]] = $val["media_name"];
    }
    if (!$mediaCdList) {
        // 代理店媒体コード設定が無ければエラーメッセージ作成
        $errMsg = "表示する媒体コードを設定して下さい";
    }

} else {
    //全代理店媒体コード取得
    $otherAryAll = "";
    $otherAryAll[] = "ORDER BY media_cd";
    $cdSettingList = $adminBaitaiAgencyCdSettingOBJ->getBaitaiAgencyCdSettingList("", $otherAryAll);

    // 管理者アクセスは全媒体取得
    $columnAryAll = "";
    $whereAryAll = "";
    $otherAryAll = "";

    $columnAryAll[] = "v_user_profile.media_cd";
    $columnAryAll[] = "baitai_agency_cd_setting.media_name";
    $whereAryAll[] = "user_disable = 0";
    $whereAryAll[] = "admin_id = 0";
    $whereAryAll[] = "v_user_profile.media_cd regexp '^([a-z][A-z])'";
    $otherAryAll[] = "GROUP BY v_user_profile.media_cd";

    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile LEFT JOIN baitai_agency_cd_setting ON v_user_profile.media_cd = baitai_agency_cd_setting.media_cd ", $columnAryAll, $whereAryAll, $otherAryAll);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        while ($data = $AdmBaitaiAgencyOBJ->fetch($resultOBJ)) {
            $mediaCdList[] = $data["media_cd"];
            $mediaCdNameList[$data["media_cd"]] = $data["media_name"];
        }
    }
}

$smartyOBJ->assign("mediaCdNameList", $mediaCdNameList);

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
if ((!$corporation && $displayMediaCdList ) OR ($param["advertise_all"] && $displayMediaCdList )) {
    $searchMediaCdArray = array();
    $searchMediaCd = "";
    foreach ($displayMediaCdList as $val) {
        $searchMediaCdArray[] = "'" . $val . "'";
    }
    $searchMediaCd = implode(",", $searchMediaCdArray);
}

// この時点でエラーが無ければ以下を処理
if (!$errMsg AND count($displayMediaCdList)) {
    /*********************/
    /***  本登録リスト ***/
    /*********************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";
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

    // 集計期間毎（月毎）に条件SQLを生成
    $dispMonthlyRegist = array();
    for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

        // 登録期間
        $startRegistStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
        $endRegistStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

        $columnArray[] = "SUM(CASE WHEN vup.regist_datetime BETWEEN " . $startRegistStr . " AND " . $endRegistStr . " THEN 1 ELSE 0 END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";

        // 登録期間を月毎に生成
        $dispMonthlyRegist[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));
    }

    // SQL文生成(参照テーブルは「v_user_profile」)
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $registCountList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    // 登録数合計を生成
    $baitaiRegistList = "";
    if ($registCountList) {
        foreach ($registCountList as $list) {
            foreach ($dispMonthlyRegist as $month) {
                $baitaiRegistList[$list["media_cd"]][$month] = $list[$month];

                // 月毎の合計
                $registTotalForMonthly[$month] += $list[$month];
            }
            // 媒体ごとの合計
            $registTotalForMediaCd[$list["media_cd"]] = array_sum($baitaiRegistList[$list["media_cd"]]);
        }
    } else {
        // 該当件数なし
        foreach ($dispMonthlyRegist as $month) {
            // 月毎の合計
            $registTotalForMonthly[$month] = 0;
        }
    }

    // 表示する登録者数テーブル
    if ($displayMediaCdList) {
        foreach ($displayMediaCdList as $cdKey => $cdVal) {
            if ($baitaiRegistList[$cdVal]) {
                $baitaiRegistCountList[$cdVal] = $baitaiRegistList[$cdVal];
            } else {
                foreach ($dispMonthlyRegist as $monthKey => $monthVal) {
                    $baitaiRegistCountList[$cdVal][$monthVal] = 0;
                }
            }
        }
    }

    $smartyOBJ->assign("baitaiRegistCountList", $baitaiRegistCountList);
    $smartyOBJ->assign("registTotalForMediaCd", $registTotalForMediaCd);
    $smartyOBJ->assign("registTotalForMonthly", $registTotalForMonthly);
    $smartyOBJ->assign("registAllTotal", $registTotalForMediaCd ? array_sum($registTotalForMediaCd):0);

    $smartyOBJ->assign("dispMonthlyRegist", $dispMonthlyRegist);
    $smartyOBJ->assign("dispMonthlyRegistCount", count($dispMonthlyRegist));

    /*********************/
    /***  退会者リスト ***/
    /*********************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";
    $whereArray[] = "vup.regist_status = 2";
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

    // 集計期間毎（月毎）に条件SQLを生成
    $dispMonthlyQuitUser = array();
    for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

        // 登録期間
        $startQuitUserStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
        $endQuitUserStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

        $columnArray[] = "SUM(CASE WHEN vup.quit_datetime BETWEEN " . $startQuitUserStr . " AND " . $endQuitUserStr . " THEN 1 ELSE 0 END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";

        // 登録期間を月毎に生成
        $dispMonthlyQuitUser[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));
    }

    // SQL文生成(参照テーブルは「v_user_profile」)
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $quitUserCountList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    // 退会数合計を生成
    $baitaiQuitUserList = "";
    if ($quitUserCountList) {
        foreach ($quitUserCountList as $list) {
            foreach ($dispMonthlyQuitUser as $month) {
                $baitaiQuitUserList[$list["media_cd"]][$month] = $list[$month];

                // 月毎の合計
                $quitUserTotalForMonthly[$month] += $list[$month];
            }
            // 媒体ごとの合計
            $quitUserTotalForMediaCd[$list["media_cd"]] = array_sum($baitaiQuitUserList[$list["media_cd"]]);
        }
    } else {
        // 該当件数なし
        foreach ($dispMonthlyQuitUser as $month) {
            // 月毎の合計
            $quitUserTotalForMonthly[$month] = 0;
        }
    }

    // 表示する登録者数テーブル
    if ($displayMediaCdList) {
        foreach ($displayMediaCdList as $cdKey => $cdVal) {
            if ($baitaiQuitUserList[$cdVal]) {
                $baitaiQuitUserCountList[$cdVal] = $baitaiQuitUserList[$cdVal];
            } else {
                foreach ($dispMonthlyQuitUser as $monthKey => $monthVal) {
                    $baitaiQuitUserCountList[$cdVal][$monthVal] = 0;
                }
            }
        }
    }

    $smartyOBJ->assign("baitaiQuitUserCountList", $baitaiQuitUserCountList);
    $smartyOBJ->assign("quitUserTotalForMediaCd", $quitUserTotalForMediaCd);
    $smartyOBJ->assign("quitUserTotalForMonthly", $quitUserTotalForMonthly);
    $smartyOBJ->assign("quitUserAllTotal", $quitUserTotalForMediaCd ? array_sum($quitUserTotalForMediaCd):0);

    $smartyOBJ->assign("dispMonthlyQuitUser", $dispMonthlyQuitUser);
    $smartyOBJ->assign("dispMonthlyQuitUserCount", count($dispMonthlyQuitUser));

    // 「（代理店 and 入金額を表示）or 管理者 」の場合
    if ($corporation || (!$corporation && $loginBaitaiUserData["is_display_trade_amount"])) {
        /*******************/
        /*** 入金額リスト***/
        /*******************/
        // 初期化
        $columnArray = array();
        $whereArray = array();
        $otherArray = array();

        // 固定SQL文
        $columnArray[] = "vtu.media_cd";

        //$whereArray[] = "vtu.disable = 0";
        $whereArray[] = "vtu.media_cd != ''";
        $whereArray[] = "vtu.admin_id = 0";
        $whereArray[] = "vtu.trade_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";

        // 代理店媒体コードが設定されていればSQL条件追加
        if ($searchMediaCd) {
            $whereArray[] = "vtu.media_cd IN (" . $searchMediaCd . ")";
        }

        // 媒体コード検索があればSQL条件追加
        if ($searchMediaCdString) {
            $whereArray[] = "EXISTS (
                                 SELECT vtu_sub.* FROM v_trade_user AS vtu_sub
                                 WHERE vtu_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                                 AND vtu_sub.id = vtu.id
                                 )";
        }

        $searchTradeTable = "v_trade_user AS vtu" ;

        //登録期間があればSQL条件追加
        if ($startDateTrade AND $endDateTrade) {
            $whereArray[] = "vtu.user_id = u.id AND u.regist_datetime BETWEEN '".$startDateTrade."' AND '".$endDateTrade."'" ;
            $searchTradeTable = $searchTradeTable." , user AS u" ;
        }

        $otherArray[] = "GROUP BY vtu.media_cd";
        $otherArray[] = "ORDER BY vtu.media_cd";

        // 集計期間毎に条件SQLを生成
        $dispMonthlyRegist = array();
        for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

            // 入金期間
            $startPayDateStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
            $endPayDateStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

            $columnArray[] = "SUM(CASE WHEN vtu.trade_datetime BETWEEN " . $startPayDateStr . " AND " . $endPayDateStr . " THEN vtu.trade_amount ELSE 0 END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";

            // 入金期間を月毎に生成
            $dispMonthlyPay[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));

        }

        // SQL文生成
        $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery($searchTradeTable, $columnArray, $whereArray, $otherArray);

        // SQL実行
        if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
            $tradeList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
        }

        // 入金額合計を生成
        if ($tradeList) {
            foreach ($tradeList as $tradeKey => $list) {
                $total = "";
                foreach ($dispMonthlyPay as $month) {
                    $tradeAmountList[$list["media_cd"]][$month] = (int)$list[$month];
                    $total[] = $list[$month];

                    // 月毎の合計
                    $payTotalForMonthly[$month] += $list[$month];
                }
                // 媒体ごとの合計
                $payTotalForMediaCd[$list["media_cd"]] = array_sum($total);
            }
        } else {
            foreach ($dispMonthlyPay as $month) {
                // 月毎の合計
                $payTotalForMonthly[$month] = 0;
            }
        }

        // 表示する入金額テーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($tradeAmountList[$cdVal]) {
                    $baitaiTradeAmountList[$cdVal] = $tradeAmountList[$cdVal];
                } else {
                    foreach ($dispMonthlyPay as $monthKey => $monthVal) {
                        $baitaiTradeAmountList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }

        $smartyOBJ->assign("tradeAmountList", $baitaiTradeAmountList);
        $smartyOBJ->assign("payTotalForMediaCd", $payTotalForMediaCd);
        $smartyOBJ->assign("payTotalForMonthly", $payTotalForMonthly);
        $smartyOBJ->assign("payAllTotal", $payTotalForMediaCd ? array_sum($payTotalForMediaCd):0);

        $smartyOBJ->assign("dispMonthlyPay", $dispMonthlyPay);
        $smartyOBJ->assign("dispMonthlyPayCount", count($dispMonthlyPay));


        /*******************/
        /*** 入金者数リスト***/
        /*******************/
        // 初期化
        $columnArray = array();
        $whereArray = array();
        $otherArray = array();

        // 固定SQL文
        $columnArray[] = "vtu.media_cd";

        //$whereArray[] = "vtu.disable = 0";
        $whereArray[] = "vtu.media_cd != ''";
        $whereArray[] = "vtu.admin_id = 0";
        $whereArray[] = "vtu.trade_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";

        // 代理店媒体コードが設定されていればSQL条件追加
        if ($searchMediaCd) {
            $whereArray[] = "vtu.media_cd IN (" . $searchMediaCd . ")";
        }

        // 媒体コード検索があればSQL条件追加
        if ($searchMediaCdString) {
            $whereArray[] = "EXISTS (
                                 SELECT vtu_sub.* FROM v_trade_user AS vtu_sub
                                 WHERE vtu_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                                 AND vtu_sub.id = vtu.id
                                 )";
        }

        $searchTradeTable = "v_trade_user AS vtu" ;

        //登録期間があればSQL条件追加
        if ($startDateTrade AND $endDateTrade) {
            $whereArray[] = "vtu.user_id = u.id AND u.regist_datetime BETWEEN '".$startDateTrade."' AND '".$endDateTrade."'" ;
            $searchTradeTable = $searchTradeTable." , user AS u" ;
        }

        $otherArray[] = "GROUP BY vtu.media_cd";
        $otherArray[] = "ORDER BY vtu.media_cd";

        // 集計期間毎に条件SQLを生成
        $dispMonthlyRegist = array();
        for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

            // 入金期間
            $startPayUserDateStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
            $endPayUserDateStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

            $columnArray[] = "COUNT(DISTINCT CASE WHEN vtu.trade_datetime BETWEEN " . $startPayUserDateStr . " AND " . $endPayUserDateStr . " THEN vtu.user_id ELSE NULL END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";


            // 入金期間を月毎に生成
            $dispMonthlyPayUser[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));

        }

        // SQL文生成
        $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery($searchTradeTable, $columnArray, $whereArray, $otherArray);

        // SQL実行
        if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
            $tradeUserList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
        }

        // 入金者合計を生成
        if ($tradeUserList) {
            foreach ($tradeUserList as $tradeKey => $list) {
                $total = "";
                foreach ($dispMonthlyPayUser as $month) {
                    $tradeUserList[$list["media_cd"]][$month] = (int)$list[$month];
                    $total[] = $list[$month];

                    // 月毎の合計
                    $payUserTotalForMonthly[$month] += $list[$month];
                }
                // 媒体ごとの合計
                $payUserTotalForMediaCd[$list["media_cd"]] = array_sum($total);
            }
        } else {
            foreach ($dispMonthlyPayUser as $month) {
                // 月毎の合計
                $payUserTotalForMonthly[$month] = 0;
            }
        }

        // 表示する入金額テーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($tradeUserList[$cdVal]) {
                    $baitaiTradeUserList[$cdVal] = $tradeUserList[$cdVal];
                } else {
                    foreach ($dispMonthlyPayUser as $monthKey => $monthVal) {
                        $baitaiTradeUserList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }

        $smartyOBJ->assign("tradeUserList", $baitaiTradeUserList);
        $smartyOBJ->assign("payUserTotalForMediaCd", $payUserTotalForMediaCd);
        $smartyOBJ->assign("payUserTotalForMonthly", $payUserTotalForMonthly);
        $smartyOBJ->assign("payUserAllTotal", $payUserTotalForMediaCd ? array_sum($payUserTotalForMediaCd):0);

        $smartyOBJ->assign("dispMonthlyPayUser", $dispMonthlyPayUser);
        $smartyOBJ->assign("dispMonthlyPayUserCount", count($dispMonthlyPayUser));

    }

    /****************************/
    /***   アクセスリスト   ***/
    /****************************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "ma.media_cd";

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

    // 集計期間毎（月毎）に条件SQLを生成
    $dispMonthlyAccess = array();
    for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

        // 登録期間
        $startRegistStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
        $endRegistStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

        $columnArray[] = "SUM(CASE WHEN ma.analyze_datetime BETWEEN " . $startRegistStr . " AND " . $endRegistStr . " THEN ma.access_count ELSE 0 END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";

        // 登録期間を月毎に生成
        $dispMonthlyAccess[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));
    }

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("media_analyze AS ma", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $accessList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    // アクセス数合計を生成
    $baitaiAccessList = "";
    if ($accessList) {
        foreach ($accessList as $list) {
            foreach ($dispMonthlyAccess as $month) {
                $baitaiAccessList[$list["media_cd"]][$month] = $list[$month];
                // 月毎の合計
                $accessTotalForMonthly[$month] += $list[$month];
            }
            // 媒体ごとの合計
            $accessTotalForMediaCd[$list["media_cd"]] = array_sum($baitaiAccessList[$list["media_cd"]]);
        }
    } else {
        foreach ($dispMonthlyAccess as $month) {
            // 月毎の合計
            $accessTotalForMonthly[$month] = 0;
        }
    }

    // 表示するアクセス数テーブル
    if ($displayMediaCdList) {
        foreach ($displayMediaCdList as $cdKey => $cdVal) {
            if ($baitaiAccessList[$cdVal]) {
                $baitaiAccessCountList[$cdVal] = $baitaiAccessList[$cdVal];
            } else {
                foreach ($dispMonthlyAccess as $monthKey => $monthVal) {
                    $baitaiAccessCountList[$cdVal][$monthVal] = 0;
                }
            }
        }
    }

    $smartyOBJ->assign("baitaiAccessCountList", $baitaiAccessCountList);
    $smartyOBJ->assign("accessTotalForMediaCd", $accessTotalForMediaCd);
    $smartyOBJ->assign("accessTotalForMonthly", $accessTotalForMonthly);
    $smartyOBJ->assign("accessAllTotal", $accessTotalForMediaCd ? array_sum($accessTotalForMediaCd):0);

    $smartyOBJ->assign("dispMonthlyAccess", $dispMonthlyAccess);
    $smartyOBJ->assign("dispMonthlyAccessCount", count($dispMonthlyAccess));

    /**********************/
    /***  仮登録リスト  ***/
    /**********************/
    // 初期化
    $columnArray = array();
    $whereArray = array();
    $otherArray = array();

    $columnArray[] = "vup.media_cd";

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

    // 集計期間毎（月毎）に条件SQLを生成
    $dispMonthlyPreRegist = array();
    for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {

        // 登録期間
        $startDateStr = "'" . date("Y-m-d H:i:s", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";
        $endDateStr = "'" . date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) . "'";

        $columnArray[] = "SUM(CASE WHEN vup.pre_regist_datetime BETWEEN " . $startDateStr . " AND " . $endDateStr . " THEN 1 ELSE 0 END) AS '" . date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) . "'";

        // 登録期間を月毎に生成
        $dispMonthlyPreRegist[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));
    }

    // SQL文生成
    $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray, $otherArray);

    // SQL実行
    if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
        $preRegistList = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    }

    // 登録数合計を生成
    $baitaiPreRegistList = "";
    if ($preRegistList) {
        foreach ($preRegistList as $list) {
            foreach ($dispMonthlyPreRegist as $month) {
                $baitaiPreRegistList[$list["media_cd"]][$month] = $list[$month];
                // 月毎の合計
                $preRegistTotalForMonthly[$month] += $list[$month];
            }
            // 媒体ごとの合計
            $preRegistTotalForMediaCd[$list["media_cd"]] = array_sum($baitaiPreRegistList[$list["media_cd"]]);
        }
    } else {
        // 該当件数なし
        foreach ($dispMonthlyPreRegist as $month) {
            // 月毎の合計
            $preRegistTotalForMonthly[$month] = 0;
        }
    }

    // 表示する仮登録者数テーブル
    if ($displayMediaCdList) {
        foreach ($displayMediaCdList as $cdKey => $cdVal) {
            if ($baitaiPreRegistList[$cdVal]) {
                $baitaiPreRegistCountList[$cdVal] = $baitaiPreRegistList[$cdVal];
            } else {
                foreach ($dispMonthlyPreRegist as $monthKey => $monthVal) {
                    $baitaiPreRegistCountList[$cdVal][$monthVal] = 0;
                }
            }
        }
    }

    $smartyOBJ->assign("baitaiPreRegistCountList", $baitaiPreRegistCountList);
    $smartyOBJ->assign("preRegistTotalForMediaCd", $preRegistTotalForMediaCd);
    $smartyOBJ->assign("preRegistTotalForMonthly", $preRegistTotalForMonthly);
    $smartyOBJ->assign("preRegistAllTotal", $preRegistTotalForMediaCd ? array_sum($preRegistTotalForMediaCd):0);

    $smartyOBJ->assign("dispMonthlyPreRegist", $dispMonthlyPreRegist);
    $smartyOBJ->assign("dispMonthlyPreRegistCount", count($dispMonthlyPreRegist));

    /*********************/
    /***  広告費リスト ***/
    /*********************/
    if(count($cdSettingList)){
        foreach( $cdSettingList as $val ){
            if(!in_array($val["media_cd"],$displayMediaCdList)){
                continue ;
            }

            $mediaCdDataForAdvertiseExpenses[$val["advertise_expenses_type"]][$val["media_cd"]] = $val;
        }
    
         $count = 1 ;
        foreach($displayMediaCdList as $key => $mediaCd){
            for ($i=0; mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))<=mktime(0,0,0,date("n", strtotime($endDate)), 1, date("Y", strtotime($endDate))); $i++) {
        
                $startRegistStr = date("Y-m-d", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate)))) ;
                $endRegistStr = date("Y-m-d H:i:s", mktime(23,59,59,date("n", strtotime($startDate))+($i+1), 0, date("Y", strtotime($startDate)))) ;
    
                if($count == 1){    
                    // 登録期間を月毎に生成
                    $dispMonthAdvertiseExpenses[] = date("Y年m月", mktime(0,0,0,date("n", strtotime($startDate))+$i, 1, date("Y", strtotime($startDate))));
                }
    
                // 初期化
                $columnArray = array();
                $whereArray = array();
                $otherArray = array();
        
                $columnArray[] = "vup.user_id";
                $whereArray[] = "vup.regist_status != 0";
                $whereArray[] = "vup.user_disable = 0";
                $whereArray[] = "vup.profile_disable = 0";
                $whereArray[] = "vup.regist_datetime BETWEEN '" . $startRegistStr . "' AND '" . $endRegistStr . "'";
                $whereArray[] = "vup.admin_id = 0";
                $whereArray[] = "vup.media_cd = '".$mediaCd ."'";
    
        
                // 媒体コード検索があればSQL条件追加 
    /*
                if ($searchMediaCdString) {
                    $whereArray[] = "EXISTS (
                                         SELECT vup_sub.* FROM v_user_profile AS vup_sub
                                         WHERE vup_sub.media_cd REGEXP '" . $searchMediaCdString . "'
                                         AND vup_sub.user_id = vup.user_id
                                         AND vup_sub.user_disable = 0
                                         AND vup_sub.profile_disable = 0
                                         )";
                }
    */
    /*
                $otherArray[] = "GROUP BY vup.media_cd";
                $otherArray[] = "ORDER BY vup.media_cd";
    */
                // SQL文生成(参照テーブルは「v_user_profile」)
                $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_user_profile AS vup", $columnArray, $whereArray);

                // SQL実行
                if ($resultOBJ = $AdmBaitaiAgencyOBJ->executeQuery($sql)) {
                    $resul = $AdmBaitaiAgencyOBJ->fetchAll($resultOBJ);
    
                    if(count($resul)){
                        foreach($resul as $key => $val){
                            $registList[$mediaCd][$startRegistStr][]= $val["user_id"] ;
                        }
                    } else {
                            $registList[$mediaCd][$startRegistStr] =$resul ;
                    }
    
                }
    
            }
            $count++;
        }
    
        //広告費（毎月）
        if(count($mediaCdDataForAdvertiseExpenses[1])){
            foreach($mediaCdDataForAdvertiseExpenses[1] as $mediaCdKey => $val){
    	        foreach($registList[$mediaCdKey] as $registDateKey => $userIdAryVal){
                    //広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上
                    if( ($val["advertise_period_from"] <= $registDateKey) && ($val["advertise_period_to"] >= $registDateKey)){
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = $val["advertise_expenses"] ;
                    } else {
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                    }
                }
            }
        }
        //広告費（一回払い）
        if(count($mediaCdDataForAdvertiseExpenses[2])){
            foreach($mediaCdDataForAdvertiseExpenses[2] as $mediaCdKey => $val){
                foreach($registList[$mediaCdKey] as $registDateKey => $userIdAryVal){
                    //広告期間fromと集計対象年月が一致している月のみ広告費を計上
                    if( ($val["advertise_period_from"] == $registDateKey) ){
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = $val["advertise_expenses_once"] ;
                    } else {
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                    }
                }
            }
        }
    
        //広告費（単価）
        if(count($mediaCdDataForAdvertiseExpenses[3])){
            foreach($mediaCdDataForAdvertiseExpenses[3] as $mediaCdKey => $val){
                foreach($registList[$mediaCdKey] as $registDateKey => $userIdAryVal){
                    //広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上
                    if( ($val["advertise_period_from"] <= $registDateKey) && ($val["advertise_period_to"] >= $registDateKey)){
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = count($userIdAryVal)*$val["advertise_expenses_apiece"] ;
                    } else {
                        $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                    }
                }
            }
        }

        //成果報酬
        if(count($mediaCdDataForAdvertiseExpenses[4])){
            $totalUserIdAryVal = array() ;
            foreach($mediaCdDataForAdvertiseExpenses[4] as $mediaCdKey => $val){
                foreach($registList[$mediaCdKey] as $registDateKey => $userIdAryVal){
                    //広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上
                    if( ($val["advertise_period_from"] <= $registDateKey) && ($val["advertise_period_to"] >= $registDateKey)){
                        // 月末の日付を求める
                        $baseTimestamp  = strtotime($registDateKey);
                        $afterTimestamp = strtotime("+1 month -1 day", $baseTimestamp);
                        $startDate = $registDateKey ;
                        $endDate = date("Y-m-d", $afterTimestamp);

                        $totalUserIdAryVal = array_merge($totalUserIdAryVal , $userIdAryVal) ;
                        if(!count($totalUserIdAryVal)){
                            $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                            //ﾕｰｻﾞｰが取得出来なかったら以下の処理はやりません。
                            continue ;
                        }
    
                        $userIdString = implode(",",$totalUserIdAryVal) ;
                        // 初期化
                        $columnArray = array();
                        $whereArray = array();
                        $otherArray = array();
    
                        // 固定SQL文
                        $columnArray[] = "SUM(vtu.trade_amount) as totalAmount";
    
                        $whereArray[] = "vtu.media_cd = '".$mediaCdKey."'";
                        $whereArray[] = "vtu.admin_id = 0";
                        $whereArray[] = "vtu.trade_datetime BETWEEN '" . $startDate . " 00:00:00' AND '" . $endDate . " 23:59:59'";
                        $whereArray[] = "vtu.user_id in( ".$userIdString." )" ;
    
                        // SQL文生成
                        $sql = $AdmBaitaiAgencyOBJ->makeSelectQuery("v_trade_user AS vtu", $columnArray, $whereArray, $otherArray);

                        // SQL実行
                        if ($result = $AdmBaitaiAgencyOBJ->fetchOne($sql)) {
                            $advertiseExpenses[$mediaCdKey][$registDateKey] = $result/100*$val["advertise_expenses_percent"] ;
                        } else {
                            $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                        }
                    }
                }
                $i++;
            }
        }

        //広告費タイプ設定無し
        if(count($mediaCdDataForAdvertiseExpenses[0])){
            foreach($mediaCdDataForAdvertiseExpenses[0] as $mediaCdKey => $val){
                foreach($registList[$mediaCdKey] as $registDateKey => $userIdAryVal){
                    $advertiseExpenses[$mediaCdKey][$registDateKey] = 0 ;        	
                }
            }
        }
    
        //配列のキー名を変更します。 例 [2012-03-01] => 30000 から[2012年03月] => 30000
        foreach($advertiseExpenses as $advertiseExpensesKey => $advertiseExpensesVal){
            foreach($advertiseExpensesVal as $key => $generalAdvertiseExpensesVal){
                $dateAry = explode("-" , $key) ;
                $revisedAdvertiseExpenses[$advertiseExpensesKey] [$dateAry[0]."年".$dateAry[1]."月"] =  $generalAdvertiseExpensesVal;
            }
        }
    
        // 広告費合計を生成
        if ($revisedAdvertiseExpenses) {
            foreach ($revisedAdvertiseExpenses as $advertiseKey => $list) {
                $total = "";
                foreach ($dispMonthAdvertiseExpenses as $month) {
                    $advertiseExpensesList[$advertiseKey][$month] = (int)$list[$month];
                    $total[] = $list[$month];
                    // 月毎の合計
                    $advertiseExpensesTotalForMonthly[$month] += $list[$month];
                }
                // 媒体ごとの合計
                $advertiseExpensesTotalForMediaCd[$advertiseKey] = array_sum($total);
            }
        } else {
            foreach ($dispMonthAdvertiseExpenses as $month) {
                // 月毎の合計
                $advertiseExpensesTotalForMonthly[$month] = 0;
            }
        }
    
        // 表示する広告費テーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($advertiseExpensesList[$cdVal]) {
                    $baitaiAdvertiseExpensesList[$cdVal] = $advertiseExpensesList[$cdVal];
                } else {
                    foreach ($dispMonthAdvertiseExpenses as $monthKey => $monthVal) {
                        $baitaiAdvertiseExpensesList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }
    
        //広告費表示データをアサイン
        $smartyOBJ->assign("baitaiAdvertiseExpensesList", $baitaiAdvertiseExpensesList);
        $smartyOBJ->assign("advertiseExpensesTotalForMediaCd", $advertiseExpensesTotalForMediaCd);
        $smartyOBJ->assign("advertiseExpensesTotalForMonthly", $advertiseExpensesTotalForMonthly);
        $smartyOBJ->assign("advertiseExpensesTotal", $advertiseExpensesTotalForMediaCd ? array_sum($advertiseExpensesTotalForMediaCd):0);
    
        $smartyOBJ->assign("dispMonthAdvertiseExpenses", $dispMonthAdvertiseExpenses);
        $smartyOBJ->assign("dispMonthAdvertiseExpensesCount", count($dispMonthAdvertiseExpenses));
    
        /*********************/
        /***  CPAリスト ***/
        /*********************/
        foreach($revisedAdvertiseExpenses as $mediaCdKey => $advertiseExpensesVal){
            foreach($advertiseExpensesVal as $dateKey => $advertiseExpensesIntervalsOfMonthVal){
                if(!$advertiseExpensesIntervalsOfMonthVal OR !$baitaiRegistCountList[$mediaCdKey][$dateKey]){
                    $cpaDateList[$mediaCdKey][$dateKey] = 0 ;
                    continue ;
                }
                $cpa = $advertiseExpensesIntervalsOfMonthVal/$baitaiRegistCountList[$mediaCdKey][$dateKey] ;
                $cpaDateList[$mediaCdKey][$dateKey] = $cpa ;
            }
        
        }
        // CPA合計を生成
        if ($cpaDateList) {
            foreach ($cpaDateList as $advertiseKey => $list) {
                foreach ($dispMonthAdvertiseExpenses as $month) {
                    $cpaList[$advertiseKey][$month] = number_format($list[$month]  ,"",".","") ;
                }
            }
        } else {
            foreach ($dispMonthAdvertiseExpenses as $month) {
                // 月毎の合計
                $cpaTotalForMonthly[$month] = 0;
            }
        }
    
        // 表示するCPAテーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($cpaList[$cdVal]) {
                    $baitaiCpaList[$cdVal] = $cpaList[$cdVal];
                } else {
                    foreach ($dispMonthAdvertiseExpenses as $monthKey => $monthVal) {
                        $baitaiCpaList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }
    
        // 月毎の合計
        foreach($advertiseExpensesTotalForMonthly as $dateKey => $advertiseExpensesVal){
            if(!$advertiseExpensesVal OR !$registTotalForMonthly[$dateKey]){
                $monthLyTotalCpa = 0 ;
            } else {
                $monthLyTotalCpa = $advertiseExpensesVal/$registTotalForMonthly[$dateKey] ;
            }
            $cpaTotalForMonthly[$dateKey] = number_format($monthLyTotalCpa  ,"",".","") ;
        }
        // 媒体ごとの合計
        foreach($advertiseExpensesTotalForMediaCd as $mediaCdKey => $advertiseExpensesVal){
    
            if(!$advertiseExpensesVal OR !$registTotalForMediaCd[$mediaCdKey]){
                $monthLyTotalCpaForMediaCd = 0 ;
            } else {
                $monthLyTotalCpaForMediaCd = $advertiseExpensesVal/$registTotalForMediaCd[$mediaCdKey] ;
            }
        	$cpaTotalForMediaCd[$mediaCdKey] =  number_format($monthLyTotalCpaForMediaCd ,"",".","")  ;
        }
        // 合計
        if(count($advertiseExpensesTotalForMonthly) && count($registTotalForMonthly)){
            if(!array_sum($advertiseExpensesTotalForMonthly) OR !array_sum($registTotalForMonthly)){
                $cpaTotal = 0 ;
            } else {
                $cpaTotal = array_sum($advertiseExpensesTotalForMonthly)/array_sum($registTotalForMonthly) ;
            }
            $cpaTotal = number_format($cpaTotal  ,"",".","") ;
        } else {
            $cpaTotal = 0 ;
        }
    
        $smartyOBJ->assign("baitaiCpaList", $baitaiCpaList);
        $smartyOBJ->assign("cpaTotalForMediaCd", $cpaTotalForMediaCd);
        $smartyOBJ->assign("cpaTotalForMonthly", $cpaTotalForMonthly);
        $smartyOBJ->assign("cpaTotal", $cpaTotal);
    
    
        /*********************/
        /***  CPCリスト ***/
        /*********************/
        foreach($revisedAdvertiseExpenses as $mediaCdKey => $advertiseExpensesVal){
            foreach($advertiseExpensesVal as $dateKey => $advertiseExpensesIntervalsOfMonthVal){
                if(!$advertiseExpensesIntervalsOfMonthVal OR !$baitaiAccessCountList[$mediaCdKey][$dateKey]){
                    $cpcDateList[$mediaCdKey][$dateKey] = 0 ;
                    continue ;
                }
                $cpc = $advertiseExpensesIntervalsOfMonthVal/$baitaiAccessCountList[$mediaCdKey][$dateKey] ;
                $cpcDateList[$mediaCdKey][$dateKey] = $cpc ;
            }
        
        }
    
        // CPC合計を生成
        if ($cpcDateList) {
            foreach ($cpcDateList as $advertiseKey => $list) {
                foreach ($dispMonthAdvertiseExpenses as $month) {
                    $cpcList[$advertiseKey][$month] = number_format($list[$month]  ,"",".","") ;
                }
            }
        } else {
            foreach ($dispMonthAdvertiseExpenses as $month) {
                // 月毎の合計
                $cpcTotalForMonthly[$month] = 0;
            }
        }
    
        // 表示するCPCテーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($cpcList[$cdVal]) {
                    $baitaiCpcList[$cdVal] = $cpcList[$cdVal];
                } else {
                    foreach ($dispMonthAdvertiseExpenses as $monthKey => $monthVal) {
                        $baitaiCpcList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }
    
        // 月毎の合計
        foreach($advertiseExpensesTotalForMonthly as $dateKey => $advertiseExpensesVal){
    
            if(!$advertiseExpensesVal OR !$accessTotalForMonthly[$dateKey] ){
                $monthLyTotalCpc = 0 ;
            } else {
                $monthLyTotalCpc = $advertiseExpensesVal/$accessTotalForMonthly[$dateKey] ;
            }
    
            $cpcTotalForMonthly[$dateKey] = number_format($monthLyTotalCpc  ,"",".","") ;
        }
        // 媒体ごとの合計
        foreach($advertiseExpensesTotalForMediaCd as $mediaCdKey => $advertiseExpensesVal){
    
            if(!$advertiseExpensesVal OR !$accessTotalForMediaCd[$mediaCdKey]){
            	$monthLyTotalCpcForMediaCd = 0 ;
            } else {
            	$monthLyTotalCpcForMediaCd = $advertiseExpensesVal/$accessTotalForMediaCd[$mediaCdKey] ;
            }
    
        	$cpcTotalForMediaCd[$mediaCdKey] =  number_format( $monthLyTotalCpcForMediaCd,"",".","")  ;
    
        }
        // 合計
        if(count($advertiseExpensesTotalForMonthly) && count($accessTotalForMonthly)){
            if(!array_sum($advertiseExpensesTotalForMonthly) OR !array_sum($accessTotalForMonthly)){
                $cpcTotal = 0 ;
            } else {
                $cpcTotal = array_sum($advertiseExpensesTotalForMonthly)/array_sum($accessTotalForMonthly) ;
            }
            $cpcTotal = number_format($cpcTotal  ,"",".","") ;
        } else {
            $cpcTotal = 0 ;
        }
    
        $smartyOBJ->assign("baitaiCpcList", $baitaiCpcList);
        $smartyOBJ->assign("cpcTotalForMediaCd", $cpcTotalForMediaCd);
        $smartyOBJ->assign("cpcTotalForMonthly", $cpcTotalForMonthly);
        $smartyOBJ->assign("cpcTotal", $cpcTotal);
    
        /*********************/
        /***  CVRリスト ***/
        /*********************/
        foreach($baitaiRegistCountList as $mediaCdKey => $registCountVal){
            foreach($registCountVal as $dateKey => $registCountIntervalsOfMonthVal){
                if(!$registCountIntervalsOfMonthVal OR !$baitaiAccessCountList[$mediaCdKey][$dateKey]){
                    $cvrDateList[$mediaCdKey][$dateKey] = 0 ;
                    continue ;
                }
                $cvr = $registCountIntervalsOfMonthVal/$baitaiAccessCountList[$mediaCdKey][$dateKey] ;
                $cvrDateList[$mediaCdKey][$dateKey] = $cvr*100 ;
            }
        
        }
        // CVR合計を生成
        if ($cvrDateList) {
            foreach ($cvrDateList as $advertiseKey => $list) {
                foreach ($dispMonthAdvertiseExpenses as $month) {
                    $cvrList[$advertiseKey][$month] = number_format($list[$month]  ,1,".","") ;
                    $total[] = $list[$month];
                }
            }
        } else {
            foreach ($dispMonthAdvertiseExpenses as $month) {
                // 月毎の合計
                $cvrTotalForMonthly[$month] = 0;
            }
        }
        // 表示するCVRテーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($cvrList[$cdVal]) {
                    $baitaiCvrList[$cdVal] = $cvrList[$cdVal];
                } else {
                    foreach ($dispMonthAdvertiseExpenses as $monthKey => $monthVal) {
                        $baitaiCvrList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }
        // 月毎の合計
        foreach($registTotalForMonthly as $dateKey => $registTotal){
            if(!$registTotal OR !$accessTotalForMonthly[$dateKey]){
                $monthLyTotalCvr = 0 ;
            } else {
                $monthLyTotalCvr = ($registTotal/$accessTotalForMonthly[$dateKey]) * 100 ;
            }
            $cvrTotalForMonthly[$dateKey] = number_format($monthLyTotalCvr  ,1,".","") ;
        }
        // 媒体ごとの合計
        if(count($registTotalForMediaCd)){
            foreach($registTotalForMediaCd as $mediaCdKey => $registTotalVal){
                if(!$registTotalVal OR !$accessTotalForMediaCd[$mediaCdKey]){
                    $cvr = 0 ;
                } else {
                    $cvr = ($registTotalVal/$accessTotalForMediaCd[$mediaCdKey])  * 100 ;
                }
                $cvrTotalForMediaCd[$mediaCdKey] =  number_format($cvr ,1,".","")  ;
            }
        }
    
        // 合計
        if(count($registTotalForMonthly) && count($accessTotalForMonthly)){
    
            if(!array_sum($registTotalForMonthly) OR !array_sum($accessTotalForMonthly)){
                $tempCvrTotal = 0 ;
            } else {
                $tempCvrTotal = array_sum($registTotalForMonthly)/array_sum($accessTotalForMonthly)  ;
            }
            $cvrTotal = $tempCvrTotal*100;
            $cvrTotal = number_format($cvrTotal  ,1,".","") ;
        } else {
            $cvrTotal = 0 ;
        }
    
        $smartyOBJ->assign("baitaiCvrList", $baitaiCvrList);
        $smartyOBJ->assign("cvrTotalForMediaCd", $cvrTotalForMediaCd);
        $smartyOBJ->assign("cvrTotalForMonthly", $cvrTotalForMonthly);
        $smartyOBJ->assign("cvrTotal", $cvrTotal);
    
        /*********************/
        /***  ROIリスト ***/
        /*********************/
        foreach($baitaiTradeAmountList as $mediaCdKey => $baitaiTradeAmountVal){
            foreach($baitaiTradeAmountVal as $dateKey => $baitaiTradeAmountIntervalsOfMonthVal){
                if(!$baitaiTradeAmountIntervalsOfMonthVal OR !$revisedAdvertiseExpenses[$mediaCdKey][$dateKey]){
                    $roiDateList[$mediaCdKey][$dateKey] = 0 ;
                    continue ;
                }
                $roi = $baitaiTradeAmountIntervalsOfMonthVal/$revisedAdvertiseExpenses[$mediaCdKey][$dateKey] ;
                $roiDateList[$mediaCdKey][$dateKey] = $roi*100 ;
            }
        
        }
        // ROI合計を生成
        if ($roiDateList) {
            foreach ($roiDateList as $advertiseKey => $list) {
                foreach ($dispMonthAdvertiseExpenses as $month) {
                    $roiList[$advertiseKey][$month] = number_format($list[$month]  ,1,".","") ;
                }
            }
        } else {
            foreach ($dispMonthAdvertiseExpenses as $month) {
                // 月毎の合計
                $roiTotalForMonthly[$month] = 0;
            }
        }
    
        // 表示するROIテーブル
        if ($displayMediaCdList) {
            foreach ($displayMediaCdList as $cdKey => $cdVal) {
                if ($roiList[$cdVal]) {
                    $baitaiRoiList[$cdVal] = $roiList[$cdVal];
                } else {
                    foreach ($dispMonthAdvertiseExpenses as $monthKey => $monthVal) {
                        $baitaiRoiList[$cdVal][$monthVal] = 0;
                    }
                }
            }
        }
    
        // 月毎の合計
        foreach($payTotalForMonthly as $dateKey => $payTotal){
            if(!$payTotal  OR !$advertiseExpensesTotalForMonthly[$dateKey]){
                $tempMonthLyTotalRoi = 0 ;
            } else {
                $tempMonthLyTotalRoi = $payTotal/$advertiseExpensesTotalForMonthly[$dateKey] ;
            }
    
            $monthLyTotalRoi =$tempMonthLyTotalRoi * 100 ;
            $roiTotalForMonthly[$dateKey] = number_format($monthLyTotalRoi  ,1,".","") ;
        }
        // 媒体ごとの合計
        if(count($payTotalForMediaCd)){
            foreach($payTotalForMediaCd as $mediaCdKey => $payTotalVal){
    
                if(!$payTotalVal OR !$advertiseExpensesTotalForMediaCd[$mediaCdKey]){
                    $tempRoi = 0 ;
                } else {
                    $tempRoi = $payTotalVal/$advertiseExpensesTotalForMediaCd[$mediaCdKey] ;
                }
    
                $roi = $tempRoi * 100 ;
                $roiTotalForMediaCd[$mediaCdKey] =  number_format($roi ,1,".","")  ;
            }
        }
        // 合計
        if(count($payTotalForMonthly) && count($advertiseExpensesTotalForMonthly)){
            if(!array_sum($payTotalForMonthly) OR !array_sum($advertiseExpensesTotalForMonthly)){
                $tempRoiTotal = 0 ;
            } else {
                $tempRoiTotal = array_sum($payTotalForMonthly)/array_sum($advertiseExpensesTotalForMonthly)  ;
            }
    
            $roiTotal = $tempRoiTotal *100;
            $roiTotal = number_format($roiTotal  ,1,".","") ;
        } else {
            $roiTotal = 0 ;
        }
    
        $smartyOBJ->assign("baitaiRoiList", $baitaiRoiList);
        $smartyOBJ->assign("roiTotalForMediaCd", $roiTotalForMediaCd);
        $smartyOBJ->assign("roiTotalForMonthly", $roiTotalForMonthly);
        $smartyOBJ->assign("roiTotal", $roiTotal);
    
    }
}
// エラーメッセージ
$smartyOBJ->assign("errMsg", $errMsg);

?>
