<?php
require_once($controllerOBJ->getIncludeBusinessLogic("preHeader"));
require_once($controllerOBJ->getIncludeBusinessLogic("preHeaderMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("preSide"));
require_once($controllerOBJ->getIncludeBusinessLogic("preFooter"));
require_once($controllerOBJ->getIncludeBusinessLogic("preHeadCampaign"));
require_once($controllerOBJ->getIncludeBusinessLogic("parts"));

// コピーライト作成
$smartyOBJ->assign("copyright", date("Y") . " オフィシャル情報競馬サイト -" . $_config["define"]["SITE_NAME"] . "-");

$smartyOBJ->assign("siteName", "オフィシャル情報競馬サイト -" . $_config["define"]["SITE_NAME"] . "-");
$smartyOBJ->assign("preHeader", $controllerOBJ->getIncludeDispPage("preHeader"));
$smartyOBJ->assign("preHeaderMenu", $controllerOBJ->getIncludeDispPage("preHeaderMenu"));
$smartyOBJ->assign("preSide", $controllerOBJ->getIncludeDispPage("preSide"));
$smartyOBJ->assign("preFooter", $controllerOBJ->getIncludeDispPage("preFooter"));
$smartyOBJ->assign("blankFooter", $controllerOBJ->getIncludeDispPage("blankFooter"));
$smartyOBJ->assign("preHeadCampaign", $controllerOBJ->getIncludeDispPage("preHeadCampaign"));
$smartyOBJ->assign("preHeaderAllDisplay", $controllerOBJ->getIncludeDispPage("preHeaderAllDisplay"));

$smartyOBJ->assign("loginForm", $controllerOBJ->getIncludeDispPage("login"));
$smartyOBJ->assign("registForm", $controllerOBJ->getIncludeDispPage("registForm"));
?>