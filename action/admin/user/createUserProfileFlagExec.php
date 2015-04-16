<?php
/**
 *
 * @author hoang_minh
 * @since 2014/12/2
 */
require_once(D_BASE_DIR . "/common/admin_common.php");

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err");

//validate
$param["code"] =$param["user_profile_flag_code"] ;

if (! ComValidation::isNumeric($param["user_profile_flag_code"])) {
    $errMsg[] = "ユーザプロファイルフラグコードは整数でなければなりません。";
} elseif ($AdminUserProfileFlagOBJ->getUserProfileFlag($param)) {
    $errMsg[] = "ユーザプロファイルフラグコードが既存在しています。";
}

if (! ComValidation::isValue($param["user_profile_flag_name"])) {
    $errMsg[] = "ユーザープロファイルフラグ名がNULLではいけません。";
}

if (! ComValidation::isNumeric($param["user_profile_flag_convert_code"])) {
	$errMsg[] = "ユーザプロファイルフラグコンバートコードは整数でなければなりません。";
}

if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    header("Location: ./?action_User_UserProfileFlagList=1");
    exit;
}

//set user profile flag data
$setUserProfileFlagParam['code'] = $param['user_profile_flag_code'];
$setUserProfileFlagParam['name'] = $param['user_profile_flag_name'];
$setUserProfileFlagParam['convert_code'] = $param['user_profile_flag_convert_code'];

//insert
$errSessOBJ->errMsg = array("更新しました。");

if(!$AdminUserProfileFlagOBJ->insertUserProfileFlagData($setUserProfileFlagParam)) {
    $errSessOBJ->errMsg = array("更新できませんでした。");
}

header("Location: ./?action_User_UserProfileFlagList=1");
exit;
?>