<?php
/*
*       情報表示場所リスト
*       informationSearchList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoStatusOBJ       = AdmInformationStatus::getInstance();
$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();

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

$dispCnt = 30;

// 検索項目の取得
$searchValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻ってきた場合
if ($searchValue) {
    $param = $searchValue;
}

// 表示開始日指定
if ($param["search_display_datetime_type"]) {
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

// 情報ID
if ($param["search_information_id"]) {
    $searchItemId = "";
    // 末尾のカンマ削除(あれば)
    $param["search_information_id"] = rtrim($param["search_information_id"], ",");
    $searchItemId = explode(",", $param["search_information_id"]);
    foreach ($searchItemId as $key => $val) {
        if (!ComValidation::isNumeric($val)) {
            $param["search_information_id"] = "";
            break;
        }
    }
}

// 情報アクセスキー
if ($param["search_information_key"]) {
    // 末尾のカンマ削除(あれば)
    $param["search_information_key"] = rtrim($param["search_information_key"], ",");
}

// 検索保存条件ID
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
        $orderBy = "ims.id ASC ";
        // パラメータ切り替え
        $sort["sort_id"] = "dsc";
    } else {
        // 降順
        $orderBy = "ims.id DESC ";
        // パラメータ切り替え
        $sort["sort_id"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_id"] = "asc";
    if (!$sort["sort_seq"]) {
        $orderBy = "ims.id DESC ";
    }
}

// 表示優先順位の設定
if ($param["sort_seq"]) {
    if ($param["sort_seq"] == "asc") {
        // 昇順
        $orderBy = "ims.sort_seq ASC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "dsc";
    } else {
        // 降順
        $orderBy = "ims.sort_seq DESC ";
        // パラメータ切り替え
        $sort["sort_seq"] = "asc";
    }
} else {
    // 初期値
    $sort["sort_seq"] = "asc";
}

// 情報本文検索条件のデコード
if ($param["search_html_text"]) {
    // 一度デコード
    $param["search_html_text"] = htmlspecialchars_decode($param["search_html_text"]);

    // さらにデコード※<body>～とか
    $searchHtmlText = htmlspecialchars_decode(urldecode($param["search_html_text"]), ENT_QUOTES);

    // 情報データ取得用にエンコード
    $param["search_html_text"] = htmlspecialchars($searchHtmlText, ENT_QUOTES);
}

$smartyOBJ->assign("sort", $sort);
$smartyOBJ->assign("param", $param);

$infoDispPositionForSelectList = $AdmInfoDispPositionOBJ->getInformationDisplayPositionForSelect();
$smartyOBJ->assign("infoDispPositionForSelectList", $infoDispPositionForSelectList);

// 情報データリストの取得
$infoStatusList = $AdmInfoStatusOBJ->getInformationStatusList($param, $offset, $orderBy, $dispCnt);
if ($infoStatusList) {
    while (list($key, $val) = each($infoStatusList)) {
        if (!(($val["display_start_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["display_start_datetime"]) <= time())
             AND ($val["display_end_datetime"] == "0000-00-00 00:00:00" OR strtotime($val["display_end_datetime"]) >= time())) OR !$val["is_display"]) {
            $infoStatusList[$key]["not_display_flag"] = 1;
        }
    }
}

$smartyOBJ->assign("isDisplay", AdmInformationStatus::$_isDisplay);

$totalCount = $AdmInfoStatusOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($infoStatusList);

$smartyOBJ->assign("infoStatusList", $infoStatusList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

// 情報本文検索条件のエンコード
if ($param["search_html_text"]) {
    $requestOBJ->setParameter("search_html_text", urlencode($param["search_html_text"]));
}

$tags = array(
            "folder_id",
            "position_id",
            "search_type",
            "search_is_display",
            "search_string",
            "search_html_text",
            "search_html_text_type",
            "search_information_id",
            "search_conditions_id",
            "search_conditions_type",
            "search_conditions_display_type",
            "search_information_key",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "search_display_datetime_type",
            );

$reloadTags = array(
            "folder_id",
            "position_id",
            "search_type",
            "search_is_display",
            "search_string",
            "search_html_text",
            "search_html_text_type",
            "search_information_id",
            "search_conditions_id",
            "search_conditions_type",
            "search_conditions_display_type",
            "search_information_key",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "search_display_datetime_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

// aタグで渡すパラメーター
$addParam = "";
if ($param["sort_id"]) {
    $addParam .= "&sort_id=" . $param["sort_id"];
}
if ($param["sort_seq"]) {
    $addParam .= "&sort_seq=" . $param["sort_seq"];
}

$smartyOBJ->assign("URLparam", "&offset=" . $offset  . $addParam . "&" . $URLparam);

// ソートリンクのパラメーター(ID,表示優先順位)
$smartyOBJ->assign("sortParam", "&offset=" . $offset . "&" . $URLparam);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// <FORM>で渡す検索パラメーター
$smartyOBJ->assign("searchParam", $reloadParam);

// ページリンク生成
$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"]      = $offset;
$pagerArray["disp_count"]  = $dispCnt;
$pagerArray["action_name"] = "informationStatus_InformationSearchList=1";
$pagerArray["additional_param"] = $addParam . "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 検索用データ取得
$smartyOBJ->assign("displayPositionList", array("0" => "気にしない") + AdmInformationDisplayPosition::$_displayPositionName);
$smartyOBJ->assign("searchFolderList", array("0" => "気にしない") + (array)$infoDispPositionForSelectList);
$smartyOBJ->assign("searchTypeAry", AdmInformationStatus::$_searchTypeAry);
$smartyOBJ->assign("searchHtmlTextTypeAry", AdmInformationStatus::$_searchHtmlTextAry);
$smartyOBJ->assign("searchIsDisplay", AdmInformationStatus::$_searchIsDisplay);
$smartyOBJ->assign("batchOperateInfoSelectAry", AdmInformationStatus::$_batchOperateInfoSelectAry);
$smartyOBJ->assign("searchConditionsTypeArray", array("2" => "いずれか含む","1" => "すべて含む"));
$smartyOBJ->assign("searchConditionDisplayType", AdmItem::$_isDisplay);
$smartyOBJ->assign("searchDisplayDateTimeTypeAry", AdmInformationStatus::$_searchDisplayDateTimeTypeAry);

// 情報本文検索のデフォルトはすべてチェック
if (!$param["search_html_text_type"]) {
    $smartyOBJ->assign("defaultHtmlTextType", array_flip(AdmInformationStatus::$_searchHtmlTextAry));
}

// 情報コピー数(とりあえず最大9で...。)
$selectCopyNumber = "";
for ($i = 1; $i < 10; $i++) {
    $selectCopyNumber[$i] = $i;
}
$smartyOBJ->assign("selectCopyNumber", $selectCopyNumber);

?>