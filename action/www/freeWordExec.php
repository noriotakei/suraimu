<?php
/**
 * freeWordExec.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * フリーワード登録処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio_takei
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$validationOBJ = new ComArrayValidation($param);

//ﾌﾘｰﾜｰﾄﾞはfree_word_1(type)-1(cd)の形で渡ってくる。
//1(type)-1(cd)を添え字としたフリーワード配列を作成。
foreach($param as $key => $val){
    if(eregi("free_word", $key )){
    	$explodeFreeWordKey = explode("_",$key) ;
        $freeWordAry[$explodeFreeWordKey[2]] = $val ;
    }
}

//エラーチェック
foreach($freeWordAry as $key => $val){
   	$explodeTypeCdKey = explode("-",$key) ;
    //TYPEが1-xxの場合、xxの数字が桁とする。
    if($explodeTypeCdKey[0] ==1 ){
        if (mb_strlen($val) != $explodeTypeCdKey[1]) {
            $validationOBJ->setErrorMessage("free_word_strlen", "入力した数字の桁が適当ではありません。");
            break ;
        }
        if (!is_numeric($val)) {
            $validationOBJ->setErrorMessage("free_word_strlen", "入力は数字のみでお願いします。");
            break ;
        }
    }
}

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$freeWordOBJ = new FreeWord();

foreach($freeWordAry as $key => $val){
    $explodeTypeCdKey = explode("-",$key) ;
    $freeWordType = $explodeTypeCdKey[0] ;
    $freeWordCd    = $explodeTypeCdKey[1] ;

    $val = abs($val);

    // ﾌﾘｰﾜｰﾄﾞ取得 ﾃﾞｰﾀ有りｱｯﾌﾟﾃﾞｰﾄ ｾﾞｰﾀ無しｲﾝｻｰﾄ
    if($data = $freeWordOBJ->getFreeWordData($comUserData["user_id"],$freeWordType,$freeWordCd)){
        $updateArray = array() ;
        $whereArray = array() ;
 
        $updateArray["free_word_value"] = $val;
        $updateArray["update_datetime"] = date("YmdHis");

        if($freeWordType ==2 ){
            $freeWordSetData = $freeWordOBJ->getFreeWordSetData($freeWordType,$freeWordCd,$val) ;
            $updateArray["free_word_text"] = $freeWordSetData["free_word_text"];
        }

        $whereArray[] = "user_id = ".$comUserData["user_id"] ;
        $whereArray[] = "free_word_type = ".$freeWordType ;
        $whereArray[] = "free_word_cd = ".$freeWordCd ;
        $whereArray[] = "disable = 0 " ;

        if(!$freeWordOBJ->updateFreeWordData($updateArray, $whereArray) ){
            $ComErrSessOBJ->errMsg = $freeWordOBJ->getErrorMsg;
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
            exit();
        }

    } else {
        $insertArray = array() ;

        $insertArray["user_id"] = $comUserData["user_id"]  ;
        $insertArray["free_word_type"] = $freeWordType ;
        $insertArray["free_word_cd"] = $freeWordCd ;
        $insertArray["free_word_value"] = $val  ;
        $insertArray["create_datetime"] = date("YmdHis") ;

        if($freeWordType ==2 ){
            $freeWordSetData = $freeWordOBJ->getFreeWordSetData($freeWordType,$freeWordCd,$val) ;
            $insertArray["free_word_text"] = $freeWordSetData["free_word_text"];
        }

        if(!$freeWordOBJ->insertFreeWordData($insertArray) ){
            $ComErrSessOBJ->errMsg = $freeWordOBJ->getErrorMsg;
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
            exit();
        }

    }

}

if($param["remail"]){
    /******************/
    /* PC or MBへ送信 */
    /******************/

    $AutoMailOBJ = AutoMail::getInstance();

    // リメールデータの取得
    $mailAddress = $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"];
    $mailElementsData = $AutoMailOBJ->getAutoMailData("free_word", "free_word_".$param["remail"], $mailAddress);

    $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"], $convAry);
    // メール送信
    if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
        $SendMailOBJ = SendMail::getInstance();
        $errMailElements["subject"] = "フリワード入力リメール送信エラー";
        $errMailElements["text_body"] = "ユーザーID:" . $comUserData["user_id"]  . "\nユーザーにメール送信できませんでした。";

        // システムにエラーメール
        $SendMailOBJ->debugMailTo($errMailElements);

        header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_Information=1&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
