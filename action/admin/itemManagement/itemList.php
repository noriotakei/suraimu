<?php
/*
 * 商品リスト
 * itemList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admItemOBJ = AdmItem::getInstance();
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $msg);

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// 検索項目の取得
$searchValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻ってきた場合の検索条件
if ($searchValue) {
    $param = $searchValue;
}

// 入力日時の生成
if ($param["search_sales_datetime_type"]) {
    // 表示開始日指定
    $param["searchDatetimeFrom"] = $param["search_datetime_from_date"] . " " . $param["search_datetime_from_time"];
    if (!ComValidation::isDatetime($param["searchDatetimeFrom"])) {
        // 日付不正なら空にする
        $param["searchDatetimeFrom"] = "";
    }

    // 表示終了日指定
    $param["searchDatetimeTo"] = $param["search_datetime_to_date"] . " " . $param["search_datetime_to_time"];
    if (!ComValidation::isDatetime($param["searchDatetimeTo"])) {
        // 日付不正なら空にする
        $param["searchDatetimeTo"] = "";
    }
} else {
    // 初期化
    $param["search_datetime_from_date"] = "";
    $param["search_datetime_from_time"] = "";
    $param["search_datetime_to_date"] = "";
    $param["search_datetime_to_time"] = "";
}

// 商品ID
if ($param["search_item_id"]) {
    $searchItemId = "";
    // 末尾のカンマ削除(あれば)
    $param["search_item_id"] = rtrim($param["search_item_id"], ",");
    $searchItemId = explode(",", $param["search_item_id"]);
    foreach ($searchItemId as $key => $val) {
        if (!ComValidation::isNumeric($val)) {
            $param["search_item_id"] = "";
            break;
        }
    }
}

// 商品アクセスキー
if ($param["search_item_key"]) {
    // 末尾のカンマ削除(あれば)
    $param["search_item_key"] = rtrim($param["search_item_key"], ",");
}

// 検索条件保存ID（表示/非表示）
if ($param["search_conditions_id"]) {
    $searchConditionsId = "";
    // 末尾のカンマ削除(あれば)
    $param["search_conditions_id"] = rtrim($param["search_conditions_id"], ",");
    $searchConditionsId = explode(",", $param["search_conditions_id"]);
    foreach ($searchConditionsId as $key => $val) {
        if (!ComValidation::isNumeric($val)) {
            $param["search_conditions_id"] = "";
            break;
        }
    }
}

// ID表示順の設定
if ($param["sort_id"]) {
    if ($param["sort_id"] == "asc") {
        // 昇順
        $orderBy = "item.id ASC ";
        // パラメータ切り替え
        $sort["sort_id"] = "dsc";
    } else {
        // 降順
        $orderBy = "item.id DESC ";
        // パラメータ切り替え
        $sort["sort_id"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_id"] = "asc";
    if (!$sort["sort_seq"]) {
        $orderBy = "item.id DESC ";
    }
}

// 表示優先順位の設定
if ($param["sort_seq"]) {
    if ($param["sort_seq"] == "asc") {
        // 昇順
        $orderBy = "item.sort_seq ASC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "dsc";
    } else {
        // 降順
        $orderBy = "item.sort_seq DESC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_seq"] = "asc";
}

$smartyOBJ->assign("sort", $sort);
$smartyOBJ->assign("param", $param);

// 表示状態
$smartyOBJ->assign("isDisplay", AdmItem::$_isDisplay);

// 強制注文フラグ
//$smartyOBJ->assign("isSelfOrder", AdmItem::$_isSelfOrder);

// 商品リストの取得
$itemList = $admItemOBJ->getItemList($param, $offset, $orderBy, $dispCnt);
if ($itemList) {
    while (list($key, $val) = each($itemList)) {
        if (!(($val["sales_start_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["sales_start_datetime"]) <= time())
             AND ($val["sales_end_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["sales_end_datetime"]) >= time())) OR !$val["is_display"]) {
            $itemList[$key]["not_display_flag"] = 1;
        }
    }
}
$totalCount = $admItemOBJ->getFoundRows();

$dispFirst = $offset + 1;
$dispLast = $offset + count($itemList);

$smartyOBJ->assign("itemList", $itemList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "search_category_id",
            "search_is_display",
            //"search_is_self_order", ※現在は使用してないのでコメント(いつか使うかも)
            "search_type",
            "search_item_id",
            "search_conditions_id",
            "search_conditions_display_type",
            "search_item_key",
            "search_item_name_type",
            "search_string",
            "search_conditions_type",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "search_sales_datetime_type",
            );

$reloadTags = array(
            "search_category_id",
            "search_is_display",
            //"search_is_self_order", ※現在は使用してないのでコメント(いつか使うかも)
            "search_type",
            "search_item_id",
            "search_conditions_id",
            "search_conditions_display_type",
            "search_item_key",
            "search_item_name_type",
            "search_string",
            "search_conditions_type",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "search_sales_datetime_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

// aタグで渡す検索パラメーター
$addParam = "";
if ($param["sort_id"]) {
    $addParam .= "&sort_id=" . $param["sort_id"];
}
if ($param["sort_seq"]) {
    $addParam .= "&sort_seq=" . $param["sort_seq"];
}
$smartyOBJ->assign("URLparam", "&offset=" . $offset . $addParam . "&" . $URLparam);

// ソートリンクのパラメーター(ID,表示優先順位)
$smartyOBJ->assign("sortParam", "&offset=" . $offset . "&" . $URLparam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// <FORM>で渡すパラメーター
$smartyOBJ->assign("searchParam", $reloadParam);

// ページリンク生成
$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "itemManagement_ItemList=1";
$pagerArray["additional_param"] = $addParam . "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 検索用データ取得(カテゴリーの登録が有るか無いかで配列内容が違う)
$searchitemCategoryList = $admItemOBJ->getItemCategoryForSelect();
if ($searchitemCategoryList) {
    $smartyOBJ->assign("searchItemCategoryList", array("0" => "気にしない") + (array)$searchitemCategoryList);
} else {
    $smartyOBJ->assign("searchItemCategoryList", array("0" => "気にしない"));
}
$smartyOBJ->assign("searchTypeAry", AdmItem::$_searchTypeAry);
$smartyOBJ->assign("searchIsDisplay", AdmItem::$_searchIsDisplay);
$smartyOBJ->assign("searchItemNameAry", AdmItem::$_searchItemNameAry);
$smartyOBJ->assign("searchConditionsTypeArray", array("2" => "いずれか含む","1" => "すべて含む"));
$smartyOBJ->assign("searchConditionDisplayType", AdmItem::$_isDisplay);
$smartyOBJ->assign("searchDisplayDateTimeTypeAry", AdmInformationStatus::$_searchDisplayDateTimeTypeAry);

// 商品名検索のデフォルトはすべてチェック
if (!$param["search_item_name_type"]) {
    $smartyOBJ->assign("defaultItemNameType", array_flip(AdmItem::$_searchItemNameAry));
}

// 商品データ一括操作用
$smartyOBJ->assign("batchOperateItemSelectAry", AdmItem::$_batchOperateItemSelectAry);

// 決済飛び先
$settlementOBJ = Settlement::getInstance();
$settleControlData = $settlementOBJ->getSettleSelectData() ;
$smartyOBJ->assign("settleSelectAry", $_config["define"]["DIRECT_SETTLE_TYPE"] );
$smartyOBJ->assign("settleControlData", $settleControlData );

if ($searchitemCategoryList) {
    $smartyOBJ->assign("categoryList", $searchitemCategoryList);
} else {
    $smartyOBJ->assign("categoryList", array("0" => "現在カテゴリーの登録がありません"));
}

// 月額コースリスト取得
if ($monthlyCourseList = $AdmMonthlyCourseOBJ->getMonthlyCourseListForSelect()) {
    $smartyOBJ->assign("monthlyCourseList", $monthlyCourseList);
} else {
    $smartyOBJ->assign("monthlyCourseList", array("0" => ""));
}

// 情報コピー数(とりあえず最大9で...。)
$selectCopyNumber = "";
for ($i = 1; $i < 10; $i++) {
    $selectCopyNumber[$i] = $i;
}
$smartyOBJ->assign("selectCopyNumber", $selectCopyNumber);

// 現在は使用してないのでコメント(いつか使うかも)
//$smartyOBJ->assign("searchIsSelfOrder", array("0" => "気にしない") + AdmItem::$_searchIsSelfOrder);

?>