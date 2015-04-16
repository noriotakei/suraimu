<?php

/**
 * ComSendMagicDelivery.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * sendmagic配信用クラス
 * 20131122 sendmagic→自社カエデにMTA切り替え
 * 処理内容はほぼ同一なのでリネームせずにそのまま流用しています
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */

class ComSendMagicDelivery extends SendMagic_ComSendMagicMail{

    //const SMTP_HOST = "122.202.21.33";
    //const SMTP_HOST = "127.0.0.1";
    //const SMTP_SEND_SINGLE = 1; // 1接続→1送信
    //const SMTP_SEND_MULTI = 2; // 1接続→複数送信

    /** @var インスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /** @var string メールサーバIP */
    private $_smtpMailServerIp = null;

    /** @var object Configオブジェクト */
    protected $_configOBJ = null;

    /** @var object SMTP接続リトライ回数 */
    protected $_retrySmtpConnCnt = 3; // 適当

    /** @var object SMTP接続リトライ間隔(秒) */
    protected $_retrySmtpInterval = 10; // 適当

    /** @var object 予約送信日時(秒) */
    protected $_mailSendStartDate = 0;

    /** @var SMTP送信フラグ(TRUE:複数 FALSE：単一) */
    //protected $_smtpSendType = null;

    /**
     *  コンストラクタ
     */
    public function __construct() {
        parent::__construct();
        // 設定データのインスタンスを取得
        $this->_configOBJ = ComConfig::getInstance();

        // デフォルトは1接続1送信
        /*
        if (!$this->_smtpSendType) {
            $this->_smtpSendType = self::SMTP_SEND_SINGLE;
        }
        */
    }

    /**
     *  getInstanceメソッド
     *
     *  このクラスのオブジェクトを生成する。
     *  既に生成されていたら、前回と同じものを返す。
     *
     *  @return object  $instance
     */
    public static function getInstance() {
        if (!self::$instance) {
            $className = __CLASS__;
            self::$instance = new $className();
        }
        return self::$instance;
    }

    /**
     * 文字列の整形をする。
     *
     *
     * @param  string $value
     *
     * @return string $value
     */
    public function plasticStrings($value) {
        // smtpでqmailに送る場合はLFだけでは送信できない
        // LFをCRLFに変換する
        //$value = preg_replace("/\r?\n/", "\r\n", $value);
        $value = preg_replace("/\n/", "\r\n", $value);
        return $value;
    }

    /**
     * 配信時間調整をする。
     *
     *
     * @param  integer $sec 秒
     *
     * @return integer $sec
     */
    public function makeSendStart($sec) {
        // 現在のUnix タイムスタンプ(GMT)
        $now = time();
        if (!$sec) {
            return $now;
        }
        if ($now_odd = ($now % $sec)) {
            // Unix タイムスタンプ(GMT)をジャストに調整
            $now = $now - $now_odd;
        }
        return $now + $sec;
    }

    /**
     * 配信日時を設定
     *
     *
     * @param  integer $date 日時
     *
     * @return integer $sec
     */
    public function makeSendStartDate($sendDateTime) {
        // 日時をUnix タイムスタンプに変換
        $sec = strtotime($sendDateTime);
        $this->_mailSendStartDate = $sec;
        return TRUE;
    }

    /**
     * メールサーバーIPをセットする。
     *
     * @param  string $mailServerIp メールサーバーIP
     *
     * @return boolean
     */
    public function setSendMailServerIp($mailServerIp = null) {
        $this->_smtpMailServerIp = $mailServerIp;
        return TRUE;
    }

    /**
     * SMTP接続を開始する。
     *
     * @param
     *
     * @return boolean
     */
    public function openSmtpConnect() {
        // 未接続なら接続処理
        if (!$this->smtp_conn) {
            $mailServerIpAry = array();
            // IPが空ならデフォルトセット
            if (!$this->_smtpMailServerIp) {
                // デフォルト(通常)
                $this->setSendMailServerIp($this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic);
            }

            // ホストとポートに分ける
            $mailServerIpAry = explode(":", $this->_smtpMailServerIp);

            // host
            $host = $mailServerIpAry[0];
            // port
            $port = $mailServerIpAry[1];

            // 接続先をセット
            $this->setSmtpHost($host, (int)$port);

            // 接続
            try{
                // 接続出来なければ、リトライ(指定秒間隔)
                for ($cnt=0;$cnt<$this->_retrySmtpConnCnt;$cnt++) {
                    // 接続確立
                    if ($this->_openSmtpConn()) {
                        break;
                    }
                    // 10秒インターバル
                    sleep($this->_retrySmtpInterval);
                }
                // それもダメならさよなら。
                if (!$this->getSmtpConnect()) {
                    return false;
                }

                // 接続後、最初に必要なSMTPコマンドをここでやっちゃおう!!
                if (!$this->_sendSmtpCommand("helo ". $this->smtp_host, array(220, 250, 354))) {
                    return false;
                }
            } catch (Zend_Exception $e) {
                // デバッグメール
                $SendMailOBJ = SendMail::getInstance();
                $debugMail = "";
                $debugMail["subject"] = "SMTP接続エラー";
                $debugMail["text_body"][] = "file:" . __FILE__ ;
                $debugMail["text_body"][] = "line:" . __LINE__ ;
                $debugMail["text_body"][] = "err:" . $e->getMessage();
                $debugMail["text_body"][] = "server_ip:" . $this->_smtpMailServerIp;
                $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($debugMail);
            }
        }
        return true;
    }

