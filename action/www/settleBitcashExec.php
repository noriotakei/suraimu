<?php
/**
 * settleBitcashExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後ビットキャッシュ決済処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

// 引継ぎデータ
$tags = array(
    "odid",        // 注文アクセスキー
);

$URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用

// カードナンバーが不正
if (!preg_match("/^[ぁ-ん]+$/u", $param["card_number"]) OR mb_strlen($param["card_number"], "UTF-8") != 16) {
    $errSessOBJ->errMsg[] = "カード番号が正しくありません。";
    header("Location: ./?action_SettleBitcash=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$SettlementBitcashOBJ = SettlementBitcash::getInstance();
$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "ご予約がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 決済金額の確認
if ($orderingData["pay_total"] > 25000) {
    $errSessOBJ->errMsg[] = "ビットキャッシュ決済は25000円以下しか使えません。";
    header("Location: ./?action_SettleBank=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 注文詳細リストの確認
if (!$ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご予約商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

if (!$SettlementBitcashOBJ->sendToBitcash($orderingData, $param["card_number"])) {
    $errSessOBJ->errMsg[] = "決済が失敗しました。<br>カード番号をご確認下さい。";
    header("Location: ./?action_SettleBitcash=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 金額
$param["money"] = $orderingData["pay_total"];

// エラーメッセージ
//$param["errMsg"][] = "注文ID:" . $orderingData["id"] . "\nカード番号:" . $param["card_number"] . "\n金額:" . $orderingData["pay_total"];
$param["errMsg"][] = "注文ID:" . $orderingData["id"] . "\n金額:" . $orderingData["pay_total"];

// トランザクション開始
$SettlementBitcashOBJ->beginTransaction();

// 決済処理
if (!$SettlementBitcashOBJ->execSettlement($orderingData, $comUserData, Ordering::PAY_TYPE_BITCASH, $param)) {
    // ロールバック
    $SettlementBitcashOBJ->rollbackTransaction();
    $errSessOBJ->errMsg[] = "決済が失敗しました。<br>お手数ですが、お問い合わせよりご連絡ください。";
    header("Location: ./?action_SettleBitcash=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// コミット
$SettlementBitcashOBJ->commitTransaction();
header("Location: ./?action_SettleBitcashEnd=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;

?>
