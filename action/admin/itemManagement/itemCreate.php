<?php
/**
 * itemCreate.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側商品データ登録ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmItemOBJ = AdmItem::getInstance();
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$AdminUserOBJ = AdmUser::getInstance();

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnParam = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnParam) {
    // 表示開始日時
    $returnParam["sales_start_datetime"] = $returnParam["sales_start_date"] . " " . $returnParam["sales_start_time"];
    // 表示終了日時
    $returnParam["sales_end_datetime"] = $returnParam["sales_end_date"] . " " . $returnParam["sales_end_time"];
}
$smartyOBJ->assign("returnParam", $returnParam);

// select用商品カテゴリーリスト取得
$itemCategoryListForSelect = $AdmItemOBJ->getItemCategoryForSelect();
$smartyOBJ->assign("itemCategoryListForSelect", $itemCategoryListForSelect);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmItem::$_isDisplay);

// 入金状態
$smartyOBJ->assign("paymentStatus", AdmItem::$_paymentStatus);

// 月額コースリスト取得
$monthlyCourseList = $AdmMonthlyCourseOBJ->getMonthlyCourseListForSelect();
if ($monthlyCourseList) {
    $smartyOBJ->assign("monthlyCourseList", array("0" => "設定しない") + $monthlyCourseList);
} else {
    $smartyOBJ->assign("monthlyCourseList", array("0" => "設定しない", "1" => "月額コースが登録されていません。"));
}

// 検索保存条件ID(表示/非表示)の検索条件指定
$smartyOBJ->assign("searchConditionsTypeArray", array("0" => "いずれか含む","1" => "すべて含む"));

// 強制注文フラグ
//$smartyOBJ->assign("isSelfOrder", AdmItem::$_isSelfOrder);

// 表示曜日縛り
$smartyOBJ->assign("isDisplayWeek", AdmInformationStatus::$_isDisplayWeek);

?>