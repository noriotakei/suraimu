<?php
/**
 * testRegularMailSendExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * 定期メルマガ送信ページ処理ファイル。by SMTP
 *
 * @copyright   2011 Fraise, Inc.
 * @author      norihisa Hosoda
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");
set_time_limit( 0 );
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
$KeyConvertOBJ = KeyConvert::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$SendMailOBJ = SendMail::getInstance();
$UserOBJ = User::getInstance();

//通常メルマガ用とひっぺ用ふたつインスタンス
$normalComSendMagicDeliveryOBJ  = new ComSendMagicDelivery();
$reverseComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

$timeStamp = strtotime(date("H:i:00"));
$hour = idate("H");
$minute = idate("i");
$intervalKey = 2;

//$whereTestArray = "";
//$whereTestArray[] = "id = 255"; // norihisa_hosoda@fraise.jpへ
//$regularList = $AdmMailMagazineOBJ->testGetSendMailRegularList($whereTestArray);
$regularList = $AdmMailMagazineOBJ->getSendMailRegularList();

if (!$regularList) {
    exit("NoData");
}

// SMTPホスト設定(通常・反転)
$normalComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["sendMagic"]);
$reverseComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["reverse"]);

try{

    // 該当する予約の数だけループ
    foreach ($regularList as $listValue) {

        // 配信条件の作成
        if ($listValue["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_HOUR) {
            if (!($listValue["hour_from"] <= $hour AND $listValue["hour_to"] >= $hour AND (int)AdmMailMagazine::$_sendConditionTypeHourSecond[$listValue["second"]] == $minute)) {
                 continue;
            }
        } else if ($listValue["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_DAY) {
            if (strtotime(date("Ymd") . $listValue["send_time"]) != $timeStamp) {
                 continue;
            }
        } else if ($listValue["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_WEEK) {
           if (!($listValue["week"] == date("w") AND strtotime(date("Ymd") . $listValue["send_time"]) == $timeStamp)) {
                 continue;
           }
        } else if ($listValue["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_MONTH) {
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
        $pcHtmlBody = htmlspecialchars_decode($listValue["pc_html_body"], ENT_QUOTES);
        $mbSubject = htmlspecialchars_decode($listValue["mb_subject"], ENT_QUOTES);
        $mbTextBody = htmlspecialchars_decode($listValue["mb_text_body"], ENT_QUOTES);
        $mbHtmlBody = htmlspecialchars_decode($listValue["mb_html_body"], ENT_QUOTES);

        $userList = "";
        $userListCnt = "";

        // データリスト取得
        // sql文を作成する
        if (!$userList = $AdmMailMagazineOBJ->getUserList(unserialize($listValue["search_condition"]))) {
            continue;
        }
        $userListCnt = $AdmMailMagazineOBJ->getFoundRows();

        if (!$userList) {
            continue;
        }

        if (!$listValue["from_address"]) {
            continue;
        }

        // 検索条件の解凍
        $searchCondition = unserialize($listValue["search_condition"]);

        //-------------------------
        // アップロード画像の取得
        //-------------------------

        // PC画像リストの取得
        $pcRegularImageList = $AdmMailMagazineOBJ->getMailImageRegularData($listValue["id"], false);

        $pcImageData = array();
        $pcImageType = array();
        for ($i = 0; $i < count($pcRegularImageList); $i++) {
            if ($pcRegularImageList[$i]["file_name"]) {
                $pcImageData[$i] = file_get_contents(D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH . $pcRegularImageList[$i]["file_name"]);
                $size = getimagesize(D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH . $pcRegularImageList[$i]["file_name"]);
                $pcImageType[$i] = $size["mime"];
            }
        }

        // MB画像リストの取得
        $mbRegularImageList = $AdmMailMagazineOBJ->getMailImageRegularData($listValue["id"], true);

        $mbImageData = array();
        $mbImageType = array();
        for ($i = 0; $i < count($mbRegularImageList); $i++) {
            if ($mbRegularImageList[$i]["file_name"]) {
                $mbImageData[$i] = file_get_contents(D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH . $mbRegularImageList[$i]["file_name"]);
                $size = getimagesize(D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH . $mbRegularImageList[$i]["file_name"]);
                $mbImageType[$i] = $size["mime"];
            }
        }

        $mailLog = "";
        // 管理ユーザーID
        $mailLog["admin_id"] = $listValue["admin_id"];
        $mailLog["send_start_datetime"] = date("Y-m-d H:i:s");
        $mailLog["create_datetime"]     = date("Y-m-d H:i:s");
        $mailLog["mailmagazine_regular_id"] = $listValue["id"];
        $mailLog["mail_reserve_type"] = AdmMailMagazine::MAILMAGAZINE_TYPE_REGULAR;

        $second = 60 * (int)AdmMailMagazine::$_intervalSecond[$intervalKey];  // インターバル指定

        // ログの書き込み
        $AdmMailMagazineOBJ->insertMailMagaLog($mailLog);
        $mailMagaId = $AdmMailMagazineOBJ->getInsertId();

        // ％変換処理 mailmagazine_log の id
        $convertAry["-%mailmagazine_log_id-"] = $mailMagaId;

        // 戻り先
        $return = AdmMailMagazine::MAIL_MAGAZINE_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];

        $sendCnt["notSendPcCnt"] = 0;
        $sendCnt["sendPcCnt"] = 0;
        $sendCnt["notSendMbCnt"] = 0;
        $sendCnt["sendMbCnt"] = 0;
        $sendCnt["notSendNoRegCnt"] = 0;

        $fromAddressAry = explode("@",$listValue["from_address"]) ;
        $changeFromAddressFlag = FALSE ;
        if($_config["define"]["MAIL_DOMAIN"] == $fromAddressAry[1]){
            $changeFromAddressFlag = TRUE ;
        }

        $mailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
        end($mailDomainArray);//最後の要素
        $lastMailDomainKey = key($mailDomainArray);//最後の要素のキー

        // SMTP接続開始
        if(!$normalComSendMagicDeliveryOBJ->openSmtpConnect() || !$reverseComSendMagicDeliveryOBJ->openSmtpConnect()){
            // デバッグメール
            $debugMail = "";
            $debugMail["subject"] = "定期メルマガ送信エラー";
            $debugMail["text_body"][] = "file:" . __FILE__ ;
            $debugMail["text_body"][] = "line:" . __LINE__ ;
            $debugMail["text_body"][] = "mailmagine_regular_id:" . $listValue["id"];
            $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
            // システムにエラーメール
            $SendMailOBJ->debugMailTo($debugMail);
        }

        // 送信数
        $sendUserCount = 0;
        while (list($key, $val) = each($userList)) {

            // 送信数が1000件でSMTP切断→再接続
            if ($sendUserCount != 0 && ($sendUserCount%1000) == 0) {
                if(!$normalComSendMagicDeliveryOBJ->retryOpenSmtpConnect() || !$reverseComSendMagicDeliveryOBJ->retryOpenSmtpConnect()){
                    // 接続エラーならば、次のループ送信処理
                    $sendCnt["notSendNoRegCnt"]++;
                    continue;
                }
            }

            // ユーザーステータスのチェック(下記の場合、送信しない)
            // ﾌﾞﾗｯｸの場合
            if ($val["danger_status"] == $_config["define"]["DANGER_VALID"]) {
                $sendCnt["notSendNoRegCnt"]++;
                continue;
            }

            //懸賞用ＬＰ入り口ﾕｰｻﾞｰは懸賞ＬＰ用ﾌﾗｸﾞがない場合はさようなら。。
            if (in_array($val["regist_page_id"] ,$_config["define"]["REGIST_PAGE_PRIZE"]) AND !$listValue["prize_mail_status"]) {
                $sendCnt["notSendNoRegCnt"]++;
                continue;
            } 

            // 銀行口座、住所 ％変換処理
            $userBankData = $UserOBJ->getBankDetailData($val["user_id"]) ;
            $userAddressData = $UserOBJ->getAddressDetailData($val["user_id"]) ;
            if($userBankData){
                $convertAry["-%u_bank-"] = $userBankData["bank_name"] ;
                $convertAry["-%u_b_code-"] = $userBankData["bank_code"] ;
                $convertAry["-%u_b_branch-"] = $userBankData["branch_name"] ;
                $convertAry["-%u_b_branchcode-"] = $userBankData["branch_code"] ;
                $convertAry["-%u_b_classification-"] = $userBankData["type"] ;
                $convertAry["-%u_b_number-"] = $userBankData["account_number"] ;
                $convertAry["-%u_b_registered_stockholder-"] = $userBankData["name"] ;
            }
            if($userAddressData){
                $convertAry["-%u_postcode-"] = $userAddressData["postal_code"] ;
                $convertAry["-%u_address-"] = $userAddressData["address"] ;
                $convertAry["-%u_name-"] = $userAddressData["name"] ;
                $convertAry["-%u_telephone_number-"] = $userAddressData["phone_number"] ;
            }

            // フリーワード％変換処理
            $AdmFreeWordOBJ = AdmFreeWord::getInstance();
            $userFreeWordData = $AdmFreeWordOBJ->getFreeWordData($val["user_id"]) ;

            if(count($userFreeWordData)){
                foreach($userFreeWordData as $freeWordVal){
                    $valFreeWord = 0 ;
                    if($freeWordVal["free_word_type"] == 2){
                        $valFreeWord = $freeWordVal["free_word_text"] ;
                    } else {
                        $valFreeWord = $freeWordVal["free_word_value"] ;
                    }
                    $convertAry["-%free_word_".$freeWordVal["free_word_type"]."_".$freeWordVal["free_word_cd"]."-"] = $valFreeWord;
                }
            }

            $isPcSend = true;
            // pc送信
            if ($val["pc_address"] AND ($pcTextBody OR $pcHtmlContents)) {
                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($searchCondition["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_address_status_or"])) AND $val["pc_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($searchCondition["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_address_send_status_or"])) AND $val["pc_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($searchCondition["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_mailmagazine_or"])) AND $val["pc_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }

                //配信ｱﾄﾞﾚｽ作成処理。pc_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $listValue["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]]){
                        $listValue["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]] ;
                    } else {
                        $listValue["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }

                if ($isPcSend) {
                    $mailData = array(
                                        "to_address" => $val["pc_address"],
                                        "return_path" => $return,
                                        "from_address" => $listValue["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $pcSubject,
                                        "text_body" => $pcTextBody,
                                        "html_body" => $pcHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $pcImageData, $pcImageType);

                    if ($sendMailData) {
                        try{
                            $sendResult = "";
                            if ($val["pc_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$listValue["reverse_mail_status"] and !$val["is_pc_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif (!$listValue["reverse_mail_status"] && !$val["is_pc_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($listValue["reverse_mail_status"] || $val["is_pc_reverse"]) {
                                // 反転
                                $sendResult = $reverseComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            }

                            if (!$sendResult) {
                                $sendCnt["notSendPcCnt"]++;
                                $isPcSend = false;
                            }
                        } catch (Zend_Exception $e) {
                            // 送れたものとして判断
                            // デバッグメール
                            $debugMail = "";
                            $debugMail["subject"] = "定期メルマガ送信エラー";
                            $debugMail["text_body"][] = "file:" . __FILE__ ;
                            $debugMail["text_body"][] = "line:" . __LINE__ ;
                            $debugMail["text_body"][] = "mailmagine_log.id:" . $mailMagaId;
                            $debugMail["text_body"][] = "user.id:" . $val["user_id"];
                            $debugMail["text_body"][] = "send_device_type:PC";
                            $debugMail["text_body"][] = "err:" . $e->getMessage();
                            $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($debugMail);
                        }
                    } else {
                        $sendCnt["notSendPcCnt"]++;
                        $isPcSend = false;
                    }

                    if($isPcSend){
                        $sendCnt["sendPcCnt"]++;
                        //100件毎に送信数を更新
                        if(($sendCnt["sendPcCnt"]%100)==0){
                            // ログの書き込み
                            $sendPcCntUpdate["send_total_count_pc"] = $sendCnt["sendPcCnt"];
                            $sendPcCntUpdate["peak_memory"]         = memory_get_peak_usage();
                            $sendPcCntUpdate["create_datetime"]     = date("Y-m-d H:i:s");
                            $AdmMailMagazineOBJ->updateMailMagaLog($sendPcCntUpdate , array("id = " . $mailMagaId));
                        }
                    }
                } else {
                    $sendCnt["notSendPcCnt"]++;
                }
            }else{
                $isPcSend = false;
            }

            $isMbSend = true;
            // mb送信
            if ($val["mb_address"] AND ($mbTextBody OR $mbHtmlBody)) {
                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($searchCondition["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_address_status_or"])) AND $val["mb_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($searchCondition["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_address_send_status_or"])) AND $val["mb_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($searchCondition["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $searchCondition["is_mailmagazine_or"])) AND $val["mb_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }

                //配信ｱﾄﾞﾚｽ作成処理。mb_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $listValue["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]]){
                        $listValue["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]] ;
                    } else {
                        $listValue["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }

                if ($isMbSend) {
                    $mailData = array(
                                        "to_address" => $val["mb_address"],
                                        "return_path" => $return,
                                        "from_address" => $listValue["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $mbSubject,
                                        "text_body" => $mbTextBody,
                                        "html_body" => $mbHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $mbImageData, $mbImageType);

                    if ($sendMailData) {
                        try{
                            $sendResult = "";
                            if ($val["mb_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$listValue["reverse_mail_status"] and !$val["is_mb_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif (!$listValue["reverse_mail_status"] && !$val["is_mb_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($listValue["reverse_mail_status"] || $val["is_mb_reverse"]) {
                                // 反転
                                $sendResult = $reverseComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            }

                            if (!$sendResult) {
                                $sendCnt["notSendMbCnt"]++;
                                $isMbSend = false;
                            }
                        } catch (Zend_Exception $e) {
                            // 送れたものとして判断
                            // デバッグメール
                            $debugMail = "";
                            $debugMail["subject"] = "予約メルマガ送信エラー";
                            $debugMail["text_body"][] = "file:" . __FILE__;
                            $debugMail["text_body"][] = "line:" . __LINE__;
                            $debugMail["text_body"][] = "mailmagine_log.id:" . $mailMagaId;
                            $debugMail["text_body"][] = "user.id:" . $val["user_id"];
                            $debugMail["text_body"][] = "send_device_type:MB";
                            $debugMail["text_body"][] = "err:" . $e->getMessage();
                            $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($debugMail);
                        }
                    } else {
                        $sendCnt["notSendMbCnt"]++;
                        $isMbSend = false;
                    }

                    if($isMbSend){
                        $sendCnt["sendMbCnt"]++;
                        //100件毎に送信数を更新
                        if(($sendCnt["sendMbCnt"]%100)==0){
                            // ログの書き込み
                            $sendMbCntUpdate["send_total_count_mb"] = $sendCnt["sendMbCnt"];
                            $sendMbCntUpdate["peak_memory"]         = memory_get_peak_usage();
                            $sendMbCntUpdate["create_datetime"]     = date("Y-m-d H:i:s");
                            $AdmMailMagazineOBJ->updateMailMagaLog($sendMbCntUpdate , array("id = " . $mailMagaId));
                        }
                    }
                } else {
                    $sendCnt["notSendMbCnt"]++;
                }
            }else{
                $isMbSend = false;
            }

            if ($isPcSend OR $isMbSend) {
                // 引っペ返し回数の更新
                if ($listValue["reverse_mail_status"]) {
                    $setProfileParam = "";
                    $setProfileParam["reverse_mail_status_count"] = "reverse_mail_status_count + 1";
                    $setProfileParam["update_datetime"] = "'" . date("YmdHis") . "'";
                    $userProfileWhere = "";
                    $userProfileWhere[] = "user_id = " . $val["user_id"];
                    $AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, "profile", false);
                }

                // 送信メルマガログの追加
                $mailMagaSendLog = "";
                $mailMagaSendLogList = $AdmMailMagazineOBJ->getMailMagaSendLogList($val["user_id"], "mailmagazine_log_id_regular");
                $mailMagaSendLog["mailmagazine_log_id_regular"] = $mailMagaId;
                $mailMagaSendLog["update_datetime"] = date("YmdHis");
                if (count($mailMagaSendLogList) >= AdmMailMagazine::MAIL_MAGAZINE_SEND_LOG_COUNT) {
                    // ログの書き込み
                    $AdmMailMagazineOBJ->updateMailMagaSendLog($mailMagaSendLog, array("id = " . $mailMagaSendLogList["0"]["id"]));
                } else {
                    $mailMagaSendLog["user_id"] = $val["user_id"];
                    // ログの書き込み
                    $AdmMailMagazineOBJ->insertMailMagaSendLog($mailMagaSendLog);
                }
            }

            // 送信数カウント
            $sendUserCount++;
        }

        // SMTP切断
        $normalComSendMagicDeliveryOBJ->closeSmtpConnect();
        $reverseComSendMagicDeliveryOBJ->closeSmtpConnect();

        // メルマガログの追加
        $mailLog["interval_second"] = $intervalKey;
        $mailLog["from_address"] = $listValue["from_address"];
        $mailLog["from_name"] = $listValue["from_name"];
        $mailLog["pc_subject"] = $listValue["pc_subject"];
        $mailLog["pc_text_body"] = $listValue["pc_text_body"];
        $mailLog["pc_html_body"] = $listValue["pc_html_body"];
        $mailLog["mb_subject"] = $listValue["mb_subject"];
        $mailLog["mb_text_body"] = $listValue["mb_text_body"];
        $mailLog["mb_html_body"] = $listValue["mb_html_body"];
        $mailLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
        $mailLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
        $mailLog["send_err_count_mb"] = $sendCnt["notSendMbCnt"];
        $mailLog["send_err_count_pc"] = $sendCnt["notSendPcCnt"];
        $mailLog["err_count"] = $sendCnt["notSendNoRegCnt"];
        $mailLog["return_path"] = $return;
        $mailLog["peak_memory"] = memory_get_peak_usage();
        $mailLog["create_datetime"] = date("Y-m-d H:i:s");
        $mailLog["update_datetime"] = date("Y-m-d H:i:s");
        $mailLog["send_end_datetime"] = date("Y-m-d H:i:s");

        // 検索条件表の作成
        $mailLog["search_condition"] = $listValue["search_condition"];

        // ログの書き込み
        $AdmMailMagazineOBJ->updateMailMagaLog($mailLog , array("id = " . $mailMagaId));
        // PCメール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLogByCron($mailMagaId, $pcRegularImageList, D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH, false);
        // MBメール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLogByCron($mailMagaId, $mbRegularImageList, D_BASE_DIR . AdmMailMagazine::MAIL_REGULAR_IMAGE_PATH, true);
    }

} catch (Exception $e) {
    exit("NG5");
}
exit("終了");
?>

