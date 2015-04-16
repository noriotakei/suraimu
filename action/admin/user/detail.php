<?php

/**
 * detail.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報詳細ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdminUserOBJ = AdmUser::getInstance();
$AdmAdminOBJ = AdmAdmin::getInstance();
$UserOBJ = User::getInstance();
$AdmAdminDisplayControlOBJ = AdmAdminDisplayControl::getInstance();

$userId = $requestOBJ->getParameter("user_id");
$userData =$AdminUserOBJ->getUserData($userId);

// 正規表現文字列に「/」を使用するため、「!」がデリミタ
$deviceRegex = "!^(?:KDDI|UP.Browser/[\d\.]+)-(\S+) !";
if (preg_match($deviceRegex, $userData["mb_user_agent"], $matches)) {
    $ezwebFlag = TRUE ;
}

// MBの場合、ユーザーデータからキャリアを取得
// AUの場合のみ処理
if ($ezwebFlag) {
    if ($userData["mb_user_agent"]) {
        // ユーザエージェントオブジェクト作成
        $userAgentMobileEzwebOBJ = new ComUserAgentMobileEzweb($userData["mb_user_agent"]);
        $model = $userAgentMobileEzwebOBJ->getModel();
        if ($model !="" && $model != $userData["mb_model"]) {
            $userData["mb_model"] = $model;
        }
    }
}

if ($userData) {
    $userData["pre_regist_datetime"] = ComValidation::isDateTime($userData["pre_regist_datetime"]) ? $userData["pre_regist_datetime"] : "";
    $userData["regist_datetime"] = ComValidation::isDateTime($userData["regist_datetime"]) ? $userData["regist_datetime"] : "";
    $userData["last_buy_datetime"] = ComValidation::isDateTime($userData["last_buy_datetime"]) ? $userData["last_buy_datetime"] : "";
    $userData["last_access_datetime"] = ComValidation::isDateTime($userData["last_access_datetime"]) ? $userData["last_access_datetime"] : "";
    $userData["quit_datetime"] = ComValidation::isDateTime($userData["quit_datetime"]) ? $userData["quit_datetime"] : "";
}

if ($userData) {
    //配信ドメイン取得
    $userData["pc_mailmagazine_from_domain"] = $_config["define"]["SEND_MAIL_DOMAIN"][$userData["pc_mailmagazine_from_domain_id"]] ;
    $userData["mb_mailmagazine_from_domain"] = $_config["define"]["SEND_MAIL_DOMAIN"][$userData["mb_mailmagazine_from_domain_id"]] ;
}

// 銀行振込先データ取得
if ($data = $UserOBJ->getBankDetailData($userId)) {
    $userData["bank_name"] = $data["bank_name"];
    $userData["bank_code"] = $data["bank_code"];
    $userData["branch_name"] = $data["branch_name"];
    $userData["branch_code"] = $data["branch_code"];
    $userData["type"] = $data["type"];
    $userData["account_number"] = $data["account_number"];
    $userData["account_holder_name"] = $data["name"];
}

$data = "";
// 住所データ取得
if ($data = $UserOBJ->getAddressDetailData($userId)) {
    $userData["postal_code"] = $data["postal_code"];
    $userData["address"] = $data["address"];
    $userData["address_name"] = $data["name"];
    $userData["phone_number"] = $data["phone_number"];
    $userData["phone_number2"] = $data["phone_number2"];
    $userData["phone_number3"] = $data["phone_number3"];
    $userData["phone_is_use"] = $data["phone_is_use"];
}

//平均購入金額（購入金額合計/購入回数)
if($userData["total_payment"] && $userData["buy_count"]){
    $averageUserPayment = round($userData["total_payment"] /$userData["buy_count"]) ;
    $userData["average_item"] = $averageUserPayment ;
}

//購入商品があるかないか
$OrderingOBJ = Ordering::getInstance();
$otherString = "ORDER BY od.price ASC" ;

$orderingData = $OrderingOBJ->getOrderingDetailListFromOerderingId($userData["user_id"],$otherString);

if($orderingData){
    //最高購入金額（買った商品のうち最も高い品の金額)
    $count = count($orderingData) ;
    $key = $count-1 ;
    $userData["expensive_item"] = $orderingData[$key]["price"] ;

    //最低購入金額（買った商品のうち最も安い品の金額)
    $userData["cheap_item"] = $orderingData[0]["price"] ;

    //中央値（買った商品のうちの中央値の金額)
    if(!is_int($count/2)){
        //奇数
        if($count== 1 ){
            $userData["median_item"] = $orderingData[0]["price"] ;
        } else {
            $key = floor($count/2 ) ;
            $userData["median_item"] = $orderingData[$key]["price"] ;
        }
    }else{
        $keyA = floor($count/2 ) ;
        $keyB = $keyA-1 ;
        $userData["median_item"] = ($orderingData[$keyA]["price"] + $orderingData[$keyB]["price"]) /2;
    }

    //最頻値（買った商品のうちの最頻値の金額｛最頻値が複数ある場合は非表示｝)
    $i=1 ;
    foreach($orderingData as $val){
        $itemPriceAry[$val["price"]] = $itemPriceAry[$val["price"]]+$i;
    }
    arsort($itemPriceAry) ;
    foreach($itemPriceAry as $key => $val){
        if(!$highFrequentlyItemCount){
            $highFrequentlyItemCount = $val ;
            $highFrequentlyItemPrice = $key ;
            $userData["frequently_item"] = $highFrequentlyItemPrice;
        } else {
            if($highFrequentlyItemCount == $val){
                $userData["frequently_item"] = "";
                break ;
            } else {
                break ;
            }
        }
    }
}

$smartyOBJ->assign("userData", $userData);

$tags = array(
            "user_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// 重複ユーザーの取得
if ($userData) {
    $columnArray[] = "user_id";

    if ($userData["pc_address"]) {
        $duplicateWhere[] = "pc_address = '" . $userData["pc_address"] . "'";
    }

    if ($userData["mb_address"]) {
        $duplicateWhere[] = "mb_address = '" . $userData["mb_address"] . "'";
    }

    if ($userData["mb_serial_number"]) {
        $duplicateWhere[] = "mb_serial_number = '" . $userData["mb_serial_number"] . "'";
    }

    if(count($duplicateWhere)){
        $whereArray[] = "(" . implode(" OR ", $duplicateWhere) . ")";
        $whereArray[] = "user_id != " . $userData["user_id"];
        $duplicateUserDataList = $AdminUserOBJ->getUserListByFreeSearch($columnArray, $whereArray);
        $smartyOBJ->assign("duplicateUserDataList", $duplicateUserDataList);
    }
}
// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err");
// エラーメッセージの取得
$errMsg = $errSessOBJ->getIterator();
// セッション変数の破棄
$errSessOBJ->unsetAll();
$smartyOBJ->assign("errMsg", $errMsg);

$adminList = $AdmAdminOBJ->getListForSelect();
$smartyOBJ->assign("adminList", array("0" => "一般") + (array)$adminList);
$smartyOBJ->assign("accessKeyName", Auth::ACCESS_KEY_NAME);
$smartyOBJ->assign("phoneIsUse", array("0" => "電話受信なし","1" => "電話受信あり") );

// 個体識別削除
$smartyOBJ->assign("serialNumberDelete", array("1" => "この個体識別を削除する"));

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileFlagCodeList = array("0" => "フラグＯＦＦ");
foreach ($userProfileFlagList as $item) {
    $userProfileFlagCodeList += array(
            $item['code'] => $item['name']);
}
$sesParam['userProfileCodeFlagList'] = $userProfileFlagCodeList;
$smartyOBJ->assign("user_profile_flag_code", $userProfileFlagCodeList);


?>
