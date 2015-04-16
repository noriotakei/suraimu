<?php

/**
 * convert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * コンバート対象媒体コード集計ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmCalculationOBJ = AdmCalculation::getInstance();
// 期間指定
if( (ComValidation::isDate($param["start_date"])) AND (ComValidation::isDate($param["end_date"])) ){

    $param["3month_date"] = date("Y-m-d 00:00:00", strtotime($param["start_date"]." -2 month"));
/*    
    //コンバート対象媒体コードの売上集計
    $tradeSql = "
    SELECT trade.`media_cd` AS trade_media_cd, 
    SUM(CASE WHEN trade_datetime between '" . $param["start_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' THEN trade_amount ELSE 0 END) as trade_amount, 
    SUM(CASE WHEN trade_datetime between '" . $param["start_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' AND user_regist_datetime between '" . $param["start_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' THEN trade_amount ELSE 0 END) as regist_amount, 
    SUM(CASE WHEN trade_datetime between '" . $param["start_date"]  . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' AND user_regist_datetime between '" . $param["3month_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59'THEN trade_amount ELSE 0 END) AS 3month_amount 
    FROM `v_trade_user` AS trade
    WHERE EXISTS(
    SELECT * FROM cnv_user AS cnv 
    WHERE convert_media_cd = '".$param["media_cd"]."' 
    AND cnv.media_cd = trade.media_cd
    ) 
    GROUP BY trade.media_cd
    ";
    
    if (!$tradeData = $AdmCalculationOBJ->executeQuery($tradeSql)) {
        exit(__LINE__);
    }
    $tradeDataArray = array();
    $allTradeAmount = 0;
    $allRegistAmount = 0;
    $all3MonthAmount = 0;
    $tradeDataList = $tradeData->fetchAll();
    foreach($tradeDataList AS $key => $value ){
        $tradeDataArray[$value['trade_media_cd']]['trade_amount'] = $value['trade_amount'];
        $tradeDataArray[$value['trade_media_cd']]['regist_amount'] = $value['regist_amount'];
        $tradeDataArray[$value['trade_media_cd']]['3month_amount'] = $value['3month_amount'];
    
        $allTradeAmount  += $value['trade_amount'];
        $allRegistAmount += $value['regist_amount'];
        $all3MonthAmount += $value['3month_amount'];
    }
    
    //コンバート対象媒体コードの新規登録集計
    $registSql = "
    SELECT media_cd,count(user_id) AS countUser
    FROM v_user_profile 
    WHERE EXISTS(
    SELECT * FROM cnv_user AS cnv
     WHERE cnv.media_cd = v_user_profile.media_cd
     AND cnv.convert_media_cd = '".$param["media_cd"]."'
    )
    AND pre_regist_datetime BETWEEN '" . $param["start_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' 
    AND v_user_profile.user_disable = 0 
    GROUP BY media_cd
    ";
    if (!$registData = $AdmCalculationOBJ->executeQuery($registSql)) {
        exit(__LINE__);
    }
    $registDataArray = array();
    $allRegistCount = 0;
    $registdataList = $registData->fetchAll();
    foreach($registdataList AS $key => $value ){
        $registDataArray[$value['media_cd']] = $value['countUser'];
        $allRegistCount += $value['countUser'];
    }
*/    
    //コンバート先での売上集計
    //コンバート先サイトより売上データを移植してログインIDと紐付けて集計します
    $ConvertTradeSql = "
    SELECT user.media_cd,
    sum(case when cnv.trade_datetime between '" . $param["start_date"]  . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' THEN trade_amount ELSE 0 END) AS trade_amount, 
    sum(case when cnv.trade_datetime between '" . $param["start_date"]  . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' AND cnv.regist_datetime between '" . $param["start_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' THEN trade_amount ELSE 0 END) AS regist_amount, 
    sum(case when cnv.trade_datetime between '" . $param["start_date"]  . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59' AND cnv.regist_datetime between '" . $param["3month_date"] . " 00:00:00' AND '" . $param["end_date"] . " 23:59:59'THEN trade_amount ELSE 0 END) AS 3month_amount 
    FROM (select login_id,media_cd,disable from user group by login_id) as user,`cnv_trade` AS cnv
    WHERE cnv.convert_media_cd = '".$param["media_cd"]."'
    AND user.login_id = cnv.login_id 

    GROUP BY user.media_cd
    ";
    
    if (!$ConvertTradeData = $AdmCalculationOBJ->executeQuery($ConvertTradeSql)) {
        exit(__LINE__);
    }
    
    $ConvertTradeDataArray = array();
    $allConvertTradeAmount = 0;
    $allConvertRegistAmount = 0;
    $allConvert3MonthAmount = 0;
    $ConvertTradeDataList = $ConvertTradeData->fetchAll();
    
    foreach($ConvertTradeDataList AS $key => $value ){
        $ConvertTradeDataArray[$value['media_cd']]['trade_amount']  = $value['trade_amount'];
        $ConvertTradeDataArray[$value['media_cd']]['regist_amount'] = $value['regist_amount'];
        $ConvertTradeDataArray[$value['media_cd']]['3month_amount'] = $value['3month_amount'];
    
        $allConvertTradeAmount  += $value['trade_amount'];
        $allConvertRegistAmount += $value['regist_amount'];
        $allConvert3MonthAmount += $value['3month_amount'];
    }
    
    //コンバート対象アドコード一覧
    $mediaCdSql = "
    SELECT media_cd
    FROM `cnv_user`
    WHERE convert_media_cd = '".$param["media_cd"]."'
    AND media_cd != ''
    group by media_cd
    order by media_cd 
    ";
    
    if (!$mediaCdData = $AdmCalculationOBJ->executeQuery($mediaCdSql)) {
        exit(__LINE__);
    }
    
    $mediaCdDataList = $mediaCdData->fetchAll();
    
    //コンバート対象アドコード一覧に該当するデータを組み入れます
    $mediaCdDataArray = array();
    //$synthesisRegistCount  = 0;
    $synthesisTradeAmount  = 0;
    $synthesisRegistAmount = 0;
    $synthesis3MonthAmount = 0;

    foreach($mediaCdDataList AS $key => $value ){
/*    
        if($registDataArray[$value['media_cd']]){
            $mediaCdDataArray[$value['media_cd']]['countUser'] = $registDataArray[$value['media_cd']];
        }else{
            $mediaCdDataArray[$value['media_cd']]['countUser'] = 0;
        }
*/
/*    
        if($tradeDataArray[$value['media_cd']]){
            $mediaCdDataArray[$value['media_cd']]['trade_amount'] = $tradeDataArray[$value['media_cd']]['trade_amount'];
            $mediaCdDataArray[$value['media_cd']]['regist_amount'] = $tradeDataArray[$value['media_cd']]['regist_amount'];
            $mediaCdDataArray[$value['media_cd']]['3month_amount'] = $tradeDataArray[$value['media_cd']]['3month_amount'];
        }else{
            $mediaCdDataArray[$value['media_cd']]['trade_amount']  = 0;
            $mediaCdDataArray[$value['media_cd']]['regist_amount'] = 0;
            $mediaCdDataArray[$value['media_cd']]['3month_amount'] = 0;
        }
*/    
        if($ConvertTradeDataArray[$value['media_cd']]){
            $mediaCdDataArray[$value['media_cd']]['convert_trade_amount']  = $ConvertTradeDataArray[$value['media_cd']]['trade_amount'];
            $mediaCdDataArray[$value['media_cd']]['convert_regist_amount'] = $ConvertTradeDataArray[$value['media_cd']]['regist_amount'];
            $mediaCdDataArray[$value['media_cd']]['convert_3month_amount'] = $ConvertTradeDataArray[$value['media_cd']]['3month_amount'];
        }else{
            $mediaCdDataArray[$value['media_cd']]['convert_trade_amount']  = 0;
            $mediaCdDataArray[$value['media_cd']]['convert_regist_amount'] = 0;
            $mediaCdDataArray[$value['media_cd']]['convert_3month_amount'] = 0;
        }
    
        $mediaCdDataArray[$value['media_cd']]['trade_amount_all']   = $ConvertTradeDataArray[$value['media_cd']]['trade_amount']  + $tradeDataArray[$value['media_cd']]['trade_amount'];
        $mediaCdDataArray[$value['media_cd']]['regist_amount_all']  = $ConvertTradeDataArray[$value['media_cd']]['regist_amount'] + $tradeDataArray[$value['media_cd']]['regist_amount'];
        $mediaCdDataArray[$value['media_cd']]['3month_amount_all']  = $ConvertTradeDataArray[$value['media_cd']]['3month_amount'] + $tradeDataArray[$value['media_cd']]['3month_amount'];

        $synthesisTradeAmount  += $mediaCdDataArray[$value['media_cd']]['trade_amount_all'];
        $synthesisRegistAmount += $mediaCdDataArray[$value['media_cd']]['regist_amount_all'];
        $synthesis3MonthAmount += $mediaCdDataArray[$value['media_cd']]['3month_amount_all'];
        $synthesisRegistCount  += $mediaCdDataArray[$value['media_cd']]['countUser'];

    }
}
//
$targetMediaCdArray = array(
                        "zf00010" => "zf00010"
                        ,"zf00012" => "zf00012"
                        ,"zf00013" => "zf00013"
                        ,"zf00014" => "zf00014"
                        );

