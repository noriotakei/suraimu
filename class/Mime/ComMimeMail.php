<?php
/**
 * Mime_ComMimeMail.php
 *
 * メール生成を行うクラス
 *
 * phpclassesより、メキシコ人のソースを元にマルチバイト対応へ改造しました
 * http://www.phpclasses.org/browse/package/1267.html
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */
/**
 * Mime_ComMimeMail
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */

class Mime_ComMimeMail {
    /** @const Version */
    const VERSION = "1.0";

    /** @const Multipart type */
    const TYPE_TEXT_PART             = 1;
    const TYPE_HTML_PART             = 2;
    const TYPE_ATTACHMENT_PART       = 4;
    const TYPE_ATTACHMENT_IMAGE_PART = 8;

    /** @var string メール配信の際の文字コード */
    protected $_charset = "ISO-2022-JP";

    /** @var string 件名 */
    protected $_subject = "件名なし";

    /** @var string 送信者アドレス */
    protected $_from = "";

    /** @var string 送信先アドレス */
    protected $_to = "";

    /** @var string CCアドレス */
    protected $_cc = "";

    /** @var string BCCアドレス */
    protected $_bcc = "";

    /** @var string text本文 */
    protected $_text = "";

    /** @var string HTML本文 */
    protected $_html = "";

    /** @var interger メールフォーマットID */
    protected $_type = 0;

    /** @var string メールヘッダ */
    protected $_header = "";

    /** @var string メールボディ */
    protected $_body = "";

    /** @var string Replyアドレス */
    protected $_replyTo = "";

    /** @var string リターンパス */
    protected $_returnPath = "";

    /** @var interger 添付ファイル数 */
    protected $_attachmentsIndex;

    /** @var array 添付ファイルデータ格納配列 */
    protected $_attachments = array();

    /** @var array 添付画像名格納配列 */
    protected $_attachmentsImg = array();

    /** @var string mixedバウンダリ */
    protected $_boundaryMix;

    /** @var string relatedバウンダリ */
    protected $_boundaryRel;

    /** @var string alternativeバウンダリ */
    protected $_boundaryAlt;

    /** @var string 改行コード */
    public $EOL;

    /**
     * コンストラクタ
     *
     * バウンダリ・添付ファイル個数・送信回数・改行コードをリセットします
     */
    public function __construct() {
        $this->_boundaryMix      = "=-nxs_mix_" . md5(uniqid(rand()));
        $this->_boundaryRel      = "=-nxs_rel_" . md5(uniqid(rand()));
        $this->_boundaryAlt      = "=-nxs_alt_" . md5(uniqid(rand()));
        $this->_attachmentsIndex = 0;
        $this->EOL = strstr(PHP_OS, "WIN") ? "\r\n" : "\n";
    }

    /**
     * setCharsetメソッド
     *
     * 文字コードをセットする
     *
     * @param  string $charset 文字コード
     * @return void
     */
    public function setCharset($charset) {
        $this->_charset = $charset;
    }

    /**
     * getCharsetメソッド
     *
     * 文字コードを取得する
     *
     * @return string 文字コード
     */
    public function getCharset() {
        return $this->_charset;
    }

