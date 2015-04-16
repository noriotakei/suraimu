<?php
/**
 * settleSelect.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後決済選択処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラーセッション生成
$errMsgSessOBJ = new ComSessionNamespace("err_msg");

// カートに商品IDを格納
$cartSessOBJ = new ComSessionNamespace("cart");
$ItemOBJ = Item::getInstance();

$MonthlyCourseOBJ = MonthlyCourse::getInstance();

// カートから商品削除
if ($param["del"]) {
    // カートから削除対象商品IDの「キー」を抽出
    if ($param["iid"] AND $cartSessOBJ->itemId) {
        $delCartItemKey = array_search($param["iid"], $cartSessOBJ->itemId);
        // カートからキーを元に削除
        unset($cartSessOBJ->itemId[$delCartItemKey]);
    }
// カートに商品追加
} else {
    if ($param["iid"]) {
        // 商品データ取得
        $itemSearchKey = array();
        $itemSearchKey["access_key"] = $param["iid"];
        $itemData = $ItemOBJ->getItemData($comUserData, $itemSearchKey);

        // 購入可能な商品であればカート処理
        if ($itemData) {
            if($itemData["redirect_unit_item_id"] && $itemData["redirect_unit_id"]){
                $UnitOBJ = Unit::getInstance();

                $redirectItemUnitIdAry = "";
                $redirectUnitIdAry = "";
                $redirectItemUnitIdAry = explode(",", $itemData["redirect_unit_item_id"]);
                $redirectUnitIdAry = explode(",", $itemData["redirect_unit_id"]);

                foreach ($redirectUnitIdAry as $key => $unitId) {
                    $isInUnitUserResult = $UnitOBJ->isInUnitUser($comUserData["user_id"],$unitId) ;
                    if($isInUnitUserResult){
                        $redirectUnitItemIdKey = $key ;

                        //unit_idと対になる商品IDを取得。
                        $redirectItemId = $redirectItemUnitIdAry[$redirectUnitItemIdKey] ;

                        if($redirectItemId){
                            $itemSearchIdKey = array();
                            $itemSearchIdKey["id"] = $redirectItemId ;
                            if ($preItemData = $ItemOBJ->getItemData($comUserData, $itemSearchIdKey)) {
                                $itemData = $preItemData ;
                                // 一つでもﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ商品データが取得出来たらﾙｰﾌﾟを抜ける
                                break ;
                            }
                        }
                    }
                }
            }
            /*** 追加処理 ***/
            if (!$cartSessOBJ->itemId) {
                // カートに商品を新規格納
                $cartSessOBJ->itemId[] = $itemData["access_key"];
            } else {
                if (!is_numeric(array_search($itemData["access_key"], $cartSessOBJ->itemId))) {
                    // 同じグループの付与月額コース設定の商品があった場合は上書き処理
                    if($itemData["monthly_course_id"]){
                        // 商品に設定されている月額コースデータを取得
                        if($monthlyCourseData = $MonthlyCourseOBJ->getMonthlyCourseData($itemData["monthly_course_id"])){
                            //同じグループの月額コースが設定されている商品データを取得
                            $mcItemSearchKey = array();
                            $mcItemSearchKey["monthly_course_group_id"] = $monthlyCourseData["monthly_course_group_id"];
                            if($mcItemList = $ItemOBJ->getItemList($comUserData, $mcItemSearchKey)){
                                //カート内の同じグループの月額コースが設定されている商品データがあったら上書き
                                foreach($mcItemList as $mcItemValue){
                                    $updateKey = array_search($mcItemValue["access_key"], $cartSessOBJ->itemId);
                                    if($updateKey !== false){
                                        $cartSessOBJ->itemId[$updateKey] = $itemData["access_key"];
                                    }

                                }
                                $cartSessOBJ->itemId = array_unique($cartSessOBJ->itemId);
                            }
                        }
                    }
                    // まだカートに商品が入っていなかったら格納
                    if(array_search($itemData["access_key"], $cartSessOBJ->itemId) === false){
                        $cartSessOBJ->itemId[] = $itemData["access_key"];
                    }
                } else {
                    // 同一商品がカートにあらばメッセージ作成
                    $errMsgSessOBJ->errMsg[] = "お選び頂きました商品は";
                    $errMsgSessOBJ->errMsg[] = "現在ｶｰﾄに入っております｡";
                }
            }
        } else {
            // エラーメッセージ作成
            $errMsgSessOBJ->errMsg[] = "申し訳ありません｡";
            $errMsgSessOBJ->errMsg[] = "お選び頂きました商品は";
            $errMsgSessOBJ->errMsg[] = "現在お取り扱い出来ません｡";

            // 商品リストページへ
            header("Location:./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
            exit;
        }
    }
}

// カートに入れた商品リストの取得
if (!$cartSessOBJ->itemId) {
    // この時点でカートに商品が無ければ商品リストページへ
    header("Location:./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
} else {
    // 販売終了フラグ(デフォルトはFALSE)
    $salesEndFlg = FALSE;

    // カートの商品を取得
    $itemList = array();
    $itemSearchKey = array();
    foreach ($cartSessOBJ->itemId as $key => $val) {

        // 商品アクセスキー設定
        $itemSearchKey["access_key"] = $val;

        if ($data = $ItemOBJ->getItemData($comUserData, $itemSearchKey)) {
            // 購入可能な商品のみ格納
            $itemList[$key] = $data;
            $itemTotalMoney += $data["price"];
        } else {
            // カートからキーを元に削除
            unset($cartSessOBJ->itemId[$key]);
            // カートの商品が販売終了なのでフラグ変更
            $salesEndFlg = TRUE;
        }
    }

    // カートに販売終了の商品があればエラーメッセージ生成
    if ($salesEndFlg) {
        // エラーメッセージ作成
        $errMsgSessOBJ->errMsg[] = "販売終了とさせて頂きました";
        $errMsgSessOBJ->errMsg[] = "商品をｶｰﾄから削除しました｡";
    }

    // この時点でカートに商品が無ければ商品リストページへ
    if (!$itemList) {
        // この時点でカートに商品が無ければ商品リストページへ
        header("Location:./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
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

// エラーメッセージの取得
if ($errMsgSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errMsgSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errMsgSessOBJ->unsetAll();
}

// 表示配列を逆順にしてアサイン
$smartyOBJ->assign("itemList", array_reverse($itemList));
$smartyOBJ->assign("itemTotalMoney", $itemTotalMoney);

//リダイレクト決済選択処理
$settlementOBJ = Settlement::getInstance();
$settleControlData = $settlementOBJ->getSettleSelectData() ;
if($settleControlData["direct_settle_name"] != "not_select"){
    header("Location:./?action_".$settleControlData["direct_settle_name"]."=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
}

?>
