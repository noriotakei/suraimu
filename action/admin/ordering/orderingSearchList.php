<?php

/**
 * orderingSearchList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文検索リストページ処理ファイル。
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

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();

// セッションにセットします
if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    // 上書き
    if ($param["search_flag"]) {
        $orderingSearchSessOBJ->$sesKey = $param;
    }
    $param = $orderingSearchSessOBJ->$sesKey;
} else {
    $sesKey = "ordering_" . strtotime("NOW");
    $orderingSearchSessOBJ->$sesKey = $param;
}
$requestOBJ->setParameter("sesKey", $sesKey);

// 入力日時の生成
$param["order_start_datetime"] = $param["order_start_datetime_Date"]
                        . " " . $param["order_start_datetime_Time"];

if (!ComValidation::isDatetime($param["order_start_datetime"])) {
    $param["order_start_datetime"] = date("Y-m-d") . " 00:00:00";
}

$param["order_end_datetime"] = $param["order_end_datetime_Date"]
                        . " " . $param["order_end_datetime_Time"];

if (!ComValidation::isDatetime($param["order_end_datetime"])) {
    $param["order_end_datetime"] = date("Y-m-d") . " 23:59:59";
}

$param["paid_start_datetime"] = $param["paid_start_datetime_Date"]
. " " . $param["paid_start_datetime_Time"];

if (!ComValidation::isDatetime($param["paid_start_datetime"])) {
    $param["paid_start_datetime"] = date("Y-m-d") . " 00:00:00";
}

$param["paid_end_datetime"] = $param["paid_end_datetime_Date"]
. " " . $param["paid_end_datetime_Time"];

if (!ComValidation::isDatetime($param["paid_end_datetime"])) {
    $param["paid_end_datetime"] = date("Y-m-d") . " 23:59:59";
}


// 注文リストの取得
if ($param["search_flag"]) {
    $orderingList = $AdmOrderingOBJ->getOrderingList($param, $offset, "ordering.id DESC", $dispCnt);
    $totalCount = $AdmOrderingOBJ->getFoundRows();
    $dispFirst = $offset + 1;
    $dispLast = $offset + count($orderingList);

    foreach ((array)$orderingList as $key => $val) {
        // 商品詳細の取得
        $itemList[$key] = $AdmItemOBJ->getOrderingDetailItemList($val["id"]);
        // 変更商品詳細の取得
        $changeItemList[$key] = $AdmOrderChangeLogOBJ->getChangeItemList($val["id"]);
        foreach ($changeItemList[$key] as $chgVal) {
            $changeItemTotalMoney[$key] += $chgVal["price"];
        }

        if ($val["is_cancel"]) {
            $orderingList[$key]["style"] = "style=\"background-color:pink;\"";
        } else if (($val["status"] == AdmOrdering::ORDERING_STATUS_COMPLETE OR $val["status"] == AdmOrdering::ORDERING_STATUS_REST) AND $val["is_paid"]) {
            $orderingList[$key]["style"] = "style=\"background-color:gray;\"";
        }
    }
}

$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$smartyOBJ->assign("orderingList", $orderingList);
$smartyOBJ->assign("itemList", $itemList);
$smartyOBJ->assign("changeItemList", $changeItemList);
$smartyOBJ->assign("changeItemTotalMoney", $changeItemTotalMoney);
$smartyOBJ->assign("param", $param);

// セッションに上書き

$orderingSearchSessOBJ->$sesKey = $param;

$urlTags = array(
            "sesKey",
            );

$tags = array(
            "sesKey",
            "offset",
            );

$supportMailTags = array(
            "sesKey",
            "offset",
            );


$URLparam = $requestOBJ->makeGetTag($urlTags);
$supportPOSTparam = $requestOBJ->makePostTag($supportMailTags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);
// サポートメール一括送信用
$smartyOBJ->assign("supportPOSTparam", $supportPOSTparam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "ordering_OrderingSearchList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 注文ステータス
$smartyOBJ->assign("orderStatus", AdmOrdering::$_orderStatus);
// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
// キャンセルフラグ
$smartyOBJ->assign("cancelFlag", AdmOrdering::$_cancelFlag);
// 入金フラグ
$smartyOBJ->assign("paidFlag", AdmOrdering::$_paidFlag);
// 入金フラグ
$smartyOBJ->assign("overLapFlag", AdmOrdering::$_overLapFlag);
?>
