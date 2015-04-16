<?php
/**
 * admTmpAdminAccesList.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/** 
 * 管理者アクセスログページ処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$admTmpAdminAccessOBJ = AdmTmpAdminAccess::getInstance();
$admAdminOBJ = AdmAdmin::getInstance();
$adminList = $admAdminOBJ->getList();

 $dspAdminList[0] = "管理者ALL" ;
foreach($adminList as $val){
    $dspAdminList[$val["id"]] = $val["name"] ;
}
$smartyOBJ->assign("dspAdminList", $dspAdminList);

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
// 入力項目の取得
if ($returnSessOBJ->return) {
    $param = $returnSessOBJ->return;
}
// メッセージの取得
$execMessage = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();
$returnSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $execMessage);

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

$dataList = $admTmpAdminAccessOBJ->getList($param, $offset, "create_datetime DESC", $dispCnt);
$totalCount = $admTmpAdminAccessOBJ->getFoundRows();

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
            "admin_id",
            );

$reloadTags = array(
            "disp_date_from",
            "disp_date_to",
            "disp_time_from",
            "disp_time_to",
            "admin_id",
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
$pagerArray["action_name"] = "adminUser_AdminUserAccessLog=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

?>

