<?php
/**
 * settleTelecom.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後クレジット処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$SettlementTelecomOBJ = SettlementTelecom::getInstance();
// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

// カートから商品IDを取り出す
$cartSessOBJ = new ComSessionNamespace("cart");
$ItemIdList = $cartSessOBJ->itemId;

$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 引継ぎデータ
$tags = array(
    "odid",        // 注文アクセスキー
);

$URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用
$FORMparam = $requestOBJ->makePostTag($tags); // formに付加するPOST用

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("FORMparam", $FORMparam);

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    // トランザクション開始
    $OrderingOBJ->beginTransaction();

    // 商品の有効性を確認
    if ($ItemIdList) {

        foreach ($ItemIdList as $val) {
            $itemDetailList[] = $ItemOBJ->getItemData($comUserData, array("access_key" => $val));
        }

        // すべて有効でなければ商品リストへ
        if (!$itemDetailList) {
            header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
            exit;
        }
    } else {
        header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }

    // 注文情報作成
    $insertOrderingArray["user_id"] = $comUserData["user_id"];
    $insertOrderingArray["status"] = Ordering::ORDERING_STATUS_WAIT_TELECOM;
    $insertOrderingArray["pay_type"] = Ordering::PAY_TYPE_TELECOM;
    $insertOrderingArray["create_datetime"] = date("YmdHis");
    $insertOrderingArray["update_datetime"] = date("YmdHis");

    if (!$OrderingOBJ->insertOrderingData($insertOrderingArray)) {
        $errSessOBJ->errMsg[] = "注文できませんでした。";
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }

    $orderingId = $OrderingOBJ->getInsertId();

    foreach ($itemDetailList as $val) {
        // 注文詳細情報作成
        $insertOrderingDetailArray["ordering_id"] = $orderingId;
        $insertOrderingDetailArray["item_id"] = $val["id"];
        $insertOrderingDetailArray["price"] = $val["price"];
        $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
        $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
        if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
            $errSessOBJ->errMsg[] = "注文できませんでした。";
            // ロールバック
            $OrderingOBJ->rollbackTransaction();
            header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
            exit;
        }
        $itemPayTotal = $itemPayTotal + $val["price"];
    }

    // アクセスキーと合計金額の更新
    $updateOrderingArray["access_key"] = $OrderingOBJ->getNewAccessKey($orderingId);
    $updateOrderingArray["pay_total"] = $itemPayTotal;
    if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingId))) {
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "注文できませんでした。";
        header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }

    // コミット
    $OrderingOBJ->commitTransaction();
    // カートセッション変数の破棄
    $cartSessOBJ->unsetAll();
    header("Location: ./?". $requestOBJ->getActionKey() . "=1&odid=" . $updateOrderingArray["access_key"] . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;

// 注文情報があれば更新
} else {

    // 商品の有効性を確認
    if ($ItemIdList) {

        foreach ($ItemIdList as $val) {
            // 注文詳細に商品がなければ商品詳細情報を取得
            $itemDetailData = $ItemOBJ->getItemData($comUserData, array("access_key" => $val));
            if (!$OrderingOBJ->getOrderingDetailDataFromItemId($orderingData["id"], $itemDetailData["id"])) {
                $itemDetailList[] = $itemDetailData;
            }
        }

        // トランザクション開始
        $OrderingOBJ->beginTransaction();

        // 有効な商品があれば商品詳細に追加
        if ($itemDetailList) {
            foreach ($itemDetailList as $val) {
                // 注文詳細情報作成
                $insertOrderingDetailArray["ordering_id"] = $orderingData["id"];
                $insertOrderingDetailArray["item_id"] = $val["id"];
                $insertOrderingDetailArray["price"] = $val["price"];
                $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
                $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
                if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
                    $errSessOBJ->errMsg[] = "注文できませんでした。";
                    // ロールバック
                    $OrderingOBJ->rollbackTransaction();
                    header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
                    exit;
                }
                $itemPayTotal = $itemPayTotal + $val["price"];
            }
            // 合計金額の格納
            $updateOrderingArray["pay_total"] = $orderingData["pay_total"] + $itemPayTotal;
        }
    }

    // 注文情報更新
    $updateOrderingArray["status"] = Ordering::ORDERING_STATUS_WAIT_TELECOM;
    $updateOrderingArray["pay_type"] = Ordering::PAY_TYPE_TELECOM;
    $updateOrderingArray["update_datetime"] = date("YmdHis");

    if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingData["id"]))) {
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "注文できませんでした。";
        header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
    // コミット
    $OrderingOBJ->commitTransaction();

    // カートセッション変数の破棄
    $cartSessOBJ->unsetAll();

    // 注文の再取得
    if (!$orderingData = $OrderingOBJ->getOrderingData($orderingData["id"], $comUserData["user_id"])) {
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "注文データを取得できませんでした。";
        header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }

    // 注文IDの格納
    $orderingId = $orderingData["id"];
}

// 注文詳細リストの取得
if (!$itemList = $ItemOBJ->getOrderingDetailItemList($orderingId)) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご注文商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

//カウントダウン処理
if(count($itemList)){
    $salesEndDatetimeAry = array();
    foreach($itemList as $key => $val){
        if($val["sales_end_datetime"] != "0000-00-00 00:00:00"){
            $salesEndDatetimeAry[] = $val["sales_end_datetime"] ;
        }
    }

    if(count($salesEndDatetimeAry)){
        $countDownDate = min($salesEndDatetimeAry) ;

        $timeLimitTimeStomp = strtotime($countDownDate)-strtotime(date("Y-m-d H:i:s"));

        //残り日数
        $DAY = floor($timeLimitTimeStomp/86400);
        $smartyOBJ->assign("countDownDay",'' );
        if($DAY){
            $smartyOBJ->assign("countDownDay",'<span style="color:#f00;">'.$DAY.'</span>日' );
            $minusDay = 86400*$DAY ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusDay ;
        }
        //残り時間        
        $HOUR = floor($timeLimitTimeStomp /3600) ;
        $smartyOBJ->assign("countDownHour",'' );
        if($HOUR){
            $smartyOBJ->assign("countDownHour",'<span style="color:#f00;">'.$HOUR.'</span>時間' );
            $minusHour = 3600*$HOUR ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusHour ;
        }
        //残り分数        
        $MINUTE = floor($timeLimitTimeStomp /60) ;
        $smartyOBJ->assign("countDownMinute",'' );
        if($MINUTE){
            $smartyOBJ->assign("countDownMinute",'<span style="color:#f00;">'.$MINUTE.'</span>分' );
            $minusMinute = 60*$MINUTE ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusMinute ;
        }
        //残り秒数
        $SECOND = $timeLimitTimeStomp ;
        $smartyOBJ->assign("countDownSecond",'<span style="color:#f00;">'.$SECOND.'</span>秒' );

        $smartyOBJ->assign("showCountDown",TRUE);
    }
}

$smartyOBJ->assign("orderingData", $orderingData);
// 表示配列を逆順にしてアサイン
$smartyOBJ->assign("itemList", array_reverse($itemList));

$SettlementTelecomOBJ->setSettleType("ssl");
$SettlementTelecomOBJ->setHiddenData("money", $orderingData["pay_total"]);
$SettlementTelecomOBJ->setHiddenData("sendid", $comUserData["user_id"]);
$SettlementTelecomOBJ->setHiddenData("sendpoint", $orderingData["id"]);
$SettlementTelecomOBJ->setHiddenData("i", "on");
$SettlementTelecomOBJ->setHiddenData("usrmail", $comUserData["mb_address"] ? $comUserData["mb_address"] : $comUserData["pc_address"]);
$SettlementTelecomOBJ->setHiddenData("redirect_back_url", $_config["define"]["SITE_URL_MOBILE"] . "?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);

$creditUrl = $SettlementTelecomOBJ->getCreditSettleUrl();
$creditHiddenTags = $SettlementTelecomOBJ->makeCreditHiddenTags();

// クイックチャージ判定
$isQuick = $comUserData["telecom_certify_phone_number"] ? true : false;

$smartyOBJ->assign("isQuick", $isQuick);
$smartyOBJ->assign("creditUrl", $creditUrl);
$smartyOBJ->assign("creditHiddenTags", $creditHiddenTags);
// 決済表示用合計金額の取得
$itemTotalMoney = $orderingData["pay_total"];
$smartyOBJ->assign("itemTotalMoney", $itemTotalMoney);
?>
