<?php

/**
 * orderingLogList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文ログリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdminUserOBJ = AdmUser::getInstance();
$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();

$userData =$AdminUserOBJ->getUserData($param["user_id"]);
$smartyOBJ->assign("userData", $userData);

// 登録解除、ブラックも含む
$param["is_quit"] = 1;
$param["is_danger"] = 1;

// 注文ログリスト
$orderingList = $AdmOrderingOBJ->getOrderingList($param, "", "create_datetime DESC", "");

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

$smartyOBJ->assign("orderingList", $orderingList);
$smartyOBJ->assign("itemList", $itemList);
$smartyOBJ->assign("changeItemList", $changeItemList);
$smartyOBJ->assign("changeItemTotalMoney", $changeItemTotalMoney);

// 注文ステータス
$smartyOBJ->assign("orderStatus", AdmOrdering::$_orderStatus);
// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
// キャンセルフラグ
$smartyOBJ->assign("cancelFlag", AdmOrdering::$_cancelFlag);
// 入金フラグ
$smartyOBJ->assign("paidFlag", AdmOrdering::$_paidFlag);

// 「商品名」に付与するパラメータ（情報リストへリンク）
$URLparam = "&search_html_text_type[]=1&search_html_text_type[]=2&search_html_text_type[]=3&search_html_text_type[]=4&search_type=6";
$smartyOBJ->assign("URLparam", $URLparam);

?>
