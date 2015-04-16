<?php

/**
 * salesReportItemMonth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面当月登録商品別売り上げ(月間)リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);
$ComEmojiOBJ = ComEmoji::getInstance();
// 他キャリアの絵文字を変換する際、半角カナを用いるよう設定
$ComEmojiOBJ->useHalfwidthKatakana();


// 商品別売り上げの取得
$dispDataList = $AdmCalculationOBJ->getCalcItemMonthList($param);

// 総合計
if ($dispDataList) {
    foreach ((array)$dispDataList as $val) {
        $val["item_name"] = ($val["is_rest"] ? "余り金PT購入" : $ComEmojiOBJ->convertCarrier($val["item_name"]));
        $jsonData[] = $val;
        $totalDataList["ordering_cnt"] += $val["ordering_cnt"];
        $totalDataList["total_pay"] += $val["total_pay"];
    }
    $totalDataList["item_id"] = "総合計";
}

$jsonData[] = $totalDataList;

$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;
?>
