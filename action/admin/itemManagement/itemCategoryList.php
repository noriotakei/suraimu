<?php
/*
*       商品カテゴリーリスト
*       itemCategoryList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admItemOBJ = AdmItem::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 10;

$smartyOBJ->assign("param", $param);

// 商品カテゴリーリスト取得
$itemCategoryList = $admItemOBJ->getItemCategoryList($param, $offset, "sort_seq DESC, id DESC", $dispCnt);
$totalCount = $admItemOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($itemCategoryList);

$smartyOBJ->assign("itemCategoryList", $itemCategoryList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);


// 表示場所名
$smartyOBJ->assign("displayPositionList", AdmInformationStatus::$_displayPositionName);

$tags = array(
            "icid",
            );

$reloadTags = array(
            "icid",
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
$pagerArray["action_name"] = "itemManagement_itemCategoryList=1";
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
$smartyOBJ->assign("isDisplay", AdmInformationStatus::$_isDisplay);

// カテゴリーグループ
$smartyOBJ->assign("categoryGroupSelect", AdmItem::$_categoryGroupAry);

?>