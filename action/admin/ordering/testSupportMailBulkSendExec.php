<?php
/**
 * supportMailBulkSendExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール一括送信ページ処理ファイル。
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
$orderingSearchSessOBJ = new ComSessionNamespace("ordering_search");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$ComSendMagicDeliveryOBJ = ComSendMagicDelivery::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// セッションにセットします
if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    $searchValue = $orderingSearchSessOBJ->$param["sesKey"];
} else {
    $execMsgSessOBJ->errMsg[] = "パラメータがありません";
    $param["return_flag"] = true;
    header("location: ./?action_ordering_SupportMailBulkInput=1&" . $URLparam);
    exit;
}

$orderingList = $AdmOrderingOBJ->getOrderingList($searchValue);
$orderingCnt = $AdmOrderingOBJ->getFoundRows();

// SMTPホスト設定(通常)
$ComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["sendMagic"]);

// 一括サポートメール
if ($param["mail_reserve_type"] == AdmSupportMail::SUPPORTMAIL_TYPE_BULK) {

    if (!$orderingList) {
        $errorMsg[] = "注文が取得できません";
        header("location: ./?action_ordering_OrderingSearchList=1&" . $URLparam);
        exit;
    }

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("from_address", "送信元アドレス",
                    array("MailAddress" => null),
                    array("MailAddress" => "送信元アドレスが正しくありません"));

    $validationOBJ->check("from_name", "送信者名",
                    array("FromName" => null),
                    array("FromName" => "送信者名が正しくありません"));

    $validationOBJ->check("pc_text_body", "TEXT本文",
                    array("Value" => null),
                    array("Value" => "PCのTEXT本文を入力してください"));

    $validationOBJ->check("mb_text_body", "TEXT本文",
                    array("Value" => null),
                    array("Value" => "MBのTEXT本文を入力してください"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->errMsg = $errorMsg;
        $param["return_flag"] = true;
        header("location: ./?action_ordering_SupportMailBulkInput=1&" . $URLparam);
        exit;
    }

    $sendCnt["notSendPcCnt"] = 0;
    $sendCnt["sendPcCnt"] = 0;
    $sendCnt["notSendMbCnt"] = 0;
    $sendCnt["sendMbCnt"] = 0;
    $sendCnt["errCnt"] = 0;

    $supportMailSendLog = "";
    $supportMailSendLog["send_start_datetime"] = date("YmdHis");

    // SMTP接続開始
    if(!$ComSendMagicDeliveryOBJ->openSmtpConnect()){
        $execMsgSessOBJ->errMsg[] = "接続エラーが発生しました。";
        $param["return_flag"] = true;
        header("location: ./?action_ordering_SupportMailBulkInput=1&" . $URLparam);
        exit;
    }

    // 送信数
    $sendUserCount = 0;
    while (list($key, $val) = each($orderingList)) {

        // 送信数が1000件でSMTP切断→再接続
        if (($sendUserCount%1000) == 0) {
            if(!$ComSendMagicDeliveryOBJ->retryOpenSmtpConnect()){
                // 接続エラーならば、次のループ送信処理
                $sendCnt["errCnt"]++;
                // デバッグメール
                $debugMail = "";
                $debugMail["subject"] = "予約サポートメール一括接続エラー";
                $debugMail["text_body"][] = "file:" . __FILE__ ;
                $debugMail["text_body"][] = "line:" . __LINE__ ;
                $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($debugMail);
                continue;
            }
        }

        $orderingData = $AdmOrderingOBJ->getOrderingData($val["id"]);
        $userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);
        if (!($orderingData AND $userData)) {
            $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "に送信できませんでした。";
            $sendCnt["errCnt"]++;
            continue;
        }

        // ユーザーステータスのチェック(下記の場合、送信しない)
        // ﾌﾞﾗｯｸ、退会の場合
        if ($userData["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]
            OR $userData["danger_status"] == $_config["define"]["DANGER_VALID"]) {
            $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "はﾌﾞﾗｯｸか退会ユーザーです";
            $sendCnt["errCnt"]++;
            continue;
        }

        $sendData = null;

        $sendData["from_address"] = $param["from_address"];
        $sendData["from_name"] = $fromName;
        $sendData["pc_to_address"] = $userData["pc_address"];
        $sendData["mb_to_address"] = $userData["mb_address"];

        // 別途%変換用にセット
        $setArray = $AdmOrderingOBJ->makeOrderConvertArray($orderingData);

        if (!$sendData["pc_to_address"] AND !$sendData["mb_to_address"]) {
            $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "に送信できませんでした。";
            $sendCnt["errCnt"]++;
            continue;
        }

        $sendData["return_path"] = AdmSupportMail::SUPPORTMAIL_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];
        $second = 60 * (int)AdmSupportMail::$_intervalSecond[$param["interval_second"]];  // インターバル指定

        // サポートメールログの登録
        $insertData = null;

        // PC送信
        if (ComValidation::isMailAddress($sendData["pc_to_address"]) AND $userData["pc_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
            $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "のPCアドレスステータスが送信可能ではないので送信できませんでした。";
            $sendCnt["notSendPcCnt"]++;
        } else if (ComValidation::isMailAddress($sendData["pc_to_address"])) {
            $pcSendMailData = "";
            $sendData["to_address"] = $sendData["pc_to_address"];
            $sendData["subject"] = $pcSubject;
            $sendData["text_body"] = $pcTextBody;
            $sendData = $AdmSupportMailOBJ->convertMailElements($sendData, $orderingData["user_id"], $setArray);
            $pcSendMailData = $AdmSupportMailOBJ->smtpMailTo($sendData, $second);

            try{
                if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($pcSendMailData)) {
                    $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "のPCアドレスに送信できませんでした。";
                    $sendCnt["notSendPcCnt"]++;
                } else {
                    $sendCnt["sendPcCnt"]++;
                    $insertData["pc_subject"]  = $sendData["subject"];
                    $insertData["pc_text_body"] = $sendData["text_body"];
                }
            } catch (Zend_Exception $e) {
                // デバッグメール
                $debugMail = "";
                $debugMail["subject"] = "PCサポート一括メール送信エラー";
                $debugMail["text_body"][] = "file:" . __FILE__ ;
                $debugMail["text_body"][] = "line:" . __LINE__ ;
                $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                $debugMail["text_body"][] = "user.id:" . $userData["user_id"];
                $debugMail["text_body"][] = "send_device_type:PC";
                $debugMail["text_body"][] = "err:" . $e->getMessage();
                $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($debugMail);
            }
        }

        // MB送信
        if (ComValidation::isMobileAddress($sendData["mb_to_address"]) AND $userData["mb_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
            $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "のMBアドレスステータスが送信可能ではないので送信できませんでした。";
            $sendCnt["notSendMbCnt"]++;
        } else if (ComValidation::isMobileAddress($sendData["mb_to_address"])) {
            $mbSendMailData = "";
            $sendData["to_address"] = $sendData["mb_to_address"];
            $sendData["subject"] = $mbSubject;
            $sendData["text_body"] = $mbTextBody;
            $sendData = $AdmSupportMailOBJ->convertMailElements($sendData, $orderingData["user_id"], $setArray);
            $mbSendMailData = $AdmSupportMailOBJ->smtpMailTo($sendData, $second);

            try{
                if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($mbSendMailData)) {
                    $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "のMBアドレスに送信できませんでした。";
                    $sendCnt["notSendMbCnt"]++;
                } else {
                    $sendCnt["sendMbCnt"]++;
                    $insertData["mb_subject"] = $sendData["subject"];
                    $insertData["mb_text_body"] = $sendData["text_body"];
                }
            } catch (Zend_Exception $e) {
                // デバッグメール
                $debugMail = "";
                $debugMail["subject"] = "MBサポート一括メール送信エラー";
                $debugMail["text_body"][] = "file:" . __FILE__ ;
                $debugMail["text_body"][] = "line:" . __LINE__ ;
                $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                $debugMail["text_body"][] = "user.id:" . $userData["user_id"];
                $debugMail["text_body"][] = "send_device_type:MB";
                $debugMail["text_body"][] = "err:" . $e->getMessage();
                $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($debugMail);
            }
        }
        // 配信ログの登録
        if ($insertData["pc_text_body"] OR $insertData["mb_text_body"]) {
            $insertData["ordering_id"]     = $val["id"];
            $insertData["from_address"]    = $sendData["from_address"];
            $insertData["from_name"]       = $sendData["from_name"];
            $insertData["pc_to_address"]   = $sendData["pc_to_address"];
            $insertData["mb_to_address"]   = $sendData["mb_to_address"];
            $insertData["create_datetime"] = date("YmdHis");

            if (!$AdmSupportMailLogOBJ->insertSupportMailLogData($insertData)) {
                $execMsgSessOBJ->exec_msg[] = "注文ID:" . $val["id"] . "のサポートメールログの登録に失敗しました。";
                continue;
            }
        }

        // 送信数カウント
        $sendUserCount++;
    }

    // SMTP切断
    $ComSendMagicDeliveryOBJ->closeSmtpConnect();

    // サポートメール送信ログの追加
    $supportMailSendLog["admin_id"] = $loginAdminData["id"];
    $supportMailSendLog["interval_second"] = $param["interval_second"];
    $supportMailSendLog["from_address"] = $sendData["from_address"];
    $supportMailSendLog["from_name"] = $sendData["from_name"];
    $supportMailSendLog["mail_reserve_type"] = AdmSupportMail::SUPPORTMAIL_TYPE_BULK;
    $supportMailSendLog["pc_subject"] = $param["pc_subject"];
    $supportMailSendLog["pc_text_body"] = $param["pc_text_body"];
    $supportMailSendLog["mb_subject"] = $param["mb_subject"];
    $supportMailSendLog["mb_text_body"] = $param["mb_text_body"];
    $supportMailSendLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
    $supportMailSendLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
    $supportMailSendLog["send_err_count_mb"] = $sendCnt["notSendMbCnt"];
    $supportMailSendLog["send_err_count_pc"] = $sendCnt["notSendPcCnt"];
    $supportMailSendLog["err_count"] = $sendCnt["errCnt"];
    $supportMailSendLog["return_path"] = $sendData["return_path"] ;
    $supportMailSendLog["create_datetime"] = date("YmdHis");
    $supportMailSendLog["update_datetime"] = date("YmdHis");
    $supportMailSendLog["send_end_datetime"] = date("YmdHis");

    // 検索条件
    $supportMailSendLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchValue), "sql");

    // ログの書き込み
    if (!$AdmSupportMailLogOBJ->insertSupportMailSendLog($supportMailSendLog)) {
        $execMsgSessOBJ->exec_msg[] = "サポートメール送信ログの登録に失敗しました。";
    }

    $execMsgSessOBJ->exec_msg[] = "PC：" . $sendCnt["sendPcCnt"] . "件 MB：" . $sendCnt["sendMbCnt"] . "件 送信完了しました。";

// 予約サポートメール
} else if ($param["mail_reserve_type"] == AdmSupportMail::SUPPORTMAIL_TYPE_TIMER) {

    $timerDatetime = $param["reserve_datetime_Date"] . " " . $param["reserve_datetime_Time"] . ":00";

    if (!ComValidation::isDatetime($timerDatetime)) {
        $errSessOBJ->errMsg = array("有効な日時を入力して下さい");
        $param["return_flag"] = true;
        header("Location: ./?action_ordering_SupportMailBulkInput=1" . $URLparam);
        exit;
    }

    // 予約サポートメール内容の追加
    $supportMailLog["admin_id"] = $loginAdminData["id"];
    $supportMailLog["from_address"] = $param["from_address"];
    $supportMailLog["from_name"] = $param["from_name"];
    $supportMailLog["search_sql"] = htmlspecialchars($AdmOrderingOBJ->getListSql(), ENT_QUOTES);
    $supportMailLog["pc_subject"] = $param["pc_subject"];
    $supportMailLog["pc_text_body"] = $param["pc_text_body"];
    $supportMailLog["mb_subject"] = $param["mb_subject"];
    $supportMailLog["mb_text_body"] = $param["mb_text_body"];
    $supportMailLog["send_datetime"] = $timerDatetime;
    $supportMailLog["send_plans_count"] = $orderingCnt;
    $supportMailLog["create_datetime"] = date("YmdHis");

    // 検索条件
    $supportMailLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchValue), "sql");

    // 書き込み
    if (!$AdmSupportMailOBJ->insertSupportMailReserve($supportMailLog)) {
        $errSessOBJ->errMsg = $AdmSupportMailOBJ->getErrorMsg();
        $param["return_flag"] = true;
        header("Location: ./?action_ordering_SupportMailBulkInput=1" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->message = array("設定しました。");

// 定期サポートメール
} else if ($param["mail_reserve_type"] == AdmSupportMail::SUPPORTMAIL_TYPE_REGULAR) {

    if ($param["send_condition_type"] > 0) {
        if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_DAY) {
            $sendTime = $param["send_time_day"] . ":00";
        } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_WEEK) {
            $sendTime = $param["send_time_week"] . ":00";
        } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_MONTH) {
            $sendTime = $param["send_time_month"] . ":00";
        }

        if (!ComValidation::isTime($sendTime)) {
            $errMsg[] = "有効な日時を入力して下さい";
        }
    }

    if ($param["hour_from"] AND !ComValidation::isBetween($param["hour_from"], 0, 23)) {
        $errMsg[] = "有効な開始時間を入力して下さい";
    }

    if ($param["hour_to"] AND !ComValidation::isBetween($param["hour_to"], 0, 23)) {
        $errMsg[] = "有効な終了時間を入力して下さい";
    }

    if ($param["second"] AND !ComValidation::isNumeric($param["second"])) {
        $errMsg[] = "分に有効な数字を入力して下さい";
    }

    if ($param["send_day"] AND !ComValidation::isNumeric($param["send_day"])) {
        $errMsg[] = "送信日に有効な数字を入力して下さい";
    }

    if ($errMsg) {
        $errSessOBJ->errMsg = $errMsg;
        $param["return_flag"] = true;
        header("Location: ./?action_ordering_SupportMailBulkInput=1" . $URLparam);
        exit;
    }

    // 定期サポートメール内容の追加
    $supportMailLog["admin_id"] = $loginAdminData["id"];
    $supportMailLog["title"] = $param["title"];
    $supportMailLog["from_address"] = $param["from_address"];
    $supportMailLog["from_name"] = $param["from_name"];
    $supportMailLog["search_sql"] = htmlspecialchars($AdmOrderingOBJ->getListSql(), ENT_QUOTES);
    $supportMailLog["pc_subject"] = $param["pc_subject"];
    $supportMailLog["pc_text_body"] = $param["pc_text_body"];
    $supportMailLog["mb_subject"] = $param["mb_subject"];
    $supportMailLog["mb_text_body"] = $param["mb_text_body"];
    $supportMailLog["send_condition_type"] = $param["send_condition_type"];
    $supportMailLog["hour_from"] = $param["regular_hour_from"];
    $supportMailLog["hour_to"] = $param["regular_hour_to"];
    $supportMailLog["second"] = $param["regular_second"];
    $supportMailLog["week"] = $param["regular_week"];
    $supportMailLog["send_day"] = $param["send_day"];
    $supportMailLog["send_time"] = $sendTime;
    $supportMailLog["create_datetime"] = date("YmdHis");
    $supportMailLog["update_datetime"] = date("YmdHis");

    // 検索条件
    $supportMailLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchValue), "sql");

    // 書き込み
    if (!$AdmSupportMailOBJ->insertSupportMailRegular($supportMailLog)) {
        $errSessOBJ->errMsg = $AdmSupportMailOBJ->getErrorMsg();
        $param["return_flag"] = true;
        header("Location: ./?action_ordering_SupportMailBulkInput=1" . $URLparam);
        exit;
    }
    $execMsgSessOBJ->message = array("設定しました。");

}

header("location: ./?action_ordering_OrderingSearchList=1&" . $URLparam);
exit;



?>