<?php
/**
 * registPageSearchList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録ページリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmRegistPageOBJ = AdmRegistPage::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);
$smartyOBJ->assign("param", $param);

$dispCnt = 20;

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// メッセージの取得
$execMessage = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();
$returnSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $execMessage);

$dataList = $AdmRegistPageOBJ->getRegistPageList($param, $offset, "id DESC", $dispCnt);
$totalCount = $AdmRegistPageOBJ->getFoundRows();
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
$pagerArray["action_name"] = "registPage_RegistPageSearchList=1";

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));
$smartyOBJ->assign("isUseAry", AdmRegistPage::$_isUse);

// カテゴリーの取得
$categoryList = $AdmRegistPageOBJ->getRegistPageCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
$smartyOBJ->assign("searchCategoryList", array("" => "気にしない") + (array)$categoryList);
$smartyOBJ->assign("pageCdName", RegistPage::PAGE_CD_NAME);

?>

