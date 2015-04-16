<?php
/*
*       管理画面 情報表示確認
*       informationPreview.php
*
*/

require_once(D_BASE_DIR . "/common/user_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$infoStatusOBJ = InformationStatus::getInstance();

// 情報取得
$infoStatusData = $infoStatusOBJ->getInformationStatusPreviewData($param);

// プレビューの切り替え
if ($param["banner_mb"]) {
    $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_BANNER_MB;
}
if ($param["text_mb"]) {
    $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_MB;
}

// コンバート処理
$infoStatusData = $infoStatusOBJ->informationKeyConvert($infoStatusData, "", $isURIMobile, $convertInfoHtmlKey, $isPreAccess = TRUE);

$smartyOBJ->assign("param", $param);

$displayInfoStatusData = $infoStatusData[$convertInfoHtmlKey];
$smartyOBJ->assign("displayInfoStatusData", htmlspecialchars_decode($displayInfoStatusData, ENT_QUOTES));

$smartyOBJ->assign("sexCd", $_config["web_config"]["sex_cd"]);
$smartyOBJ->assign("bloodType", $_config["web_config"]["blood_type"]);
$smartyOBJ->assign("month", $_config["web_config"]["month"]);
$smartyOBJ->assign("day", $_config["web_config"]["day"]);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>