<?php
/**
 * mailSendExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガ送信ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit", "-1");
$param = $requestOBJ->getParameterExcept($exceptArray);
$fromName = $requestOBJ->getParameter("from_name", "off_html");
$pcSubject = $requestOBJ->getParameter("pc_title", "off_html");
$mbSubject = $requestOBJ->getParameter("mb_title", "off_html");
$pcTextBody = $requestOBJ->getParameter("pc_text_contents", "off_html");
$mbTextBody = $requestOBJ->getParameter("mb_text_contents", "off_html");
$pcHtmlBody = $requestOBJ->getParameter("pc_html_contents", "off_html");
$mbHtmlBody = $requestOBJ->getParameter("mb_html_contents", "off_html");

$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
$SendMailOBJ = SendMail::getInstance();

//通常メルマガ用とひっぺ用ふたつインスタンス
$normalComSendMagicDeliveryOBJ  = new ComSendMagicDelivery();
$reverseComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;
$tags = array(
            "sesKey",
            );

$URLparam = "&" . $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1");
    exit;
}

$userList = $AdmMailMagazineOBJ->getUserList($value);
$userListCnt = $AdmMailMagazineOBJ->getFoundRows();
if ($AdmMailMagazineOBJ->getErrorMsg()) {
    $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}

/* 未来でも予約できるようにコメントアウト
if (!$userList) {
    $errSessOBJ->errMsg = array("アドレス入力済みユーザーデータがありません");
    header("Location: ./?action_user_Search=1");
    exit;
}
*/
if (!ComValidation::isMailAddress($param["from_address"])) {
    $errSessOBJ->errMsg = array("送信アドレスを入力してください");
    header("Location: ./?action_mail_mailInput=1" . $URLparam);
    exit;
}

//MB添付画像ﾌｧｲﾙ容量制限ﾁｪｯｸ
$imageDataSize = 0;
for ($i = 1; $i <= count($_FILES["mb_image"]["tmp_name"]); $i++) {

    if (ComValidation::isValue($_FILES["mb_image"]["tmp_name"][$i])) {
        $imageData = file_get_contents($_FILES["mb_image"]["tmp_name"][$i]);
        $imageDataSize += strlen($imageData);

        if(ceil($imageDataSize/1024) > 10){
            $errSessOBJ->errMsg = array("MB添付ﾌｧｲﾙの容量制限(10k迄)ｵｰﾊﾞｰ！");
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }
    }

}

// SMTPホスト設定(通常・反転)
$normalComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["sendMagic"]);
$reverseComSendMagicDeliveryOBJ->setSendMailServerIp($_config["common_config"]["smtp_mail_server_ip"]["reverse"]);

