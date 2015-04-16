<?php
/**
 * supportMailSendExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール送信ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit", "-1");
$param = $requestOBJ->getParameterExcept($exceptArray);
$fromName = $requestOBJ->getParameter("from_name", "off_html");
$pcSubject = $requestOBJ->getParameter("pc_subject", "off_html");
$pcTextBody = $requestOBJ->getParameter("pc_text_body", "off_html");
$mbSubject = $requestOBJ->getParameter("mb_subject", "off_html");
$mbTextBody = $requestOBJ->getParameter("mb_text_body", "off_html");

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$ComSendMagicDeliveryOBJ = ComSendMagicDelivery::getInstance();

$tags = array(
            "ordering_id",
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);
$userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);
if (!$orderingData) {
    $errorMsg[] = "注文が取得できません";
    $execMsgSessOBJ->exec_msg = $errorMsg;
    header("location: ./?action_ordering_OrderingSearchList=1&" . $URLparam);
    exit;
}

$sendData = null;

$param["pc_to_address"] = $userData["pc_address"];
$param["mb_to_address"] = $userData["mb_address"];

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("from_address", "送信元アドレス",
                array("MailAddress" => null),
                array("MailAddress" => "送信元アドレスが正しくありません"));

$validationOBJ->check("from_name", "送信者名",
                array("FromName" => null),
                array("FromName" => "送信者名が正しくありません"));

if ($param["pc_to_address"]) {
    $validationOBJ->check("pc_to_address", "PC送信先アドレス",
                    array("MailAddress" => null),
                    array("MailAddress" => "PC送信元アドレスが正しくありません"));

    $validationOBJ->check("pc_subject", "PC件名",
                    array("Value" => null),
                    array("Value" => "PC件名を入力してください"));

    $validationOBJ->check("pc_text_body", "PCTEXT本文",
                    array("Value" => null),
                    array("Value" => "PCTEXT本文を入力してください"));
}

if ($param["mb_to_address"]) {
    $validationOBJ->check("mb_to_address", "MB送信先アドレス",
                    array("MobileAddress" => null),
                    array("MobileAddress" => "MB送信元アドレスが正しくありません"));

        $validationOBJ->check("mb_subject", "MB件名",
                        array("Value" => null),
                        array("Value" => "MB件名を入力してください"));

        $validationOBJ->check("mb_text_body", "MBTEXT本文",
                        array("Value" => null),
                        array("Value" => "MBTEXT本文を入力してください"));
}

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

$sendData["from_address"] = $param["from_address"];
$sendData["from_name"] = $fromName;

// ユーザーステータスのチェック(下記の場合、送信しない)
// ﾌﾞﾗｯｸ、退会の場合
if ($userData["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]
    OR $userData["danger_status"] == $_config["define"]["DANGER_VALID"]) {
    $errorMsg[] = "ﾌﾞﾗｯｸか退会ユーザーです";
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

// 別途%変換用にセット
$setArray = $AdmOrderingOBJ->makeOrderConvertArray($orderingData);

if (!$param["pc_to_address"] AND !$param["mb_to_address"]) {
    $errorMsg[] = "メールアドレスを入力してください";
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

$sendData["return_path"] = AdmMailMagazine::MAIL_MAGAZINE_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];
$intervalKey = 0;
$second = 60 * (int)AdmSupportMail::$_intervalSecond[$intervalKey];  // インターバル指定
$insertData = null;

$supportMailSendLog["send_start_datetime"] = date("YmdHis");

// SMTPホスト設定(通常)
$ComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["sendMagic"]);

// SMTP接続開始
if(!$ComSendMagicDeliveryOBJ->openSmtpConnect()){
    $errorMsg[] = "送信できませんでした";
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

// PC送信
$pcSendMailData = "";
if ($param["pc_to_address"]) {
    $sendData["to_address"] = $param["pc_to_address"];
    $sendData["subject"] = $pcSubject;
    $sendData["text_body"] = $pcTextBody;
    $sendData = $AdmSupportMailOBJ->convertMailElements($sendData, $orderingData["user_id"], $setArray);
    $pcSendMailData = $AdmSupportMailOBJ->smtpMailTo($sendData, $second);

    if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($pcSendMailData)) {
        $errorMsg[] = "送信できませんでした";
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
        exit;
    }
    $insertData["pc_subject"] = $sendData["subject"];
    $insertData["pc_text_body"] = $sendData["text_body"];
    $sendCnt["sendPcCnt"] = 1;
}

// MB送信
$mbSendMailData = "";
if ($param["mb_to_address"]) {
    $sendData["to_address"] = $param["mb_to_address"];
    $sendData["subject"] = $mbSubject;
    $sendData["text_body"] = $mbTextBody;
    $sendData = $AdmSupportMailOBJ->convertMailElements($sendData, $orderingData["user_id"], $setArray);
    $mbSendMailData = $AdmSupportMailOBJ->smtpMailTo($sendData, $second);

    if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($mbSendMailData)) {
        $errorMsg[] = "送信できませんでした";
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
        exit;
    }
    $insertData["mb_subject"] = $sendData["subject"];
    $insertData["mb_text_body"] = $sendData["text_body"];
    $sendCnt["sendMbCnt"] = 1;
}

// SMTP切断
$ComSendMagicDeliveryOBJ->closeSmtpConnect();

$execMsgSessOBJ->exec_msg = array("送信しました。");

// サポートメールログの登録
$insertData["ordering_id"]     = $param["ordering_id"];
$insertData["from_address"]    = $sendData["from_address"];
$insertData["from_name"]       = $sendData["from_name"];
$insertData["pc_to_address"]   = $param["pc_to_address"];
$insertData["mb_to_address"]   = $param["mb_to_address"];
$insertData["create_datetime"] = date("YmdHis");

if (!$AdmSupportMailLogOBJ->insertSupportMailLogData($insertData)) {
    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

// サポートメール送信ログの追加
$supportMailSendLog["admin_id"] = $loginAdminData["id"];
$supportMailSendLog["interval_second"] = $intervalKey;
$supportMailSendLog["from_address"] = $sendData["from_address"];
$supportMailSendLog["from_name"] = $sendData["from_name"];
$supportMailSendLog["mail_reserve_type"] = AdmSupportMail::SUPPORTMAIL_TYPE_INVIDUAL;
$supportMailSendLog["pc_subject"] = $insertData["pc_subject"];
$supportMailSendLog["pc_text_body"] = $insertData["pc_text_body"];
$supportMailSendLog["mb_subject"] = $insertData["mb_subject"];
$supportMailSendLog["mb_text_body"] = $insertData["mb_text_body"];
$supportMailSendLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
$supportMailSendLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
$supportMailSendLog["return_path"] = $sendData["return_path"] ;
$supportMailSendLog["create_datetime"] = date("YmdHis");
$supportMailSendLog["update_datetime"] = date("YmdHis");
$supportMailSendLog["send_end_datetime"] = date("YmdHis");

// ログの書き込み
if (!$AdmSupportMailLogOBJ->insertSupportMailSendLog($supportMailSendLog)) {
    $execMsgSessOBJ->exec_msg[] = "サポートメール送信ログの登録に失敗しました。";
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_SupportMailInput=1&" . $URLparam);
    exit;
}

header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;

?>