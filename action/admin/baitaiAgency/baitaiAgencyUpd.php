<?php
/**
 * baitaiUserUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体CHKユーザー更新ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmBaitaiAgencyOBJ = AdmBaitaiAgency::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 代理店データを取得
$baitaiAgencyData = $AdmBaitaiAgencyOBJ->getUserData($param["id"]);

// 登録エラーで戻った場合
if ($returnValue["return_cd"]  == "setting") {
    // 媒体コード設定
    $cdSettingParam = $returnValue;
    $cdSettingParam["return_flag"] = 1;
    $ipSettingParam["return_flag"] = 0;
    $agencyParam = $baitaiAgencyData;
} else if ($returnValue["return_cd"]  == "ip_setting") {
    // 認証IPアドレス設定
    $ipSettingParam = $returnValue;
    $ipSettingParam["return_flag"] = 1;
    $cdSettingParam["return_flag"] = 0;
    $agencyParam = $baitaiAgencyData;
} else if ($returnValue["return_flag"]) {
    // 代理店設定
    $agencyParam = $returnValue;
    $cdSettingParam["return_flag"] = 0;
    $ipSettingParam["return_flag"] = 0;
} else {
    // その他
    $agencyParam = $baitaiAgencyData;
    $cdSettingParam["return_flag"] = 0;
    $ipSettingParam["return_flag"] = 0;
}

$smartyOBJ->assign("agencyParam", $agencyParam);
$smartyOBJ->assign("cdSettingParam", $cdSettingParam);
$smartyOBJ->assign("ipSettingParam", $ipSettingParam);

$POSTparam = $requestOBJ->makePostTag(array("id"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("disable", array("1" => "削除する"));

// 入金額の表示/非表示
$smartyOBJ->assign("isDisplayPay", AdmBaitaiAgency::$_isDisplayPay);


// 設定した媒体コードリストの取得
$AdmBaitaiAgencyCdSettingOBJ = AdmBaitaiAgencyCdSetting::getInstance();

$cdSettingList = $AdmBaitaiAgencyCdSettingOBJ->getBaitaiAgencyCdSettingList(array("baitai_agency_id = " . $param["id"]));
$smartyOBJ->assign("cdSettingList", $cdSettingList);

// 設定した認証IPアドレスリストの取得
$AdmBaitaiAgencyIpAddressSettingOBJ = AdmBaitaiAgencyIpAddressSetting::getInstance();
$ipSettingList = $AdmBaitaiAgencyIpAddressSettingOBJ->getBaitaiAgencyIpAddressSettingList(array("baitai_agency_id = " . $param["id"]));

foreach ($ipSettingList as $key => $val) {
    $ipAddressAry = "";
    $ipAddressAry = explode(".",  $val["ip_address"]);
    $ipSettingList[$key]["ip_address"] = $ipAddressAry;
}

$smartyOBJ->assign("ipSettingList", $ipSettingList);

// 使用状況フラグ
$smartyOBJ->assign("isUse", AdmBaitaiAgencyIpAddressSetting::$_isUse);

// 認証タイプ
$smartyOBJ->assign("isAuthIpAddress", AdmBaitaiAgency::$_isAuthIpAddress);

// 成果報酬の期間
/*
$spanForPercent = $_config["web_config"]["month"] + array(99=>"無期限") ;
$smartyOBJ->assign("spanForPercent", $spanForPercent);
*/
//広告費タイプ
$advertiseExpensesType = AdmBaitaiAgencyCdSetting::$_advertiseExpensesType ;
$advertiseExpensesType = $advertiseExpensesType + array(0=>"設定しない") ;
$smartyOBJ->assign("advertiseExpensesType", $advertiseExpensesType);
?>