<?php
/**
 * paymentLogFile.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面決済ログファイル一覧ページファイル。
 * 全体一挙取得はあきらめました。
 * @copyright   2009 Fraise, Inc.
 * @author      takuro ito
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

//ログファイルのディレクトリ（月別）取得
if($param['disp_date']){
    $baseDate = str_replace("-","",$param['disp_date']);
    $baseDir = substr($baseDate,0,6);
}else{
    $param['disp_date'] = date("Y-m-d");
    $baseDate = date("Ymd");
    $baseDir  = date("Ym");
}

$paymentLogFilePath = D_BASE_DIR . "/log/settlement/" . $baseDir . "/";

//ログファイル名取得(settlementクラスの$_payTypeArray内容に準拠)
$targetFileNameArray = Settlement::$_payTypeArray;

$paymentArray = array();
if($param['pay_type']){

    $readFlag = false;
    $targetFileName = $targetFileNameArray[$param['pay_type']];
    $targetFile = $paymentLogFilePath . 'settlement-' . $baseDate . '-' . $targetFileName . '.txt';

    //エンコーディングしないと文字化けです
    $targetValue = mb_convert_encoding($targetFile,'SJIS','auto');

    //file関数はエラーで止まってしまうので@で抑制
    $readFlag = false;
    if($dataList = @file($targetValue)){
        $readFlag = true;
    }

    //ファイル読み込み成功したら表示
    if($readFlag == true){
        foreach($dataList as $value){
            //[yyyy-mm-dd hh:ii:ss] ～形式の為、データ取得毎に整形します
            $timeString = substr($value,12,8);
            $main    = substr($value,22);
            $paymentArray[] = array("time" => $timeString
                                    ,"type" => $param['pay_type']
                                    ,"value" => mb_convert_encoding(trim($main),'UTF-8','auto')
                                    );
        } 
    }
}else{

    foreach($targetFileNameArray as $typeNum => $targetFileName){

        $readFlag = false;
        $targetFile = $paymentLogFilePath . 'settlement-' . $baseDate . '-' . $targetFileName . '.txt';

        //エンコーディングしないと文字化けです
        $targetValue = mb_convert_encoding($targetFile,'SJIS','auto');
   
        //file関数はエラーで止まってしまうので@で抑制
        if($logFileArray = @file($targetValue)){
            foreach($logFileArray as $value){
                //[yyyy-mm-dd hh:ii:ss] ～形式の為、データ取得毎に整形します
                $timeString = substr($value,12,8);
                $main    = substr($value,22);
                $paymentArray[] = array("time" => $timeString
                                        ,"type" => $typeNum 
                                        ,"value" => mb_convert_encoding(trim($main),'UTF-8','auto')
                                        );
            } 
        }
    }
}
if(count($paymentArray) >= 1){
    //時間でソートします
    foreach($paymentArray as $key => $row){
        $foo[$key] = $row["time"];
    }
       
    array_multisort($foo,SORT_ASC,$paymentArray);
}

$totalCount = count($paymentArray);
//決済項目はAdmOrderingから取得
$basePayTypeArray = array("" => "全体") + AdmOrdering::$_payType;

//決済ログが生成されない決済種別は排除します
$payTypeArray = array();
foreach($basePayTypeArray as $key => $value){
    switch($key){
    
        case AdmOrdering::PAY_TYPE_BITCASH:
            continue;       
        case AdmOrdering::PAY_TYPE_ADMIN:
            continue;       
        default:
            $payTypeArray[$key] = $value;
            break;
            
    }

}

// 表示状態
$smartyOBJ->assign("param", $param);
$smartyOBJ->assign("payType", $payTypeArray);
$smartyOBJ->assign("dataList", $paymentArray);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("payTypeNameArray", AdmOrdering::$_payType);
?>

