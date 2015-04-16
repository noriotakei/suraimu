<?php
/**
 * @author hoang minh
 * @since 2014/12/2
 *
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if ($returnSessOBJ->return) {
    $param = $returnSessOBJ->return;
}

$msg = $messageSessOBJ->getIterator();
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

//get user profile flag list
$dataList = $AdminUserProfileFlagOBJ->getUserProfileFlag(null, $offset, null, $dispCnt);

$totalCount = $AdminUserProfileFlagOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$reloadTags = array(
            "offset",
            );

$errSessOBJ = new ComSessionNamespace("err");
$errMsg = $errSessOBJ->getIterator();
$errSessOBJ->unsetAll();
$smartyOBJ->assign("errMsg", $errMsg);


$POSTParam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("POSTParam", $POSTParam);

$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "user_UserProfileFlagList=1";

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileFlagCodeList = array("0" => "フラグＯＦＦ");
foreach ($userProfileFlagList as $item) {
    $userProfileFlagCodeList += array(
            $item['code'] => $item['name']);
}
$sesParam['userProfileCodeFlagList'] = $userProfileFlagCodeList;
$smartyOBJ->assign("user_profile_flag_convert_code", $userProfileFlagCodeList);
?>