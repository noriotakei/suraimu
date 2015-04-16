<?php
/**
 * registTestAddressList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面広告用テストアドレスデータリストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmRegistTestAddressOBJ = AdmRegistTestAddress::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

$smartyOBJ->assign("param", $param);

$dataList = $AdmRegistTestAddressOBJ->getRegistTestAddressList($param, $offset, "sort_seq DESC, id DESC", $dispCnt);
$totalCount = $AdmRegistTestAddressOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$categoryList = $AdmRegistTestAddressOBJ->getRegistTestAddressCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
$smartyOBJ->assign("searchCategoryList", array("" => "気にしない") + (array)$categoryList);

$tags = array(
            "category_id",
            "specify_keyword",
            "search_string",
            );

$reloadTags = array(
            "category_id",
            "specify_keyword",
            "search_string",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "testAddress_RegistTestAddressList=1";
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

$smartyOBJ->assign("specifyKeywordAry", AdmRegistTestAddress::$_specifyKeywordAry);
// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmRegistTestAddress::$_isDisplay);
?>

