<?php
/**
 * informationData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報データ更新ページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoStatusOBJ = AdmInformationStatus::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// 情報本文検索条件のデコード
if ($param["search_html_text"]) {
    // 一度デコード
    $param["search_html_text"] = htmlspecialchars_decode($param["search_html_text"], ENT_QUOTES);
    //一度タグにデコード変換
    $param["search_html_text"] = htmlspecialchars_decode(urldecode($param["search_html_text"]), ENT_QUOTES);
    // エンコードした検索値をパラメータにセット
    $requestOBJ->setParameter("search_html_text", urlencode($param["search_html_text"]));
}

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 情報データ取得
if ($param["isid"]) {
    $infoStatusData = $AdmInfoStatusOBJ->getInformationStatusDisplayPositionData($param["isid"]);
    $smartyOBJ->assign("infoStatusData", $infoStatusData);
}

$tags = array(
            "isid",
            "folder_id",
            "position_id",
            "search_type",
            "search_conditions_id",
            "search_conditions_type",
            "search_conditions_display_type",
            "search_is_display",
            "search_string",
            "search_html_text",
            "search_html_text_type",
            "search_information_id",
            "search_information_key",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "search_display_datetime_type",
            "user_search_conditions_type",
            "except_user_search_conditions_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$POSTparam   = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// 作るものは作ったのでもう初期化
$param = array();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnValue) {
    $param = $returnValue;

    // 情報アクセスキー
    $param["access_key"] = $infoStatusData["access_key"];

    // 表示開始日時
    $param["display_start_datetime"] = $param["display_start_date"] . " " . $param["display_start_time"];

    // 表示終了日時
    $param["display_end_datetime"] = $param["display_end_date"] . " " . $param["display_end_time"];

} elseif ($infoStatusData) {
    $param = $infoStatusData;

    // 表示曜日日時
    $displayWeekString = $infoStatusData["display_week_string"];
    $splitString = explode("_",$displayWeekString);
    $displayWeekStartArray = explode(",",$splitString[0]);
    $displayWeekLastArray  = explode(",",$splitString[1]);
    $param["display_week_start_num"] = $displayWeekStartArray[0];
    $param["display_week_start_time"] = $displayWeekStartArray[1];
    $param["display_week_last_num"] = $displayWeekLastArray[0];
    $param["display_week_last_time"] = $displayWeekLastArray[1];

} else {
    $execMsgSessOBJ->message = array("データ取得に失敗しました。");
    header("Location: ./?action_informationStatus_InformationSearchList=1&" . $URLparam);
    exit;
}

// アクセスURLの設定
$accessUrl = array();

// 登録情報データの表示場所によって切り替え(ログイン前 ⇔ ログイン後)
if (in_array($infoStatusData["cd"], InformationStatus::$_prePermissionDisplayPosition)) {
    $accessPageName = "PreInformation=1";
    $dispMsg = "(ログイン前)";
} else {
    $accessPageName = "Information=1";
    $dispMsg = "(ログイン後)";
}

$accessUrl = "./?action_" . $accessPageName . "&isid=" . $param["access_key"];
$smartyOBJ->assign("accessUrl", $accessUrl);
$smartyOBJ->assign("dispMsg", $dispMsg);

$smartyOBJ->assign("param", $param);

// bodyタグ基本設定
$htmlTagPC = '<body>';
$htmlTagMB = '<body link="#ffcc99" vlink="#cc9966" alink="#ffcc99" text="#ffffff" style="color:#ffffff; background:#000000;" bgcolor="#000000">'
              . "\n".'<a name="top" id="top"></a>'
              . "\n".'<div style="font-size:x-small; text-align:left; width:100%;">';
$smartyOBJ->assign("htmlTagPC", htmlspecialchars($htmlTagPC));
$smartyOBJ->assign("htmlTagMB", htmlspecialchars($htmlTagMB));

// selectbox用情報リストの取得
$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();
$dispPositionForSelect = $AdmInfoDispPositionOBJ->getInformationDisplayPositionForSelect();
$smartyOBJ->assign("dispPositionForSelect", $dispPositionForSelect);

// 入金状態
$smartyOBJ->assign("paymentStatus", AdmInformationStatus::$_paymentStatus);

// 戻り値の取得
$smartyOBJ->assign("registParam", $registParam);
// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationStatus::$_isDisplay);

// 全画面表示フラグ
$smartyOBJ->assign("isAllDisplay", AdmInformationStatus::$_isAllDisplay);

// 表示曜日縛り
$smartyOBJ->assign("isDisplayWeek", AdmInformationStatus::$_isDisplayWeek);

// 情報定型文データの有無
$AdmInfoTemplateOBJ = AdmInformationTemplate::getInstance();
$infoTemplateList = $AdmInfoTemplateOBJ->getInformationTemplateList();

$smartyOBJ->assign("infoTemplateList", $infoTemplateList);

// 情報、商品用検索条件保存リスト(表示)
if ($infoStatusData["user_search_conditions_id"] ) {
    $userSearchConditionAry = explode(",", $infoStatusData["user_search_conditions_id"]);
    foreach ($userSearchConditionAry as $val) {
        $searchSaveData = $AdminUserOBJ->getUserSearchConditionData($val);
        $searchSaveComment[] = $searchSaveData["comment"] ? $searchSaveData["comment"]: "設定なし";
    }
    $smartyOBJ->assign("searchSaveComment", implode(",", $searchSaveComment));
}
// 情報、商品用検索条件保存リスト(非表示)
if ($infoStatusData["except_user_search_conditions_id"] ) {
    $exceptUserSearchConditionAry = explode(",", $infoStatusData["except_user_search_conditions_id"]);
    foreach ($exceptUserSearchConditionAry as $val) {
        $exceptSearchSaveData = $AdminUserOBJ->getUserSearchConditionData($val);
        $exceptSearchSaveComment[] = $exceptSearchSaveData["comment"] ? $exceptSearchSaveData["comment"]: "設定なし";
    }
    $smartyOBJ->assign("exceptSearchSaveComment", implode(",", $exceptSearchSaveComment));
}

// 検索保存条件ID(表示/非表示)の検索条件指定
$smartyOBJ->assign("searchConditionsTypeArray", array("0" => "いずれか含む","1" => "すべて含む"));
//付与ポイント無制限
$smartyOBJ->assign("bonusPointLimitTypeArray", array("0" => "無効","1" => "有効"));
?>