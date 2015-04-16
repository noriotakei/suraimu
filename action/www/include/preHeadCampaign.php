<?php
/**
 * preHeadCampaign.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前ヘッダーキャンペーン画像表示処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

$infoStatusOBJ = InformationStatus::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

$dispPositionId = array();
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_PC_PRE_TOP_CAMP;

// 情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = array();
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($dispPositionId, "pc_sort_seq DESC");

// 初期化
$convertArray = "";
$convertInfoHtmlKey = "";
$preInformationDataForConvertList = "";
$preTopInfoStatusCampList = "";

// コンバート対象情報HTML
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;

// トップキャンペーンの情報リストを取得(DISPLAY_POSITION_PC_PRE_TOP_CAMP = 14)
foreach ($infoDispPositionList as $positionData) {
    $infoStatusList = "";
    if ($infoStatusList = $infoStatusOBJ->getInformationStatusList($positionData["information_category_id"], $comUserData, $isPreAccess = TRUE)) {
        foreach ($infoStatusList as $key => $val) {
            // 情報データコンバート用変換キーの取得
            $convertArray[$val["id"]] = $infoStatusOBJ->makeInformationConvertKey($val);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $preInformationDataForConvertList[$val["id"]] = $infoStatusOBJ->getInformationDataForConvert($val, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $preTopInfoStatusCampList[$val["id"]] = $val;
        }
    }
}

// 情報HTMLのコンバート⇒表示データに格納
if ($preInformationDataForConvertList) {
    // コンバート
    $preInformationConvertList = "";
    $preInformationConvertList = $infoStatusOBJ->informationListKeyConvert($preInformationDataForConvertList, $comUserData["user_id"], $convertArray);

    // 変換したデータを表示用リストデータにセット
    if ($preInformationConvertList) {
        foreach ($preInformationConvertList as $relationKey => $convertVal) {
            // 変換したデータを情報に格納
            $preTopInfoStatusCampList[$relationKey][$convertInfoHtmlKey] = $convertVal;
        }
    }
}

$smartyOBJ->assign("preTopInfoStatusCampList", $preTopInfoStatusCampList);
?>
