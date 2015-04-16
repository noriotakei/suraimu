<?php
/**
 * authExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

//2012/05時点ではID下xx桁の認証。
//似たような認証が増えたらこのファイルを改修して対応。
/**
 * 認証チェック処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio_takei
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$validationOBJ = new ComArrayValidation($param);

foreach($param as $key => $val){
    //ﾕｰｻﾞｰID下ｘ桁認証用
    if(eregi("user_id_shimo", $key )){
        $userIdShimoAry[substr($key,13)] = $val ;
    }
    //運営指定認証用
    if(eregi("auth", $key )){
        $authAry[substr($key,4)] = $val ;
    }
}

//ﾕｰｻﾞｰID下ｘ桁認証
if(count($userIdShimoAry)){
    foreach($userIdShimoAry as $numKey => $val){
    	$validationOBJ->check("user_id_shimo".$numKey, "ﾕｰｻﾞｰID下".$numKey."桁目",
        array("value" => null));
    }

    if ($validationOBJ->isError()) {
        $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
        header("Location: ./?action_InformationDecryption=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    $userIfShimoStrTmp = "" ;
    for($i = 10; $i >= 1; $i--) {
        $userIfShimoStrTmp .= $userIdShimoAry[$i] ;
    }

    $count = count($userIdShimoAry) ;

    $userIdshimoStr = substr($comUserData["user_id"],-$count,$count) ;

    //下xx桁の認証
    if($userIfShimoStrTmp  != $userIdshimoStr){
    
        $validationOBJ->setErrorMessage("user_id_shimo", "【会員IDが違います】");
        $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
        header("Location: ./?action_InformationDecryption=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
        exit ;
    }
}

//運営指定認証
if(count($authAry)){
    $specifiedAuthAry = array("yrotciv" =>1,"19610804"=>1) ;
    $authCount = count($specifiedAuthAry);

    foreach($authAry as $key => $val){
        if($specifiedAuthAry[$val]){
            $count += 1 ;
        }
    }

    //認証チェック
    if($authCount  != $count){
        $validationOBJ->setErrorMessage("auth", "認証コードが違います。");
        $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
        header("Location: ./?action_InformationDecryption=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
        exit ;
    }
}

header("Location: ./?action_InformationDecryption=1&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
