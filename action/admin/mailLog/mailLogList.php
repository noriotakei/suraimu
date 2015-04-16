<?php
/**
 * mailLogList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガログリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// 入力日時の生成
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

// ソート条件
switch ($param["sort"]) {
    case "pc_access":
        $sortColumn = "access_count_pc DESC,";
        break;
    case "pc_access_percent":
        $sortColumn = "pc_access_percent DESC,";
        break;
    case "mb_access":
        $sortColumn = "access_count_mb DESC,";
        break;
    case "mb_access_percent":
        $sortColumn = "mb_access_percent DESC,";
        break;
    case "regular":
        $sortColumn = "mailmagazine_regular_id DESC,";
        break;
    case "reserve":
        $sortColumn = "mailmagazine_reserve_id DESC,";
        break;
}

$logDataList = $AdmMailMagazineOBJ->getMailLogList($param, $offset, $sortColumn . " id DESC", $dispCnt);
$totalCount = $AdmMailMagazineOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($logDataList);

$smartyOBJ->assign("logDataList", $logDataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "disp_date_from",
            "disp_date_to",
            "disp_time_from",
            "disp_time_to",
            "mail_reserve_type",
            "mailmagazine_regular_id",
            "mailmagazine_reserve_id",
            "sort",
            "mailmagazine_body",
            );

$sortTags = array(
            "disp_date_from",
            "disp_date_to",
            "disp_time_from",
            "disp_time_to",
            "mail_reserve_type",
            "mailmagazine_regular_id",
            "mailmagazine_reserve_id",
            "sort",
            "mailmagazine_body",
            );

$reloadTags = array(
            "disp_date_from",
            "disp_date_to",
            "disp_time_from",
            "disp_time_to",
            "mail_reserve_type",
            "mailmagazine_regular_id",
            "mailmagazine_reserve_id",
            "mailmagazine_body",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$sortURLparam = $requestOBJ->makeGetTag($sortTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("sortURLparam", $sortURLparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "mailLog_MailLogList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

$smartyOBJ->assign("mailReserveType", AdmMailMagazine::$_mailReserveType);
?>

