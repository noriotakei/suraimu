<?php
/**
 * Mime_Parser_ComMimeParserMail.php
 *
 * サーバー上で受信したメールを解析するクラス
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * Mime_Parser_ComMimeParserMail
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */
class Mime_Parser_ComMimeParserMail {
    /** @var object parseされたメールデータのStdClass */
    protected $_mailData = null;

    /** @var array 添付ファイル格納配列 */
    protected $_attach = array(
        "image"       => array(),
        "application" => array(),
        "text"        => array()
    );

    /** @var string テキストメール内容 */
    protected $_text = "";

    /** @var string HTMLメール内容 */
    protected $_html = "";

    /** @var array 添付ファイル判別用拡張子 */
    public static $imageTypes = array("gif", "png", "jpg", "jpeg");
    public static $appliTypes = array("swf", "doc", "xls", "ppt", "pdf", "bz2", "gz", "tgz", "tar", "zip");
    public static $textTypes  = array("html", "htm", "txt", "css", "js", "xml");

    /**
     * コンストラクタ
     *
     * 標準入力からメールデータを取得する
     */
    public function __construct() {
        $mailData = "";
        // 標準入力からメール情報を取得し、解析する
        $fp = fopen("php://stdin", "r");
        while (!feof($fp)) {
            $mailData .= fgets($fp, 4096);
        }
        fclose($fp);

        $parser = new Mime_ComMimeParser();
        $this->_mailData = $parser->parse($mailData);
        // multipartまで解析
        $this->_parse();
    }

    /**
     * _parse()メソッド
     *
     * メールデータを解析する
     *
     * @return void
     */
    protected function _parse() {
        // Simgle part mail
        if (!isset($this->_mailData->multipart)) {
            $primary   = strtolower($this->_mailData->contentType["primary"]);
            $secondary = strtolower($this->_mailData->contentType["secondary"]);
            // Content-Type
            $contentType = $primary . "/" . $secondary;
            if ($contentType == "text/plain") {
                $this->_text = $part->body;
            } else if ($contentType == "text/html") {
                $this->_html = $part->body;
            }
        } else {
            // Multi part Mail
            // それぞれのContent-Typeを設定
            foreach (self::$imageTypes as $ext) {
                $imageTypes = ComMime::$mimeType[$ext];
            }
            foreach (self::$appliTypes as $ext) {
                $appliTypes = ComMime::$mimeType[$ext];
            }
            foreach (self::$textTypes as $ext) {
                $textTypes = ComMime::$mimeType[$ext];
            }

            // multipartをループ
            foreach ($this->_mailData->multipart as $part) {
                $primary   = strtolower($part->contentType["primary"]);
                $secondary = strtolower($part->contentType["secondary"]);
                // Content-Type
                $contentType = $primary . "/" . $secondary;
                // 添付ファイル名を取得
                $filename = isset($part->contentDisposition["other"]["filename"]) ? $part->contentDisposition["other"]["filename"] : null;

                $attach = array();
                // 添付画像 Content-Type: image/****
                if ($contentType == $imageTypes) {
                    $attach["body"]     = $part->body;
                    $attach["filename"] = $filename;
                    $this->_attach["image"][] = $attach;
                    continue;
                }
                // 添付ファイル Content-Type: application/****
                if ($contentType == $appliTypes) {
                    $attach["body"]     = $part->body;
                    $attach["filename"] = $filename;
                    $this->_attach["application"][] = $attach;
                    continue;
                }
                // text/****
                if ($contentType == $textTypes) {
                    // 添付テキスト Content-Type: text/****
                    if (isset($part->contentDisposition["value"]) && $part->contentDisposition["value"] == "attachment") {
                        $attach["body"]     = $part->body;
                        $attach["filename"] = $filename;
                        $this->_attach["text"][] = $attach;
                    // 以下メッセージ部分
                    } else if ($contentType == "text/plain") {
                        $this->_text = $part->body;
                    } else if ($contentType == "text/html") {
                        $this->_html = $part->body;
                    }
                    continue;
                }
            }
        }
    }

    /**
     * getHeadersメソッド
     *
     * メールヘッダを取得する。
     *
     * @param  string $name ヘッダ名
     * @return mixed 指定のヘッダ、もしくは全ヘッダ内容を返す。
     */
    public function getHeaders($name = null) {
        if (!is_null($name) && isset($this->_mailData->headers[$name])) {
            return $this->_mailData->headers[$name];
        }
        return $this->_mailData->headers;
    }

    /**
     * getBodyメソッド
     *
     * メール内容を取得する。
     *
     * @param  string $key  "text" or "html"
     * @return string $body 指定のメール内容を返す
     */
    public function getBody($key = "text") {
        $body = "";
        switch (strtolower($key)) {
            case "text":
                $body = $this->_text;
                break;
            case "html":
                $body = $this->_html;
                break;
            default:
                break;
        }
        return $body;
    }

    /**
     * getAttachImageメソッド
     *
     * 添付画像を取得する。
     *
     * @return array 添付画像配列
     */
    public function getAttachImage() {
        return $this->_attach["image"];
    }

    /**
     * getAttachApplicationメソッド
     *
     * 添付ファイルを取得する。
     *
     * @return array 添付ファイル配列
     */
    public function getAttachApplication() {
        return $this->_attach["application"];
    }

    /**
     * getAttachTextメソッド
     *
     * 添付テキストを取得する。
     *
     * @return array 添付テキスト配列
     */
    public function getAttachText() {
        return $this->_attach["text"];
    }

    /**
     * isMultipartメソッド
     *
     * メールがマルチパートがどうか判別する。
     *
     * @return boolean multipartならtrue、でなければfalse
     */
    public function isMultipart() {
        return (isset($this->_mailData->multipart));
    }

    /**
     * isAttachメソッド
     *
     * 添付ファイルがあるかどうか判別する。
     *
     * @return boolean 添付ファイルありならtrue、でなければfalse
     */
    public function isAttach() {
        return (count($this->_attach["image"]) > 0 || count($this->_attach["application"]) > 0 || count($this->_attach["text"]) > 0);
    }

    /**
     * isAttachImageメソッド
     *
     * 添付画像があるかどうか判別する。
     *
     * @return boolean 添付画像ありならtrue、でなければfalse
     */
    public function isAttachImage() {
        return (count($this->_attach["image"]) > 0);
    }

    /**
     * isAttachApplicationメソッド
     *
     * 添付ファイル(Offileファイルや圧縮ファイル)があるかどうか判別する。
     *
     * @return boolean 添付ファイルありならtrue、でなければfalse
     */
    public function isAttachApplication() {
        return (count($this->_attach["application"]) > 0);
    }

    /**
     * isAttachTextメソッド
     *
     * 添付テキストがあるかどうか判別する。
     *
     * @return boolean 添付テキストありならtrue、でなければfalse
     */
    public function isAttachText() {
        return (count($this->_attach["text"]) > 0);
    }
}
?>
