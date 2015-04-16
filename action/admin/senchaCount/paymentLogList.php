<?php

/**
 * paymentLogList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面入金ログリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);
$ComEmojiOBJ = ComEmoji::getInstance();
// 他キャリアの絵文字を変換する際、半角カナを用いるよう設定
$ComEmojiOBJ->useHalfwidthKatakana();

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "p.create_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

// 登録日
if (!$param["start_date"] AND !$param["end_date"] AND ComValidation::isDate($param["date"])) {
    $defaultWhereArray[] = "p.create_datetime >= '" . $param["date"] . " 00:00:00'";
    $defaultWhereArray[] = "p.create_datetime <= '" . $param["date"] . " 23:59:59'";
}

$columnArray[] = "p.*";
$columnArray[] = "o.id ordering_id";
$columnArray[] = "o.status ordering_status";
$columnArray[] = "o.create_datetime ordering_create_datetime";

// ログリスト
$dataList = $AdmCalculationOBJ->getCalcPaymentList($param, $columnArray, $defaultWhereArray, $otherArray);
if ($dataList) {
    foreach ($dataList as $key => $val) {
        $total["cnt"]++;
        $total["receive_money"] += $val["receive_money"];
        $dataList[$key]["pay_type"] = AdmOrdering::$_payType[$val["pay_type"]];

        if ($val["ordering_status"] == AdmOrdering::ORDERING_STATUS_REST) {
            $dataList[$key]["item"] = "余り金決済";
        } else {
            $itemList = "";
            // 商品詳細の取得
            $itemList = $AdmItemOBJ->getOrderingDetailItemList($val["ordering_id"]);
            foreach ((array)$itemList as $itemVal) {
                if ($itemVal["is_rest"]) {
                    $dataList[$key]["item"] = '余り金PT購入';
                } else {
                    $dataList[$key]["item"] .= '<b>ID</b> : <a href="./?action_itemManagement_ItemData=1&iid=' . $itemVal["id"] . '" target="_blank">' . $itemVal["id"] . '</a>';
                    $dataList[$key]["item"] .= " " . $ComEmojiOBJ->convertCarrier($itemVal["name"]) . " " . number_format($itemVal["price"]) . "円<br><hr>";
                }
            }
        }
    }
    $jsonData = $dataList;
}

$data = "";

$data["create_datetime"] = "合計";
$data["ordering_id"] = ($total["cnt"] ? $total["cnt"] : 0) . "件";
$data["receive_money"] = ($total["receive_money"] ? $total["receive_money"] : 0);

$jsonData[] = $data;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