// 表示状態
$smartyOBJ->assign("param", $param);
$smartyOBJ->assign("mediaCdDataArray"       , $mediaCdDataArray);
$smartyOBJ->assign("targetMediaCdArray"     , $targetMediaCdArray);
/*
$smartyOBJ->assign("allTradeAmount"         , number_format($allTradeAmount));
$smartyOBJ->assign("allRegistAmount"        , number_format($allRegistAmount));
$smartyOBJ->assign("all3MonthAmount"        , number_format($all3MonthAmount));
$smartyOBJ->assign("allRegistCount"         , number_format($allRegistCount));
*/
$smartyOBJ->assign("allConvertTradeAmount"  , number_format($allConvertTradeAmount));
$smartyOBJ->assign("allConvertRegistAmount" , number_format($allConvertRegistAmount));
$smartyOBJ->assign("allConvert3MonthAmount" , number_format($allConvert3MonthAmount));
$smartyOBJ->assign("synthesisTradeAmount"   , number_format($synthesisTradeAmount));
$smartyOBJ->assign("synthesisRegistAmount"  , number_format($synthesisRegistAmount));
$smartyOBJ->assign("synthesis3MonthAmount"  , number_format($synthesis3MonthAmount));
$smartyOBJ->assign("synthesisRegistCount"   , number_format($synthesisRegistCount));
?>
