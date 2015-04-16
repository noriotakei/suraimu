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

// Check user profile flag name
if(!ComValidation::isValue($param["user_profile_flag_name"])) {
    $errMsg[] = "user profile flag name is not null";
}

if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    header("Location: ./?action_User_UserProfileFlagData=1&user_profile_flag_code=" . $param["user_profile_flag_code"]);
    exit;
}

//set user profile flag
$setUserProfileFlagParam['name'] = $param['user_profile_flag_name'];
$setUserProfileFlagParam['convert_code'] = $param['convert_code'];

//set where
$whereUserProfileFlag[] = "code = '" . $param['user_profile_flag_code'] . "'";

//update
$errSessOBJ->errMsg = array("更新しました。");

if(!$AdminUserProfileFlagOBJ->updateUserProfileFlagData($setUserProfileFlagParam, $whereUserProfileFlag)) {
    $errSessOBJ->errMsg = array("更新できませんでした。");
}

header("Location: ./?action_User_UserProfileFlagData=1&user_profile_flag_code=" . $param["user_profile_flag_code"]);
exit;
?>