<?php
/**
 * SendMail.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * メルマガデータの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class SendMail extends ComCommon {

    const RETURN_PATH = "bounce@mail.";
    const OPERATION_MAIL_ACCOUNT = "info@"; // 運営メールアカウント

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string 検索条件内容 */
    private $_contents = null;

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * getInstanceメソッド
     *
     * このクラスのオブジェクトを生成する。
     * 既に生成されていたら、前回と同じものを返す。
     *
     * @return object $instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * メールサーバIPの設定
     *
     * @param  integer $id メルマガID
     * @return arrat メルマガ画像ログリスト、失敗ならfalse
     */
    public function setMailServerIp($mailServerIp) {

        $this->_mailServerIp = $mailServerIp;
        return TRUE;
    }


    /**
     * mailToメソッド
     *
     * メール送信実行
     *
     * @param array   $$mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function mailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {
        if (!isset($mailElements["to_address"]) || !isset($mailElements)) {
            return FALSE;
        }

        if (!$this->_mailServerIp) {
            $this->_mailServerIp = $this->_configOBJ->common_config->mail_server_ip->sendMagic;
        }

        $mailServer = "http://" . $this->_mailServerIp . "/maildelivery.php";

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        $sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = $mailElements["to_address"];
        $postdata["to_nm"] = $mailElements["to_name"];
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = $mailElements["from_address"];
        $postdata["from_nm"] = $mailElements["from_name"];
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $sendHtmlBody;
        $postdata["sec"] = $sec;

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata["image"][] = base64_encode($image);
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata["image_type"][] = $type;
            }
        }

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        $ComHttpOBJ = new ComHttp($mailServer, $httpParam);
        $ComHttpOBJ->setParameterPost($postdata);
        $result = $ComHttpOBJ->request("POST");

        if ($result->isSuccessful()) {
            return true;
        } else {
            return false;
        }
/*
        // curl送信
        //送信用にエンコード
        $sendSubject = urlencode($mailElements["subject"]);
        $sendTextBody = urlencode(htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES));
        $sendHtmlBody = urlencode(base64_encode($mailElements["html_body"]));

        // 送信項目の設定
        $postdata = "to=" . $mailElements["to_address"]
                  . "&to_nm=" . $mailElements["to_name"]
                  . "&rtn_path=" . ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN)
                  . "&from=" . $mailElements["from_address"]
                  . "&from_nm=" . $mailElements["from_name"]
                  . "&sbj=" . $sendSubject
                  . "&body=" . $sendTextBody
                  . "&html=" . $sendHtmlBody
                  . "&sec=" . $sec;

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata .= "&image[]=" . urlencode(base64_encode($image));
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata .= "&image_type[]=".urlencode($type);
            }
        }

        $curlOpt = " -d '$postdata' --connect-timeout 3600 -m 3 $mailServer";
        $curlResult = exec("/usr/bin/curl $curlOpt ");

        return true;
*/
    }

    /**
     * smtpMailToメソッド(SMTP)
     *
     * メール送信実行
     *
     * @param array   $$mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function smtpMailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {

        if (!isset($mailElements["to_address"]) || !isset($mailElements)) {
            return FALSE;
        }

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = $mailElements["to_address"];
        //$postdata["to_nm"] = $mailElements["to_name"];
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = $mailElements["from_address"];
        $postdata["from_nm"] = $mailElements["from_name"];
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $mailElements["html_body"];
        $postdata["sec"] = $sec;

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata["image"][] = $image;
                //$postdata["image"][] = base64_encode($image);
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata["image_type"][] = $type;
            }
        }

        // リメール用インスタンス生成
        $sendMailComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

        if (!$this->_mailServerIp) {
            // 無ければメールサーバーは通常SendMagic
            $this->_mailServerIp = $this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic;
        }

        // SMTPホスト設定
        $sendMailComSendMagicDeliveryOBJ->setSendMailServerIp($this->_mailServerIp);

        // SMTP接続開始
        if (!$sendMailComSendMagicDeliveryOBJ->openSmtpConnect()) {
            return false;
        }

        // 送信メールデータ生成
        $sendMailData = $postdata;

        if ($sendMailData) {
            // 送信
            try{
                // リメール送信
                if (!$sendMailComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                    // SMTP切断
                    $sendMailComSendMagicDeliveryOBJ->closeSmtpConnect();
                    return false;
                }
            } catch (Zend_Exception $e) {

                $requestOBJ = ComRequest::getInstance();
                $actionName = $requestOBJ->getActionName();

                // 送れたものとして判断
                // デバッグメール
                $debugMail = "";
                $debugMail["subject"] = "リメール送信エラー";
                $debugMail["text_body"][] = "file:" . __FILE__;
                $debugMail["text_body"][] = "line:" . __LINE__;
                $debugMail["text_body"][] = "err:" . $e->getMessage();
                $debugMail["text_body"][] = "action_file_name:" . $actionName;
                $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                // システムにエラーメール
                $this->debugSmtpMailTo($debugMail);

                // SMTP切断
                $sendMailComSendMagicDeliveryOBJ->closeSmtpConnect();
                return false;
            }
        } else {
            // SMTP切断
            $sendMailComSendMagicDeliveryOBJ->closeSmtpConnect();
            return false;
        }

        /*
        // 以下、デバッグメール ※当分の間残しといて下さい!!
        $requestOBJ = ComRequest::getInstance();
        $actionName = $requestOBJ->getActionName();
        $testMail = "";
        $sendMailData = "";
        $testMail["subject"] = "TESTリメール送信";
        $testMail["text_body"][] = "file:" . __FILE__;
        $testMail["text_body"][] = "line:" . __LINE__;
        $testMail["text_body"][] = "action_file_name:" . $actionName;
        $testMail["text_body"][] = "result:OK";
        $testMail["text_body"] = implode("\n", $testMail["text_body"]);
        $sendMailData = print_r($testMail, true);
        // 指定アドレスに送信
        mb_send_mail("norihisa_hosoda@gdmm.co.jp", "smtp_remail_test", $sendMailData, "");
        */

        // SMTP切断
        $sendMailComSendMagicDeliveryOBJ->closeSmtpConnect();

        return $postdata;
    }

    /**
     * convertMailElementsメソッド
     *
     * メールタイトル、文言、HTML等の％変換処理を実施
     *
     * @param array   $contents   メールコンテンツ
     * @param integer $userId     送信相手のUserテーブルID
     * @param array   $convertAry %変換用配列(個別処理用)
     * @return array 変換済みメール要素配列
     */
    public function convertMailElements($elements, $userId = "", $convertAry = "") {
        if (!isset($elements)) {
            return FALSE;
        }

        $KeyConvertOBJ = KeyConvert::getInstance();
        // 変換処理
        $elements["from_address"] = $KeyConvertOBJ->execConvert($elements["from_address"], $userId, $convertAry);
        $elements["from_name"]    = $KeyConvertOBJ->execConvert($elements["from_name"], $userId, $convertAry);
        $elements["subject"]      = $KeyConvertOBJ->execConvert($elements["subject"], $userId, $convertAry);
        $elements["text_body"]    = str_replace("<br>", "\n", $KeyConvertOBJ->execConvert($elements["text_body"], $userId, $convertAry));
        $elements["html_body"]    = $KeyConvertOBJ->execConvert($elements["html_body"], $userId, $convertAry);
        $elements["return_path"]  = $KeyConvertOBJ->execConvert($elements["return_path"], $userId, $convertAry);

        return $elements;
    }

    /**
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * debugMailToメソッド
     *
     * デバッグメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
     /*
    public function debugMailTo ($mailElements, $sec = 0) {
        if (!isset($mailElements)) {
            return FALSE;
        }

        $this->_mailServerIp = $this->_configOBJ->common_config->mail_server_ip->sendMagic;

        $mailServer = "http://" . $this->_mailServerIp . "/maildelivery.php";

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        $sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = "ml_sys_com_portal@ichi5.asia";
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = "root@" . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["from_nm"] = $this->_configOBJ->define->SITE_NAME;
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $sendHtmlBody;
        $postdata["sec"] = $sec;

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        $ComHttpOBJ = new ComHttp($mailServer, $httpParam);
        $ComHttpOBJ->setParameterPost($postdata);
        $result = $ComHttpOBJ->request("POST");

        if ($result->isSuccessful()) {
            return true;
        } else {
            return false;
        }
    }
    */

    /**
     * operationMailToメソッド
     *
     * 運営へメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
     /*
    public function operationMailTo ($mailElements, $sec = 0) {
        if (!isset($mailElements)) {
            return FALSE;
        }

        $this->_mailServerIp = $this->_configOBJ->common_config->mail_server_ip->sendMagic;

        $mailServer = "http://" . $this->_mailServerIp . "/maildelivery.php";

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        $sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = self::OPERATION_MAIL_ACCOUNT . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = "root@" . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["from_nm"] = $this->_configOBJ->define->SITE_NAME;
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $sendHtmlBody;
        $postdata["sec"] = $sec;

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        $ComHttpOBJ = new ComHttp($mailServer, $httpParam);
        $ComHttpOBJ->setParameterPost($postdata);
        $result = $ComHttpOBJ->request("POST");

        if ($result->isSuccessful()) {
            return true;
        } else {
            return false;
        }
    }
    */

    /**
     * debugMailToメソッド(SMTP)
     *
     * デバッグメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function debugMailTo ($mailElements, $sec = 0) {

        if (!isset($mailElements)) {
            return FALSE;
        }

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = "ml_sys_com_portal@ichi5.asia";
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = "root@" . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["from_nm"] = $this->_configOBJ->define->SITE_NAME;
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $mailElements["html_body"];
        $postdata["sec"] = $sec;

        // リメール用インスタンス生成
        $debugMailComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

        // SMTPホスト設定(SendMagic)
        $debugMailComSendMagicDeliveryOBJ->setSendMailServerIp($this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic);

        // SMTP接続開始
        if (!$debugMailComSendMagicDeliveryOBJ->openSmtpConnect()) {
            return false;
        }

        // 送信メールデータ生成
        $sendMailData = $postdata;

        $smtpSendResult = true;
        if ($sendMailData) {
            // リメール送信
            if (!$debugMailComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                $smtpSendResult = false;
            }
        } else {
            $smtpSendResult = false;
        }

        // SMTP切断
        $debugMailComSendMagicDeliveryOBJ->closeSmtpConnect();

        return $smtpSendResult;
    }

    /**
     * operationMailToメソッド(SMTP)
     *
     * 運営へメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function operationMailTo ($mailElements, $sec = 0) {

        if (!isset($mailElements)) {
            return FALSE;
        }

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = self::OPERATION_MAIL_ACCOUNT . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = "root@" . $this->_configOBJ->define->MAIL_DOMAIN;
        $postdata["from_nm"] = $this->_configOBJ->define->SITE_NAME;
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $mailElements["html_body"];
        $postdata["sec"] = $sec;

        // リメール用インスタンス生成
        $operationMailComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

        // SMTPホスト設定(SendMagic)
        $operationMailComSendMagicDeliveryOBJ->setSendMailServerIp($this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic);

        // SMTP接続開始
        if(!$operationMailComSendMagicDeliveryOBJ->openSmtpConnect()){
            return false;
        }

        // 送信メールデータ生成
        $sendMailData = $postdata;

        $smtpSendResult = true;
        if ($sendMailData) {
            // リメール送信
            if (!$operationMailComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                $smtpSendResult = false;
            }
        } else {
            $smtpSendResult = false;
        }

        // SMTP切断
        $operationMailComSendMagicDeliveryOBJ->closeSmtpConnect();

        return $smtpSendResult;
    }

}
?>
