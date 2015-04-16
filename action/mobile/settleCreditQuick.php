<?php
/**
 * settleCreditQuick.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後クイックチャージ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "注文がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// 注文詳細リストの確認
if (!$itemList = $ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご注文商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

//カウントダウン処理
if(count($itemList)){
    $salesEndDatetimeAry = array();
    foreach($itemList as $key => $val){
        if($val["sales_end_datetime"] != "0000-00-00 00:00:00"){
            $salesEndDatetimeAry[] = $val["sales_end_datetime"] ;
        }
    }

    if(count($salesEndDatetimeAry)){
        $countDownDate = min($salesEndDatetimeAry) ;

        $timeLimitTimeStomp = strtotime($countDownDate)-strtotime(date("Y-m-d H:i:s"));

        //残り日数
        $DAY = floor($timeLimitTimeStomp/86400);
        $smartyOBJ->assign("countDownDay",'' );
        if($DAY){
            $smartyOBJ->assign("countDownDay",'<span style="color:#f00;">'.$DAY.'</span>日' );
            $minusDay = 86400*$DAY ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusDay ;
        }
        //残り時間        
        $HOUR = floor($timeLimitTimeStomp /3600) ;
        $smartyOBJ->assign("countDownHour",'' );
        if($HOUR){
            $smartyOBJ->assign("countDownHour",'<span style="color:#f00;">'.$HOUR.'</span>時間' );
            $minusHour = 3600*$HOUR ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusHour ;
        }
        //残り分数        
        $MINUTE = floor($timeLimitTimeStomp /60) ;
        $smartyOBJ->assign("countDownMinute",'' );
        if($MINUTE){
            $smartyOBJ->assign("countDownMinute",'<span style="color:#f00;">'.$MINUTE.'</span>分' );
            $minusMinute = 60*$MINUTE ;
            $timeLimitTimeStomp = $timeLimitTimeStomp - $minusMinute ;
        }
        //残り秒数
        $SECOND = $timeLimitTimeStomp ;
        $smartyOBJ->assign("countDownSecond",'<span style="color:#f00;">'.$SECOND.'</span>秒' );

        $smartyOBJ->assign("showCountDown",TRUE);
    }
}

// 引継ぎデータ
$tags = array(
    "odid",        // 注文アクセスキー
);

$URLparam = $requestOBJ->makeGetTag($tags); // URLに付加するGET用
$FORMparam = $requestOBJ->makePostTag($tags); // formに付加するPOST用

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("FORMparam", $FORMparam);
$smartyOBJ->assign("orderingData", $orderingData);
// 表示配列を逆順にしてアサイン
$smartyOBJ->assign("itemList", array_reverse($itemList));
// 決済表示用合計金額の取得
$itemTotalMoney = $orderingData["pay_total"];
$smartyOBJ->assign("itemTotalMoney", $itemTotalMoney);
?>
