<?php

$smartyOBJ->assign("siteName", $_config["define"]["SITE_NAME"]);
$smartyOBJ->assign("admBaitaiAgencyHeader", $controllerOBJ->getIncludeDispPage("admBaitaiAgencyHeader"));
$smartyOBJ->assign("admBaitaiAgencyFooter", $controllerOBJ->getIncludeDispPage("admBaitaiAgencyFooter"));

?>