// 検索条件の取得
$whereContents = $AdmMailMagazineOBJ->getWhereContents();
try{

    // 管理ユーザーID
    $mailLog["admin_id"] = $loginAdminData["id"];

    // 通常メルマガ
    if ($param["mail_reserve_type"] == AdmMailMagazine::MAILMAGAZINE_TYPE_NORMAL) {

        //-------------------------
        // アップロード画像の取得
        //-------------------------

        $pcImageData = array();
        $pcImageType = array();
        for ($i = 1; $i <= count($_FILES["pc_image"]["tmp_name"]); $i++) {
            if ($_FILES["pc_image"]["tmp_name"][$i]) {
                $pcImageData[$i] = file_get_contents($_FILES["pc_image"]["tmp_name"][$i]);
                $imageAry = getimagesize($_FILES["pc_image"]["tmp_name"][$i]);
                $pcImageType[$i] = $imageAry["mime"];
            }
        }

        $mbImageData = array();
        $mbImageType = array();
        for ($i = 1; $i <= count($_FILES["mb_image"]["tmp_name"]); $i++) {
            if ($_FILES["mb_image"]["tmp_name"][$i]) {
                $mbImageData[$i] = file_get_contents($_FILES["mb_image"]["tmp_name"][$i]);
                $imageAry = getimagesize($_FILES["mb_image"]["tmp_name"][$i]);
                $mbImageType[$i] = $imageAry["mime"];
            }
        }

        $AdminUserOBJ = AdmUser::getInstance();

        $second = 60 * (int)AdmMailMagazine::$_intervalSecond[$param["interval_second"]];  // インターバル指定

        // ログの書き込み
        $mailLog["send_start_datetime"] = date("YmdHis");
        $mailLog["create_datetime"]     = date("YmdHis");
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

        $fromAddressAry = explode("@",$param["from_address"]) ;
        $changeFromAddressFlag = FALSE ;
        if($_config["define"]["MAIL_DOMAIN"] == $fromAddressAry[1]){
            $changeFromAddressFlag = TRUE ;
        }

        $mailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
        end($mailDomainArray);//最後の要素
        $lastMailDomainKey = key($mailDomainArray);//最後の要素のキー

        // SMTP接続開始
        if(!$normalComSendMagicDeliveryOBJ->openSmtpConnect() || !$reverseComSendMagicDeliveryOBJ->openSmtpConnect()){
            $errSessOBJ->errMsg = array("接続エラーが発生しました。");
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // 送信数
        $sendUserCount = 0;
        while (list($key, $val) = each($userList)) {

            // 送信数が1000件でSMTP切断→再接続
            if (($sendUserCount%1000) == 0) {
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

            $isPcSend = true;
            // pc送信
            if ($val["pc_address"] AND ($pcTextBody OR $pcHtmlBody)) {
                //配信ｱﾄﾞﾚｽ作成処理。pc_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $param["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]]){
                        $param["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]] ;
                    } else {
                        $param["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }

                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($value["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_status_or"])) AND $val["pc_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($value["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_send_status_or"])) AND $val["pc_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($value["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $value["is_mailmagazine_or"])) AND $val["pc_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }

                if ($isPcSend) {
                    $mailData = array(
                                        "to_address" => $val["pc_address"],
                                        "return_path" => $return,
                                        "from_address" => $param["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $pcSubject,
                                        "text_body" => $pcTextBody,
                                        "html_body" => $pcHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $pcImageData, $pcImageType);

                    if ($sendMailData) {
                        // 送信
                        try{
                            $sendResult = "";
                            if ($val["pc_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$param["reverse_mail_status"][0] and !$val["is_pc_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } else if(!$param["reverse_mail_status"][0] && !$val["is_pc_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($param["reverse_mail_status"][0] || $val["is_pc_reverse"]) {
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
                            $debugMail["subject"] = "通常メルマガ送信エラー";
                            $debugMail["text_body"][] = "file:" . __FILE__;
                            $debugMail["text_body"][] = "line:" . __LINE__;
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

                    if ($isPcSend) {
                        $sendCnt["sendPcCnt"]++;
                        //100件毎に送信数を更新
                        if (($sendCnt["sendPcCnt"]%100)==0) {
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
                //配信ｱﾄﾞﾚｽ作成処理。mb_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $param["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]]){
                        $param["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]] ;
                    } else {
                        $param["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }
                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($value["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_status_or"])) AND $val["mb_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($value["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_send_status_or"])) AND $val["mb_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($value["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $value["is_mailmagazine_or"])) AND $val["mb_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }

                if ($isMbSend) {
                    $mailData = array(
                                        "to_address" => $val["mb_address"],
                                        "return_path" => $return,
                                        "from_address" => $param["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $mbSubject,
                                        "text_body" => $mbTextBody,
                                        "html_body" => $mbHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $mbImageData, $mbImageType);

                    if ($sendMailData) {
                        // 送信
                        try{
                            $sendResult = "";
                            if ($val["mb_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$param["reverse_mail_status"][0] and !$val["is_mb_reverse"]){
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } else if(!$param["reverse_mail_status"][0] && !$val["is_mb_reverse"]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($param["reverse_mail_status"][0] || $val["is_mb_reverse"]) {
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
                            $debugMail["subject"] = "通常メルマガ送信エラー";
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

                    if ($isMbSend) {
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
                if ($param["reverse_mail_status"][0]) {
                    $setProfileParam = "";
                    $setProfileParam["reverse_mail_status_count"] = "reverse_mail_status_count + 1";
                    $setProfileParam["update_datetime"] = "'" . date("YmdHis") . "'";
                    $userProfileWhere = "";
                    $userProfileWhere[] = "user_id = " . $val["user_id"];
                    $AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, "profile", false);
                }

                // 送信メルマガログの追加
                $mailMagaSendLog = "";
                $mailMagaSendLogList = $AdmMailMagazineOBJ->getMailMagaSendLogList($val["user_id"], "mailmagazine_log_id");
                $mailMagaSendLog["mailmagazine_log_id"] = $mailMagaId;
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
        $mailLog["interval_second"] = $param["interval_second"];
        $mailLog["from_address"] = $param["from_address"];
        $mailLog["from_name"] = $param["from_name"];
        $mailLog["mail_reserve_type"] = $param["mail_reserve_type"];
        $mailLog["pc_subject"] = $param["pc_title"];
        $mailLog["pc_text_body"] = $param["pc_text_contents"];
        $mailLog["pc_html_body"] = $param["pc_html_contents"];
        $mailLog["mb_subject"] = $param["mb_title"];
        $mailLog["mb_text_body"] = $param["mb_text_contents"];
        $mailLog["mb_html_body"] = $param["mb_html_contents"];
        $mailLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
        $mailLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
        $mailLog["send_err_count_mb"] = $sendCnt["notSendMbCnt"];
        $mailLog["send_err_count_pc"] = $sendCnt["notSendPcCnt"];
        $mailLog["err_count"] = $sendCnt["notSendNoRegCnt"];
        $mailLog["return_path"] = $return;
        $mailLog["peak_memory"] = memory_get_peak_usage();
        $mailLog["create_datetime"] = date("YmdHis");
        $mailLog["update_datetime"] = date("YmdHis");
        $mailLog["send_end_datetime"] = date("YmdHis");

        // 検索条件
        $mailLog["search_condition"] = serialize($value);

        // ログの書き込み
        $AdmMailMagazineOBJ->updateMailMagaLog($mailLog , array("id = " . $mailMagaId));
        // メール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLog($mailMagaId, "pc_image", false);
        // メール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLog($mailMagaId, "mb_image", true);
        // 完了画面に送るID
        $URLparam .= "&mail_maga_log_id=" . $mailMagaId;


    // 予約メルマガ
    } else if ($param["mail_reserve_type"] == AdmMailMagazine::MAILMAGAZINE_TYPE_TIMER) {

        $timerDatetime = $param["reserve_datetime_Date"] . " " . $param["reserve_datetime_Time"] . ":00";

        if (!ComValidation::isDatetime($timerDatetime)) {
            $errSessOBJ->errMsg = array("有効な日時を入力して下さい");
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // 予約メルマガ内容の追加
        $mailLog["from_address"] = $param["from_address"];
        $mailLog["from_name"] = $param["from_name"];
        $mailLog["search_sql"] = htmlspecialchars($AdmMailMagazineOBJ->getListSql(), ENT_QUOTES);
        $mailLog["pc_subject"] = $param["pc_title"];
        $mailLog["pc_text_body"] = $param["pc_text_contents"];
        $mailLog["pc_html_body"] = $param["pc_html_contents"];
        $mailLog["mb_subject"] = $param["mb_title"];
        $mailLog["mb_text_body"] = $param["mb_text_contents"];
        $mailLog["mb_html_body"] = $param["mb_html_contents"];
        $mailLog["reverse_mail_status"] = $param["reverse_mail_status"][0];
        $mailLog["send_datetime"] = $timerDatetime;
        $mailLog["send_plans_count"] = $userListCnt;
        $mailLog["create_datetime"] = date("YmdHis");

        // 検索条件
        $mailLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($value), "sql");

        // トランザクション開始
        $AdmMailMagazineOBJ->beginTransaction();

        // 書き込み
        if (!$AdmMailMagazineOBJ->insertMailMagaReserve($mailLog)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }
        $mailMagaReserveId = $AdmMailMagazineOBJ->getInsertId();

        // メール画像の追加
        if (!$AdmMailMagazineOBJ->insertMailImageReserve($mailMagaReserveId, "pc_image", false)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // メール画像の追加
        if (!$AdmMailMagazineOBJ->insertMailImageReserve($mailMagaReserveId, "mb_image", true)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }
        // コミット
        $AdmMailMagazineOBJ->commitTransaction();
        $execMsgSessOBJ->message = array("設定しました。");

    // 定期メルマガ
    } else if ($param["mail_reserve_type"] == AdmMailMagazine::MAILMAGAZINE_TYPE_REGULAR) {

        if ($param["send_condition_type"] > 0) {
            if ($param["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_DAY) {
                $sendTime = $param["send_time_day"] . ":00";
            } else if ($param["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_WEEK) {
                $sendTime = $param["send_time_week"] . ":00";
            } else if ($param["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_MONTH) {
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
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // 定期メルマガ内容の追加
        $mailLog["title"] = $param["title"];
        $mailLog["from_address"] = $param["from_address"];
        $mailLog["from_name"] = $param["from_name"];
        $mailLog["search_sql"] = htmlspecialchars($AdmMailMagazineOBJ->getListSql(), ENT_QUOTES);
        $mailLog["pc_subject"] = $param["pc_title"];
        $mailLog["pc_text_body"] = $param["pc_text_contents"];
        $mailLog["pc_html_body"] = $param["pc_html_contents"];
        $mailLog["mb_subject"] = $param["mb_title"];
        $mailLog["mb_text_body"] = $param["mb_text_contents"];
        $mailLog["mb_html_body"] = $param["mb_html_contents"];
        $mailLog["send_condition_type"] = $param["send_condition_type"];
        $mailLog["hour_from"] = $param["regular_hour_from"];
        $mailLog["hour_to"] = $param["regular_hour_to"];
        $mailLog["second"] = $param["regular_second"];
        $mailLog["week"] = $param["regular_week"];
        $mailLog["send_day"] = $param["send_day"];
        $mailLog["send_time"] = $sendTime;
        $mailLog["reverse_mail_status"] = $param["reverse_mail_status"][0];
        $mailLog["create_datetime"] = date("YmdHis");
        $mailLog["update_datetime"] = date("YmdHis");

        // 検索条件
        $mailLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($value), "sql");

        // トランザクション開始
        $AdmMailMagazineOBJ->beginTransaction();

        // 書き込み
        if (!$AdmMailMagazineOBJ->insertMailMagaRegular($mailLog)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }
        $mailMagaRegularId = $AdmMailMagazineOBJ->getInsertId();

        // メール画像の追加
        if (!$AdmMailMagazineOBJ->insertMailImageRegular($mailMagaRegularId, "pc_image", false)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // メール画像の追加
        if (!$AdmMailMagazineOBJ->insertMailImageRegular($mailMagaRegularId, "mb_image", true)) {
            $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
            // ロールバック
            $AdmMailMagazineOBJ->rollbackTransaction();
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // コミット
        $AdmMailMagazineOBJ->commitTransaction();
        $execMsgSessOBJ->message = array("設定しました。");

    // 予約TESTメルマガ（予約時、即メールサーバーに転送 ※cronで処理しない）
    } else if ($param["mail_reserve_type"] == 3) {

        //-------------------------
        // アップロード画像の取得
        //-------------------------

        $pcImageData = array();
        $pcImageType = array();
        for ($i = 1; $i <= count($_FILES["pc_image"]["tmp_name"]); $i++) {
            if ($_FILES["pc_image"]["tmp_name"][$i]) {
                $pcImageData[$i] = file_get_contents($_FILES["pc_image"]["tmp_name"][$i]);
                $imageAry = getimagesize($_FILES["pc_image"]["tmp_name"][$i]);
                $pcImageType[$i] = $imageAry["mime"];
            }
        }

        $mbImageData = array();
        $mbImageType = array();
        for ($i = 1; $i <= count($_FILES["mb_image"]["tmp_name"]); $i++) {
            if ($_FILES["mb_image"]["tmp_name"][$i]) {
                $mbImageData[$i] = file_get_contents($_FILES["mb_image"]["tmp_name"][$i]);
                $imageAry = getimagesize($_FILES["mb_image"]["tmp_name"][$i]);
                $mbImageType[$i] = $imageAry["mime"];
            }
        }

        $AdminUserOBJ = AdmUser::getInstance();

        //$second = 60 * (int)AdmMailMagazine::$_intervalSecond[$param["interval_second"]];  // インターバル指定
        // 予約日時をセット（形式→年/月/日 時:分:秒）
        $sendDateTime = $param["reserve_datetime_Date"] . " " . $param["reserve_datetime_Time"] . ":00";
        $normalComSendMagicDeliveryOBJ->makeSendStartDate($sendDateTime);
        $reverseComSendMagicDeliveryOBJ->makeSendStartDate($sendDateTime);

        // ログの書き込み
        $mailLog["send_start_datetime"] = date("YmdHis");
        $mailLog["create_datetime"]     = date("YmdHis");
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

        $fromAddressAry = explode("@",$param["from_address"]) ;
        $changeFromAddressFlag = FALSE ;
        if($_config["define"]["MAIL_DOMAIN"] == $fromAddressAry[1]){
            $changeFromAddressFlag = TRUE ;
        }

        $mailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
        end($mailDomainArray);//最後の要素
        $lastMailDomainKey = key($mailDomainArray);//最後の要素のキー

        // SMTP接続開始
        if(!$normalComSendMagicDeliveryOBJ->openSmtpConnect() || !$reverseComSendMagicDeliveryOBJ->openSmtpConnect()){
            $errSessOBJ->errMsg = array("接続エラーが発生しました。");
            header("Location: ./?action_mail_mailInput=1" . $URLparam);
            exit;
        }

        // 送信数
        $sendUserCount = 0;
        while (list($key, $val) = each($userList)) {

            // TEST
            /*
            mb_send_mail("norihisa_hosoda@gdmm.co.jp", "koko", $val["pc_address"], "info@ko-haito.com");
            if ($val["pc_address"] == "hirotoshi_mori@gdmm.co.jp") {
                mb_send_mail("norihisa_hosoda@gdmm.co.jp", "smtp", date("Y/m/d H:i:s", mktime(14,24,0,7,25,2011)), "info@ko-haito.com");
                $sendDateTime = date("Y/m/d H:i:s", mktime(14,24,0,7,25,2011));
            }
            if ($val["pc_address"] == "norihisa_hosoda@gdmm.co.jp") {
                mb_send_mail("norihisa_hosoda@gdmm.co.jp", "smtp", date("Y/m/d H:i:s", mktime(14,20,0,7,25,2011)), "info@ko-haito.com");
                $sendDateTime = date("Y/m/d H:i:s", mktime(14,20,0,7,25,2011));
            }
            $normalComSendMagicDeliveryOBJ->makeSendStartDate($sendDateTime);
            $reverseComSendMagicDeliveryOBJ->makeSendStartDate($sendDateTime);
            */
            // TEST


            // 送信数が1000件でSMTP切断→再接続
            if (($sendUserCount%1000) == 0) {
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

            $isPcSend = true;
            // pc送信
            if ($val["pc_address"] AND ($pcTextBody OR $pcHtmlBody)) {
                //配信ｱﾄﾞﾚｽ作成処理。pc_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $param["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]]){
                        $param["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["pc_mailmagazine_from_domain_id"]] ;
                    } else {
                        $param["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }
                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($value["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_status_or"])) AND $val["pc_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($value["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_send_status_or"])) AND $val["pc_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($value["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $value["is_mailmagazine_or"])) AND $val["pc_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isPcSend = false;
                    }
                }

                if ($isPcSend) {
                    $mailData = array(
                                        "to_address" => $val["pc_address"],
                                        "return_path" => $return,
                                        "from_address" => $param["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $pcSubject,
                                        "text_body" => $pcTextBody,
                                        "html_body" => $pcHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $pcImageData, $pcImageType);

                    if ($sendMailData) {
                        // 送信
                        try{
                            $sendResult = "";
                            if ($val["pc_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$param["reverse_mail_status"][0]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif (!$param["reverse_mail_status"][0]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($param["reverse_mail_status"][0]) {
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
                            $debugMail["subject"] = "通常メルマガ送信エラー";
                            $debugMail["text_body"][] = "file:" . __FILE__;
                            $debugMail["text_body"][] = "line:" . __LINE__;
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

                    if ($isPcSend) {
                        $sendCnt["sendPcCnt"]++;
                        //100件毎に送信数を更新
                        if (($sendCnt["sendPcCnt"]%100)==0) {
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
                //配信ｱﾄﾞﾚｽ作成処理。mb_mailmagazine_from_domain_idｶﾗﾑのﾃﾞｰﾀを元に、配信ドメインを決定。
                if($changeFromAddressFlag){
                    $param["from_address"] = "" ;
                    $sendMailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
                    //$sendMailDomainArray配列から万が一、値を引っ張ってこれなかったらを考え、一応のif文
                    if($sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]]){
                        $param["from_address"] = $fromAddressAry[0]."@".$sendMailDomainArray[$val["mb_mailmagazine_from_domain_id"]] ;
                    } else {
                        $param["from_address"] = $fromAddressAry[0]."@".$_config["define"]["MAIL_DOMAIN"] ;
                    }
                }
                // OR検索用管理ｱﾄﾞﾚｽｽﾃ-ﾀｽ
                if ($value["is_address_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_status_or"])) AND $val["mb_address_status"] != $_config["define"]["ADDRESS_STATUS_DO"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用管理メアド送信ステータス
                if ($value["is_address_send_status_or"]) {
                    if (is_numeric(array_search("1", $value["is_address_send_status_or"])) AND $val["mb_send_status"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }
                // OR検索用メアド配信ステータス
                if ($value["is_mailmagazine_or"]) {
                    if (is_numeric(array_search("1", $value["is_mailmagazine_or"])) AND $val["mb_is_mailmagazine"] == $_config["define"]["ADDRESS_SEND_STATUS_FAIL"]) {
                        $isMbSend = false;
                    }
                }

                if ($isMbSend) {
                    $mailData = array(
                                        "to_address" => $val["mb_address"],
                                        "return_path" => $return,
                                        "from_address" => $param["from_address"],
                                        "from_name" => $fromName,
                                        "subject" => $mbSubject,
                                        "text_body" => $mbTextBody,
                                        "html_body" => $mbHtmlBody,
                                        );
                    $mailElements = $AdmMailMagazineOBJ->convertMailElements($mailData, $val["user_id"], $convertAry);

                    $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $second, $pcImageData, $pcImageType);

                    if ($sendMailData) {
                        // 送信
                        try{
                            $sendResult = "";
                            if ($val["mb_mailmagazine_from_domain_id"] >= $lastMailDomainKey and !$param["reverse_mail_status"][0]){
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif (!$param["reverse_mail_status"][0]) {
                                // 通常
                                $sendResult = $normalComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);
                            } elseif ($param["reverse_mail_status"][0]) {
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
                            $debugMail["subject"] = "通常メルマガ送信エラー";
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

                    if ($isMbSend) {
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
                if ($param["reverse_mail_status"][0]) {
                    $setProfileParam = "";
                    $setProfileParam["reverse_mail_status_count"] = "reverse_mail_status_count + 1";
                    $setProfileParam["update_datetime"] = "'" . date("YmdHis") . "'";
                    $userProfileWhere = "";
                    $userProfileWhere[] = "user_id = " . $val["user_id"];
                    $AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, "profile", false);
                }

                // 送信メルマガログの追加
                $mailMagaSendLog = "";
                $mailMagaSendLogList = $AdmMailMagazineOBJ->getMailMagaSendLogList($val["user_id"], "mailmagazine_log_id");
                $mailMagaSendLog["mailmagazine_log_id"] = $mailMagaId;
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
        $mailLog["interval_second"] = $param["interval_second"];
        $mailLog["from_address"] = $param["from_address"];
        $mailLog["from_name"] = $param["from_name"];
        $mailLog["mail_reserve_type"] = $param["mail_reserve_type"];
        $mailLog["pc_subject"] = $param["pc_title"];
        $mailLog["pc_text_body"] = $param["pc_text_contents"];
        $mailLog["pc_html_body"] = $param["pc_html_contents"];
        $mailLog["mb_subject"] = $param["mb_title"];
        $mailLog["mb_text_body"] = $param["mb_text_contents"];
        $mailLog["mb_html_body"] = $param["mb_html_contents"];
        $mailLog["send_total_count_mb"] = $sendCnt["sendMbCnt"];
        $mailLog["send_total_count_pc"] = $sendCnt["sendPcCnt"];
        $mailLog["send_err_count_mb"] = $sendCnt["notSendMbCnt"];
        $mailLog["send_err_count_pc"] = $sendCnt["notSendPcCnt"];
        $mailLog["err_count"] = $sendCnt["notSendNoRegCnt"];
        $mailLog["return_path"] = $return;
        $mailLog["peak_memory"] = memory_get_peak_usage();
        $mailLog["create_datetime"] = date("YmdHis");
        $mailLog["update_datetime"] = date("YmdHis");
        $mailLog["send_end_datetime"] = date("YmdHis");

        // 検索条件
        $mailLog["search_condition"] = serialize($value);

        // ログの書き込み
        $AdmMailMagazineOBJ->updateMailMagaLog($mailLog , array("id = " . $mailMagaId));
        // メール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLog($mailMagaId, "pc_image", false);
        // メール画像ログの書き込み
        $AdmMailMagazineOBJ->insertMailImageLog($mailMagaId, "mb_image", true);
        // 完了画面に送るID
        $URLparam .= "&mail_maga_log_id=" . $mailMagaId;
    }
} catch (Exception $e) {
    $errSessOBJ->errMsg = array($e->getMessage());
    header("Location: ./?action_mail_mailInput=1" . $URLparam);
    exit;
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_mail_MailSendEnd=1" . $URLparam);
exit;
?>