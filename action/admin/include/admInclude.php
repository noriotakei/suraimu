<?php

$smartyOBJ->assign("siteName", $_config["define"]["SITE_NAME"]);
$smartyOBJ->assign("admHeader", $controllerOBJ->getIncludeDispPage("admHeader"));
$smartyOBJ->assign("admFooter", $controllerOBJ->getIncludeDispPage("admFooter"));
$smartyOBJ->assign("admBaitaiHeader", $controllerOBJ->getIncludeDispPage("admBaitaiHeader"));

?>