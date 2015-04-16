<?php
/**
 * profileDetailExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ﾕｰｻﾞｰﾌﾟﾛﾌｨｰﾙ情報登録処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$validationOBJ = new ComArrayValidation($param);

if($param["bloodType_check"]){
    $updateData["blood_type"] = $param["bloodType"];
    $validationOBJ->check("bloodType", "血液型",
                            array("Value" => null));
}
if($param["sexCd_check"]){
    $updateData["sex_cd"] = $param["sexCd"];
    $validationOBJ->check("sexCd", "性別",
                            array("Numeric" => null));
}
if($param["birthYear_check"]){
    $validationOBJ->check("birthYear", "年",
                            array("Numeric" => null));
}
if($param["birthMonth_check"]){
    $validationOBJ->check("birthMonth", "月",
                            array("Numeric" => null));
}
if($param["birthDay_check"]){
    $validationOBJ->check("birthDay", "日",
                            array("Numeric" => null));
}
if($param["birthYear_check"] && $param["birthMonth_check"] && $param["birthDay_check"] ){
    if (mb_strlen($param["birthYear"]) != 4) {
        $validationOBJ->setErrorMessage("birthYear", "エラーです。数字の桁は4桁でお願いします。");
    }
    $limitBirthYear =  date("Y") - 20;
    $limitBirthDate = $limitBirthYear.$param["birthMonth"].$param["birthDay"] ;
    $BirthDate = $param["birthYear"].$param["birthMonth"].$param["birthDay"] ;

    if (($limitBirthDate <$BirthDate )  OR $param["birthYear"] <1900) {
        $validationOBJ->setErrorMessage("birthDate", "エラーです。生年月日が適当ではありません。");
    }
    $birthDate = $param["birthYear"]."-". $param["birthMonth"]."-". $param["birthDay"] ;
    $updateData["birth_date"] = mb_convert_kana($birthDate, a);
}

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""). "&" . $sessId);
    exit;
}

$UserOBJ = User::getInstance();
// ﾕｰｻﾞｰﾌﾟﾛﾌｨｰﾙ情報登録
if ($param["profile_flag"]) {
    $updateData["update_datetime"] = date("YmdHis");

    if($comUserData["user_id"]){
        $whereArray[] = "user_id = " .  $comUserData["user_id"];

        if (!$UserOBJ->updateProfileData($updateData, $whereArray)) {
            $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg;
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""). "&" . $sessId);
            exit();
        }
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    header("Location: ./?action_Information=1&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""). "&" . $sessId);
    exit();
}

//基本ここまでは来ない。ハズ。
header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""). "&" . $sessId);
exit;
?>
