<?php

/**
 * SendMagicクラス
 *
 * 2010/09/10 nakamura
 *
 */

require_once(D_BASE_DIR . "/func/SendMagic/DecoMimeMail.php");

class SendMagicMail extends DecoMimeMail{
    protected $sendStart = "";

    /** @var インスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /**
     * Constructor
     * void __condtruct()
     */
    public function __construct(){
        parent::__construct();
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
     * 配信予約日時(10進数のUTC)
     */
    public function setSendStart($time) {
        $this->sendStart = $time;
    }

    /**
     * SendMagic拡張ヘッダ
     */
    protected function _getSmExtensionHeader() {
        // sendmagicを通すなら(通常配信時、インターバル指定で必須)
        $smExtensionHeader  = "X-SM-Start:" . BR;

        if ($this->sendStart) {
            $smExtensionHeader .= "X-SM-SendStart: " . $this->sendStart . BR;
        }
        return $smExtensionHeader;
    }

    /**
     * SendMagic拡張フッタ
     */
    protected function _getSmExtensionFooter() {
        // sendmagicを通すなら(通常配信時、インターバル指定用。無くても配信可能ですが。)
        return "X-SM-End:" . BR;
    }

    /**
     * bool send()
     * ヘッダーを変更したいため強制的にqmail()で送信
     *
     * @access public
     * @return bool
     */
    public function send(){
        if ($this->sended_index == 0 && !$this->_buildBody()){
            $this->_debug(1);
            return false;
        }

        if (!empty($this->smtp_host)) {
            return $this->smtpSend();
        } else {
            return false;
        }
    }

    /**
     * bool smtpSend()
     * SendMagic Sends the email message via SMTP
     * @access protected
     * @return bool
     */
    protected function smtpSend(){

        //if ($this->_openSmtpConn()){

            //if (!$this->_sendSmtpCommand("helo ".$this->smtp_host, array(220, 250, 354))){return false;}

            /*
            // SMTP認証（※必要ないかも）
            if(!empty($this->smtp_user) && !empty($this->smtp_pass)){
                if (!$this->_sendSmtpCommand("EHLO ".$this->smtp_host, array(220, 250, 354))){return false;}
                if (!$this->_sendSmtpCommand("AUTH LOGIN", array(334))){return false;}
                if (!$this->_sendSmtpCommand(base64_encode($this->smtp_user), array(334))){return false;}
                if (!$this->_sendSmtpCommand(base64_encode($this->smtp_pass), array(235))){return false;}
            }
            */

            if (!$this->_sendSmtpCommand("MAIL FROM: ".$this->_extractEmail($this->mail_from), array(220, 250, 354))){
                //return false;

                // 接続確認し、非接続状態なら再度接続チャレンジ
                if(!$this->getSmtpConnect()){
                    if(!$this->openSmtpConnect()){
                        return false;
                    }
                }

                if (!$this->_sendSmtpCommand("MAIL FROM: ".$this->_extractEmail($this->mail_from), array(220, 250, 354))){
                    return false;
                }
            }
            //$all_email = $this->_extractEmail(implode(", ", array($this->mail_to, $this->mail_cc, $this->mail_bcc)));
            //foreach ((array)$all_email as $email){
            //    if (!$this->_sendSmtpCommand("RCPT TO: ".$email, array(220, 250, 354))){return false;}
            //}
            if (!$this->_sendSmtpCommand("RCPT TO: ".$this->mail_to, array(220, 250, 354))){return false;}
            if (!$this->_sendSmtpCommand("DATA", array(220, 250, 354))){return false;}
            $this->_sendSmtpCommand("Subject: ".$this->mail_subject);

            // SendMagic拡張ヘッダ
            $this->_sendSmtpCommand($this->mail_header);

            $this->_sendSmtpCommand("To: ".$this->mail_to);
            //$this->_sendSmtpCommand("Date: ".date("r", $this->sendStart));

            // SendMagic拡張フッタ(※これ無くても送信可能なのでいらない)
            //$this->_sendSmtpCommand(BR . $this->mail_body . BR . $this->_getSmExtensionFooter());

            $this->_sendSmtpCommand(BR . $this->mail_body);

            if (!$this->_sendSmtpCommand(".", array(220, 250, 354))){return false;}

            //$this->_closeSmtpConn();

            return true;
        //}

        //return false;
    }
}
?>