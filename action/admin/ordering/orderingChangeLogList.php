<?php

/**
 * orderingChangeLogList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文変更ログリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);
$dispCnt = 20;

// セッションオブジェクトのインスタンス
$orderingSearchSessOBJ = new ComSessionNamespace("ordering_search");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();
$AdmItemOBJ = AdmItem::getInstance();

// 入力日時の生成
$param["order_start_datetime"] = $param["order_start_datetime_Date"]
                        . " 00:00:00";
if (!ComValidation::isDatetime($param["order_start_datetime"])) {
    if (!$param["search_flag"]) {
        $param["order_start_datetime"] = date("Y-m-01 00:00:00");
    } else {
        $param["order_start_datetime"] = "";
    }
}

$param["order_end_datetime"] = $param["order_end_datetime_Date"]
                        . " 23:59:59";
if (!ComValidation::isDatetime($param["order_end_datetime"])) {
    $param["order_end_datetime"] = "";
}

$param["change_start_datetime"] = $param["change_start_datetime_Date"]
                        . " 00:00:00";
if (!ComValidation::isDate($param["change_start_datetime"])) {
    $param["change_start_datetime"] = "";
}

$param["change_end_datetime"] = $param["change_end_datetime_Date"]
                        . " 23:59:59";
if (!ComValidation::isDate($param["change_end_datetime"])) {
    $param["change_end_datetime"] = "";
}

// セッションにセットします
if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    $param = $orderingSearchSessOBJ->$param["sesKey"];
} else {
    $sesKey = "change_" . strtotime("NOW");
    $orderingSearchSessOBJ->$sesKey = $param;
}
$requestOBJ->setParameter("sesKey", $sesKey);

// 注文リストの取得
if ($param["search_flag"]) {
    $changeLogList = $AdmOrderChangeLogOBJ->getOrderingChangeLogList($param, $offset, "order_change_log.id DESC", $dispCnt);
    $totalCount = $AdmOrderChangeLogOBJ->getFoundRows();
    $dispFirst = $offset + 1;
    $dispLast = $offset + count($changeLogList);

    foreach ((array)$changeLogList as $key => $val) {
        // キャンセル商品詳細の取得
        $itemData[$key] = $AdmItemOBJ->getItemData($val["item_id"]);
    }
}

$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$smartyOBJ->assign("changeLogList", $changeLogList);
$smartyOBJ->assign("itemData", $itemData);
$smartyOBJ->assign("param", $param);

$urlTags = array(
            "sesKey",
            );

$tags = array(
            "sesKey",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($urlTags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "ordering_OrderingChangeLogList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
// 変更時ステータス
$smartyOBJ->assign("status", AdmOrderChangeLog::$_status);
$smartyOBJ->assign("promidePath", "image/thumb/");
?>