    /**
     * setFromメソッド
     *
     * 送信者アドレスをセットする
     *
     * @param  string $from 送信者アドレス
     * @param  string $name 送信者名
     * @return void
     */
    public function setFrom($from, $name = "") {
        if ($this->_validateMail($from)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->_from = $name . " <" . $from . ">";
            } else {
                $this->_from = $from;
            }
        } else {
            throw new Mime_ComMimeException("Need a mail transmitter in From Address");
        }
    }

    /**
     * getFromメソッド
     *
     * 送信者アドレスを取得する
     *
     * @return string 送信者アドレス
     */
    public function getFrom() {
        return $this->_from;
    }

    /**
     * setToメソッド
     *
     * 送信先アドレスをセットする
     *
     * @param  string $to   送信先アドレス
     * @param  string $name 送信先名
     * @return void
     */
    public function setTo($to, $name = "") {
        if ($this->_validateMail($to)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->_to = $name . " <" . $to . ">";
            } else {
                $this->_to = $to;
            }
        }
    }

    /**
     * getToメソッド
     *
     * 送信先アドレスを取得する
     *
     * @return string 送信先アドレス
     */
    public function getTo() {
        return $this->_to;
    }

    /**
     * setCcメソッド
     *
     * CCをセットする(carbon copy)
     *
     * @param  string $cc   CCアドレス
     * @param  string $name CC名
     * @return void
     */
    public function setCc($cc, $name = "") {
        if ($this->_validateMail($cc)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->_cc = $name . " <" . $cc . ">";
            } else {
                $this->_cc = $cc;
            }
        }
    }

    /**
     * getCcメソッド
     *
     * CCを取得する
     *
     * @return string CCアドレス
     */
    public function getCc() {
        return $this->_cc;
    }

    /**
     * setBccメソッド
     *
     * BCCをセットする(blind carbon copy)
     *
     * @param  string $bcc  BCCアドレス
     * @param  string $name BCC名
     * @return void
     */
    public function setBcc($bcc, $name = "") {
        if ($this->_validateMail($bcc)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->_bcc = $name . " <" .$bcc . ">";
            } else {
                $this->_bcc = $bcc;
            }
        }
    }

    /**
     * getBccメソッド
     *
     * BCCを取得する
     *
     * @return string BCCアドレス
     */
    public function getBcc() {
        return $this->_bcc;
    }

    /**
     * setReplyToメソッド
     *
     * Replyをセットする
     *
     * @param  string $replyTo Replyアドレス
     * @param  string $name    Reply名
     * @return void
     */
    public function setReplyTo($replyTo, $name = "") {
        if ($this->_validateMail($replyTo)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $this->_replyTo = $name . " <" . $replyTo . ">";
            } else {
                $this->_replyTo = $replyTo;
            }
        }
    }

    /**
     * getReplyToメソッド
     *
     * Replyを取得する
     *
     * @return string Replyアドレス
     */
    public function getReplyTo() {
        return $this->_replyTo;
    }

    /**
     * addToメソッド
     *
     * 送信者を追加します(セットされていなければセットします)
     *
     * @param  string  $to   送信先アドレス
     * @param  string  $name 送信先名
     * @return void
     */
    public function addTo($to, $name = "") {
        if ($this->_validateMail($to)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $to = $name . " <" . $to . ">";
            }
            $this->_to = !empty($this->_to) ? $this->_to . ", " . $to : $to;
        }
    }

    /**
     * addCcメソッド
     *
     * CCを追加します(セットされていなければセットします)
     *
     * @param  string $cc   CCアドレス
     * @param  string $name CC名
     * @return void
     */
    public function addCc($cc, $name = "") {
        if ($this->_validateMail($cc)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $cc = $name . " <" . $cc . ">";
            }
            $this->_cc = !empty($this->_cc) ? $this->_cc . ", " . $cc : $cc;
        }
    }

    /**
     * addBccメソッド
     *
     * BCCを追加します(セットされていなければセットします)
     *
     * @param  string  $bcc  BCCアドレス
     * @param  string  $name BCC名
     * @return void
     */
    public function addBcc($bcc, $name = "") {
        if ($this->_validateMail($bcc)){
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $bcc = $name . " <" . $bcc . ">";
            }
            $this->_bcc = !empty($this->_bcc) ? $this->_bcc . ", " . $bcc : $bcc;
        }
    }

    /**
     * addReplyToメソッド
     *
     * Replyを追加します(セットされていなければセットします)
     *
     * @param  string $replyTo Replyアドレス
     * @param  string $name    Reply名
     * @return void
     */
    public function addReplyTo($replyTo, $name = "") {
        if ($this->_validateMail($replyTo)) {
            if (!empty($name)) {
                // マルチバイト対応
                if ($this->_charset) {
                    $name = $this->_encodedString($name);
                    // エスケープシーケンスを付加
                    $name = $this->_encodeBase64Mimeheader($name);
                }

                $replyTo = $name . " <" . $replyTo . ">";
            }
            $this->_replyTo = !empty($this->_replyTo) ? $this->_replyTo . ", " . $replyTo : $replyTo;
        }
    }

    /**
     * setReturnPathメソッド
     *
     * リターンパスをセットします
     *
     * @param  string $returnPath リターンパス
     * @return void
     */
    public function setReturnPath($returnPath) {
        if ($this->_validateMail($returnPath)) {
            $this->_returnPath = $returnPath;
        }
    }

    /**
     * getReturnPathメソッド
     *
     * リターンパスを取得する
     *
     * @return string リターンパス
     */
    public function getReturnPath() {
        return $this->_returnPath;
    }

    /**
     * setSubjectメソッド
     *
     * 件名をセットします
     *
     * @param  string $subject 件名
     * @return void
     */
    public function setSubject($subject) {
        $this->_subject = !empty($subject) ? trim($subject) : $this->_subject;
        // マルチバイト対応
        if ($this->_charset) {
            $this->_subject = $this->_encodedString($this->_subject);

            // 絵文字コンバート
            $this->_subject = $this->_convertEmoji($this->_subject);
            // エスケープシーケンスを付加
            $this->_subject = $this->_encodeBase64Mimeheader($this->_subject);
        }
    }

    /**
     * getSubjectメソッド
     *
     * 件名を取得する
     *
     * @return string 件名
     */
    public function getSubject() {
        return $this->_subject;
    }

    /**
     * setTextメソッド
     *
     * text本文をセットします
     *
     * @param  string $text text本文
     * @return void
     */
    public function setText($text) {
        if (!empty($text)) {
            // マルチバイト対応
            if ($this->_charset) {
                $this->_text = $this->_encodedString($text);
                // 絵文字コンバート
                $this->_text = $this->_convertEmoji($this->_text);
            } else {
                $this->_text = $text;
            }
        }
    }

    /**
     * getTextメソッド
     *
     * text本文を取得する
     *
     * @return string 件text本文名
     */
    public function getText() {
        return $this->_text;
    }

    /**
     * setHtmlメソッド
     *
     * HTML本文をセットします
     *
     * @param  string $html HTML本文
     * @return void
     */
    public function setHtml($html) {
        if (!empty($html)) {
            // マルチバイト対応
            if ($this->_charset) {
                $this->_html = $this->_encodedString($html);
                // 絵文字コンバート
                $this->_html = $this->_convertEmoji($this->_html);
            } else {
                $this->_html = $html;
            }
        }
    }

    /**
     * getHtmlメソッド
     *
     * HTML本文を取得する
     *
     * @return string HTML本文
     */
    public function getHtml() {
        return $this->_html;
    }

    /**
     * getEmlメソッド
     *
     * メールデータを返します
     *
     * @return mixed メールデータが生成できればメールデータ、できなければfalseを返す
     */
    public function getEml() {
        if ($this->_buildBody()) {
            return
                $this->_header . $this->EOL .
                "Subject: " . $this->_subject . $this->EOL .
                $this->_body;
        }
        return false;
    }

    /**
     * addAttachmentメソッド
     *
     * 既存のファイルから添付ファイルとして追加する
     *
     * @param  string $file 既存ファイルのパス
     * @param  string $name 添付ファイル名
     * @param  string $type MimeType(指定がない場合は$nameの拡張子よりセットされる)
     * @return void
     */
    public function addAttachment($file, $name, $type = "") {
        if (($content = $this->_openFile($file))) {
            $this->addContentAttachment($content, $name, $type);
        }
    }

    /**
     * addContentAttachmentメソッド
     *
     * ファイルデータを添付ファイルとして追加する
     *
     * @param  string $content 添付するファイルの生データ
     * @param  string $name    添付ファイル名
     * @param  string $type    MimeType(指定がない場合は$nameの拡張子よりセットされる)
     * @return void
     */
    public function addContentAttachment($content, $name, $type = "") {
        $this->_attachments[$this->_attachmentsIndex] = array(
            "content"  => chunk_split(base64_encode($content), 76, $this->EOL),
            "name"     => $name,
            "type"     => (empty($type) ? $this->_getMimetype($name): $type),
            "embedded" => false
        );
        $this->_attachmentsIndex++;
    }

    /**
     * newMailメソッド
     *
     * attachment以外のメールデータを1度にセットできるショートカットメソッド
     * 不必要なパラメータは省略可
     * ※元ソースからリターンパスの設定ができる様に改造しました。2007/04/06 T.Kawamura
     *
     * @param  mixed  $from       送信者アドレス nameをセットするならarray 0番目にアドレス 1番目にname
     * @param  mixed  $to         送信先アドレス nameをセットするならarray 0番目にアドレス 1番目にname
     * @param  string $returnPath リターンパス
     * @param  string $subject    件名
     * @param  string $text       テキスト本文
     * @param  string $html       HTML本文
     * @return void
     */
    public function newMail($from = "", $to = "", $returnPath = "", $subject = "", $text = "", $html = "") {

        // メンバ変数を初期化します
        $this->_subject          = "";
        $this->_from             = "";
        $this->_to               = "";
        $this->_cc               = "";
        $this->_bcc              = "";
        $this->_text             = "";
        $this->_html             = "";
        $this->_header           = "";
        $this->_body             = "";
        $this->_replyTo          = "";
        $this->_returnPath       = "";
        $this->_attachmentsIndex = 0;

        $this->_attachments = array();
        $this->_attachmentsImg = array();

        // Fromをセット
        if (is_array($from)) {
            $this->setFrom($from[0], $from[1]);
        } else {
            $this->setFrom($from);
        }

        // Toをセット
        if (is_array($to)) {
            $this->setTo($to[0], $to[1]);
        } else {
            $this->setTo($to);
        }

        // Return-Pathをセット
        if ($returnPath) {
            $this->setReturnPath($returnPath);
        } else if (is_array($from)) {
            $this->setReturnPath($from[0]);
        } else {
            $this->setReturnPath($from);
        }

        // subjectをセット
        $this->setSubject($subject);
        // TextBodyをセット
        $this->setText($text);
        // HTMLBodyをセット
        $this->setHtml($html);
    }

    /**
     * getHeaderメソッド
     *
     * メールヘッダーを取得する
     *
     * @return string メールヘッダー
     */
    public function getHeader() {
        return $this->_header;
    }

    /**
     * getBodyメソッド
     *
     * メールボディを取得する
     *
     * @return string メールボディ
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * buildBodyメソッド
     *
     * 解析した送信フォーマットに対応したメールボディを生成する
     *
     * @return boolean メールボディ生成に成功したらtrue、失敗したらfalseを返す
     */
    public function buildBody() {
        return $this->_buildBody();
    }

    /**
     * _encodedStringメソッド
     *
     * マルチバイト対応のため、追加しました。
     *
     * @param  string $string
     * @return string $string
     */
    protected function _encodedString($string) {
        $encode = "";
        switch(strtolower($this->_charset)) {
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
     * _encodeBase64Mimeheaderメソッド
     *
     * マルチバイト対応のため、追加しました。
     *
     * @param  string $string
     * @return string $encoded
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
            $charset = $this->_charset;
        }

        $start = "=?".$this->_charset."?B?";
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
                $encoded .= "\t" . $start . $chunk . $end . $this->EOL;
            }
        }
        /* 最初のタブと最後の改行を削除 */
        $encoded = substr($encoded, 1, -strlen($this->EOL));

        return $encoded;
    }

    /**
     * _buildHeaderメソッド
     *
     * メールヘッダーを生成します
     *
     * @param  string $contentType コンテントタイプ
     * @return void
     */
    protected function _buildHeader($contentType) {
        $this->_header = "";
        if (!empty($this->_from)) {
            $this->_header .= "From: " . $this->_from . $this->EOL;
            $this->_header .= !empty($this->_replyTo) ? "Reply-To: " . $this->_replyTo . $this->EOL : "Reply-To: " . $this->_from . $this->EOL;
        }
        if (!empty($this->_cc)) {
            $this->_header .= "Cc: " . $this->_cc . $this->EOL;
        }
        if (!empty($this->_bcc)) {
            $this->_header .= "Bcc: " . $this->_bcc . $this->EOL;
        }
        if (!empty($this->_returnPath)) {
            $this->_header .= "Return-Path: " . $this->_returnPath . $this->EOL;
        }
        $this->_header .= "MIME-Version: 1.0" . $this->EOL;
        $this->_header .= "X-Mailer: ComMineMail/". $this->getVersion() . $this->EOL;
        $this->_header .= $contentType;
    }

    /**
     * _buildBodyメソッド
     *
     * 解析した送信フォーマットに対応したメールボディを生成する
     *
     * @return boolean メールボディ生成に成功したらtrue、失敗したらfalseを返す
     */
    public function _buildBody() {
        $this->_body = "";
        switch ($this->_parseElements()) {
            // text(テキストパートのみ)
            case self::TYPE_TEXT_PART:
                $this->_buildHeader("Content-Type: text/plain; charset=\"" . $this->_charset . "\"");
                $this->_body .= $this->_text;
                break;
            // text＆html(テキストパートとHTMLパート)
            case self::TYPE_TEXT_PART + self::TYPE_HTML_PART:
                $this->_buildHeader("Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"");
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL;
                break;
            // text＆attachment(テキストパートと添付ファイル)
            case self::TYPE_TEXT_PART + self::TYPE_ATTACHMENT_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                    $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                    $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            // text＆html＆attachment(テキストパートとHTMLパートと添付ファイル)
            case self::TYPE_TEXT_PART + self::TYPE_HTML_PART + self::TYPE_ATTACHMENT_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                    $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                    $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            // text＆html＆inlineImage(テキストパートとHTMLパートとインライン画像)
            case self::TYPE_TEXT_PART + self::TYPE_HTML_PART + self::TYPE_ATTACHMENT_IMAGE_PART:
                $this->_buildHeader("Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"" . $this->_boundaryRel . "\"");
                $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if ($value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                        $this->_body .= "Content-ID: <" . $value["embedded"] . ">" . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryRel . "--" . $this->EOL;
                break;
            // text＆html＆attachment＆inlineImage(テキストパートとHTMLパートと添付ファイルとインライン画像)
            case self::TYPE_TEXT_PART + self::TYPE_HTML_PART + self::TYPE_ATTACHMENT_PART + self::TYPE_ATTACHMENT_IMAGE_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"" . $this->_boundaryRel . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if ($value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                        $this->_body .= "Content-ID: <" . $value["embedded"] . ">" . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryRel . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if (!$value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            default:
                throw new Mime_ComMimeException("Body Build Incomplete");
        }

        return true;
    }

    /**
     * _parseElementsメソッド
     *
     * 送信するメールデータを解析し、送信メールフォーマットを確定する
     *
     * @return interger 送信するメールタイプを返す
     */
    protected function _parseElements() {
        if (empty($this->_to)) {
            throw new Mime_ComMimeException("Need a mail recipient in To Address");
        }
        $this->_type = 0;
        $this->_searchImages();
        if (!empty($this->_text)) {
            $this->_type = $this->_type + self::TYPE_TEXT_PART;
        }
        if (!empty($this->_html)) {
            $this->_type = $this->_type + self::TYPE_HTML_PART;
            if (empty($this->_text)) {
                $this->_text = strip_tags(str_ireplace("<br>", $this->EOL, $this->_html));
                $this->_type = $this->_type + self::TYPE_TEXT_PART;
            }
        }
        if ($this->_attachmentsIndex != 0) {
            if (count($this->_attachmentsImg) != 0) {
                $this->_type = $this->_type + self::TYPE_ATTACHMENT_IMAGE_PART;
            }
            if ((count($this->_attachments) - count($this->_attachmentsImg)) >= 1) {
                $this->_type = $this->_type + self::TYPE_ATTACHMENT_PART;
            }
        }
        return $this->_type;
    }

    /**
     * _searchImagesメソッド
     *
     * 添付ファイルにImageが存在するか走査し、
     * 見つかった場合、HTMLデータ内で使用可能なデータを生成する
     *
     * @return void
     */
    protected function _searchImages() {
        if ($this->_attachmentsIndex != 0) {
            foreach ($this->_attachments as $key => $value) {
                if (preg_match('/(css|image)/i', $value["type"]) &&
                    preg_match('/\s(background|href|src)\s*=\s*[\"|\'](' . $value["name"] . ')[\"|\'].*>/is', $this->_html)) {
                    $img_id = md5($value["name"]) . "@mimemail";
                    $this->_html = preg_replace(
                                    '/\s(background|href|src)\s*=\s*[\"|\'](' . $value["name"] . ')[\"|\']/is',
                                    ' \\1="cid:' . $img_id . '"',
                                    $this->_html);
                    $this->_attachments[$key]["embedded"] = $img_id;
                    $this->_attachmentsImg[] = $value["name"];
                }
            }
        }
    }

    /**
     * _validateMailメソッド
     *
     * 文字列がメールアドレスかどうか確認する
     *
     * @param  string $mail メールアドレス
     * @return boolean      値がメールアドレスならtrue、でなければ例外をスロー
     */
    protected function _validateMail($mail) {

        if (preg_match('(^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$)', $mail)) {
            return true;
        }
        throw new Mime_ComMimeException("No valid Email Address:" . $mail);
    }

    /**
     * _getMimetypeメソッド
     *
     * ファイル名からMimeTypeを取得する
     *
     * @param  string $name ファイル名
     * @return string MimeType
     */
    protected function _getMimetype($name) {
        $extArray = explode(".", $name);
        if (($last = count($extArray) - 1) != 0) {
            $ext = $extArray[$last];
            if (isset(ComMime::$mimeType[$ext])) {
                return ComMime::$mimeType[$ext];
            }
        }
        return "application/octet-stream";
    }

    /**
     * _openFileメソッド
     *
     * ファイル読み込みを行う
     *
     * @param  string $file    ファイルパス
     * @return string $content ファイル読み込みに成功したらファイルデータ、失敗なら例外をスロー
     */
    protected function _openFile($file) {
        if (($fp = @fopen($file, "r"))) {
            $content = fread($fp, filesize($file));
            fclose($fp);
            return $content;
        }
        throw new Mime_ComMimeException("Cannot open file: " . $file);
    }


    /**
     * _convertEmojiメソッド
     *
     * 絵文字を変換する
     *
     * @param  string $string 文字列
     * @return string $string
     */
    protected function _convertEmoji($string) {

        $utilityOBJ  = ComUtility::getInstance();
        $configOBJ  = ComConfig::getInstance();
        $carrier = $utilityOBJ->getDeviceFromMailAddress($this->getTo());
        $comEmojiOBJ = ComEmoji::getInstance($configOBJ->admin_config->device->$carrier);
        $string = $comEmojiOBJ->mailConvertCarrier($string);

        return $string;
    }

    /**
     * getVersionメソッド
     *
     * このクラスのバージョンを返します
     *
     * @return string バージョン
     */
    public function getVersion() {
        return self::VERSION;
    }
}
?>