<?php
/**
 * デコメール用にヘッダとcidを生成するメソッドを
 * オーバーライドしました。
 *
 * 2010/09/13 nakamura
 */
class SendMagic_ComDecoMimeMail extends SendMagic_ComMimeMail{
    protected $to_address = "";

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
     * bool setTo(string mail_to, [string name])
     * Set the recipient email address
     * @access public
     * @param string mail_to The recipient email address
     * @param string name Optional name contact
     * @return bool
     */
    public function setTo($mail_to, $name = ""){
        // 絵文字用にドメイン判別するため、mail_toとは別で取得。
        $this->to_address = $mail_to;
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
        $this->mail_subject = !empty($subject) ? trim($subject) : $this->mail_subject;
        // マルチバイト対応
        if ($this->charset) {
            $this->mail_subject = $this->_encodedString($this->mail_subject);
            // 絵文字変換
            $this->mail_subject = $this->_convertEmoji($this->mail_subject);
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
                // 絵文字変換
                $this->mail_text = $this->_convertEmoji($this->mail_text);
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
                // 絵文字変換
                $this->mail_html = $this->_convertEmoji($this->mail_html);
            } else {
                $this->mail_html = $html;
            }
        }
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
            // textPart + htmlPart + attachment_img (デコメール用ヘッダ)
            case 11:
//              $this->_buildHeader("Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"$this->boundary_rel\"");
                $this->_buildHeader("Content-Type: multipart/related; boundary=\"$this->boundary_rel\"");
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
                        // DoCoMoのインライン画像対応のため、Content-Dispositionはコメントアウト
//                      $this->mail_body .= "Content-Disposition: attachment; filename=\"" . $value['name'] . "\"" . BR;
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
     * void _searchImages()
     * Search all embeded images in HTML and attachments
     * @access protected
     * @return void
     */
    protected function _searchImages(){
        if ($this->attachments_index != 0){
            foreach($this->attachments as $key => $value){
                $img_id = substr($value['name'], 0, strrpos($value['name'], "."));
                if (preg_match('/(css|image)/i', $value['type']) && preg_match('/\s(background|href|src)\s*=\s*[\"|\'](' . $img_id . ')[\"|\'].*>/is', $this->mail_html)) {
                    $content_id = $img_id . "@".date("ymd.His");
                    $this->mail_html = preg_replace('/\s(background|href|src)\s*=\s*[\"|\'](' . $img_id . ')[\"|\']/is', ' \\1="cid:' . $content_id . '"', $this->mail_html);
                    $this->attachments[$key]['embedded'] = $content_id;
                    $this->attachments_img[] = $value['name'];
                }
            }
        }
    }

    /**
     * string _convertEmoji()
     *
     * 文字列中の絵文字コードを対応したキャリアの絵文字に変換します。
     *
     * @access protected
     * @return string
     */
    protected function _convertEmoji($string){
        list($account, $domain) = explode("@", $this->to_address);
        $emoji = new SendMagic_ComMailEmoji($domain);
        $string = $emoji->encode($string);

        return $emoji->decode($string);
    }


}
?>