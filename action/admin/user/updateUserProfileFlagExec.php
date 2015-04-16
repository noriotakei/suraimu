<?php

/**
 * Process update profile.userProfileFlag
 *
 * @author hoang minh
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$messageSessOBJ = new ComSessionNamespace("exec_msg");

$errSessOBJ = new ComSessionNamespace("err");

$param = $requestOBJ->getParameterExcept($exceptArray);

$userSearchSessOBJ = new ComSessionNamespace("user_search");

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}
/*
// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileCodeFlagList = array();
foreach ($userProfileFlagList as $item) {
    $userProfileCodeFlagList[] = $item['code'];
}

//check if user_profile_flag_code_update is exist in user_profile_flag table
if ( ! ComValidation::isNumeric($param['user_profile_flag_code_update']) || ! in_array($param['user_profile_flag_code_update'], $userProfileCodeFlagList)) {
    $messageSessOBJ->message = array('flag_code_error' => "は数値で入力してください");
    header("location: ./?action_user_List&" . $URLparam);
    exit;
}
*/
$whereArray = $AdminUserOBJ->setWhereString($searchParam);

//update profile.user_profile_flag_code data
$setProfileParam['profile.user_profile_flag_code'] = $param['user_profile_flag_code_update'];
$setProfileParam["profile.update_datetime"] = "'" . date("YmdHis") . "'";

//condition to update
$userProfileWhere = $whereArray;
$table = "profile join v_user_profile on profile.id = v_user_profile.profile_id";

// トランザクション開始
$AdminUserOBJ->beginTransaction();

if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, $table, false)) {
    $messageSessOBJ->message = array("更新できませんでした。");
    // ロールバック
    $AdminUserOBJ->rollbackTransaction();
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

$messageSessOBJ->message = array("更新しました。");

// コミット
$AdminUserOBJ->commitTransaction();

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;


?>
