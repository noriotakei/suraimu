<?php
require_once($controllerOBJ->getIncludeBusinessLogic("preHeader"));
require_once($controllerOBJ->getIncludeBusinessLogic("preFooterMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("preContentsMenu"));
require_once($controllerOBJ->getIncludeBusinessLogic("easyLogin"));
require_once($controllerOBJ->getIncludeBusinessLogic("pr"));
require_once($controllerOBJ->getIncludeBusinessLogic("quitPr"));
require_once($controllerOBJ->getIncludeBusinessLogic("parts"));

// dioタグ設置
$trackingTag = $controllerOBJ->getTrackingTag("dio");
$smartyOBJ->assign("trackingTag", $trackingTag);

$smartyOBJ->assign("siteName", $_config["define"]["SITE_NAME"]);
$smartyOBJ->assign("preHeader", $controllerOBJ->getIncludeDispPage("preHeader"));
$smartyOBJ->assign("preCopylight", $controllerOBJ->getIncludeDispPage("preCopylight"));
$smartyOBJ->assign("preFooter", $controllerOBJ->getIncludeDispPage("preFooter"));
$smartyOBJ->assign("preRuleFooter", $controllerOBJ->getIncludeDispPage("preRuleFooter"));
$smartyOBJ->assign("preFooterMenu", $controllerOBJ->getIncludeDispPage("preFooterMenu"));
$smartyOBJ->assign("preContentsMenu", $controllerOBJ->getIncludeDispPage("preContentsMenu"));
$smartyOBJ->assign("easyLogin", $controllerOBJ->getIncludeDispPage("easyLogin"));
$smartyOBJ->assign("pr", $controllerOBJ->getIncludeDispPage("pr"));
$smartyOBJ->assign("quitPr", $controllerOBJ->getIncludeDispPage("quitPr"));
?>