<?php
/**
 * regularSupportMailList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期サポートメールリストページ処理ファイル。
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

$dataList = $AdmSupportMailOBJ->getSupportMailRegularList($param, $offset, "id DESC", $dispCnt);
$totalCount = $AdmSupportMailOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($dataList);

for ($i = 0; $i < count($dataList); $i++) {
    // 配信条件の作成
    if ($dataList[$i]["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_HOUR) {
        $dataList[$i]["send_condition"] = AdmSupportMail::$_sendConditionType[$dataList[$i]["send_condition_type"]] . $dataList[$i]["hour_from"] . "時から" . $dataList[$i]["hour_to"] . "時までの" . AdmSupportMail::$_intervalSecond[$dataList[$i]["second"]] . "分に送信する";
    } else if ($dataList[$i]["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_DAY) {
        $dataList[$i]["send_condition"] = AdmSupportMail::$_sendConditionType[$dataList[$i]["send_condition_type"]] . " " . date("H:i", strtotime($dataList[$i]["send_time"])) . "に送信する";
    } else if ($dataList[$i]["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_WEEK) {
        $dataList[$i]["send_condition"] = AdmSupportMail::$_sendConditionType[$dataList[$i]["send_condition_type"]] . $_config["admin_config"]["week_array"][$dataList[$i]["week"]] . "の" . date("H:i", strtotime($dataList[$i]["send_time"])) . "に送信する";
    } else if ($dataList[$i]["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_MONTH) {
        $dataList[$i]["send_condition"] = AdmSupportMail::$_sendConditionType[$dataList[$i]["send_condition_type"]] . $dataList[$i]["send_day"] . "日の" . date("H:i", strtotime($dataList[$i]["send_time"])) . "に送信する";
    }
}

$smartyOBJ->assign("dataList", $dataList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$reloadTags = array(
            "offset",
            );

$POSTParam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("POSTParam", $POSTParam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "mailLog_RegularMailList=1";

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));
$smartyOBJ->assign("stopFlag", AdmSupportMail::$_stopFlag);

?>

