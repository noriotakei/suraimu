<?php
/**
 * search.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー検索ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");

// 検索条件保存リスト
$AdminUserOBJ = AdmUser::getInstance();

// セッション変数の取得
if (ComValidation::isNumeric(($param["search_conditions_id"]))) {
    $searchSaveData = $AdminUserOBJ->getUserSearchConditionData($param["search_conditions_id"]);
    if ($searchSaveData) {
        $value = unserialize($searchSaveData["search_condition"]);
        $searchMsg[] = array($searchSaveData["comment"] . "をロードしました");
    } else {
        $searchMsg[] = array("ID:" . $param["search_conditions_id"] . "はありません");
    }
} else if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
// 定期メルマガの条件
} else if (ComValidation::isNumeric(($param["mail_maga_regular_id"]))) {
    $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
    $searchSaveData = $AdmMailMagazineOBJ->getMailRegularData($param["mail_maga_regular_id"]);
    $value = unserialize($searchSaveData["search_condition"]);
// 予約メルマガの条件
} else if (ComValidation::isNumeric(($param["mail_maga_reserve_id"]))) {
    $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
    $searchSaveData = $AdmMailMagazineOBJ->getMailReserveData($param["mail_maga_reserve_id"]);
    $value = unserialize($searchSaveData["search_condition"]);
}

// 競馬間コンバート用パラメーター生成
if ($value["specify_convert_type"] == 2) {
    $value["total_payment_from"] = "";
    $value["buy_count_from"] = "";
    $value["total_payment_to"] = "";
    $value["buy_count_to"] = "";
    $value["regist_site"] = "";
}
$admConvertConfigOBJ = AdmConvertConfig::getInstance();
$cnvType = $admConvertConfigOBJ->getVisitorType($param["search_conditions_id"]);
// 検索タイプ指定
if ($cnvType) {
    // 競馬間コンバート
    $value["specify_convert_type"] = 2;
} else {
    // 通常
    $value["specify_convert_type"] = 1;
}

$smartyOBJ->assign("value", $value);

$errMsg = $errSessOBJ->getIterator();
// エラーメッセージの取得
$smartyOBJ->assign("errMsg", (array)$errMsg + (array)$searchMsg);
// セッション変数の破棄
$errSessOBJ->unsetAll();

// 最終アクセス日時の生成
$lastAccessDatetimeFrom = $value["last_access_from_Date"]
                        . " " . $value["last_access_from_Time"];

if (ComValidation::isDatetime($lastAccessDatetimeFrom)) {
    $smartyOBJ->assign("lastAccessDatetimeFrom", $lastAccessDatetimeFrom);
} else {
    $smartyOBJ->assign("lastAccessDatetimeFrom", date("Y-m-d H:0:0"));
}

$lastAccessDatetimeTo = $value["last_access_to_Date"]
                        . " " . $value["last_access_to_Time"];
if (ComValidation::isDatetime($lastAccessDatetimeTo)) {
    $smartyOBJ->assign("lastAccessDatetimeTo", $lastAccessDatetimeTo);
} else {
    $smartyOBJ->assign("lastAccessDatetimeTo", date("Y-m-d H:0:0"));
}

// アクセス無し日時の生成
$notAccessDatetimeFrom = $value["not_access_from_Date"]
                        . " " . $value["not_access_from_Time"];

if (ComValidation::isDatetime($notAccessDatetimeFrom)) {
    $smartyOBJ->assign("notAccessDatetimeFrom", $notAccessDatetimeFrom);
} else {
    $smartyOBJ->assign("notAccessDatetimeFrom", date("Y-m-d H:0:0"));
}

$notAccessDatetimeTo = $value["not_access_to_Date"]
                        . " " . $value["not_access_to_Time"];
if (ComValidation::isDatetime($notAccessDatetimeTo)) {
    $smartyOBJ->assign("notAccessDatetimeTo", $notAccessDatetimeTo);
} else {
    $smartyOBJ->assign("notAccessDatetimeTo", date("Y-m-d H:0:0"));
}

// 仮登録日時の生成
$preRegistDatetimeFrom = $value["pre_regist_from_Date"]
                        . " " . $value["pre_regist_from_Time"];
if (ComValidation::isDatetime($preRegistDatetimeFrom)) {
    $smartyOBJ->assign("preRegistDatetimeFrom", $preRegistDatetimeFrom);
} else {
    $smartyOBJ->assign("preRegistDatetimeFrom", date("Y-m-d H:0:0"));
}

$preRegistDatetimeTo = $value["pre_regist_to_Date"]
                        . " " . $value["pre_regist_to_Time"];
if (ComValidation::isDatetime($preRegistDatetimeTo)) {
    $smartyOBJ->assign("preRegistDatetimeTo", $preRegistDatetimeTo);
} else {
    $smartyOBJ->assign("preRegistDatetimeTo", date("Y-m-d H:0:0"));
}

// 登録日時の生成
$registDatetimeFrom = $value["regist_from_Date"]
                        . " " . $value["regist_from_Time"];
if (ComValidation::isDatetime($registDatetimeFrom)) {
    $smartyOBJ->assign("registDatetimeFrom", $registDatetimeFrom);
} else {
    $smartyOBJ->assign("registDatetimeFrom", date("Y-m-d H:0:0"));
}

$registDatetimeTo = $value["regist_to_Date"]
                        . " " . $value["regist_to_Time"];
if (ComValidation::isDatetime($registDatetimeTo)) {
    $smartyOBJ->assign("registDatetimeTo", $registDatetimeTo);
} else {
    $smartyOBJ->assign("registDatetimeTo", date("Y-m-d H:0:0"));
}

// 初回入金日時の生成
$firstPayDatetimeFrom = $value["first_pay_from_Date"]
                        . " " . $value["first_pay_from_Time"];
if (ComValidation::isDatetime($firstPayDatetimeFrom)) {
    $smartyOBJ->assign("firstPayDatetimeFrom", $firstPayDatetimeFrom);
} else {
    $smartyOBJ->assign("firstPayDatetimeFrom", date("Y-m-d H:0:0"));
}

$firstPayDatetimeTo = $value["first_pay_to_Date"]
                        . " " . $value["first_pay_to_Time"];
if (ComValidation::isDatetime($firstPayDatetimeTo)) {
    $smartyOBJ->assign("firstPayDatetimeTo", $firstPayDatetimeTo);
} else {
    $smartyOBJ->assign("firstPayDatetimeTo", date("Y-m-d H:0:0"));
}

// 最終購入日時の生成
$lastBuyDatetimeFrom = $value["last_buy_from_Date"]
                        . " " . $value["last_buy_from_Time"];
if (ComValidation::isDatetime($lastBuyDatetimeFrom)) {
    $smartyOBJ->assign("lastBuyDatetimeFrom", $lastBuyDatetimeFrom);
} else {
    $smartyOBJ->assign("lastBuyDatetimeFrom", date("Y-m-d H:0:0"));
}

$lastBuyDatetimeTo = $value["last_buy_to_Date"]
                        . " " . $value["last_buy_to_Time"];
if (ComValidation::isDatetime($lastBuyDatetimeTo)) {
    $smartyOBJ->assign("lastBuyDatetimeTo", $lastBuyDatetimeTo);
} else {
    $smartyOBJ->assign("lastBuyDatetimeTo", date("Y-m-d H:0:0"));
}

// 期間消費ポイント日時の生成
$usePointDatetimeFrom = $value["use_point_from_Date"]
                        . " " . $value["use_point_from_Time"];
if (ComValidation::isDatetime($usePointDatetimeFrom)) {
    $smartyOBJ->assign("usePointDatetimeFrom", $usePointDatetimeFrom);
} else {
    $smartyOBJ->assign("usePointDatetimeFrom", date("Y-m-d H:0:0"));
}

$usePointDatetimeTo = $value["use_point_to_Date"]
                        . " " . $value["use_point_to_Time"];
if (ComValidation::isDatetime($usePointDatetimeTo)) {
    $smartyOBJ->assign("usePointDatetimeTo", $usePointDatetimeTo);
} else {
    $smartyOBJ->assign("usePointDatetimeTo", date("Y-m-d H:0:0"));
}

// 生年月日日時の生成
$birthDayDatetimeFrom = $value["birth_day_from_Date"] ;

if (ComValidation::isDate($birthDayDatetimeFrom)) {
    $smartyOBJ->assign("birthDayDatetimeFrom", $birthDayDatetimeFrom);
} else {
    $smartyOBJ->assign("birthDayDatetimeFrom", date("Y-m-d"));
}

$birthDayDatetimeTo = $value["birth_day_to_Date"] ;
if (ComValidation::isDate($birthDayDatetimeTo)) {
    $smartyOBJ->assign("birthDayDatetimeTo", $birthDayDatetimeTo);
} else {
    $smartyOBJ->assign("birthDayDatetimeTo", date("Y-m-d"));
}

// 期間購入金額日時の生成
$termsPayDatetimeFrom = $value["terms_pay_from_Date"]
                        . " " . $value["terms_pay_from_Time"];
if (ComValidation::isDatetime($termsPayDatetimeFrom)) {
    $smartyOBJ->assign("termsPayDatetimeFrom", $termsPayDatetimeFrom);
} else {
    $smartyOBJ->assign("termsPayDatetimeFrom", date("Y-m-d H:0:0"));
}

$termsPayDatetimeTo = $value["terms_pay_to_Date"]
                        . " " . $value["terms_pay_to_Time"];
if (ComValidation::isDatetime($termsPayDatetimeTo)) {
    $smartyOBJ->assign("termsPayDatetimeTo", $termsPayDatetimeTo);
} else {
    $smartyOBJ->assign("termsPayDatetimeTo", date("Y-m-d H:0:0"));
}

$smartyOBJ->assign("limit", array("30" => "30", "50" => "50", "100" => "100"));
$smartyOBJ->assign("order", array("user_id DESC" => "ID", "last_access_datetime DESC" => "アクセス日時", "regist_datetime DESC" => "登録日時"));
$defaultRegistUserStatus = array(
                                $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"],
                                $_config["define"]["USER_REGIST_STATUS_MEMBER"],
                                );
$smartyOBJ->assign("defaultRegistUserStatus", $defaultRegistUserStatus);

// 管理ﾎﾞｯｸｽ
$AdmAdminOBJ = AdmAdmin::getInstance();

$adminList = $AdmAdminOBJ->getListForSelect();
$smartyOBJ->assign("adminList", array("" => "指定なし") + AdmAdmin::$_searchArray + (array)$adminList);

// サイト間登録
$AdmRegistSiteOBJ = AdmRegistSite::getInstance();

$registSiteList = $AdmRegistSiteOBJ->getListForSelect();
$smartyOBJ->assign("registSiteList", $registSiteList);
// サイト間登録状態
$smartyOBJ->assign("specifyRegistSite", AdmRegistSite::$_specifyRegistSite);

// 入金種別
$smartyOBJ->assign("payType", AdmOrdering::$_payType);

// 配信ドメイン
$smartyOBJ->assign("sendDomainType", $_config["define"]["SEND_MAIL_DOMAIN"]);

// 血液型
unset($_config["admin_config"]["blood_type"][0]) ;
$smartyOBJ->assign("bloodType", $_config["admin_config"]["blood_type"]);

// カテゴリーの取得
$AdmRegistPageOBJ = AdmRegistPage::getInstance();
$registPageCategoryList = $AdmRegistPageOBJ->getRegistPageCategoryForSelect();
$smartyOBJ->assign("registPageCategoryList", array("0" => "ダイレクト登録") + (array)$registPageCategoryList);

// 住所、銀行あり、なし
$smartyOBJ->assign("isSetting", array("" => "気にしない") + $_config["admin_config"]["is_setting"]);

// ﾌﾘｰﾜｰﾄﾞ
$smartyOBJ->assign("freeWord", array("" => "気にしない","1" => "気にする") );
$AdmFreeWordOBJ = AdmFreeWord::getInstance();
$freeWordList = $AdmFreeWordOBJ->getFreeWordDataForEdit(2) ;

foreach($freeWordList as $key => $val){
    $freeWordSetList[$val["free_word_cd"]] [$val["free_word_value"]] = $val["free_word_text"] ;
}

$smartyOBJ->assign("freeWordList", $freeWordSetList );

//ﾕｰｻﾞｰﾌﾟﾗｲﾊﾞｼｰ
$smartyOBJ->assign("addressDetail", array(1=>"住所",2=>"名前",3=>"電話番号") );
$smartyOBJ->assign("bankDetail", array(1=>"銀行名",2=>"支店名",3=>"種別",4=>"口座番号",5=>"名義人") );

//注文検索
$smartyOBJ->assign("cancelFlag", AdmOrdering::$_cancelFlag);

//電話受信
$smartyOBJ->assign("phoneIsUse", array(""=>"気にしない",1=>"あり",0=>"なし"));

/**********************************/
/*** 競馬間コンバート用条件生成 ***/
/**********************************/
$smartyOBJ->assign("selectSearchType", array("1" => "通常検索", "2" => "競馬間コンバート"));

// コンバート先に自分を含まない
$convertSitesAry = $_config["admin_config"]["specify_to_convert_sites_select"];
foreach ($convertSitesAry as $key => $site) {
    if ($key == $_config["define"]["PROJECT_NAME"]) {
        unset($convertSitesAry[$key]);
    }
}
$convertSiteSelectDefault = key(array_slice($convertSitesAry, 0, 1));
$smartyOBJ->assign("convertSiteSelectDefault", $convertSiteSelectDefault);
$smartyOBJ->assign("convertSitesAry", $convertSitesAry);

$reloadTags = array(
            "sesKey",
            "mail_maga_reserve_id",
            "mail_maga_regular_id",
            "search_conditions_id"
            );
$tags = array(
            "mail_maga_regular_id",
            "mail_maga_reserve_id",
            "search_conditions_id"
            );
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileFlagCodeList =  array("0" => "フラグＯＦＦ");
foreach ($userProfileFlagList as $item) {
    $userProfileFlagCodeList += array(
            $item['code'] => $item['name']);
}

//User profile flag
$smartyOBJ->assign("user_profile_flag_code", $userProfileFlagCodeList);

?>

