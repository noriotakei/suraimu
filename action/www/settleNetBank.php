<?php
/**
 * settleNetBank.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後ネットバンク決済処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$SettlementBankOBJ = SettlementBank::getInstance();
$errSessOBJ = new ComSessionNamespace("err_msg");

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
$smartyOBJ->assign("URLparam", $URLparam);

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
            $errSessOBJ->errMsg[] = "有効な商品が選択されていません。";
            header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
            exit;
        }
    } else {
        $errSessOBJ->errMsg[] = "有効な商品が選択されていません。";
        header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    // 注文情報作成
    $insertOrderingArray["user_id"] = $comUserData["user_id"];
    $insertOrderingArray["status"] = Ordering::ORDERING_STATUS_WAIT_BANK;
    $insertOrderingArray["pay_type"] = Ordering::PAY_TYPE_BANK_AUTOMATION;
    $insertOrderingArray["create_datetime"] = date("YmdHis");
    $insertOrderingArray["update_datetime"] = date("YmdHis");

    if (!$OrderingOBJ->insertOrderingData($insertOrderingArray)) {
        $errSessOBJ->errMsg[] = "予約できませんでした。";
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : ""));
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
            $errSessOBJ->errMsg[] = "予約できませんでした。";
            // ロールバック
            $OrderingOBJ->rollbackTransaction();
            header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : ""));
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
        $errSessOBJ->errMsg[] = "予約できませんでした。";
        header("Location: ./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    // コミット
    $OrderingOBJ->commitTransaction();
    // カートセッション変数の破棄
    $cartSessOBJ->unsetAll();
    header("Location: ./?". $requestOBJ->getActionKey() . "=1&odid=" . $updateOrderingArray["access_key"] . ($comURLparam ? "&" . $comURLparam : ""));
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

        // 有効な商品があれば商品詳細に格納
        if ($itemDetailList) {
            foreach ($itemDetailList as $val) {
                // 注文詳細情報作成
                $insertOrderingDetailArray["ordering_id"] = $orderingData["id"];
                $insertOrderingDetailArray["item_id"] = $val["id"];
                $insertOrderingDetailArray["price"] = $val["price"];
                $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
                $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
                if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
                    $errSessOBJ->errMsg[] = "予約できませんでした。";
                    // ロールバック
                    $OrderingOBJ->rollbackTransaction();
                    header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
                    exit;
                }
                $itemPayTotal = $itemPayTotal + $val["price"];
            }
            // 合計金額の格納
            $updateOrderingArray["pay_total"] = $orderingData["pay_total"] + $itemPayTotal;
        }
    }

    // 注文情報更新
    $updateOrderingArray["status"] = Ordering::ORDERING_STATUS_WAIT_BANK;
    $updateOrderingArray["pay_type"] = Ordering::PAY_TYPE_BANK_AUTOMATION;
    $updateOrderingArray["update_datetime"] = date("YmdHis");

    if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingData["id"]))) {
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "予約できませんでした。";
        header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
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
        $errSessOBJ->errMsg[] = "ご予約データを取得できませんでした。";
        header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    // 注文IDの格納
    $orderingId = $orderingData["id"];
}

// 注文詳細リストの確認
if (!$itemList = $ItemOBJ->getOrderingDetailItemList($orderingId)) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご予約商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
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
        $smartyOBJ->assign("countDownYear", substr($countDownDate, 0, 4));
        $smartyOBJ->assign("countDownMonth", substr($countDownDate, 5, 2));
        $smartyOBJ->assign("countDownDay", substr($countDownDate, 8, 2));
        $smartyOBJ->assign("countDownHour", substr($countDownDate, 11, 2));
        $smartyOBJ->assign("countDownMinute", substr($countDownDate, 14, 2));
        $smartyOBJ->assign("showCountDown",TRUE);
    }
}

// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

// 別途%変換用にセット
$convAry = $OrderingOBJ->makeOrderConvertArray($orderingData);

// リメールデータの取得
$mailAddress = $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"];
$mailElementsData = $AutoMailOBJ->getAutoMailData("ordering", "net_bank", $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"], $convAry);

// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $SendMailOBJ = SendMail::getInstance();
    $mailElements["subject"] = "入金おまかせメール送信エラー";
    $mailElements["text_body"] = "注文ID:" . $orderingData["id"] . "\n金額:" . $orderingData["pay_total"] . "\nユーザーにメール送信できませんでした。";

    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);
    $errSessOBJ->errMsg[] = "メール送信できませんでした。<br>お手数ですが、お問い合わせよりご連絡ください。";
    header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$smartyOBJ->assign("orderingData", $orderingData);
// 表示配列を逆順にしてアサイン
$smartyOBJ->assign("itemList", array_reverse($itemList));
// 決済表示用合計金額の取得
$itemTotalMoney = $orderingData["pay_total"];
$smartyOBJ->assign("itemTotalMoney", $itemTotalMoney);
$smartyOBJ->assign("operationMailAccount", SendMail::OPERATION_MAIL_ACCOUNT);

// ネットバンク用hiddenTag作成
$netBankHiddenTag = $SettlementBankOBJ->getNetBankHiddenTag($orderingData, $comUserData, false);

$smartyOBJ->assign("netBankLinkUrl", SettlementBank::NET_BANK_URL);
$smartyOBJ->assign("netBankHiddenTag", $netBankHiddenTag);
?>
