<?php
/**
 * testRegularSupportMailSendExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 定期サポートメール送信ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");
set_time_limit( 0 );
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$KeyConvertOBJ = KeyConvert::getInstance();
$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$SendMailOBJ = SendMail::getInstance();
$ComSendMagicDeliveryOBJ = ComSendMagicDelivery::getInstance();

$regularList = $AdmSupportMailOBJ->getSendSupportMailRegularList();

if (!$regularList) {
    exit("NoData");
}

$timeStamp = strtotime(date("H:i:00"));
$hour = idate("H");
$minute = idate("i");
$intervalKey = 0;

// SMTPホスト設定(通常)
$ComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["sendMagic"]);

try{

    // 該当する予約の数だけループ
    foreach ($regularList as $listValue) {
        // 配信条件の作成
        if ($listValue["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_HOUR) {
            if (!($listValue["hour_from"] <= $hour AND $listValue["hour_to"] >= $hour AND (int)AdmSupportMail::$_sendConditionTypeHourSecond[$listValue["second"]] == $minute)) {
                 continue;
            }
        } else if ($listValue["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_DAY) {
            if (strtotime(date("Ymd") . $listValue["send_time"]) != $timeStamp) {
                 continue;
            }
        } else if ($listValue["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_WEEK) {
           if (!($listValue["week"] == date("w") AND strtotime(date("Ymd") . $listValue["send_time"]) == $timeStamp)) {
                 continue;
           }
        } else if ($listValue["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_MONTH) {
            // 月末か、日にち指定
            if (!(($listValue["send_day"] == date("j") OR (!$listValue["send_day"] AND date("t") == date("j"))) AND strtotime(date("Ymd") . $listValue["send_time"]) == $timeStamp)) {
                 continue;
            }
        } else {
            continue;
        }

        $fromName = htmlspecialchars_decode($listValue["from_name"], ENT_QUOTES);
        $pcSubject = htmlspecialchars_decode($listValue["pc_subject"], ENT_QUOTES);
        $pcTextBody = htmlspecialchars_decode($listValue["pc_text_body"], ENT_QUOTES);
        $mbSubject = htmlspecialchars_decode($listValue["mb_subject"], ENT_QUOTES);
        $mbTextBody = htmlspecialchars_decode($listValue["mb_text_body"], ENT_QUOTES);

        $orderingList = "";
        $orderingCnt = "";

        // データリスト取得
        // sql文を作成する
        if (!$orderingList = $AdmOrderingOBJ->getOrderingList(unserialize($listValue["search_condition"]))) {
            continue;
        }

        $orderingCnt = $AdmOrderingOBJ->getFoundRows();

        if (!$orderingList) {
            continue;
        }

        if (!$listValue["from_address"]) {
            continue;
        }

        $second = 60 * (int)AdmSupportMail::$_intervalSecond[$intervalKey];  // インターバル指定

        // 戻り先
        $return = AdmSupportMail::SUPPORTMAIL_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];

        $sendCnt["notSendPcCnt"] = 0;
        $sendCnt["sendPcCnt"] = 0;
        $sendCnt["notSendMbCnt"] = 0;
        $sendCnt["sendMbCnt"] = 0;
        $sendCnt["errCnt"] = 0;

        $supportMailSendLog = "";
        $supportMailSendLog["send_start_datetime"] = date("YmdHis");

        $fromAddressAry = explode("@",$listValue["from_address"]) ;
        $changeFromAddressFlag = FALSE ;
        if($_config["define"]["MAIL_DOMAIN"] == $fromAddressAry[1]){
            $changeFromAddressFlag = TRUE ;
        }

        // SMTP接続開始
        if(!$ComSendMagicDeliveryOBJ->openSmtpConnect()){
            $sendCnt["errCnt"] = 0;
            // デバッグメール
            $debugMail = "";
            $debugMail["subject"] = "予約サポート接続エラー";
            $debugMail["text_body"][] = "file:" . __FILE__ ;
            $debugMail["text_body"][] = "line:" . __LINE__ ;
            $debugMail["text_body"][] = "support_mail_regular_id:" . $listValue["id"];
            $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
            // システムにエラーメール
            $SendMailOBJ->debugMailTo($debugMail);
            continue;
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
                    $debugMail["text_body"][] = "support_mail_regular_id:" . $listValue["id"];
                    $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                    $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($debugMail);
                    continue;
                }
            }

            $orderingData = "";
            $userData = "";
            $insertData = null;

            $orderingData = $AdmOrderingOBJ->getOrderingData($val["id"]);
            $userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);
            if (!($orderingData AND $userData)) {
                $sendCnt["errCnt"]++;
                continue;
            }

            // ユーザーステータスのチェック(下記の場合、送信しない)
            // ﾌﾞﾗｯｸ、退会の場合
            if ($userData["regist_status"] == $_config["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]
                OR $userData["danger_status"] == $_config["define"]["DANGER_VALID"]) {
                $sendCnt["errCnt"]++;
                continue;
            }

            // 別途%変換用にセット
            $setArray = $AdmOrderingOBJ->makeOrderConvertArray($orderingData);

            // pc送信
            $isPcSend = FALSE;
            if ($pcTextBody) {
                //PCｱﾄﾞﾚｽｽﾃ-ﾀｽ,PCﾒｱﾄﾞ送信ｽﾃｰﾀｽ,PCﾒｱﾄﾞ配信ｽﾃｰﾀｽの有効性をﾁｪｯｸ
                if($userData["pc_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]){
                    $sendCnt["notSendPcCnt"]++;
                } else if($userData["pc_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]){
                    $sendCnt["notSendPcCnt"]++;
                } else if (ComValidation::isMailAddress($userData["pc_address"]) AND $userData["pc_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                    $sendCnt["notSendPcCnt"]++;
                } else if (ComValidation::isMailAddress($userData["pc_address"])) {

                    //配信ｱﾄﾞﾚｽ作成処理。pc_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                    if($changeFromAddressFlag){
                        $listValue["from_address"] = "" ;
                        $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                        //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                        if($sendMailDomainArray[$userData["pc_mailmagazine_from_domain_id"]]){
                            $listValue["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$userData["pc_mailmagazine_from_domain_id"]] ;
                        } else {
                            $listValue["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                        }
                    }

                    $mailData = null;
                    $mailData = array(
                                        "to_address" => $userData["pc_address"],
                                        "return_path" => $return,
                                        "from_address" => $listValue["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $pcSubject,
                                        "text_body" => $pcTextBody,
                                        );
                    $mailElements = $AdmSupportMailOBJ->convertMailElements($mailData, $userData["user_id"], $setArray);
                    $pcSendMailData = "";
                    $pcSendMailData = $AdmSupportMailOBJ->smtpMailTo($mailElements, $second);
                    try{
                        if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($pcSendMailData)) {
                            $sendCnt["notSendPcCnt"]++;
                        }else{
                            $isPcSend = TRUE;
                        }
                    } catch (Zend_Exception $e) {
                        // 送れたものとして判断
                        $isPcSend = TRUE;
                        // デバッグメール
                        $debugMail = "";
                        $debugMail["subject"] = "PC定期サポートメール送信エラー";
                        $debugMail["text_body"][] = "file:" . __FILE__;
                        $debugMail["text_body"][] = "line:" . __LINE__;
                        $debugMail["text_body"][] = "support_mail_regular_id:" . $listValue["id"];
                        $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                        $debugMail["text_body"][] = "user.id:" . $val["user_id"];
                        $debugMail["text_body"][] = "err:" . $e->getMessage();
                        $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($debugMail);
                    }
                    if($isPcSend){
                        $sendCnt["sendPcCnt"]++;
                        $insertData["pc_to_address"]   = $mailData["to_address"];
                        $insertData["pc_subject"] = $pcSubject;
                        $insertData["pc_text_body"] = $pcTextBody;
                    }
                }
            }

            // mb送信
            $isMbSend = FALSE;
            if ($mbTextBody) {
                //MBｱﾄﾞﾚｽｽﾃ-ﾀｽ,MBﾒｱﾄﾞ送信ｽﾃｰﾀｽ,MBﾒｱﾄﾞ配信ｽﾃｰﾀｽの有効性をﾁｪｯｸ
                if($userData["mb_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]){
                    $sendCnt["notSendMbCnt"]++;
                } else if($userData["mb_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]){
                    $sendCnt["notSendMbCnt"]++;
                } else if (ComValidation::isMobileAddress($userData["mb_address"]) AND $userData["mb_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                    $sendCnt["notSendMbCnt"]++;
                } else if (ComValidation::isMobileAddress($userData["mb_address"])) {

                    //配信ｱﾄﾞﾚｽ作成処理。mb_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                    if($changeFromAddressFlag){
                        $listValue["from_address"] = "" ;
                        $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                        //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                        if($sendMailDomainArray[$userData["mb_mailmagazine_from_domain_id"]]){
                            $listValue["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$userData["mb_mailmagazine_from_domain_id"]] ;
                        } else {
                            $listValue["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                        }
                    }

                    $mailData = null;
                    $mailData = array(
                                        "to_address" => $userData["mb_address"],
                                        "return_path" => $return,
                                        "from_address" => $listValue["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $mbSubject,
                                        "text_body" => $mbTextBody,
                                        );
                    $mailElements = $AdmSupportMailOBJ->convertMailElements($mailData, $userData["user_id"], $setArray);
                    $mbSendMailData = "";
                    $mbSendMailData = $AdmSupportMailOBJ->smtpMailTo($mailElements, $second);
                    try{
                        if (!$ComSendMagicDeliveryOBJ->sendMagicDelivery($pcSendMailData)) {
                            $sendCnt["notSendMbCnt"]++;
                        }else{
                            $isMbSend = TRUE;
                        }
                    } catch (Zend_Exception $e) {
                        // 送れたものとして判断
                        $isMbSend = TRUE;
                        // デバッグメール
                        $debugMail = "";
                        $debugMail["subject"] = "MB定期サポートメール送信エラー";
                        $debugMail["text_body"][] = "file:" . __FILE__;
                        $debugMail["text_body"][] = "line:" . __LINE__;
                        $debugMail["text_body"][] = "support_mail_regular_id:" . $listValue["id"];
                        $debugMail["text_body"][] = "ordering_id:" . $val["id"];
                        $debugMail["text_body"][] = "user.id:" . $val["user_id"];
                        $debugMail["text_body"][] = "err:" . $e->getMessage();
                        $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($debugMail);
                    }
                    if($isMbSend){
                        $sendCnt["sendMbCnt"]++;
                        $insertData["mb_subject"] = $mbSubject;
                        $insertData["mb_text_body"] = $mbTextBody;
                        $insertData["mb_to_address"]   = $mailData["to_address"];
                    }
                }
            }

            // 配信ログの登録
            if ($isPcSend OR $isMbSend) {
                $insertData["ordering_id"]     = $val["id"];
                $insertData["from_address"]    = $mailData["from_address"];
                $insertData["from_name"]       = $mailData["from_name"];
                $insertData["create_datetime"] = date("YmdHis");

                if (!$AdmSupportMailLogOBJ->insertSupportMailLogData($insertData)) {
                    continue;
                }
            }
            // 送信数カウント
            $sendUserCount++;
        }

        // SMTP切断
        $ComSendMagicDeliveryOBJ->closeSmtpConnect();

        // サポートメール送信ログの追加
        $supportMailSendLog["admin_id"] = $listValue["admin_id"];
        $supportMailSendLog["interval_second"] = $intervalKey;
        $supportMailSendLog["from_address"] = $listValue["from_address"];
        $supportMailSendLog["from_name"] = $listValue["from_name"];
        $supportMailSendLog["search_condition"] = $listValue["search_condition"];
        $supportMailSendLog["support_mail_regular_id"] = $listValue["id"];
        $supportMailSendLog["mail_reserve_type"] = AdmSupportMail::SUPPORTMAIL_TYPE_REGULAR;
        $supportMailSendLog["pc_subject"] = $listValue["pc_subject"];
        $supportMailSendLog["pc_text_body"] = $listValue["pc_text_body"];
        $supportMailSendLog["mb_subject"] = $listValue["mb_subject"];
        $supportMailSendLog["mb_text_body"] = $listValue["mb_text_body"];
        $supportMailSendLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
        $supportMailSendLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
        $supportMailSendLog["send_err_count_mb"] = $sendCnt["notSendMbCnt"];
        $supportMailSendLog["send_err_count_pc"] = $sendCnt["notSendPcCnt"];
        $supportMailSendLog["err_count"] = $sendCnt["errCnt"];
        $supportMailSendLog["return_path"] = $return;
        $supportMailSendLog["create_datetime"] = date("YmdHis");
        $supportMailSendLog["update_datetime"] = date("YmdHis");
        $supportMailSendLog["send_end_datetime"] = date("YmdHis");

        // ログの書き込み
        $AdmSupportMailLogOBJ->insertSupportMailSendLog($supportMailSendLog);
    }
} catch (Exception $e) {
    exit("NG5");
}
exit("終了");
?>
