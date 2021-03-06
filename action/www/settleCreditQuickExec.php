<?php
/**
 * settleCreditQuickExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後クイックチャージ決済処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");

$SettlementCreditOBJ = SettlementCredit::getInstance();
$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "ご予約がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 注文詳細リストの確認
if (!$ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご予約商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// テスト環境でなければ決済する
if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
    $SettlementCreditOBJ->setSettleType("quick_pc");
    $SettlementCreditOBJ->setPostData("money", $orderingData["pay_total"]);
    $SettlementCreditOBJ->setPostData("sendid", $comUserData["user_id"]);
    $SettlementCreditOBJ->setPostData("telno", $comUserData["credit_certify_phone_number"]);
    $SettlementCreditOBJ->setPostData("sendpoint", $orderingData["id"]);
    $SettlementCreditOBJ->setPostData("email", $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"]);
    $SettlementCreditOBJ->setPostData("siteurl", $_config["define"]["SITE_URL"] . "?action_Home=1&" . $sessId);

    // 引継ぎデータ
    $tags = array(
        "odid",        // 注文アクセスキー
    );

    $URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用

    if (!$SettlementCreditOBJ->sendToCredit()) {
        $errSessOBJ->errMsg[] = "クイックチャージに失敗しました。";
        header("Location: ./?action_SettleCreditQuick=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

header("Location: ./?action_SettleCreditQuickEnd=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;
?>
