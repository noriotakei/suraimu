<?php
/**
 * reserveSupportMailList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面予約サポートメールリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
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


$dataList = $AdmSupportMailOBJ->getSupportMailReserveList($param, $offset, "send_datetime DESC", $dispCnt);
$totalCount = $AdmSupportMailOBJ->getFoundRows();
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
$pagerArray["action_name"] = "mailLog_ReserveMailList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));


?>

