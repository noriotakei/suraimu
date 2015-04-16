<?php
/**
 * order.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後最新の予約表示処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

if ($dispLastOrderingFlag) {
    $OrderingOBJ = Ordering::getInstance();
    $ItemOBJ = Item::getInstance();

    // 最新注文の取得
    $lastOrderingData = $OrderingOBJ->getLastOrderingData($comUserData["user_id"]);

    // 注文詳細リストの取得
    if ($lastOrderingItemList = $ItemOBJ->getOrderingDetailItemList($lastOrderingData["id"])) {
        $smartyOBJ->assign("lastOrderingData", $lastOrderingData);
        // 表示配列を逆順にしてアサイン
        $smartyOBJ->assign("lastOrderingItemList", array_reverse($lastOrderingItemList));

        // 決済リンクURLの生成
        $settleLinkUrl = Ordering::$_SettleUrl[$lastOrderingData["pay_type"]];
        $settleName = Ordering::$_settleName[$lastOrderingData["pay_type"]];
        $smartyOBJ->assign("settleLinkUrl", $settleLinkUrl);
        $smartyOBJ->assign("settleName", $settleName);

        $smartyOBJ->assign("bankName", SettlementBank::BANK_NAME);
        $smartyOBJ->assign("branchName", SettlementBank::BRANCH_NAME);
        $smartyOBJ->assign("accountNumber", SettlementBank::ACCOUNT_NUMBER);
        $smartyOBJ->assign("transferDestination", SettlementBank::TRANSFER_DESTINATION);
    }
}

//カウントダウン処理
if($lastOrderingItemList[0]["sales_end_datetime"]){

    $salesEndDatetimeAry = array();
    foreach($lastOrderingItemList as $key => $val){
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

?>
