<?php
/**
 * list.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユニット一覧ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmUnitOBJ = AdmUnit::getInstance();

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

$smartyOBJ->assign("param", $param);

$dataList = $AdmUnitOBJ->getUnitList($param, $offset, "id DESC", $dispCnt);
$totalCount = $AdmUnitOBJ->getFoundRows();
foreach ($dataList as $key => $val) {
    $dataList[$key]["count"] = $AdmUnitOBJ->getUnitUserCountData($val["id"]);
}

$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "is_stay",
            "search_string",
            );

$reloadTags = array(
            "is_stay",
            "search_string",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "unit_List=1";
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

// ログ削除対象フラグ
$smartyOBJ->assign("isStay", array("" => "気にしない") + AdmUnit::$_isStayArray);
?>

