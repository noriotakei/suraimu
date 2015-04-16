<?php
require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdminAutoOBJ = AdmAutoPointGrant::getInstance();

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if ($returnSessOBJ->return) {
    $param = $returnSessOBJ->return;
}

$execMessage = $execMsgSessOBJ->getIterator();

$execMsgSessOBJ->unsetAll();
$returnSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $execMessage);

$param["dispDatetimeFrom"] = $param["disp_date_from"]
. " " . $param["disp_time_from"];

if (!ComValidation::isDatetime($param["dispDatetimeFrom"])) {
    $param["dispDatetimeFrom"] = date("Y-m-d") . " 00:00:00";
}

$param["dispDatetimeTo"] = $param["disp_date_to"]
. " " . $param["disp_time_to"];

if (!ComValidation::isDatetime($param["dispDatetimeTo"])) {
    $param["dispDatetimeTo"] = date("Y-m-d") . " 23:59:59";
}

$smartyOBJ->assign("param", $param);
$dataList = $AdminAutoOBJ->getReservePointGrantData($param, $offset, "create_datetime DESC", $dispCnt);

$totalCount = $AdminAutoOBJ->getFoundRows();

$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
        "disp_date_from",
        "disp_date_to",
        "disp_time_from",
        "disp_time_to",
);

$reloadTags = array(
        "disp_date_from",
        "disp_date_to",
        "disp_time_from",
        "disp_time_to",
        "offset",
);

$URLparam = $requestOBJ->makeGetTag($tags);
$POSTParam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("POSTParam", $POSTParam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "mailLog_reservePointGrantList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));
?>