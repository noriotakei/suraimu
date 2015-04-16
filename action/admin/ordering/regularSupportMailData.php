<?php
/**
 * regularSupportMailData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期サポートメール表示ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$AdmOrderingOBJ = AdmOrdering::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$data = $AdmSupportMailOBJ->getSupportMailRegularData($param["support_mail_regular_id"]);

$AdmOrderingOBJ->setWhereString(unserialize($data["search_condition"]));
$data["where_contents"] = $AdmOrderingOBJ->getWhereContents();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnValue) {
    // リターンデータで上書き
    foreach($returnValue as $key => $val) {
        $data[$key] = $val;
    }
    if ($data["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_DAY) {
        $data["send_time"] = $returnValue["send_time_day"];
    } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_WEEK) {
        $data["send_time"] = $returnValue["send_time_week"];
    } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_MONTH) {
        $data["send_time"] = $returnValue["send_time_month"];
    }
}
$smartyOBJ->assign("data", $data);

$reloadTags = array(
            "support_mail_regular_id",
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// 日にち配列
for ($i = 1; $i < 31; $i++) {
    $dayAry[$i] = $i;
}
$dayAry["0"] = "月末";

$smartyOBJ->assign("dayAry", $dayAry);
$smartyOBJ->assign("sendConditionTypeHourSecond", AdmSupportMail::$_sendConditionTypeHourSecond);
$smartyOBJ->assign("sendConditionType", AdmSupportMail::$_sendConditionType);
$smartyOBJ->assign("stopFlag", AdmSupportMail::$_stopFlag);

?>

