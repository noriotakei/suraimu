<?php
/**
 * orderCancel.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 期限切れ注文の自動キャンセル。
 * 毎日1時に回す
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();

// 期限切れ週
$week = -2;

$expirationOrderingList = $AdmOrderingOBJ->getExpirationOrderingDataList();
$expirationWeekOrderingList = $AdmOrderingOBJ->getExpirationWeekOrderingList($week);
while (list($key, $val) = each($expirationOrderingList)) {
    $orderingList[] = $val["id"];
}
while (list($key, $val) = each($expirationWeekOrderingList)) {
    $orderingList[] = $val["id"];
}

if ($orderingList) {

    while (list($orderKey, $orderVal) = each($orderingList)) {

        $orderingArray = null;
        $orderingDetailList = null;

        // トランザクション開始
        $AdmOrderingOBJ->beginTransaction();

        $orderingArray["is_cancel"] = 1;
        $orderingArray["pay_total"] = 0;
        $orderingArray["cancel_datetime"] = date("YmdHis");
        $orderingArray["update_datetime"] = date("YmdHis");
        // 注文データ更新
        if (!$AdmOrderingOBJ->updateOrderingData($orderingArray, array("id = " . $orderVal))) {
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
        }

        $orderingDetailList = $AdmOrderingOBJ->getOrderingDetailList($orderVal);

        foreach ((array)$orderingDetailList as $val) {

            // 注文詳細をキャンセルログに登録する
            $orderingChangeLogArray = null;

            // 注文変更ログ登録
            $orderingChangeLogArray["ordering_id"] = $orderVal;
            $orderingChangeLogArray["item_id"] = $val["item_id"];
            $orderingChangeLogArray["price"] = (0 - $val["price"]);
            $orderingChangeLogArray["status"] = AdmOrderChangeLog::STATUS_NOT_PAID;
            $orderingChangeLogArray["create_datetime"] = date("YmdHis");

            if (!$AdmOrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
                // ロールバック
                $AdmOrderingOBJ->rollbackTransaction();
            }

            $orderingDetailArray = null;

            $orderingDetailArray["is_cancel"] = 1;
            $orderingDetailArray["update_datetime"] = date("YmdHis");

            // 注文詳細データ更新
            if (!$AdmOrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $val["id"]))) {
                // ロールバック
                $AdmOrderingOBJ->rollbackTransaction();
            }
        }
        // コミット
        $AdmOrderingOBJ->commitTransaction();
    }
}

// 終了
exit("COMPLETE!!");
?>
