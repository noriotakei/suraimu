<?php
/*
 * 月額コースリスト
 * courseList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $msg);

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// 検索項目の取得
$searchValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻ってきた場合の検索条件
if ($searchValue) {
    $param = $searchValue;
}

/*
// 入力日時の生成
$param["searchDatetimeFrom"] = $param["search_datetime_from_date"]
                        . " " . $param["search_datetime_from_time"];

if (!ComValidation::isDatetime($param["searchDatetimeFrom"])) {
    $param["searchDatetimeFrom"] = date("H:00:00");
}

$param["searchDatetimeTo"] = $param["search_datetime_to_date"]
                        . " " . $param["search_datetime_to_time"];

if (!ComValidation::isDatetime($param["searchDatetimeTo"])) {
    $param["searchDatetimeTo"] = date("H:00:00");
}

if (!ComValidation::isNumeric($param["search_conditions_id"])) {
    $param["search_conditions_id"] = "";
}
*/
// ID表示順の設定
if ($param["sort_id"]) {
    if ($param["sort_id"] == "asc") {
        // 昇順
        $orderBy = "monthly_course.id ASC ";
        // パラメータ切り替え
        $sort["sort_id"] = "dsc";
    } else {
        // 降順
        $orderBy = "monthly_course.id DESC ";
        // パラメータ切り替え
        $sort["sort_id"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_id"] = "asc";
    if (!$sort["sort_seq"]) {
        $orderBy = "monthly_course.id DESC ";
    }
}

// 表示優先順位の設定
if ($param["sort_seq"]) {
    if ($param["sort_seq"] == "asc") {
        // 昇順
        $orderBy = "monthly_course.sort_seq ASC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "dsc";
    } else {
        // 降順
        $orderBy = "monthly_course.sort_seq DESC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_seq"] = "asc";
}

$smartyOBJ->assign("sort", $sort);
$smartyOBJ->assign("param", $param);

// 表示状態
$smartyOBJ->assign("isDisplay", AdmMonthlyCourse::$_isDisplay);

// 強制注文フラグ
//$smartyOBJ->assign("isSelfOrder", AdmMonthlyCourse::$_isSelfOrder);

// 商品リストの取得
$monthlyCourseList = $admMonthlyCourseOBJ->getMonthlyCourseList($param, $offset, $orderBy, $dispCnt);
/*
if ($monthlyCourseList) {
    while (list($key, $val) = each($monthlyCourseList)) {
        if (!(($val["sales_start_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["sales_start_datetime"]) <= time())
             AND ($val["sales_end_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["sales_end_datetime"]) >= time())) OR !$val["is_display"]) {
            $monthlyCourseList[$key]["not_display_flag"] = 1;
        }
    }
}
*/
$totalCount = $admMonthlyCourseOBJ->getFoundRows();

$dispFirst = $offset + 1;
$dispLast = $offset + count($monthlyCourseList);

$smartyOBJ->assign("monthlyCourseList", $monthlyCourseList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "search_group_id",
            "search_is_display",
            "search_type",
            "search_course_id",
            "specify_keyword",
            "search_string",
            );

$reloadTags = array(
            "search_group_id",
            "search_is_display",
            "search_type",
            "search_course_id",
            "specify_keyword",
            "search_string",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

// aタグで渡す検索パラメーター
$addParam = "";
if ($param["sort_id"]) {
    $addParam .= "&sort_id=" . $param["sort_id"];
}
if ($param["sort_seq"]) {
    $addParam .= "&sort_seq=" . $param["sort_seq"];
}
$smartyOBJ->assign("URLparam", "&offset=" . $offset . $addParam . "&" . $URLparam);

// ソートリンクのパラメーター(ID,表示優先順位)
$smartyOBJ->assign("sortParam", "&offset=" . $offset . "&" . $URLparam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// <FORM>で渡すパラメーター
$smartyOBJ->assign("searchParam", $reloadParam);

// ページリンク生成
$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "MonthlyCourse_CourseList=1";
$pagerArray["additional_param"] = $addParam . "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 検索用データ取得(カテゴリーの登録が有るか無いかで配列内容が違う)
$searchMonthlyCourseGroupList = $admMonthlyCourseOBJ->getMonthlyCourseGroupForSelect();
if ($searchMonthlyCourseGroupList) {
    $smartyOBJ->assign("searchMonthlyCourseGroupList", array("0" => "気にしない") + (array)$searchMonthlyCourseGroupList);
} else {
    $smartyOBJ->assign("searchMonthlyCourseGroupList", array("0" => "気にしない"));
}
$smartyOBJ->assign("searchTypeAry", AdmMonthlyCourse::$_searchTypeAry);
$smartyOBJ->assign("specifyKeywordAry", AdmMonthlyCourse::$_specifyKeywordAry);

// 商品データ一括操作用
$smartyOBJ->assign("batchOperateMonthlyCourseSelectAry", AdmMonthlyCourse::$_batchOperateMonthlyCourseSelectAry);

if ($searchMonthlyCourseGroupList) {
    $smartyOBJ->assign("groupList", $searchMonthlyCourseGroupList);
} else {
    $smartyOBJ->assign("groupList", array("0" => "現在カテゴリーの登録がありません"));
}

// 現在は使用してないのでコメント(いつか使うかも)
//$smartyOBJ->assign("searchIsSelfOrder", array("0" => "気にしない") + AdmMonthlyCourse::$_searchIsSelfOrder);

?>