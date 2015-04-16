<?php
/**
 * preInformation.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン前 情報ージ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/pre_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$infoStatusOBJ = InformationStatus::getInstance();

if ($param["isid"]) {
    //情報の取得
    if ($preInfoStatusData = $infoStatusOBJ->getInformationStatusData(array("isid" => $param["isid"]), "", $isPreAccess = TRUE)) {
        // コンバート処理
        $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_MB;
        $preInfoStatusData = $infoStatusOBJ->informationKeyConvert($preInfoStatusData, "", $isURIMobile, $convertInfoHtmlKey, $isPreAccess = TRUE, $mailToConvertArray);
    } else {
        // 情報無ければログイン前TOPへ
        header("Location:./?" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
} else {
    // 情報IDが無くてもTOPページへ
    header("Location:./?action_Index=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$smartyOBJ->assign("preInfoStatusData", $preInfoStatusData);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>