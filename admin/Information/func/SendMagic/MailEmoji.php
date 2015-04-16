<?php

/**
 * ComMailEmojiクラス
 *
 * メール用絵文字処理を行うクラスです。
 *
 * 2010/09/15 nakamura
 */

require_once(D_BASE_DIR . "/func/SendMagic/Emoji.php");

class MailEmoji extends Emoji {
    /* @var array ドメインリスト */
    protected $domainList     = array(
        "docomo.ne.jp"      => "Docomo",
        "ezweb.ne.jp"       => "Ezweb",
        "softbank.ne.jp"    => "Softbank",
        "d.vodafone.ne.jp"  => "Softbank",
        "h.vodafone.ne.jp"  => "Softbank",
        "t.vodafone.ne.jp"  => "Softbank",
        "c.vodafone.ne.jp"  => "Softbank",
        "r.vodafone.ne.jp"  => "Softbank",
        "k.vodafone.ne.jp"  => "Softbank",
        "n.vodafone.ne.jp"  => "Softbank",
        "s.vodafone.ne.jp"  => "Softbank",
        "q.vodafone.ne.jp"  => "Softbank",
        "disney.ne.jp"      => "Softbank",
        "etc"               => "NonMobile",
    );

    /* @var string 携帯キャリア */
    protected $carrier    = "";

    /**
     * コンストラクタ
     *
     * キャリア判別を行う
     *
     * @param  string $domain 送信先ドメイン
     */
    public function __construct($domain) {
        $keyList = array_keys($this->domainList);
        if (in_array($domain, $keyList)) {
            $this->carrier = $this->domainList[$domain];
        } else {
            $this->carrier = $this->domainList["etc"];
        }
    }

    /**
     * getCarrierメソッド
     *
     * キャリア情報を取得する
     *
     * @param  string キャリア情報
     */
    public function getCarrier() {
        return $this->carrier;
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
     * encodeメソッド
     *
     * 文字列中の絵文字データをキャリア別の連番文字列へ変換する
     *
     * @param  string $str       絵文字が格納されている可能性のある文字列
     * @return string $returnStr 変換後の文字列を返す
     */
    public function encode($str, $carrier = "docomo") {
        switch (strtolower($carrier)) {
            case "docomo":
                $returnStr = parent::docomoEncode($str);
                break;
            case "ezweb":
                $returnStr = parent::ezwebEncode($str);
                break;
            case "softbank":
                $returnStr = parent::softbankEncode($str);
                break;
            default:
                $returnStr = $str;
                break;
        }

        return $returnStr;
    }

    /**
     * decodeCallbackメソッド
     *
     * 文字列中のキャリア別の連番文字列を絵文字データへ変換する(メール用)
     *
     * @param  array  $matches decodeメソッド内のpreg_replace_callbackでマッチしたパターン配列
     * @return string          変換後の文字列を返す
     */
    private function decodeCallback($matches) {
        if (strtolower($this->carrier) == "nonmobile") {
            return "";
        }

        // キャリア文字の先頭を大文字へ
        $toCarrier = ucfirst($this->carrier);

        switch ($matches[1]) {
            // Docomo絵文字からアクセスキャリア絵文字へ変換
            case "i":
                $func = "getDocomoTo".$toCarrier."Mail";
                $emoji =& SendMagic_ComEmojiConfig::$func();
                break;
            // Ezweb絵文字からアクセスキャリア絵文字へ変換
            case "e":
                $func = "getEzwebTo".$toCarrier."Mail";
                $emoji =& SendMagic_ComEmojiConfig::$func();
                break;
            // Softbank絵文字からアクセスキャリア絵文字へ変換
            case "s":
                $func = "getSoftbankTo".$toCarrier."Mail";
                $emoji =& SendMagic_ComEmojiConfig::$func();
                break;
        }

        return $emoji[$matches[0]];
    }
}
?>