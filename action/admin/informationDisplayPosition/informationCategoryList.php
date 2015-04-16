<?php
/*
*       情報フォルダリスト
*       informationCategoryList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro Nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

$smartyOBJ->assign("param", $param);

// 情報表示場所リスト取得
$dispCategoryList = $AdmInfoDispPositionOBJ->getInformationCategoryList($param, $offset, "sort_seq DESC, id DESC", $dispCnt);
$totalCount = $AdmInfoDispPositionOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($dispCategoryList);

$smartyOBJ->assign("folderList", $dispCategoryList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$reloadTags = array(
            "offset",
            );

$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "informationDisplayPosition_InformationCategoryList=1";
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
$smartyOBJ->assign("isDisplay", AdmInformationDisplayPosition::$_isDisplay);

?>