<?php
/**
 * headCampaign.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後ヘッダーキャンペーン画像表示処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

$infoStatusOBJ = InformationStatus::getInstance();
$infoStatusLogOBJ = InformationStatusLog::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

$dispPositionId = array();
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_POST_TOP_CAMP;
if($actionKey == "action_Home"){
    //HOMEのみ表示
    $dispPositionId[] = InformationStatus::DISPLAY_POSITION_HOME_TOP_CAMP;
}

// 情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = array();
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($dispPositionId, "pc_sort_seq DESC");

// 初期化
$convertArray = "";
$convertInfoHtmlKey = "";
$informationDataForConvertList = "";
$postTopInfoStatusCampList = "";

// コンバート対象情報HTML
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;

// 情報データログリスト取得(既読/未読チェック用)
$informationStatusLogList = "";
$informationStatusLogList = $infoStatusLogOBJ->getInformationStatusLogListForAccessed($comUserData["user_id"]);

$userBankData = $UserOBJ->getBankDetailData($comUserData["user_id"]) ;
$userAddressData = $UserOBJ->getAddressDetailData($comUserData["user_id"]) ;

//フリーワード関連
$freeWordOBJ = new FreeWord();
$userFreeWordData = $freeWordOBJ->getFreeWordData($comUserData["user_id"]) ;
$freeWordSetDataList = $freeWordOBJ->getFreeWordSetDataList() ;
$freeWordSetDisplayData = $freeWordOBJ->getFreeWordSetDisplayData($freeWordSetDataList) ;

if($freeWordSetDisplayData) {
    foreach($freeWordSetDisplayData as $key => $val){
        $smartyOBJ->assign("freeWord_2_".$key, $val);
    }
}

// トップキャンペーンの情報リストを取得(DISPLAY_POSITION_POST_TOP_CAMP = 4)
foreach ($infoDispPositionList as $positionData) {
    $infoStatusList = "";
    if ($infoStatusList = $infoStatusOBJ->getInformationStatusList($positionData["information_category_id"], $comUserData)) {
        foreach ($infoStatusList as $key => $val) {
            // 情報データコンバート用変換キーの取得
            $val["user_bank_data"] = $userBankData ;
            $val["user_address_data"] =$userAddressData ;
            $val["user_free_word_data"] =$userFreeWordData ;
            $convertArray[$val["id"]] = $infoStatusOBJ->makeInformationConvertKey($val, $informationStatusLogList);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $informationDataForConvertList[$val["id"]] = $infoStatusOBJ->getInformationDataForConvert($val, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $postTopInfoStatusCampList[$val["id"]] = $val;
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
            $postTopInfoStatusCampList[$relationKey][$convertInfoHtmlKey] = $convertVal;
        }
    }
}

$smartyOBJ->assign("postTopInfoStatusCampList", $postTopInfoStatusCampList);

?>
