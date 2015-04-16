<?php

/**
 *
 * @author hoang_minh
 * @since 2014/12/2
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get code flag
$param = $requestOBJ->getParameterExcept($exceptArray);

//get user profile code flag
$data = $AdminUserProfileFlagOBJ->getUserProfileFlag($param["user_profile_flag_code"]);

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

$smartyOBJ->assign("data", $data[0]);

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileFlagCodeList = array("0" => "フラグＯＦＦ");
foreach ($userProfileFlagList as $item) {
	$userProfileFlagCodeList += array(
			$item['code'] => $item['name']);
}
$smartyOBJ->assign("user_profile_flag_code_convert", $userProfileFlagCodeList);

$reloadTags = array(
            "user_profile_flag_code",
            );

$errSessOBJ = new ComSessionNamespace("err");
$errMsg = $errSessOBJ->getIterator();
$errSessOBJ->unsetAll();
$smartyOBJ->assign("errMsg", $errMsg);

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

