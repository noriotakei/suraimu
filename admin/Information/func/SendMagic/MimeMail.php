<?php
/* **********************************************************************
 *
 * Copyright (C) 2003 - 2007 Alejandro Garcia Gonzalez.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * **********************************************************************
 *
 *  Class:          Nomad MIME Mail ('nxs_mimemail.inc.php')
 *  Version:        1.4
 *  Site:           http://www.developarts.com
 *  Author:         Alejandro Garcia Gonzalez <nexus@developarts.com>
 *
 * Contributors:    Pawel Tomicki <p.tomicki@digitalone.pl>
 *                  Enrique Garcia M. <egarcia@egm.as>
 *                  Ulises Hernandez <megazoidz@gmail.com>
 *
 * Description:
 * A class for sending MIME based e-mail messages.
 *
 * + Plain Text
 * + HTML
 * + Plain Text with Attachments
 * + HTML with Attachments
 * + HTML with Embedded Images
 * + HTML with Embedded Images and Attachments
 * + Send email messages via SMTP and Auth SMTP
 *
 * ********************************************************************** */

class MimeMail {

    const QMAIL_PATH = "/usr/local/qmail/bin/qmail-inject";

    /** @var インスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /**
     * Vars
     */
    private $debug_status        = "yes";            // "yes" | "no" | "halt"
    protected $charset           = "iso-2022-jp";
    protected $transfer_encoding = "7bit";
    protected $mail_subject      = "件名なし";
    protected $mail_from         = "";
    protected $mail_to;
    protected $mail_cc;
    protected $mail_bcc;
    protected $mail_text;
    protected $mail_html;
    protected $mail_type;
    protected $mail_header;
    protected $mail_body;
    protected $mail_reply_to;
    protected $mail_return_path;
    protected $attachments_index;
    protected $attachments = array();
    protected $attachments_img = array();
    protected $boundary_mix;
    protected $boundary_rel;
    protected $boundary_alt;
    protected $sended_index;
    protected $smtp_conn;
    protected $smtp_host;
    protected $smtp_port;
    protected $smtp_user;
    protected $smtp_pass;
    protected $smtp_log = false;
    protected $smtp_msg;

    private $error_msg = array(
        1   =>  'Mail was not sent',
        2   =>  'Body Build Incomplete',
        3   =>  'Need a mail recipient in mail_to',
        4   =>  'No valid Email Address: ',
        5   =>  'Could not Open File',
        6   =>  'Could not connect to SMTP server.',
        7   =>  'Unespected SMTP answer: '
    );

    protected $mime_types = array(
        'gif'   => 'image/gif',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'jpe'   => 'image/jpeg',
        'bmp'   => 'image/bmp',
        'png'   => 'image/png',
        'tif'   => 'image/tiff',
        'tiff'  => 'image/tiff',
        'swf'   => 'application/x-shockwave-flash',
        'doc'   => 'application/msword',
        'xls'   => 'application/vnd.ms-excel',
        'ppt'   => 'application/vnd.ms-powerpoint',
        'pdf'   => 'application/pdf',
        'ps'    => 'application/postscript',
        'eps'   => 'application/postscript',
        'rtf'   => 'application/rtf',
        'bz2'   => 'application/x-bzip2',
        'gz'    => 'application/x-gzip',
        'tgz'   => 'application/x-gzip',
        'tar'   => 'application/x-tar',
        'zip'   => 'application/zip',
        'html'  => 'text/html',
        'htm'   => 'text/html',
        'txt'   => 'text/plain',
        'css'   => 'text/css',
        'js'    => 'text/javascript'
    );

