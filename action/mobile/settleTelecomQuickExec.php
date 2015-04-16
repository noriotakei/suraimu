<?php
/**
 * settleTelecomQuickExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後クイックチャージ決済処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$SettlementTelecomOBJ = SettlementTelecom::getInstance();
$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "注文がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// 注文詳細リストの確認
if (!$ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errMsgSessOBJ->errMsg[] = "ご注文商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// テスト環境でなければ決済する
if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
    $SettlementTelecomOBJ->setSettleType("quick");
    $SettlementTelecomOBJ->setPostData("money", $orderingData["pay_total"]);
    $SettlementTelecomOBJ->setPostData("sendid", $comUserData["user_id"]);
    $SettlementTelecomOBJ->setPostData("sendpoint", $orderingData["id"]);

    // 引継ぎデータ
    $tags = array(
        "odid",        // 注文アクセスキー
    );

    $URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用

    if (!$SettlementTelecomOBJ->sendToCredit()) {
        $errSessOBJ->errMsg[] = "クイックチャージに失敗しました。";
        header("Location: ./?action_SettleTelecomQuick=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
}

header("Location: ./?action_SettleTelecomQuickEnd=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit;
?>
