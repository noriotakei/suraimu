<?php
/**
 * side.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後サイドメニュー処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

$infoStatusOBJ = InformationStatus::getInstance();
$infoStatusLogOBJ = InformationStatusLog::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

// サイド表示情報リストを取得(DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION = 13)
$dispPositionId = array();
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_PC_POST_SIDE_INFORMATION;

// 情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = array();
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($dispPositionId, "pc_sort_seq DESC");

// 初期化
$convertArray = "";
$convertInfoHtmlKey = "";
$informationDataForConvertList = "";
$postSideInfoStatusList = "";

// コンバート対象情報HTML
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;

// 情報データログリスト取得(既読/未読チェック用)
$informationStatusLogList = "";
$informationStatusLogList = $infoStatusLogOBJ->getInformationStatusLogListForAccessed($comUserData["user_id"]);

foreach ($infoDispPositionList as $positionData) {
    $infoStatusList = "";
    if ($infoStatusList = $infoStatusOBJ->getInformationStatusList($positionData["information_category_id"], $comUserData, $isPreAccess = FALSE)) {
        foreach ($infoStatusList as $key => $val) {
            // 情報データコンバート用変換キーの取得
            $convertArray[$val["id"]] = $infoStatusOBJ->makeInformationConvertKey($val, $informationStatusLogList);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $informationDataForConvertList[$val["id"]] = $infoStatusOBJ->getInformationDataForConvert($val, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $postSideInfoStatusList[$val["id"]] = $val;
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
        foreach ($informationConvertList as $relationKey => $convertVal) {
            // 変換したデータを情報に格納
            $postSideInfoStatusList[$relationKey][$convertInfoHtmlKey] = $convertVal;
        }
    }
}

$smartyOBJ->assign("postSideInfoStatusList", $postSideInfoStatusList);

// qrコード
$qrUrl =  urlencode($_config["define"]["SITE_URL_MOBILE"] . "?action_update=1&" . Auth::ACCESS_KEY_NAME . "=" . $comUserData["access_key"]);
$smartyOBJ->assign("qrUrl", $qrUrl);
?>
