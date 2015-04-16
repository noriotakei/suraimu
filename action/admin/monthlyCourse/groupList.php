<?php
/*
*       月額コースグループリスト
*       groupList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 10;

$smartyOBJ->assign("param", $param);

// 商品カテゴリーリスト取得
$monthlyCourseGroupList = $admMonthlyCourseOBJ->getMonthlyCourseGroupList($param, $offset, "sort_seq DESC, id DESC", $dispCnt);
$totalCount = $admMonthlyCourseOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($monthlyCourseGroupList);

$smartyOBJ->assign("monthlyCourseGroupList", $monthlyCourseGroupList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "mcgid",
            );

$reloadTags = array(
            "mcgid",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "MonthlyCourse_groupList=1";
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

// 戻り値の取得
$smartyOBJ->assign("registParam", $registParam);
// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmMonthlyCourse::$_isDisplay);

?>