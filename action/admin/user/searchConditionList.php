<?php
/**
 * searchConditionList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面検索条件リストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdminUserOBJ = AdmUser::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);
$smartyOBJ->assign("param", $param);

$dispCnt = 20;

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

$dataList = $AdminUserOBJ->getUserSearchConditionList($param, $offset, "id DESC", $dispCnt);
$totalCount = $AdminUserOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$reloadTags = array(
            "category_id",
            "offset",
            );


$POSTParam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("POSTParam", $POSTParam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "user_SearchConditionList=1";
$pagerArray["additional_param"] = "&category_id=".$param['category_id'];

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// カテゴリーの取得
$categoryList = $AdminUserOBJ->getUserSearchConditionsCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
$smartyOBJ->assign("searchCategoryList", array("" => "気にしない") + (array)$categoryList);
?>