    /**
     * Constructor
     * void __condtruct()
     */
    public function __construct(){
        $this->boundary_mix         = "=-nxs_mix_" . md5(uniqid(rand()));
        $this->boundary_rel         = "=-nxs_rel_" . md5(uniqid(rand()));
        $this->boundary_alt         = "=-nxs_alt_" . md5(uniqid(rand()));
        $this->attachments_index    = 0;
        $this->sended_index         = 0;
        if(!defined('BR')){
            define('BR', "\r\n", TRUE);
        }
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
     * void setCharset(string charset)
     * @access public
     * @param string charset str character set
     * @return void
     */
    public function setCharset($charset) {
        $this->charset = $charset;

        switch(strtolower($this->charset)) {
            case "shift_jis":
                $this->setTransferEncoding("8bit");
                break;
            case "iso-2022-jp":
            default:
                $this->setTransferEncoding("7bit");
                break;
        }
    }

    /**
     * void setTransferEncoding(string transfer_encoding)
     * @access public
     * @param string transfer_encoding str transfer_encoding set
     * @return void
     */
    public function setTransferEncoding($transfer_encoding) {
        $this->transfer_encoding = $transfer_encoding;
    }

    /**
     * void setFrom(string mail_from, [string name])
     * Set the "from" email address. "info@domain" by default
     * @access public
     * @param string mail_from The email from address
     * @param string name Optional name contact
     * @return void
     */
    public function setFrom($mail_from, $name = ""){
        if ($this->_validateMail($mail_from)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->mail_from = "$name <$mail_from>";
            } else {
                $this->mail_from = $mail_from;
            }
        } else {
            $this->_debug(4, $mail_from);
        }
    }