    /**
     * SMTP接続を切断する。
     *
     * @param
     *
     * @return boolean
     */
    public function closeSmtpConnect() {
        // 接続中なら切断
        if ($this->getSmtpConnect()) {
            $this->_closeSmtpConn();
        }
    }

    /**
     * SMTP接続の確認をする。
     *
     * @param
     *
     * @return boolean 接続中：TRUE 未接続：FALSE
     */
    public function getSmtpConnect() {
        if (!$this->smtp_conn) {
            return false;
        }
        return true;
    }

    /**
     * SMTPメール送信タイプを設定する。
     *
     * @param $type TRUE：複数 FALSE：単一
     *
     * @return boolean
     */
    public function setSmtpSendType($type) {
        $this->_smtpSendType = $type;
        return true;
    }

    /**
     * SMTP接続リトライ
     *
     * @param $type TRUE：複数 FALSE：単一
     *
     * @return boolean
     */
    public function retryOpenSmtpConnect() {
        if ($this->getSmtpConnect()) {
            // 接続中であれば切断
            $this->closeSmtpConnect();
        }
        // 接続
        if (!$this->openSmtpConnect()) {
            return false;
        }

        return true;
    }

    /**
     * sendMagicで送信する。
     *
     * @param  array $mailElemnts メールデータ配列
     *
     * @return boolean
     */
    public function sendMagicDelivery($mailElemnts) {

        if (!is_array($mailElemnts)) {
            return false;
        }

        // 整形
        $mailElemnts['sec']    = (int)$this->plasticStrings($mailElemnts['sec']);
        $mailElemnts['ts'] = (int)$this->plasticStrings($mailElemnts['ts']);
        $mailElemnts['from']      = $this->plasticStrings($mailElemnts['from']);
        $mailElemnts['from_nm']   = $this->plasticStrings($mailElemnts['from_nm']);
        $mailElemnts['rtn_path']  = $this->plasticStrings($mailElemnts['rtn_path']);
        $mailElemnts['rep_to']    = $this->plasticStrings($mailElemnts['rep_to']);
        $mailElemnts['to']        = $this->plasticStrings($mailElemnts['to']);
        //$mailElemnts['to_nm']     = $this->plasticStrings($mailElemnts['to_nm']);
        $mailElemnts['sbj']       = $this->plasticStrings($mailElemnts['sbj']);
        $mailElemnts['body']      = $this->plasticStrings($mailElemnts['body']);
        $mailElemnts['html']      = $this->plasticStrings($mailElemnts['html']);

        if (!$mailElemnts['from']) {
            return false;
        }

        // First, clear all vars
        $this->mail_subject = "";
        $this->mail_from = "";
        $this->mail_to = "";
        $this->mail_cc = "";
        $this->mail_bcc = "";
        $this->mail_text = "";
        $this->mail_html = "";
        $this->mail_header = "";
        $this->mail_body = "";
        $this->mail_reply_to = "";
        $this->mail_return_path = "";
        $this->attachments_index = 0;
        $this->sended_index = 0;

        // Clear Array Vars
        $this->attachments = array();
        $this->attachments_img = array();

        // 配信時間指定
        if ($mailElemnts['ts']) {
            $sendStart = $mailElemnts['ts'];
        } elseif ($this->_mailSendStartDate) {
            $sendStart = $this->_mailSendStartDate;
        } else {
            $sendStart = $this->makeSendStart($mailElemnts['sec']);
        }

        $this->setSendStart($sendStart);

        $ComUtilityOBJ = ComUtility::getInstance();

        $deviceCd    = $ComUtilityOBJ->getDeviceFromMailAddress($mailElemnts['to']);
        if ($deviceCd == $this->_configOBJ->define->DEVICE_OTHER) {
            // PCはJIS
            $this->setCharset("ISO-2022-JP");
        } else {
            // モバイルは絵文字対応のためShift_JIS
            $this->setCharset("Shift_JIS");
        }

        $this->setFrom($mailElemnts['from'], $mailElemnts['from_nm']);
        $this->setTo($mailElemnts['to'], $mailElemnts['to_nm']);
        $this->setReturnPath($mailElemnts['rtn_path']);
        if ($mailElemnts['rep_to']) {
            $this->setReplyTo($mailElemnts['rep_to']);
        }
        $this->setSubject($mailElemnts['sbj']);
        $this->setText($mailElemnts['body']);
        $this->setHtml($mailElemnts['html']);

        if ($mailElemnts['image'] && $mailElemnts['image_type']) {
            $count = count($mailElemnts['image']);
            for ($i=0; $i<$count; $i++) {
                $image = $mailElemnts['image'][$i];                // imageデータ
                $type  = $mailElemnts['image_type'][$i];                          // imageタイプ
                $cid   = str_pad(($i + 1), 3, "0", STR_PAD_LEFT);   // Content-ID : 00*形式
                if (preg_match("/\//", $type)) {
                    $type = substr(strrchr($type, "/"), 1);
                }
                $ext   = str_replace("jpeg", "jpg", $type);         // 拡張子(jpegのみjpgへ変換)

                $name  = $cid.".".$ext;
                $this->addContentAttachment($image, $name);
            }
        }

        // smtpHost指定(デフォルトは通常=>SendMagic)
        if (empty($this->smtp_host) && empty($this->smtp_port)) {
        //if (empty($this->openSmtpConnect())) {
            $mailServerIp = $this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic;
            // IPセット
            $this->setSendMailServerIp($mailServerIp);

            // 接続
            if (!$this->openSmtpConnect()) {
                return false;
            }
        }

        // 送信
        if ($this->send()) {
            return true;
        } else {
            return false;
        }

    }
}
?>