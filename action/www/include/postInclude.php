<?php
require_once($controllerOBJ->getIncludeBusinessLogic("headerMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("status"));
require_once($controllerOBJ->getIncludeBusinessLogic("side"));
require_once($controllerOBJ->getIncludeBusinessLogic("footer"));
require_once($controllerOBJ->getIncludeBusinessLogic("headCampaign"));
require_once($controllerOBJ->getIncludeBusinessLogic("order"));
require_once($controllerOBJ->getIncludeBusinessLogic("cart"));
require_once($controllerOBJ->getIncludeBusinessLogic("parts"));

// コピーライト作成
$smartyOBJ->assign("copyright", date("Y") . " オフィシャル情報競馬サイト -" . $_config["define"]["SITE_NAME"] . "-");

$smartyOBJ->assign("siteName", "オフィシャル情報競馬サイト -" . $_config["define"]["SITE_NAME"] . "-");
$smartyOBJ->assign("header", $controllerOBJ->getIncludeDispPage("header"));
$smartyOBJ->assign("headerMenu", $controllerOBJ->getIncludeDispPage("headerMenu"));
$smartyOBJ->assign("headerAllDisplay", $controllerOBJ->getIncludeDispPage("headerAllDisplay"));
$smartyOBJ->assign("side", $controllerOBJ->getIncludeDispPage("side"));
$smartyOBJ->assign("footer", $controllerOBJ->getIncludeDispPage("footer"));
$smartyOBJ->assign("blankFooter", $controllerOBJ->getIncludeDispPage("blankFooter"));
$smartyOBJ->assign("headCampaign", $controllerOBJ->getIncludeDispPage("headCampaign"));

$smartyOBJ->assign("status", $controllerOBJ->getIncludeDispPage("status"));
$smartyOBJ->assign("settleMenu", $controllerOBJ->getIncludeDispPage("settleMenu"));
$smartyOBJ->assign("order", $controllerOBJ->getIncludeDispPage("order"));
$smartyOBJ->assign("cart", $controllerOBJ->getIncludeDispPage("cart"));
$smartyOBJ->assign("remoteAddr", $_SERVER["REMOTE_ADDR"]);

?>