<?php
/**
 * settleDigitalEdyExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後デジタルチェックEdy決済リダイレクト処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);
$returnSessOBJ->return = $param;

$tags = array(
            "odid",        // 注文アクセスキー
            );

$URLparam = $requestOBJ->makeGetTag($tags);

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
    $errSessOBJ->errMsg[] = "ご注文商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$SettlementDigitalEdyOBJ = SettlementDigitalEdy::getInstance();

// テスト環境でなければ決済する
if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
    // Edy決済URL取得
    if (!$SettlementDigitalEdyOBJ->sendToEdy($orderingData, $comUserData)) {
        $errSessOBJ->errMsg[] = "エラーが発生しました。";
        header("Location: ./?action_SettleDigitalEdy=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_SettleDigitalEdyEnd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit;
?>
