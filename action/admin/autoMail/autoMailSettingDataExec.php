<?php
/**
 * autoMailSettingDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面リメール文言更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
$fromName = $requestOBJ->getParameter("from_name", "off_html");
$pcSubject = $requestOBJ->getParameter("pc_subject", "off_html");
$mbSubject = $requestOBJ->getParameter("mb_subject", "off_html");
$pcTextBody = $requestOBJ->getParameter("pc_text_body", "off_html");
$mbTextBody = $requestOBJ->getParameter("mb_text_body", "off_html");
$pcHtmlBody = $requestOBJ->getParameter("pc_html_body", "off_html");
$mbHtmlBody = $requestOBJ->getParameter("mb_html_body", "off_html");

$tags = array(
            "auto_mail_contents_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$AdmAutoMailOBJ = AdmAutoMail::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if (!$param["from_address"]) {
    $errMsg[] = "送信アドレスを入力してください";
}

// 戻り値の格納
$returnSessOBJ->return = $param;

if ($errMsg) {
    $execMsgSessOBJ->message = $errMsg;
    header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
    exit;
}

// リメール文言内容の追加
$mailLog["from_address"] = $param["from_address"];
$mailLog["from_name"] = $param["from_name"];
$mailLog["pc_subject"] = $param["pc_subject"];
$mailLog["pc_text_body"] = $param["pc_text_body"];
$mailLog["pc_html_body"] = $param["pc_html_body"];
$mailLog["mb_subject"] = $param["mb_subject"];
$mailLog["mb_text_body"] = $param["mb_text_body"];
$mailLog["mb_html_body"] = $param["mb_html_body"];
$mailLog["return_path"] = AdmAutoMail::REMAIL_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];
$mailLog["update_datetime"] = date("YmdHis");

$AdmAutoMailOBJ->beginTransaction();

$value["is_use"] = $param["is_use"];

if (!$AdmAutoMailOBJ->updateAutoMailContentsData($value , array("id = " . $param["auto_mail_contents_id"]))) {
    $messageSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
    $AdmAutoMailOBJ->rollbackTransaction();
    header("Location: ./?action_autoMail_AutoMailSettingData=1");
    exit();
}

// リメールエレメントIDがあれば更新
if ($param["auto_mail_elements_id"]) {
    if (!$AdmAutoMailOBJ->updateAutoMailElementData($mailLog, array("id = " . $param["auto_mail_elements_id"]))) {
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }

    // PC画像更新処理
    if (!$AdmAutoMailOBJ->updateAutoMailImage($param["auto_mail_elements_id"], "pc_image", false, $param)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }

    // MB画像更新処理
    if (!$AdmAutoMailOBJ->updateAutoMailImage($param["auto_mail_elements_id"], "mb_image", true, $param)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }

} else {
    $mailLog["auto_mail_contents_id"] = $param["auto_mail_contents_id"];
    $mailLog["create_datetime"] = date("YmdHis");
    if (!$AdmAutoMailOBJ->insertAutoMailElementData($mailLog)) {
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }
    $autoMailElementsId = $AdmAutoMailOBJ->getInsertId();

    // PC画像登録処理
    if (!$AdmAutoMailOBJ->insertAutoMailImage($autoMailElementsId, "pc_image", false)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }

    // MB画像登録処理
    if (!$AdmAutoMailOBJ->insertAutoMailImage($autoMailElementsId, "mb_image", true)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
        exit;
    }
}

$AdmAutoMailOBJ->commitTransaction();

$execMsgSessOBJ->message = array("設定しました。");

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_autoMail_AutoMailSettingData=1&" . $URLparam);
exit;
?>

