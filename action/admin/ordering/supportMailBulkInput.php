<?php
/**
 * supportMailulkInput.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール一括送信作成処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$orderingSearchSessOBJ = new ComSessionNamespace("ordering_search");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 送信されたデータを設定
$mailElements["from_address"]  = $param["from_address"];
$mailElements["from_name"]     = $param["from_name"];
$mailElements["pc_to_address"] = $param["pc_to_address"];
$mailElements["mb_to_address"] = $param["mb_to_address"];
$mailElements["subject"]       = $param["subject"];
$mailElements["text_body"]     = $param["text_body"];

$tags = array(
            "sesKey",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmSupportMailOBJ = AdmSupportMail::getInstance();

// セッションにセットします
if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    $searchValue = $orderingSearchSessOBJ->$param["sesKey"];
} else {
    $execMsgSessOBJ->errMsg[] = "パラメータがありません";
    header("location: ./?action_ordering_OrderingSearchList=1&" . $URLparam);
    exit;
}

$AdmOrderingOBJ->setWhereString($searchValue);
$smartyOBJ->assign("whereContents", $AdmOrderingOBJ->getWhereContents());

// サポートメール定型文の取得
$supportMailList = $AdmSupportMailOBJ->getSupportMailListForSelect();
$smartyOBJ->assign("supportMailList", $supportMailList);

if ($param["support_mail_id"]){
    $supportMailData = $AdmSupportMailOBJ->getSupportMailData($param["support_mail_id"]);
    $mailElements["pc_subject"]       = $supportMailData["pc_subject"];
    $mailElements["pc_text_body"]     = $supportMailData["pc_text_body"];
    $mailElements["pc_html_body"]     = $supportMailData["pc_html_body"];
    $mailElements["mb_subject"]       = $supportMailData["mb_subject"];
    $mailElements["mb_text_body"]     = $supportMailData["mb_text_body"];
    $mailElements["mb_html_body"]     = $supportMailData["mb_html_body"];
    // エラーで戻った場合
} else if ($returnValue["return_flag"]) {
    $mailElements  = $returnValue;
}

$smartyOBJ->assign("mailElements", $mailElements);

// 日にち配列
for ($i = 1; $i < 31; $i++) {
    $dayAry[$i] = $i;
}
$dayAry["0"] = "月末";

$smartyOBJ->assign("dayAry", $dayAry);
$mailReserveType = AdmSupportMail::$_mailReserveType;
unset($mailReserveType[AdmSupportMail::SUPPORTMAIL_TYPE_INVIDUAL]);
$smartyOBJ->assign("mailReserveType", $mailReserveType);
$smartyOBJ->assign("intervalSecond", AdmSupportMail::$_intervalSecond);
$smartyOBJ->assign("sendConditionTypeHourSecond", AdmSupportMail::$_sendConditionTypeHourSecond);
$smartyOBJ->assign("sendConditionType", AdmSupportMail::$_sendConditionType);
// 送信アドレス
$smartyOBJ->assign("sendAddress", AdmSupportMail::SUPPORT_MAIL_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"]);
?>

