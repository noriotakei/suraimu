<?php
/**
 * freeWordDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面フリーワード設定登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norio takei
 */



require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmFreeWordOBJ = AdmFreeWord::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$freeWordCd = $param["fwc"] ;

foreach($param as $key => $val){
    if(eregi("free_word_value", $key )){
    	$explodeFreeWordKey = explode("__",$key) ;
        $freeWordAry[$explodeFreeWordKey[1]] = $val ;
    }
}

foreach($freeWordAry as $key => $val){

    $freeWordType = 2 ;
    $freeWordVal    = $key ;

    // ﾌﾘｰﾜｰﾄﾞ取得 ﾃﾞｰﾀ有りｱｯﾌﾟﾃﾞｰﾄ ﾃﾞｰﾀ無しｲﾝｻｰﾄ
    if($data = $AdmFreeWordOBJ->getFreeWordDataForEdit($freeWordType,$freeWordCd,$freeWordVal)){
        $updateArray = array() ;
        $whereArray = array() ;
 
        $updateArray["free_word_text"] = $val;
        $updateArray["update_datetime"] = date("YmdHis");
        $whereArray[] = "free_word_type = 2" ;
        $whereArray[] = "free_word_cd = ".$freeWordCd ;
        $whereArray[] = "free_word_value = ".$freeWordVal ;

        if(!$AdmFreeWordOBJ->updateFreeWordData($updateArray, $whereArray) ){
            $messageSessOBJ->message = $AdmFreeWordOBJ->getErrorMsg();
            header("Location: ./?action_freeWord_FreeWordList=1");
            exit();
        }

    } else {
        $insertArray = array() ;

        $insertArray["free_word_type"] = 2 ;
        $insertArray["free_word_cd"] = $freeWordCd ;
        $insertArray["free_word_value"] = $freeWordVal  ;
        $insertArray["free_word_text"] = $val  ;
        $insertArray["create_datetime"] = date("YmdHis") ;
        $insertArray["update_datetime"] = date("YmdHis") ;

        if(!$AdmFreeWordOBJ->insertFreeWordData($insertArray) ){
            $messageSessOBJ->message = $AdmFreeWordOBJ->getErrorMsg();
            header("Location: ./?action_freeWord_FreeWordList=1");
            exit();
        }

    }

}

$tags = array(
            "fwc",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$messageSessOBJ->message = array("更新しました。");
header("Location: ./?action_freeWord_freeWordData=1&" . $URLparam);
exit();

?>