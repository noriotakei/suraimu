<?php
/*
*       月額コースユーザデータリスト
*       monthlyCourseUserList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
$AdmAdminOBJ = AdmAdmin::getInstance();
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

$offset = $requestOBJ->getParameter("user_offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "user_offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 5;

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("message");
$returnSessOBJ = new ComSessionNamespace("return");

// メッセージの取得
$smartyOBJ->assign("msg", $execMsgSessOBJ->getIterator());

// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 商品カテゴリーリスト取得
$monthlyCourseUserList = $AdmMonthlyCourseOBJ->getAllMonthlyCourseUserList($param, $offset, "id DESC", $dispCnt);

// 表示件数取得
$totalCount = $AdmMonthlyCourseOBJ->getFoundRows();

foreach ((array)$monthlyCourseUserList as $key => $val) {
    if ($val["is_invalid"]) {
        $monthlyCourseUserList[$key]["style"] = "style=\"background-color:pink;\"";
    } else if ($val["limit_end_date"] < date("Y-m-d")) {
        $monthlyCourseUserList[$key]["style"] = "style=\"background-color:gray;\"";
    }

    if($adminData = $AdmAdminOBJ->getData($val["admin_id"])){
        $monthlyCourseUserList[$key]["admin"] = $adminData["name"];
    }

}

$dispFirst = $offset + 1;
$dispLast = $offset + count($monthlyCourseUserList);

$smartyOBJ->assign("monthlyCourseUserList", $monthlyCourseUserList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);


// 表示場所名
//$smartyOBJ->assign("displayPositionList", AdmInformationStatus::$_displayPositionName);

$tags = array(
            "user_id",
            "search_user_id",
            "monthly_course_name",
            "monthly_course_id",
            "monthly_course_group_id",
            "create_type",
            "monthly_course_start_date",
            "monthly_course_end_date",
            "specify_monthly_update",
            "monthly_update_item_id",
            "admin_id",
            "search_flag",
            "offset",
            //"user_offset",
            );

$reloadTags = array(
            "user_id",
            "search_user_id",
            "monthly_course_name",
            "monthly_course_id",
            "monthly_course_group_id",
            "create_type",
            "monthly_course_start_date",
            "monthly_course_end_date",
            "specify_monthly_update",
            "monthly_update_item_id",
            "admin_id",
            "search_flag",
            "offset",
            "user_offset",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("POSTparam", $POSTparam);

// <FORM>で渡す検索パラメーター
$smartyOBJ->assign("searchParam", $reloadParam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

//$smartyOBJ->assign("URLparam", $URLparam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["offset_name"] = "user_offset";
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "monthlyCourse_CourseUserData=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $registParam = $returnValue;
} else {
    $registParam["return_flag"] = 0;
}

$smartyOBJ->assign("param", $param);

// 戻り値の取得
$smartyOBJ->assign("registParam", $registParam);
// 表示フラグ
//$smartyOBJ->assign("isDisplay", AdmInformationStatus::$_isDisplay);
// 作成タイプ
$smartyOBJ->assign("createType", AdmMonthlyCourse::$_monthlyCourseUserCreateType);
// 無効フラグ
$smartyOBJ->assign("isInvalid", AdmMonthlyCourse::$_iSinvalid);

// 月額更新設定
$smartyOBJ->assign("isMonthlyUpdate", AdmMonthlyCourse::$_isMonthlyUpdate);

// 決済時デバイス種別
$smartyOBJ->assign("settleDeviceTypeSelectAry", AdmMonthlyCourse::$_settleDeviceTypeSelectAry);

// 月額コースリスト取得
$monthlyCourseList = $AdmMonthlyCourseOBJ->getMonthlyCourseListForSelect();
$smartyOBJ->assign("monthlyCourseList", $monthlyCourseList);

?>