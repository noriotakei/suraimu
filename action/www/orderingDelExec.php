<?php
/**
 * orderingDelExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後予約削除処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");

$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();
$OrderChangeLogOBJ = OrderChangeLog::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "ご予約がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 注文詳細リストの確認
if (!$itemList = $ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご予約商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 引継ぎデータ
$tags = array(
    "odid",        // 注文アクセスキー
);

$URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用

// トランザクション開始
$OrderingOBJ->beginTransaction();

foreach ((array)$itemList as $val) {

    // 注文詳細をキャンセルログに登録する
    $orderingChangeLogArray = null;

    // 注文変更ログ登録
    $orderingChangeLogArray["ordering_id"] = $val["ordering_id"];
    $orderingChangeLogArray["item_id"] = $val["id"];
    $orderingChangeLogArray["price"] = (0 - $val["price"]);
    $orderingChangeLogArray["create_datetime"] = date("YmdHis");

    if (!$OrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
    $errSessOBJ->errMsg[] = "ご予約キャンセルできませんでした。";
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        header("Location: ./?action_OrderingDelChk=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }

    $orderingDetailArray = null;

    $orderingDetailArray["is_cancel"] = 1;
    $orderingDetailArray["update_datetime"] = date("YmdHis");

    // 注文詳細データ更新
    if (!$OrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $val["detail_id"]))) {
        $errSessOBJ->errMsg[] = "ご予約キャンセルできませんでした。";
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        header("Location: ./?action_OrderingDelChk=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

// 注文情報更新
$updateOrderingArray["is_cancel"] = 1;
$updateOrderingArray["pay_total"] = 0;
$updateOrderingArray["update_datetime"] = date("YmdHis");
$updateOrderingArray["cancel_datetime"] = date("YmdHis");

if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingData["id"]))) {
    $errSessOBJ->errMsg[] = "ご予約キャンセルできませんでした。";
    header("Location: ./?action_OrderingDelChk=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// コミット
$OrderingOBJ->commitTransaction();

header("Location: ./?action_OrderingDelComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;

?>
