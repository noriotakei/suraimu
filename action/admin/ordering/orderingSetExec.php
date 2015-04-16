<?php
/**
 * orderingStatusExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文ステータスデータ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmItemOBJ = AdmItem::getInstance();

$tags = array(
            "user_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("item_id", "商品ID",
                array("Value" => null),
                array("Value" => "商品IDを入力してください"));

$validationOBJ->check("pay_type", "支払方法",
                array("Numeric" => null),
                array("Numeric" => "支払方法を選択してください"));

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
    exit;
}

$itemIdAry = explode(",", $param["item_id"]);

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

// 注文情報作成
$insertOrderingArray["user_id"] = $param["user_id"];
$insertOrderingArray["status"] = $param["status"];
$insertOrderingArray["pay_type"] = $param["pay_type"];
$insertOrderingArray["create_datetime"] = date("YmdHis");
$insertOrderingArray["update_datetime"] = date("YmdHis");

if (!$AdmOrderingOBJ->insertOrderingData($insertOrderingArray)) {
    $AdmOrderingOBJ->rollbackTransaction();
    $execMsgSessOBJ->exec_msg = array("注文登録出来ませんでした。");
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
    exit;
}

$orderingId = $AdmOrderingOBJ->getInsertId();

foreach ((array)$itemIdAry as $val) {
    $itemData = $AdmItemOBJ->getItemData($val);
    if (!$itemData) {
        $AdmOrderingOBJ->rollbackTransaction();
        $execMsgSessOBJ->exec_msg = array("商品がありません。");
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
        exit;
    }

    // 注文詳細情報作成
    $insertOrderingDetailArray["ordering_id"] = $orderingId;
    $insertOrderingDetailArray["item_id"] = $val;
    $insertOrderingDetailArray["price"] = $itemData["price"];
    $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
    $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
    if (!$AdmOrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
        $execMsgSessOBJ->exec_msg = array("注文登録出来ませんでした。");
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
        exit;
    }
    $itemPayTotal = $itemPayTotal + $itemData["price"];
}

// アクセスキーと合計金額の更新
$updateOrderingArray["access_key"] = $AdmOrderingOBJ->getNewAccessKey($orderingId);
$updateOrderingArray["pay_total"] = $itemPayTotal;
if (!$AdmOrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingId))) {
    $execMsgSessOBJ->exec_msg = array("注文登録出来ませんでした。");
    // ロールバック
    $AdmOrderingOBJ->rollbackTransaction();
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
    exit;
}

$execMsgSessOBJ->errMsg = array("注文登録しました。");

// コミット
$AdmOrderingOBJ->commitTransaction();

header("location: ./?action_ordering_OrderingSet=1&" . $URLparam);
exit;
?>