<?php

/**
 * ComEmojiクラス
 *
 * 携帯絵文字処理を行うクラスです。
 *
 * 2010/09/15 nakamura
 */

require_once(D_BASE_DIR . "/func/SendMagic/EmojiConfig.php");

class Emoji {
    /* @const string PC用絵文字画像格納ディレクトリ(相対パスもしくはURL指定) */
    const EMOJI_IMAGE_DIR = "../../../image/emoji/";

    /** @var 自身のインスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /* @var string 携帯キャリア */
    protected $carrier    = "";

    /**
     * コンストラクタ
     *
     * キャリア判別を行う
     */
    public function __construct() {
    }

    /**
     * デストラクタ
     *
     */
    public function __destruct() {
        // 何もしない
    }


    /**
     * getInstanceメソッド
     *
     * Emojiのオブジェクトを生成する。
     * 既に生成されていたら、前回と同じものを返す。
     *
     * @return object $instance リクエストオブジェクト
     */
    public static function getInstance() {
        if (!self::$instance) {
            $className = __CLASS__;
            self::$instance = new $className();
        }
        return self::$instance;
    }
    /**
     * encodeメソッド
     *
     * 文字列中の絵文字データをキャリア別の連番文字列へ変換する
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    public function encode($str) {
        switch ($this->carrier) {
            case "docomo":
                $returnStr = self::docomoEncode($str);
                break;
            case "ezweb":
                $returnStr = self::ezwebEncode($str);
                break;
            case "softbank":
                // 入力に関して、J-PHONEは別処理
                if (!$this->mobile->is3G()) {
                    $returnStr = self::jphoneEncode($str);
                } else {
                    $returnStr = self::softbankEncode($str);
                }
                break;
            default:
                $returnStr = $str;
                break;
        }

        return $returnStr;
    }

    /**
     * decodeメソッド
     *
     * 文字列中のキャリア別の連番文字列を絵文字データへ変換する
     *
     * @param  string $str 絵文字が格納されている可能性のある文字列
     * @return string      変換後の文字列を返す
     */
    public function decode($str) {
        return preg_replace_callback("/%([ies])(\d{1,4})%/", array(&$this, "decodeCallback"), $str);
    }

    /**
     * decodeCallbackメソッド
     *
     * 文字列中のキャリア別の連番文字列を絵文字データへ変換する
     *
     * @param  array  $matches decodeメソッド内のpreg_replace_callbackでマッチしたパターン配列
     * @return string          変換後の文字列を返す
     */
    private function decodeCallback($matches) {
        if ($this->carrier == "nonmobile") {
            return "<img src=\"" . self::EMOJI_IMAGE_DIR . $matches[1] . $matches[2] . ".gif\" border=\"0\">";
        }

        // キャリア文字の先頭を大文字へ
        $toCarrier = ucfirst($this->carrier);

        switch ($matches[1]) {
            // Docomo絵文字からアクセスキャリア絵文字へ変換
            case "i":
                $func = "getDocomoTo".$toCarrier;
                $emoji =& EmojiConfig::$func();
                break;
            // Ezweb絵文字からアクセスキャリア絵文字へ変換
            case "e":
                $func = "getEzwebTo".$toCarrier;
                $emoji =& EmojiConfig::$func();
                break;
            // Softbank絵文字からアクセスキャリア絵文字へ変換
            case "s":
                $func = "getSoftbankTo".$toCarrier;
                $emoji =& EmojiConfig::$func();
                break;
        }

        return $emoji[$matches[0]];
    }