    /**
     * bool setTo(string mail_to, [string name])
     * Set the recipient email address
     * @access public
     * @param string mail_to The recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function setTo($mail_to, $name = ""){
        if ($this->_validateMail($mail_to)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->mail_to = "$name <$mail_to>";
            } else {
                $this->mail_to = $mail_to;
            }
            return true;
        }
        return false;
    }

    /**
     * bool setCc(string mail_cc, [string name])
     * Set the carbon copy recipient email address
     * @access public
     * @param string mail_cc The carbon copy recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function setCc($mail_cc, $name = ""){
        if ($this->_validateMail($mail_cc)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->mail_cc = "$name <$mail_cc>";
            } else {
                $this->mail_cc = $mail_cc;
            }
            return true;
        }
        return false;
    }

    /**
     * bool setBcc(string mail_bcc, [string name])
     * Set the blind carbon copy recipient email address
     * @access public
     * @param string mail_bcc The blind carbon copy recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function setBcc($mail_bcc, $name = ""){
        if ($this->_validateMail($mail_bcc)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->mail_bcc = "$name <$mail_bcc>";
            } else {
                $this->mail_bcc = $mail_bcc;
            }
            return true;
        }
        return false;
    }

    /**
     * bool setReplyTo(string mail_reply_to, [string name])
     * Set the reply email address. If this var is not set, the reply mail are the "from" email address
     * @access public
     * @param string mail_reply_to The reply email address
     * @param string name Optional name contact
     * @return bool
     */
    public function setReplyTo($mail_reply_to, $name = ""){
        if ($this->_validateMail($mail_reply_to)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->mail_reply_to = "$name <$mail_reply_to>";
            } else {
                $this->mail_reply_to = $mail_reply_to;
            }
            return true;
        }
        return false;
    }

    /**
     * bool addTo(string mail_to, [string name])
     * Set or add a new recipient email address
     * @access public
     * @param string mail_to The recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function addTo($mail_to, $name = ""){
        if ($this->_validateMail($mail_to)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $mail_to = "$name <$mail_to>";
            }
            $this->mail_to = !empty($this->mail_to) ? $this->mail_to . ", " . $mail_to : $mail_to;
            return true;
        }
        return false;
    }

    /**
     * bool addCc(string mail_cc, [string name])
     * Set or add a new carbon copy recipient email address
     * @access public
     * @param string mail_cc The carbon copy recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function addCc($mail_cc, $name = ""){
        if ($this->_validateMail($mail_cc)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $mail_cc = "$name <$mail_cc>";
            }
            $this->mail_cc = !empty($this->mail_cc) ? $this->mail_cc . ", " . $mail_cc : $mail_cc;
            return true;
        }
        return false;
    }

    /**
     * bool addBcc(string mail_bcc, [string name])
     * Set or add a new blind carbon copy recipient email address
     * @access public
     * @param string mail_bcc The blind carbon copy recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function addBcc($mail_bcc, $name = ""){
        if ($this->_validateMail($mail_bcc)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $mail_bcc = "$name <$mail_bcc>";
            }
            $this->mail_bcc = !empty($this->mail_bcc) ? $this->mail_bcc . ", " . $mail_bcc : $mail_bcc;
            return true;
        }
        return false;
    }

    /**
     * bool addReplyTo(string mail_reply_to, [string name])
     * Set or add a new reply email address. If this var is not set, the reply mail are the "from" email address
     * @access public
     * @param string mail_reply_to The reply email address
     * @param string name Optional name contact
     * @return bool
     */
    public function addReplyTo($mail_reply_to, $name = ""){
        if ($this->_validateMail($mail_reply_to)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $mail_reply_to = "$name <$mail_reply_to>";
            }
            $this->mail_reply_to = !empty($this->mail_reply_to) ? $this->mail_reply_to . ", " . $mail_reply_to : $mail_reply_to;
            return true;
        }
        return false;
    }

    /**
     * bool setReturnPath(string mail_return_path)
     * Set the devilvery error return email address
     * @access public
     * @param string mail_return_path The delivery error email account
     * @return bool
     */
    public function setReturnPath($mail_return_path){
        if ($this->_validateMail($mail_return_path)){
            $this->mail_return_path = $mail_return_path;
            return true;
        }
        return false;
    }

    /**
     * void setSubject(string subject)
     *
     * マルチバイト対応のため、改造しました。
     * 2007/04/06 T.Kawamura
     *
     * Set the email subject string. "件名なし" by default
     * @access public
     * @param string subject
     * @return void
     */
    public function setSubject($subject){
        $this->mail_subject = !empty($subject) ? trim($subject) : "件名なし";
        // マルチバイト対応
        if ($this->charset) {
            $this->mail_subject = $this->_encodedString($this->mail_subject);
            // エスケープシーケンスを付加
            $this->mail_subject = $this->_encodeBase64Mimeheader($this->mail_subject);
        }
    }

    /**
     * void setText(string text)
     * Set the plain text message in body of email
     * @access public
     * @param string text The plain text message
     * @return void
     */
    public function setText($text){
        if (!empty($text)){
            // マルチバイト対応
            if ($this->charset) {
                $this->mail_text = $this->_encodedString($text);
            } else {
                $this->mail_text = $text;
            }
        }
    }

    /**
     * void setHtml(string html)
     * Set the HTML message in body of email
     * @access public
     * @param string html The HTML message
     * @return void
     */
    public function setHtml($html){
        if (!empty($html)){
            // マルチバイト対応
            if ($this->charset) {
                $this->mail_html = $this->_encodedString($html);
            } else {
                $this->mail_html = $html;
            }
        }
    }

    /**
     * bool setSmtpHost(string host, [int port])
     * Set the SMTP host and port, if you call this method with valid parameters, the class sends email through SMTP
     * @access public
     * @param string host The Hostname/IP of the SMTP server
     * @param int port Optional, the port to connect to SMTP server
     * @return bool
     */
    public function setSmtpHost($host, $port = 25){
        if (!empty($host) && is_numeric($port)){
            $this->smtp_host = $host;
            $this->smtp_port = $port;
            return true;
        }
        return false;
    }

    /**
     * bool setSmtpHost(string host, [int port])
     * Set the Auth SMTP user and password, you need to call method setSmtpHost before
     * @access public
     * @param string user The Username Authentication account
     * @param string pass The Password Authentication account
     * @return bool
     */
    public function setSmtpAuth($user, $pass){
        if(!empty($user) && !empty($pass)){
            $this->smtp_user = $user;
            $this->smtp_pass = $pass;
            return true;
        }
        return false;
    }

    /**
     * string getEml()
     * Get the EML format message of the email
     * @access public
     * @return mixed string if message has build, false if not
     */
    public function getEml(){
        if ($this->_buildBody()){
            return
                $this->mail_header . BR .
                'Subject: ' . $this->mail_subject . BR .
                $this->mail_body;
        }
        return false;
    }

    /**
     * bool addAttachment(mixed file, string name, [string type])
     * Add a file attachment
     * @access public
     * @param string file
     * @param string name
     * @param string type
     * @return bool
     */
    public function addAttachment($file, $name, $type = ""){
        if (($content = $this->_openFile($file))){
            $this->attachments[$this->attachments_index] = array(
                'content' => chunk_split(base64_encode($content), 76, BR),
                'name' => $name,
                'type' => (empty($type) ? $this->_getMimetype($name): $type),
                'embedded' => false
            );
            $this->attachments_index++;
        }
    }

    /**
     * bool addContentAttachment(mixed file, string name, [string type])
     * Add a content to an attachment
     * @access public
     * @param string content
     * @param string name
     * @param string type
     * @return bool
     */
    public function addContentAttachment($content, $name, $type = ""){
        $this->attachments[$this->attachments_index] = array(
            'content' => chunk_split(base64_encode($content), 76, BR),
            'name' => $name,
            'type' => (empty($type) ? $this->_getMimetype($name): $type),
            'embedded' => false
        );
        $this->attachments_index++;
    }

    /**
     * void newMail([mixed from], [mixed to], [mixed returnPath], [string subject], [string text], [string html])
     *
     * リターンパスの設定ができる様に改造しました。
     * 2007/04/06 T.Kawamura
     *
     * Method shortcut to create an email
     * @access public
     * @return void
     */
    public function newMail($from = "", $to = "", $returnPath = "", $subject = "", $text = "", $html = ""){
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

        // Asign vars
        if (is_array($from)){
            $this->setFrom($from[0],$from[1]);
        } else {
            $this->setFrom($from);
        }

        if (is_array($to)){
            $this->setTo($to[0],$to[1]);
        } else {
            $this->setTo($to);
        }

        if ($returnPath) {
            $this->setReturnPath($returnPath);
        } else if (is_array($from)) {
            $this->setReturnPath($from[0]);
        } else {
            $this->setReturnPath($from);
        }

        $this->setSubject($subject);
        $this->setText($text);
        $this->setHtml($html);
    }

    /**
     * bool send()
     * Send the email message
     * @access public
     * @return bool
     */
    public function send(){
        if ($this->sended_index == 0 && !$this->_buildBody()){
            $this->_debug(1);
            return false;
        }

        if (empty($this->smtp_host) && !empty($this->mail_return_path) && $this->_php_version_check('4.0.5') && !($this->_php_version_check('4.2.3') && ini_get('safe_mode'))){
            if (function_exists("mail")) {
                return mail($this->mail_to, $this->mail_subject, $this->mail_body, $this->mail_header, '-f'.$this->mail_return_path);
            } else {
                return $this->qmail();
            }
        }
        elseif (empty($this->smtp_host)) {
            if (function_exists("mail")) {
                return mail($this->mail_to, $this->mail_subject, $this->mail_body, $this->mail_header);
            } else {
                return $this->qmail();
            }
        }
        elseif (!empty($this->smtp_host)){
            return $this->_smtpSend();
        }
        else {
            return false;
        }
    }

    /**
     * void qmail()
     *
     * qmailにてメール配信を行います。
     *
     * @access public
     * @return void
     */
    public function qmail() {
        // 実行コマンドを子プロセスとして実行し、そのプロセスへのパイプを開く
        $mailData  = "To: ".$this->mail_to.BR;
        $mailData .= $this->mail_header.BR;
        $mailData .= "Subject: ".$this->mail_subject.BR;
        $mailData .= BR;
        $mailData .= $this->mail_body.BR;

        $mail_pipe = popen(self::QMAIL_PATH, "w");
        fputs($mail_pipe, $mailData);
        pclose($mail_pipe);
        unset($mail_pipe);
    }

    /**
     * string _encodedString(string $string)
     *
     * マルチバイト対応のため、追加しました。
     * 2008/06/05 T.Kawamura
     *
     * @access protected
     * @param string string
     * @return string
     */
    protected function _encodedString($string) {
        switch(strtolower($this->charset)) {
            case "iso-2022-jp":
                $encode = "JIS";
                break;
            case "shift_jis":
                // 拡張文字(絵文字)対応
                $encode = "SJIS-win";
                break;
        }
        if ($encode) {
            $string = mb_convert_encoding($string, $encode, mb_detect_encoding($string, "auto"));
        }
        return $string;
    }

    /**
     * string _encodeBase64Mimeheader(string $string)
     *
     * マルチバイト対応のため、追加しました。
     * 2007/04/06 T.Kawamura
     *
     * @access protected
     * @param string string
     * @return string
     */
    protected function _encodeBase64Mimeheader($string) {
        if (!$string) {
            return;
        }
        //エンコード前に文字列のエンコードを取得
        $charset = mb_detect_encoding($string, "auto");
//        $string = $this->_encodedString($string);

        //先頭に特定のバイナリデータが入るとfalseを返すようなので、その際は強制で文字コードセット
        if ($charset === false) {
            $charset = $this->charset;
        }

        $start = "=?".$this->charset."?B?";
        /* base64_encodeがパディングを埋めるので、?の前に=は付けない */
        $end = "?=";
        $encoded = '';
        /* RFC上、一行の長さは、$start,$end含めて76バイト以下だったと思うけど */
        /* ちょっと自信が無いので、1バイトだけ余裕を見ておく。TODO:あとで調整 */
        $length = 75 - strlen($start) - strlen($end);
        /* マルチバイト文字の割合 */
        $ratio = mb_strlen($string, $charset) / strlen($string);
        /* Base64 はバイナリを3バイト単位で変換し4バイトとするため仮サイズと平均長は以下のようになる */
        $magic = $avglength = floor(3 * $length * $ratio / 4);
        for ($i=0; $i <= mb_strlen($string, $charset); $i+=$magic) { /* 行数分ループ */
            $magic = $avglength;
            $offset = 0;
            /* 実際にBase64エンコードされたバイト数が$lengthを超えないように調整 */
            do {
                $magic -= $offset;
                $chunk = mb_substr($string, $i, $magic, $charset);
                $chunk = base64_encode($chunk);
                $offset++;
            } while (strlen($chunk) > $length);
            /* 中身があったら、一行を組み立てる。 */
            if ($chunk) {
                $encoded .= "\t".$start.$chunk.$end.BR;
            }
        }
        /* 最初のタブと最後の改行を削除 */
        $encoded = substr($encoded, 1, -strlen(BR));

        return $encoded;
    }

    /**
     * void _buildHeader()
     * Build all the headers of email
     * @access protected
     * @param text content_type The Content Type of email
     * @return void
     */
    protected function _buildHeader($content_type){
        if (!empty($this->mail_from)){
            $this->mail_header .= "From: " . $this->mail_from . BR;
            $this->mail_header .= !empty($this->mail_reply_to) ? "Reply-To: " . $this->mail_reply_to . BR : "Reply-To: " . $this->mail_from . BR;
        }
        if (!empty($this->mail_cc)){
            $this->mail_header .= "Cc: " . $this->mail_cc . BR;
        }
        if (!empty($this->mail_bcc) && empty($this->smtp_host)){
            $this->mail_header .= "Bcc: " . $this->mail_bcc . BR;
        }
        if (!empty($this->mail_return_path)){
            $this->mail_header .= "Return-Path: " . $this->mail_return_path . BR;
        }
        $this->mail_header .= "MIME-Version: 1.0" . BR;
        $this->mail_header .= "X-Mailer: MimeMail ". $this->getVersion() . BR;
        $this->mail_header .= $content_type;
    }

    /**
     * bool _buildBody()
     * Build body email message
     * @access protected
     * @return bool
     */
    protected function _buildBody(){
        switch ($this->_parseElements()){
            // textPartのみ
            case 1:
                $content_type .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $content_type .= "Content-Transfer-Encoding: $this->transfer_encoding";
                $this->_buildHeader($content_type);
                $this->mail_body .= $this->mail_text;
                break;
            // testPart + htmlPart
            case 3:
                $this->_buildHeader("Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"");
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_text . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_html . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . "--" . BR;
                break;
            // textPart + attachment
            case 5:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
                $this->mail_body .= "--" . $this->boundary_mix . BR;
                $this->mail_body .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_text . BR . BR;
                foreach($this->attachments as $value){
                    $this->mail_body .= "--" . $this->boundary_mix . BR;
                    $this->mail_body .= "Content-Type: " . $value['type'] . "; name=\"" . $value['name'] . "\"" . BR;
                    $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
                    $this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
                    $this->mail_body .= $value['content'] . BR . BR;
                }
                $this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
                break;
            // textPart + htmlPart + attachment
            case 7:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
                $this->mail_body .= "--" . $this->boundary_mix . BR;
                $this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_text . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_html . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
                foreach($this->attachments as $value){
                    $this->mail_body .= "--" . $this->boundary_mix . BR;
                    $this->mail_body .= "Content-Type: " . $value['type'] . "; name=\"" . $value['name'] . "\"" . BR;
                    $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
                    $this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
                    $this->mail_body .= $value['content'] . BR . BR;
                }
                $this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
                break;
            // textPart + htmlPart + attachment_img
            case 11:
                $this->_buildHeader("Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"$this->boundary_rel\"");
                $this->mail_body .= "--" . $this->boundary_rel . BR;
                $this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_text . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_html . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
                foreach($this->attachments as $value){
                    if ($value['embedded']){
                        $this->mail_body .= "--" . $this->boundary_rel . BR;
                        $this->mail_body .= "Content-ID: <" . $value['embedded'] . ">" . BR;
                        $this->mail_body .= "Content-Type: " . $value['type'] . "; name=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
                        $this->mail_body .= $value['content'] . BR . BR;
                    }
                }
                $this->mail_body .= "--" . $this->boundary_rel . "--" . BR;
                break;
            // textPart + htmlPart + attachment + attachment_img
            case 15:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
                $this->mail_body .= "--" . $this->boundary_mix . BR;
                $this->mail_body .= "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"$this->boundary_rel\"" . BR . BR;
                $this->mail_body .= "--" . $this->boundary_rel . BR;
                $this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/plain; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_text . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . BR;
                $this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
                $this->mail_body .= "Content-Transfer-Encoding: $this->transfer_encoding" . BR . BR;
                $this->mail_body .= $this->mail_html . BR . BR;
                $this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
                foreach($this->attachments as $value){
                    if ($value['embedded']){
                        $this->mail_body .= "--" . $this->boundary_rel . BR;
                        $this->mail_body .= "Content-ID: <" . $value['embedded'] . ">" . BR;
                        $this->mail_body .= "Content-Type: " . $value['type'] . "; name=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
                        $this->mail_body .= $value['content'] . BR . BR;
                    }
                }
                $this->mail_body .= "--" . $this->boundary_rel . "--" . BR . BR;
                foreach($this->attachments as $value){
                    if (!$value['embedded']){
                        $this->mail_body .= "--" . $this->boundary_mix . BR;
                        $this->mail_body .= "Content-Type: " . $value['type'] . "; name=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
                        $this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
                        $this->mail_body .= $value['content'] . BR . BR;
                    }
                }
                $this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
                break;
            default:
                return $this->_debug(2);
        }
        $this->sended_index++;
        return true;
    }

    /**
     * bool _php_version_check(string vercheck)
     * Check if current version of PHP is above than other
     * @access protected
     * @param string vercheck The compare version of PHP
     * @return bool
     */
    protected function _php_version_check($vercheck){
        $minver = str_replace(".","", $vercheck);
        $curver = str_replace(".","", phpversion());
        if($curver >= $minver){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * mixed _parseElements()
     * Check all email message elements and return a identifier
     * @access protected
     * @return mixed int|false
     */
    protected function _parseElements(){
        if (empty($this->mail_to)){
            return $this->_debug(3);
        }
        $this->mail_type = 0;
        $this->_searchImages();
        if (!empty($this->mail_text)){
            $this->mail_type = $this->mail_type + 1;
        }
        if (!empty($this->mail_html)){
            $this->mail_type = $this->mail_type + 2;
            if (empty($this->mail_text)){
                $this->mail_text = strip_tags(preg_replace("/<br>/", BR, $this->mail_html));
                $this->mail_type = $this->mail_type + 1;
            }
        }
        if ($this->attachments_index != 0){
            if (count($this->attachments_img) != 0){
                $this->mail_type = $this->mail_type + 8;
            }
            if ((count($this->attachments) - count($this->attachments_img)) >= 1){
                $this->mail_type = $this->mail_type + 4;
            }
        }
        return $this->mail_type;
    }

    /**
     * void _searchImages()
     * Search all embeded images in HTML and attachments
     * @access protected
     * @return void
     */
    protected function _searchImages(){
        if ($this->attachments_index != 0){
            foreach($this->attachments as $key => $value){
                if (preg_match('/(css|image)/i', $value['type']) && preg_match('/\s(background|href|src)\s*=\s*[\"|\'](' . $value['name'] . ')[\"|\'].*>/is', $this->mail_html)) {
                    $img_id = md5($value['name']) . "@mimemail";
                    $this->mail_html = preg_replace('/\s(background|href|src)\s*=\s*[\"|\'](' . $value['name'] . ')[\"|\']/is', ' \\1="cid:' . $img_id . '"', $this->mail_html);
                    $this->attachments[$key]['embedded'] = $img_id;
                    $this->attachments_img[] = $value['name'];
                }
            }
        }
    }

    /**
     * bool _validateMail(string mail)
     * Validate an email address
     * @access protected
     * @param string mail The email address string
     * @return bool
     */
    protected function _validateMail($mail){
        if (preg_match("/^[-+.\/\w]+@([\w])+([\w\._-])*\.([a-zA-Z])+$/",$mail)){
            return true;
        }
        return $this->_debug(4, $mail);
    }

    /**
     * mixed _extractEmail(string parse)
     * Extract all email addresses from a string. If extracted more than one
     * return an array. If extraded only one email return string. Else return false
     * @access protected
     * @param string parse String whit one or more email addresses
     * @return mixed array|string|false
     */
    protected function _extractEmail($parse){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $parse, $matches);
        if (count($matches[0]) == 1){
            return $matches[0][0];
        }
        elseif (!count($matches[0])){
            return false;
        }
        else {
            return $matches[0];
        }
    }

    /**
     * string _getMimetype(string name)
     * Search a mime type based in it's extension filename
     * @access protected
     * @param string name The file name
     * @return mixed string
     */
    protected function _getMimetype($name){
        $ext_array = explode(".", $name);
        if (($last = count($ext_array) - 1) != 0){
            $ext = $ext_array[$last];
            if (isset($this->mime_types[$ext]))
                return $this->mime_types[$ext];
        }
        return "application/octet-stream";
    }

    /**
     * mixed _openFile(string file)
     * Opens a file and returns it's content
     * @access protected
     * @param string file The file path
     * @return mixed string|false
     */
    protected function _openFile($file){
        if(($fp = @fopen($file, 'r'))){
            $content = fread($fp, filesize($file));
            fclose($fp);
            return $content;
        }
        return $this->_debug(5, $file);
    }

    /**
     * bool false _debug(int msg, [string element])
     * Printa a error and returns false
     * @access protected
     * @param int msg The id error
     * @param string element Optional The extra message error
     * @return bool false
     */
    protected function _debug($msg, $element=""){
        if ($this->debug_status == "yes"){
            echo "<br><b>Error:</b> " . $this->error_msg[$msg] . " $element<br>";
        }
        elseif ($this->debug_status == "halt"){
            die ("<br><b>Error:</b> " . $this->error_msg[$msg] . " $element<br>");
        }
        return false;
    }

    /**
     * bool _openSmtpConn()
     * Opens a socket connection to SMTP server
     * @access protected
     * @return bool
     */
    protected function _openSmtpConn(){
        if ($this->smtp_conn = @fsockopen ($this->smtp_host, $this->smtp_port)){
            if (in_array($this->_getSmtpResponse(), array(220, 250, 354))){
                return true;
            }
        }
        return $this->_debug(6);
    }

    /**
     * void _closeSmtpConn()
     * Close SMTP connection
     * @access protected
     * @return void
     */
    protected function _closeSmtpConn(){
        $this->_sendSmtpCommand("QUIT");
        @fclose($this->smtp_conn);
        unset($this->smtp_conn);
    }

    /**
     * bool _sendSmtpCommand(string command, [array number])
     * Sends a Command to SMTP server
     * @access protected
     * @param string command String of Command to send
     * @param array number Optional array of accepted numbers for response
     * @return bool
     */
    protected function _sendSmtpCommand($command, $number=""){
        if (@fwrite($this->smtp_conn, $command . BR)){
            $this->smtp_msg .= $this->smtp_log == true ? $command . "\n" : "";
            if (!empty($number)){
                if (!in_array($this->_getSmtpResponse(), (array)$number)){
                    $this->_closeSmtpConn();
                    return $this->_debug(7);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * int _getSmtpResponse()
     * Check the id number response from SMTP server
     * @access protected
     * @return int
     */
    protected function _getSmtpResponse(){
        do {
            $response = chop(@fgets($this->smtp_conn, 1024));
            $this->smtp_msg .= $this->smtp_log == true ? $response . "\n" : "";
        } while($response{3} == "-");
        return intval(substr($response,0,3));
    }

    /**
     * bool _smtpSend()
     * Sends the email message via SMTP
     * @access protected
     * @return bool
     */
    protected function _smtpSend(){
        if ($this->_openSmtpConn()){
            if (!$this->_sendSmtpCommand("helo ".$this->smtp_host, array(220, 250, 354))){return false;}
            if(!empty($this->smtp_user) && !empty($this->smtp_pass)){
                if (!$this->_sendSmtpCommand("EHLO ".$this->smtp_host, array(220, 250, 354))){return false;}
                if (!$this->_sendSmtpCommand("AUTH LOGIN", array(334))){return false;}
                if (!$this->_sendSmtpCommand(base64_encode($this->smtp_user), array(334))){return false;}
                if (!$this->_sendSmtpCommand(base64_encode($this->smtp_pass), array(235))){return false;}
            }
            if (!$this->_sendSmtpCommand("MAIL FROM: ".$this->_extractEmail($this->mail_from), array(220, 250, 354))){return false;}
            $all_email = $this->_extractEmail(implode(", ", array($this->mail_to, $this->mail_cc, $this->mail_bcc)));
            foreach ((array)$all_email as $email){
                if (!$this->_sendSmtpCommand("RCPT TO: ".$email, array(220, 250, 354))){return false;}
            }
            if (!$this->_sendSmtpCommand("DATA", array(220, 250, 354))){return false;}
            $this->_sendSmtpCommand($this->mail_header);
            $this->_sendSmtpCommand("Subject: ".$this->mail_subject);
            $this->_sendSmtpCommand($this->mail_body);
            if (!$this->_sendSmtpCommand(".", array(220, 250, 354))){return false;}
            $this->_closeSmtpConn();
            return true;
        }
        return false;
    }

    /**
     * void setSmtpLog(bool log)
     * Activate or Deactivate SMTP log messages
     * @access public
     * @param bool log True if you can log SMTP messages, false by default
     * @return void
     */
    public function setSmtpLog($log = false){
        if ($log == true){
            $this->smtp_log = true;
        }
        else {
            $this->smtp_log = false;
        }
    }

    /**
     * string getSmtpLog()
     * Get all SMTP log
     * @access public
     * @return string
     */
    public function getSmtpLog(){
        if ($this->smtp_log == true){
            return $this->smtp_msg;
        }
        else {
            return "No logs activated";
        }
    }

    /**
     * string getVersion()
     * Return the version of this class
     * @access public
     * @return string
     */
    public function getVersion(){
        return "1.0";
    }
}

?>