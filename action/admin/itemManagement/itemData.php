<?php
/**
 * itemData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側商品データ更新ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmItemOBJ = AdmItem::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 商品データの取得
if ($param["iid"]) {
    $itemData = $AdmItemOBJ->getItemData($param["iid"]);
    $smartyOBJ->assign("itemData", $itemData);
}

$tags = array(
            "iid",
            "search_category_id",
            "search_is_display",
            //"search_is_self_order", ※現在は使用してないのでコメント(いつか使うかも)
            "search_type",
            "search_conditions_id",
            "search_conditions_display_type",
            "search_conditions_type",
            "search_item_id",
            "search_item_key",
            "search_item_name_type",
            "search_string",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "user_search_conditions_type",
            "except_user_search_conditions_type",
            "search_sales_datetime_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// 作るものは作ったのでもう初期化
$param = array();

// 戻り値(入力項目)の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

if ($returnValue) {

    $param = $returnValue;

    // 商品アクセスキー
    $param["access_key"] = $itemData["access_key"];

    // 表示開始日時
    $param["sales_start_datetime"] = $param["sales_start_date"] . " " . $param["sales_start_time"];
    // 表示終了日時
    $param["sales_end_datetime"] = $param["sales_end_date"] . " " . $param["sales_end_time"];

} elseif ($itemData)  {
    $param = $itemData;

    // 表示曜日日時
    $displayWeekString = $itemData["display_week_string"];
    $splitString = explode("_",$displayWeekString);
    $displayWeekStartArray = explode(",",$splitString[0]);
    $displayWeekLastArray  = explode(",",$splitString[1]);
    $param["display_week_start_num"] = $displayWeekStartArray[0];
    $param["display_week_start_time"] = $displayWeekStartArray[1];
    $param["display_week_last_num"] = $displayWeekLastArray[0];
    $param["display_week_last_time"] = $displayWeekLastArray[1];
} else {
    $execMsgSessOBJ->message = array("データ取得に失敗しました。");
    header("Location: ./?action_itemManagement_ItemList");
    exit;
}

// 注文URLの設定
$accessUrl = array();
$accessUrl["access_url"] = "./?action_SettleSelect=1&iid=" . $param["access_key"];
$smartyOBJ->assign("accessUrl", $accessUrl);

$smartyOBJ->assign("param", $param);

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

// 情報、商品用検索条件保存リスト(表示)
if ($itemData["user_search_conditions_id"] ) {
    $userSearchConditionAry = explode(",", $itemData["user_search_conditions_id"]);
    foreach ($userSearchConditionAry as $val) {
        $searchSaveData = $AdminUserOBJ->getUserSearchConditionData($val);
        $searchSaveComment[] = $searchSaveData["comment"] ? $searchSaveData["comment"]: "設定なし";
    }
    $smartyOBJ->assign("searchSaveComment", implode(",", $searchSaveComment));
}

// 情報、商品用検索条件保存リスト(非表示)
if ($itemData["except_user_search_conditions_id"] ) {
    $exceptUserSearchConditionAry = explode(",", $itemData["except_user_search_conditions_id"]);
    foreach ($exceptUserSearchConditionAry as $val) {
        $exceptSearchSaveData = $AdminUserOBJ->getUserSearchConditionData($val);
        $exceptSearchSaveComment[] = $exceptSearchSaveData["comment"] ? $exceptSearchSaveData["comment"]: "設定なし";
    }
    $smartyOBJ->assign("exceptSearchSaveComment", implode(",", $exceptSearchSaveComment));
}

// 検索保存条件ID(表示/非表示)の検索条件指定
$smartyOBJ->assign("searchConditionsTypeArray", array("0" => "いずれか含む","1" => "すべて含む"));

// 強制注文フラグ ※現在は使用してないのでコメント(いつか使うかも)
//$smartyOBJ->assign("isSelfOrder", AdmItem::$_isSelfOrder);

// 表示曜日縛り
$smartyOBJ->assign("isDisplayWeek", AdmInformationStatus::$_isDisplayWeek);

?>