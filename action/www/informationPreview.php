<?php
/**
 * informationPreview.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC 情報プレビューファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/user_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
$smartyOBJ->assign("param", $param);

$infoStatusOBJ = InformationStatus::getInstance();

// 情報取得
$infoStatusData = $infoStatusOBJ->getInformationStatusPreviewData($param);

// プレビューの切り替え
if ($param["banner_pc"]) {
    $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_PC;
}
if ($param["text_pc"]) {
    $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_PC;
}

// コンバート処理
$convertAry["-%link_name-"] = "<span style=\"color:#F00;\">【未読】</span>";
$infoStatusData = $infoStatusOBJ->informationKeyConvert($infoStatusData, "", $isURIMobile, $convertInfoHtmlKey, $isPreAccess = TRUE, $convertAry);
$smartyOBJ->assign("isAllDisplay", $infoStatusData["is_all_display"]);

$displayInfoStatusData = $infoStatusData[$convertInfoHtmlKey];
$smartyOBJ->assign("displayInfoStatusData", htmlspecialchars_decode($displayInfoStatusData, ENT_QUOTES));

$smartyOBJ->assign("sexCd", $_config["web_config"]["sex_cd"]);
$smartyOBJ->assign("bloodType", $_config["web_config"]["blood_type"]);
$smartyOBJ->assign("month", $_config["web_config"]["month"]);
$smartyOBJ->assign("day", $_config["web_config"]["day"]);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>