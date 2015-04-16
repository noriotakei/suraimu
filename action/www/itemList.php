<?php
/**
 * itemList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後情報処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");

// 予約注文表示設定取得
$OrderingOBJ = Ordering::getInstance();
$orderingDisplaySettingData = $OrderingOBJ->getOrderingDisplaySettingData(Ordering::ORDERING_DISPLAY_CD_PC_ITEMLIST);
$dispLastOrderingFlag = $orderingDisplaySettingData["is_display"];

require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラーメッセージの取得
$errMsgSessOBJ = new ComSessionNamespace("err_msg");

if ($errMsgSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errMsgSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errMsgSessOBJ->unsetAll();
}

// インスタンス生成
$infoStatusOBJ = InformationStatus::getInstance();
$infoStatusLogOBJ = InformationStatusLog::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

// 商品表示場所(説明文)※配列キーは下記「商品リスト」に合わせて下さい。
$itemDispPositionExpList[] = InformationStatus::DISPLAY_POSITION_ITEM_EXPLANATION;

// 商品表示場所(商品リスト)※配列キーは上記「説明文」に合わせて下さい。
$itemDispPositionList[] = InformationStatus::DISPLAY_POSITION_ITEM_LIST;

/**********************/
/*  商品タイトル取得  */
/**********************/
// 初期化
$infoDispPositionExpList = "";
$convertArray = "";
$convertInfoHtmlKey = "";
$informationDataForConvertList = "";
$itemExpList = "";

// コンバート対象情報HTML(商品タイトル、商品リスト共通)
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;

// 情報データログリスト取得(既読/未読チェック用)
$informationStatusLogList = "";
$informationStatusLogList = $infoStatusLogOBJ->getInformationStatusLogListForAccessed($comUserData["user_id"]);

// 商品タイトル情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionExpList = $infoDispPositionOBJ->getInformationDisplayPositionList($itemDispPositionExpList, "pc_sort_seq DESC");

foreach ($infoDispPositionExpList as $expKey => $expVal) {
    // 初期化
    $infoItemExpList = "";
    // 説明文取得
    if ($infoItemExpList = $infoStatusOBJ->getInformationStatusList($expVal["information_category_id"], $comUserData)) {
        foreach ($infoItemExpList as $itemExpVal) {
            // 情報データコンバート用変換キーの取得
            $convertArray[$itemExpVal["id"]] = $infoStatusOBJ->makeInformationConvertKey($itemExpVal, $informationStatusLogList);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $informationDataForConvertList[$itemExpVal["id"]] = $infoStatusOBJ->getInformationDataForConvert($itemExpVal, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $itemExpList[$expKey][$itemExpVal["id"]] = $itemExpVal;
        }
    }
}

// 情報HTMLのコンバート⇒表示データに格納
if ($informationDataForConvertList) {
    // コンバート
    $informationConvertList = "";
    $informationConvertList = $infoStatusOBJ->informationListKeyConvert($informationDataForConvertList, $comUserData["user_id"], $convertArray);

    // 変換したデータを表示用リストデータにセット
    foreach ($itemExpList as $itemExpKey => $itemExpVal) {
        foreach ($itemExpVal as $itemKey => $itemVal) {
            $itemExpList[$itemExpKey][$itemKey][$convertInfoHtmlKey] = $informationConvertList[$itemKey];
        }
    }
}

/**************/
/*  商品取得  */
/**************/
// 初期化
$infoDispPositionList = "";
$convertArray = "";
$informationDataForConvertList = "";
$itemList = "";

// 商品情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($itemDispPositionList, "pc_sort_seq DESC");

foreach ($infoDispPositionList as $itemKey => $itemVal) {
    // 初期化
    $infoItemList = "";
    // 商品リスト取得(説明文と合った商品リストをそれぞれ取得)
    if ($infoItemList = $infoStatusOBJ->getInformationStatusList($itemVal["information_category_id"], $comUserData)) {
        foreach ($infoItemList as $itemListVal) {
            // 情報データコンバート用変換キーの取得
            $convertArray[$itemListVal["id"]] = $infoStatusOBJ->makeInformationConvertKey($itemListVal, $informationStatusLogList);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $informationDataForConvertList[$itemListVal["id"]] = $infoStatusOBJ->getInformationDataForConvert($itemListVal, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $itemList[$itemKey][$itemListVal["id"]] = $itemListVal;
        }
    }
}

// 情報HTMLのコンバート⇒表示データに格納
if ($informationDataForConvertList) {
    // コンバート
    $informationConvertList = "";
    $informationConvertList = $infoStatusOBJ->informationListKeyConvert($informationDataForConvertList, $comUserData["user_id"], $convertArray);

    // 変換したデータを表示用リストデータにセット
    if ($informationConvertList) {
        foreach ($itemList as $itemListKey => $itemListVal) {
            foreach ($itemListVal as $itemKey => $itemVal) {
                $itemList[$itemListKey][$itemKey][$convertInfoHtmlKey] = $informationConvertList[$itemKey];
            }
        }
    }
}

// 説明文も商品リストも無ければエラーメッセージ生成
if (!$itemExpList && !$itemList) {
    $noItemList = "現在、商品ﾘｽﾄはありません｡";
    $smartyOBJ->assign("noItemList", $noItemList);
}

$smartyOBJ->assign("itemDispPosition", $infoDispPositionExpList);
$smartyOBJ->assign("itemExpList", $itemExpList);
$smartyOBJ->assign("itemList", $itemList);

?>
