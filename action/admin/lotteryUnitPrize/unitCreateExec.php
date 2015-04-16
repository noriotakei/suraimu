<?php
/**
 * unitCreateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面抽選ユニット登録ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));
ini_set("memory_limit", "-1");
$AdmUnitOBJ = AdmUnit::getInstance();
$AdmUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションにセットします
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$errSessOBJ = new ComSessionNamespace("err");

$requestOBJ->setParameter("sesKey", $param["sesKey"]);
$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}
foreach($param["number"] as $val){
    if (!ComValidation::isNumeric($val) && $val) {
        $messageSessOBJ->message[] = "確率が設定されていません。";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    }
}
$userList = $AdmUserOBJ->getUserList($searchParam);
$totalCount = $AdmUserOBJ->getFoundRows();

$smartyOBJ->assign("totalCount", $totalCount);

//高確率の場合の配列
$specificProbabilityAry = array("pattern1" => "4,4","pattern2" => "4,6","pattern3" => "2,4") ;
//該当者0ユニット作成用配列
$notLotteryUnit = $param["number"] ;

foreach( $param["number"] as $probabilityKey  => $probabilityVal ){
    $pattern = "" ;
    $notSpecificProbability = "" ;

    if(!$probabilityVal){
    	continue ;
    }

    if($probabilityVal >=65 AND $probabilityVal <= 75){
        $pattern = "pattern1" ;
    } else if($probabilityVal >=76 AND $probabilityVal <= 85) {
        $pattern = "pattern2" ;    	
    } else if($probabilityVal >=85 AND $probabilityVal <=95 ) {
        $pattern = "pattern3" ;    	
    } else{
    	$notSpecificProbability = TRUE ;
    }

    if($notSpecificProbability){
        //確率を計算します。
        $probability = 100/$probabilityVal ;
        //四捨五入します。
        $probabilityGonyu = round($probability) ;
        foreach($userList as $userVal){
            $probabilityResult = rand(1,$probabilityGonyu) ;
            //当たったら！
            if($probabilityResult == 1){
                $lotteryUnitUser[$probabilityKey][] = $userVal["user_id"] ;
                unset($notLotteryUnit[$probabilityKey]);
            }
        }
    }

    if(!$notSpecificProbability){
        //確率を計算します。
        $specificProbability = $specificProbabilityAry[$pattern] ;
        $probabilityAry = explode(",",$specificProbability) ;
        foreach($userList as $userVal){
            for($i = 1;$i <= $probabilityAry[1]; $i++){
                $probabilityResult = rand(1,$probabilityAry[0]) ;
                //当たったら！
                if($probabilityResult == 1){
                    $lotteryUnitUser[$probabilityKey][] = $userVal["user_id"] ;
                    unset($notLotteryUnit[$probabilityKey]);
                    break ;
                }
            }
        }
    }
}

$smartyOBJ->assign("whereContents", $AdmUserOBJ->getWhereContents());

$whereArray = $AdmUserOBJ->setWhereString($searchParam);

$AdmUnitOBJ->beginTransaction();

foreach($lotteryUnitUser as $key => $userValAry){

    $whereAddArray = array() ;
    foreach($userValAry as $userVal){
       $whereAddArray[] ="v_user_profile.user_id = ".$userVal ;    	
    }
    $whereAddStr = implode(" OR ",$whereAddArray) ;
    $whereArray = array() ;
    $whereArray[] = "( ".$whereAddStr." )" ;
    // ユニット登録
    $insertLotteryUnitData = array() ;
    $insertLotteryUnitData["create_datetime"] = date("YmdHis");
    $insertLotteryUnitData["comment"] = $param["comment"][$key];
    $insertLotteryUnitData["number"] = count($userValAry);
    $insertLotteryUnitData["probability"] = $param["number"][$key];
    // 検索条件登録
    $insertLotteryUnitData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");
    
    if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertLotteryUnitData($insertLotteryUnitData)) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        $AdmUnitOBJ->rollbackTransaction();
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    }
    $lotteryUnitId = $AdmUnitOBJ->getInsertId();
    $columnArray = array() ;
    $columnArray[] = $lotteryUnitId;
    $columnArray[] = "user_id";
    $columnArray[] = "NOW()";

    $listSql = $AdmUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

    // 検索条件SQLタグ登録
    $updateLotteryUnitData["sql_part"] = $requestOBJ->getParameterEscape($listSql, "sql");
    $updateLotteryUnitData["update_datetime"] = date("YmdHis");
    if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->updateLotteryUnitData($updateLotteryUnitData, array("id = " . $lotteryUnitId))) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        $AdmUnitOBJ->rollbackTransaction();
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    
    }

    // ユニットユーザー登録
    $insertColmun = array() ;
    $insertColmun[] = "lottery_unit_id";
    $insertColmun[] = "user_id";
    $insertColmun[] = "create_datetime";

    if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertLotteryUnitUserData($insertColmun, $listSql)) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        $AdmUnitOBJ->rollbackTransaction();
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    }

    //表示用配列作成
    $displayLotteryResult[$key]["number"] = $param["number"][$key]  ; //DBでは当選人数。表示は確率。
    $displayLotteryResult[$key]["comment"] = $param["comment"][$key]  ;
    $displayLotteryResult[$key]["lotteryUserCount"] = count($userValAry);
    $displayLotteryResult[$key]["lotteryUnitId"] = $lotteryUnitId;
}

//該当者0ユニット(外れ抽選会)作成
foreach($notLotteryUnit as $key => $probabilityVal){

    if(!$probabilityVal){
        continue ;
    }

    $whereArray = array() ;
    $whereArray[] ="v_user_profile.user_id = ?????" ; 
    // ユニット登録
    $insertNotLotteryUnitData = array() ;
    $insertNotLotteryUnitData["create_datetime"] = date("YmdHis");
    $insertNotLotteryUnitData["comment"] = $param["comment"][$key];
    $insertNotLotteryUnitData["number"] = 0;
    $insertNotLotteryUnitData["probability"] = $param["number"][$key];
    // 検索条件登録
    $insertNotLotteryUnitData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");
    
    if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertLotteryUnitData($insertNotLotteryUnitData)) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        $AdmUnitOBJ->rollbackTransaction();
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    }
    $notLotteryUnitId = $AdmUnitOBJ->getInsertId();
    $columnArray = array() ;
    $columnArray[] = $notLotteryUnitId;
    $columnArray[] = "user_id";
    $columnArray[] = "NOW()";

    $listSql = $AdmUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

    // 検索条件SQLタグ登録
    $updateNotLotteryUnitData["sql_part"] = $requestOBJ->getParameterEscape($listSql, "sql");
    $updateNotLotteryUnitData["update_datetime"] = date("YmdHis");
    if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->updateLotteryUnitData($updateNotLotteryUnitData, array("id = " . $notLotteryUnitId))) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        $AdmUnitOBJ->rollbackTransaction();
        header("Location: ./?action_lotteryUnitPrize_UnitCreate=1&" . $URLparam);
        exit();
    
    }

    //表示用配列作成
    $displayNotLotteryResult[$key]["number"] = $param["number"][$key]  ; //DBでは当選人数。表示は確率。
    $displayNotLotteryResult[$key]["comment"] = $param["comment"][$key]  ;
    $displayNotLotteryResult[$key]["lotteryUserCount"] = 0;
    $displayNotLotteryResult[$key]["lotteryUnitId"] = $notLotteryUnitId;
}


$AdmUnitOBJ->commitTransaction();

$smartyOBJ->assign("displayLotteryResult", $displayLotteryResult);
$smartyOBJ->assign("displayNotLotteryResult", $displayNotLotteryResult);
$smartyOBJ->assign("msg", array("抽選ユニット作成しました。"));

$tags = array(
            "sesKey",
            );
$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
?>