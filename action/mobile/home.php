<?php
/**
 * home.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後トップページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");

// 予約注文表示設定取得
$OrderingOBJ = Ordering::getInstance();
$orderingDisplaySettingData = $OrderingOBJ->getOrderingDisplaySettingData(Ordering::ORDERING_DISPLAY_CD_MB_HOME);
$dispLastOrderingFlag = $orderingDisplaySettingData["is_display"];

require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$infoStatusOBJ = InformationStatus::getInstance();
$infoStatusLogOBJ = InformationStatusLog::getInstance();
$infoDispPositionOBJ = InformationDisplayPosition::getInstance();

// ログイン後TOPに表示する情報表示場所IDの設定
$dispPositionId = array();
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_POST_TOP_CAMP;
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_HOME_TOP_CAMP;
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_TOP;
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_MB_HOME_MIDDLE_CAMP;
$dispPositionId[] = InformationStatus::DISPLAY_CD_QUIT_WEEKLY_RACE;
$dispPositionId[] = InformationStatus::DISPLAY_POSITION_MB_HOME_INFORMATION_OPEN;

// 情報リスト取得(結果セット：情報表示フォルダリスト(降順))
$infoDispPositionList = array();
$infoDispPositionList = $infoDispPositionOBJ->getInformationDisplayPositionList($dispPositionId, "mb_sort_seq DESC");

// 初期化
$convertArray = "";
$convertInfoHtmlKey = "";
$informationDataForConvertList = "";
$dispInformationList = "";

// コンバート対象情報HTML
$convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_MB;

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

// 情報表示IDごとに情報データの取得
foreach ($infoDispPositionList as $positionData) {
    $informationList = "";
    if ($informationList = $infoStatusOBJ->getInformationStatusList($positionData["information_category_id"], $comUserData)) {
        foreach ($informationList as $key => $val) {
            // 情報データコンバート用変換キーの取得
            $val["user_bank_data"] = $userBankData ;
            $val["user_address_data"] =$userAddressData ;
            $val["user_free_word_data"] =$userFreeWordData ;
            $val["display_position_cd"] =$positionData["cd"] ;

            $convertArray[$val["id"]] = $infoStatusOBJ->makeInformationConvertKey($val, $informationStatusLogList);

            // コンバート対象データを生成(情報HTML文だけ※バナーor詳細本文)
            $informationDataForConvertList[$val["id"]] = $infoStatusOBJ->getInformationDataForConvert($val, $isURIMobile, $convertInfoHtmlKey);

            // 情報データ
            $dispInformationList[$val["id"]] = $val;
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
            $dispInformationList[$relationKey][$convertInfoHtmlKey] = $convertVal;
        }
    }
}

//ログイン後トップのアクセスを取る 一回のみ
if($comUserData["home_access_datetime"]  == "0000-00-00 00:00:00"){
    $comUpdateHomeAccessData["home_access_datetime"] = date("YmdHis");

    if (!$UserOBJ->updateUserData($comUpdateHomeAccessData, array("id=" . $comUserData["user_id"]))) {
        $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
        exit();
    }

}

$smartyOBJ->assign("sexCd", $_config["web_config"]["sex_cd"]);
$smartyOBJ->assign("bloodType", $_config["web_config"]["blood_type"]);
$smartyOBJ->assign("month", $_config["web_config"]["month"]);
$smartyOBJ->assign("day", $_config["web_config"]["day"]);

if($dispInformationList){
    foreach($dispInformationList as $val){
        if ($val["display_position_cd"] == InformationStatus::DISPLAY_POSITION_MB_HOME_MIDDLE_CAMP) {
            $dispInformationListMiddle[$val["id"] ] = $val;
        } elseif ($val["display_position_cd"] == InformationStatus::DISPLAY_CD_QUIT_WEEKLY_RACE) {
            $dispInformationListQuitWeeklyRace[$val["id"] ] = $val;
        } elseif ($val["display_position_cd"] == InformationStatus::DISPLAY_POSITION_MB_HOME_INFORMATION_OPEN) {
            $dispInformationListHomeInformationOpen[$val["id"] ] = $val;
        } else{
           $dispInformationListTop[$val["id"] ] = $val;
        }
    }
}
/*
$test = $dispInformationListTop[17175]  ;
$dispInformationListTop =array() ;
$dispInformationListTop[17175] = $test;
*/
$smartyOBJ->assign("dispInformationList", $dispInformationListTop);
$smartyOBJ->assign("dispInformationListMiddle", $dispInformationListMiddle);
$smartyOBJ->assign("dispInformationListQuitWeeklyRace", $dispInformationListQuitWeeklyRace);
$smartyOBJ->assign("dispInformationListHomeInformationOpen", $dispInformationListHomeInformationOpen);

?>
