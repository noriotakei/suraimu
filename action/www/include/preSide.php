<?php
/**
 * preSide.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン前サイドメニュー処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

$infoStatusOBJ = InformationStatus::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

// サイド表示情報リストを取得(DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION = 12)
$dispPositionId = array();
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION;

// 情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = array();
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($dispPositionId, "pc_sort_seq DESC");

// 初期化
$preSideInfoStatusList = "";
$convertArray = "";
$convertInfoHtmlKey = "";
$preInformationDataForConvertList = "";

// コンバート対象情報HTML
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;

foreach ($infoDispPositionList as $positionData) {
    $infoStatusList = "";
    if ($infoStatusList = $infoStatusOBJ->getInformationStatusList($positionData["information_category_id"], $comUserData, $isPreAccess = TRUE)) {
        foreach ($infoStatusList as $key => $val) {
            // 情報データコンバート用変換キーの取得
            $convertArray[$val["id"]] = $infoStatusOBJ->makeInformationConvertKey($val);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $preInformationDataForConvertList[$val["id"]] = $infoStatusOBJ->getInformationDataForConvert($val, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $preSideInfoStatusList[$val["id"]] = $val;
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
            $preSideInfoStatusList[$relationKey][$convertInfoHtmlKey] = $convertVal;
        }
    }
}

$smartyOBJ->assign("preSideInfoStatusList", $preSideInfoStatusList);

?>