    /**
     * docomoEncodeメソッド
     *
     * 文字列中のdocomo絵文字を絵文字番号文字列へ変換する。
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    protected static function docomoEncode($str) {
        $emoji =& EmojiConfig::getDocomoEmoji();

        for ($i = 0 , $returnStr = ""; $i < strlen($str); $i++) {
            // 2バイト取得
            $char = substr($str, $i, 2);
            // 絵文字
            if (preg_match("/(^\xF8)([\x9F-\xFC])/", $char, $matches)
                || preg_match("/(^\xF9)([\x40-\x49\x50-\x52\x55-\x57\x5B-\x5E\x72-\xFC])/", $char, $matches)) {

                $returnStr .= array_search($matches[1].$matches[2], $emoji);
                $i++;
            // 絵文字以外
            } else if (preg_match("/^[\x81-\x9F\xE0-\xF7\xF9-\xFC]./", $char)) {
                $returnStr .= $char;
                $i++;
            // 1バイト文字
            } else {
                $returnStr .= substr($str, $i, 1);
            }
        }
        return $returnStr;
    }

    /**
     * ezwebEncodeメソッド
     *
     * 文字列中のezweb絵文字を絵文字番号文字列へ変換する。
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    protected static function ezwebEncode($str) {
        $emoji =& EmojiConfig::getEzwebEmoji();

        for ($i = 0 , $returnStr = ""; $i < strlen($str); $i++) {
            // 2バイト取得
            $char = substr($str, $i, 2);
            // 絵文字
            if (preg_match("/(^[\xF3\xF6\xF7])([\x40-\xFC])/", $char, $matches)
                || preg_match("/(^\xF4)([\x40-\x8D])/", $char, $matches)) {

                $returnStr .= array_search($matches[1].$matches[2], $emoji);
                $i++;
            // 絵文字以外
            } else if (preg_match("/^[\x81-\x9F\xE0-\xF7\xF9-\xFC]./", $char)) {
                $returnStr .= $char;
                $i++;
            // 1バイト文字
            } else {
                $returnStr .= substr($str, $i, 1);
            }
        }

        return $returnStr;
    }

    /**
     * softbankEncodeメソッド
     *
     * 文字列中のsoftbank絵文字を絵文字番号文字列へ変換する。
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    protected static function softbankEncode($str) {
        $emoji =& EmojiConfig::getSoftbankEmoji();

        for ($i = 0 , $returnStr = ""; $i < strlen($str); $i++) {
            // 2バイト取得
            $char = substr($str, $i, 2);
            // 絵文字
            if (preg_match("/(^\xF7)([\x41-\x7E\x80-\x9B\xA1-\xE9\xEA-\xF3])/", $char, $matches)
                || preg_match("/(^\xF9)([\x41-\x7E\x80-\x9B\xA1-\xED])/", $char, $matches)
                || preg_match("/(^\xFB)([\x41-\x7E\x80-\x8D\xA1-\xD7])/", $char, $matches)) {

                $returnStr .= array_search($matches[1].$matches[2], $emoji);
                $i++;
            // 絵文字以外
            } else if (preg_match("/^[\x81-\x9F\xE0-\xF7\xF9-\xFC]./", $char)) {
                $returnStr .= $char;
                $i++;
            // 1バイト文字
            } else {
                $returnStr .= substr($str, $i, 1);
            }
        }
        return $returnStr;
    }

    /**
     * jphoneEncodeメソッド
     *
     * 文字列中のJ-PHONE絵文字を絵文字番号文字列へ変換する。
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    protected static function jphoneEncode($str) {
        // 古い機種対応
        $returnStr = self::addJphoneEscapeSequence($str);

        $returnStr = preg_replace_callback(
                        "/([\x1B][\x24][G|E|F|O|P|Q])([\x21-\x7E]+)([\x0F])/",
                        array("self", "jphoneEncodeCallback"),
                        $returnStr
                    );

        return $returnStr;
    }

    /**
     * jphoneEncodeCallbackメソッド
     *
     * jphoneEncode内のpreg_replace_callbackにて使用
     *
     * @param  array  $matches   マッチしたパターン配列
     * @return string $returnStr 変換後の文字列を返す
     */
    private static function jphoneEncodeCallback($matches) {
        $emoji =& EmojiConfig::getJphoneEmoji();

        // 連続絵文字
        if (1 < strlen($matches[2])) {
            for ($i = 0; $i < strlen($matches[2]); $i++) {
                // 1バイト取得
                $char = substr($matches[2], $i, 1);
                $emojiStr = $matches[1] . $char . $matches[3];
                $returnStr .= array_search($emojiStr, $emoji);
            }
        } else {
            $returnStr .= array_search($matches[0], $emoji);
        }

        return $returnStr;
    }

    /**
     * addJphoneEscapeSequenceメソッド
     *
     * 古い機種で、絵文字で終わっている場合に末尾の(0x0F)がつかない端末用
     * http://labs.unoh.net/2007/01/softbank_1.html
     *
     * @param  string $str 絵文字が格納されている可能性のある文字列
     * @return string $str (0x0F)を追加した文字列を返す
     */
    private static function addJphoneEscapeSequence($str) {
        $matches = array();
        preg_match_all("/[\x1B][\x24][G|E|F|O|P|Q][\x21-\x7E]+([\x0F]?)$/", $str, $matches);
        if (isset($matches[1][0]) && $matches[1][0] === "") {
            $str .= pack("C*", 0x0F);
        }
        return $str;
    }
}
?>