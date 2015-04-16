<?php
/**
 * supportMailInput.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール作成処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$param = $requestOBJ->getParameterExcept($exceptArray);
// 送信されたデータを設定
$mailElements["from_address"]  = $param["from_address"];
$mailElements["from_name"]     = $param["from_name"];
$mailElements["pc_to_address"] = $param["pc_to_address"];
$mailElements["mb_to_address"] = $param["mb_to_address"];
$mailElements["subject"]       = $param["subject"];
$mailElements["text_body"]     = $param["text_body"];

$tags = array(
            "ordering_id",
            "sesKey",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmSupportMailOBJ = AdmSupportMail::getInstance();

// サポートメール定型文の取得
$supportMailList = $AdmSupportMailOBJ->getSupportMailListForSelect();
$smartyOBJ->assign("supportMailList", $supportMailList);

if ($param["support_mail_id"]){
    $supportMailData = $AdmSupportMailOBJ->getSupportMailData($param["support_mail_id"]);
    $mailElements["pc_subject"]       = $supportMailData["pc_subject"];
    $mailElements["pc_text_body"]     = $supportMailData["pc_text_body"];
    $mailElements["mb_subject"]       = $supportMailData["mb_subject"];
    $mailElements["mb_text_body"]     = $supportMailData["mb_text_body"];
}

$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);
$userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);

// 別途%変換用にセット
$setArray = $AdmOrderingOBJ->makeOrderConvertArray($orderingData);

$mailElements = $AdmSupportMailOBJ->convertMailElements($mailElements, $orderingData["user_id"], $setArray);

// エラーで戻った場合
if ($returnValue["return_flag"]) {
    $mailElements["from_address"]  = $returnValue["from_address"];
    $mailElements["from_name"]     = $returnValue["from_name"];
    $mailElements["pc_to_address"] = $returnValue["pc_to_address"];
    $mailElements["mb_to_address"] = $returnValue["mb_to_address"];
    $mailElements["pc_subject"]       = $returnValue["pc_subject"];
    $mailElements["pc_text_body"]     = $returnValue["pc_text_body"];
    $mailElements["mb_subject"]       = $returnValue["mb_subject"];
    $mailElements["mb_text_body"]     = $returnValue["mb_text_body"];
}

$smartyOBJ->assign("mailElements", $mailElements);
$smartyOBJ->assign("userData", $userData);

// 送信アドレス
$smartyOBJ->assign("sendAddress", AdmSupportMail::SUPPORT_MAIL_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"]);
?>

