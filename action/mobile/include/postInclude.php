<?php
require_once($controllerOBJ->getIncludeBusinessLogic("footerMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("contentsMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("pr"));
require_once($controllerOBJ->getIncludeBusinessLogic("quitPr"));
require_once($controllerOBJ->getIncludeBusinessLogic("status"));
require_once($controllerOBJ->getIncludeBusinessLogic("parts"));
require_once($controllerOBJ->getIncludeBusinessLogic("quitPrStart"));

// dioタグ設置
$trackingTag = $controllerOBJ->getTrackingTag("dio");
$smartyOBJ->assign("trackingTag", $trackingTag);

$smartyOBJ->assign("siteName", $_config["define"]["SITE_NAME"]);
$smartyOBJ->assign("header", $controllerOBJ->getIncludeDispPage("header"));
$smartyOBJ->assign("copylight", $controllerOBJ->getIncludeDispPage("copylight"));
$smartyOBJ->assign("footer", $controllerOBJ->getIncludeDispPage("footer"));
$smartyOBJ->assign("footerMenu", $controllerOBJ->getIncludeDispPage("footerMenu"));
$smartyOBJ->assign("contentsMenu", $controllerOBJ->getIncludeDispPage("contentsMenu"));
$smartyOBJ->assign("status", $controllerOBJ->getIncludeDispPage("status"));
$smartyOBJ->assign("pr", $controllerOBJ->getIncludeDispPage("pr"));
$smartyOBJ->assign("settleMenu", $controllerOBJ->getIncludeDispPage("settleMenu"));
$smartyOBJ->assign("quitPr", $controllerOBJ->getIncludeDispPage("quitPr"));
$smartyOBJ->assign("quitPrStart", $controllerOBJ->getIncludeDispPage("quitPrStart"));
$smartyOBJ->assign("remoteAddr", $_SERVER["REMOTE_ADDR"]);

?>