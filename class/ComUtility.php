<?php
/**
 * ComUtility
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * @package   bigtime
 * @version   SVN:$Id$
 * @since     2009/05/12
 * */

class ComUtility {

    /** @var インスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /** @var object Configオブジェクト */
    protected $_configOBJ = null;

    /**
     *  コンストラクタ
     */
    public function __construct() {
        // 設定データのインスタンスを取得
        $this->_configOBJ = ComConfig::getInstance();

        $requestOBJ = ComRequest::getInstance();
        // ユーザーエージェント情報をセット
        $this->_httpUserAgent = $requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");
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
     *  getDeviceFromMailAddressメソッド
     *
     *  メールアドレスからデバイスを取得
     *
     *  @param  string  $mailAddress    メールアドレス
     *  @return int     デバイス
     */
    public function getDeviceFromMailAddress($mailAddress) {

        $address = strtolower($mailAddress);
        if (preg_match("/docomo.ne.jp/", $address)) {
            //Docomo
            return $this->_configOBJ->define->DEVICE_DOCOMO;
        } else if (preg_match("/ezweb.ne.jp/", $address)) {
            //Ezweb
            return $this->_configOBJ->define->DEVICE_AU;
        } else if (preg_match("/softbank.ne.jp|vodafone.ne.jp/", $address)) {
            //SoftBank
            return $this->_configOBJ->define->DEVICE_SOFTBANK;
        } else if (preg_match("/disney.ne.jp/", $address)) {
            //disney
            return $this->_configOBJ->define->DEVICE_DISNEY;
        } else {
            //それ以外
            return $this->_configOBJ->define->DEVICE_OTHER;
        }
    }

    /**
     *  getRamdomNumberメソッド
     *
     *  ランダムな数値を生成する
     *
     *  @param  int     $figure     生成したい桁数
     *  @return int     生成したランダムな数値
     */
    public function getRamdomNumber($figure) {
        $randomNumber = null;
        mt_srand((double)microtime()*1000000);
        for ($i = 0; $i < $figure; $i++) {
            $randomNumber = $randomNumber . mt_rand(1,9);
        }
        return $randomNumber;
    }

    /**
     *  writeLog
     *
     *  ログ取りメソッド
     *
     *  @param  mix     $message    ログに書き込む文字列 or 配列
     *  @param  string  $filePath   書き込むファイルのパス
     */
    public function writeLog($message, $filePath) {
        $data = "";
        $date = "[" . date("Y-m-d H:i:s") . "] ";
        if (is_array($message)) {
            foreach ($message as $key => $val) {
                if (is_array($val)) {
                    //1回まわしても配列だったら破棄します
                    break;
                }
                $data .= $date . $key . " : " . $val . "\n";
            }
        } else {
            $data .= $date . $message . "\n";
        }

        $fp = fopen($filePath, "a+");
        flock($fp, LOCK_EX);
        fputs($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);

        chmod($filePath, 0755);
    }

    /**
     * mailtoEncodeメソッド
     *
     * mailto:のsubjectとbody内のマルチバイト文字をエンコードします
     *
     * @param  stirng $str エンコードする値
     * @param  boolean $isSmartPhone ｽﾏｰﾄﾌｫﾝﾌﾗｸﾞ
     * @return string      エンコードされた値
     *
     * @author T.Kawamura
     */
    public function mailtoEncode($str,$isSmartPhone = "") {

        //ｽﾏﾎはmb_convert_encoding無し
        if($isSmartPhone){
            $str = urlencode($str);
            return $str ;
        }

        $useragentOBJ = new ComUserAgentMobile();

        // internal_encodingの設定を得る
        $internal = mb_internal_encoding();

        // キャリア別
        switch (strtolower($useragentOBJ->getCarrier())) {
            case "docomo":
            case "ezweb":
                // SJIS ⇒ urlエンコード
                $str = mb_convert_encoding($str, "SJIS", $internal);
                $str = urlencode($str);
                break;
            case "softbank":
                // UTF-8 ⇒ urlエンコード
                $str = mb_convert_encoding($str, "UTF-8", $internal);
                $str = urlencode($str);
                break;
            default:
                // ブラウザ別
                /* 将来的にはこんな感じ↓
                switch (strtolower($useragentOBJ->getBrowser())) {
                    case "ie":
                    case "opera":
                    case "firefox":
                }
                */
                $str = mb_convert_encoding($str, "SJIS", $internal);
                $str = urlencode($str);
                break;
        }

        return $str;
    }

    /**
     * getBrowserメソッド
     *
     * ブラウザ取得メソッド
     *
     * @return string  ブラウザ
     *
     * @author ryohei murata
     */
    function getBrowser(){
        $useos = "";
        $browser = "";
        $os_browser = "";

        if ( preg_match('/Mac/',$this->_httpUserAgent) ){
            $useos='mac';
        } elseif (  preg_match('/Win/',$this->_httpUserAgent) ){
            $useos='win';
        } else {
            $useos = 'other';
        }

        if ( preg_match('/Opera/',$this->_httpUserAgent) && preg_match('/Version\/([0-9]+)/',$this->_httpUserAgent, $r) ){
            $browser = 'opera'.$r[1];
        } elseif ( preg_match('/MSIE ([0-9])+/',$this->_httpUserAgent, $r) ){
            $browser = 'ie'.$r[1];
        } elseif ( preg_match('/Safari/',$this->_httpUserAgent) && preg_match('/Version\/([0-9]+)/',$this->_httpUserAgent, $r) ){
            $browser = 'safari'.$r[1];
        } elseif ( preg_match('/Chrome\/([0-9]+)/',$this->_httpUserAgent,$r) ){
            $browser = 'chrome'.$r[1];
        } elseif ( preg_match('/Firefox\/([0-9]+)/',$this->_httpUserAgent, $r) ){
            $browser = 'firefox'.$r[1];
        } elseif ( preg_match('/Gecko/',$this->_httpUserAgent) ){
            $browser = 'gecko';
        } else {
            $browser = $this->_httpUserAgent;
        }

        $os_browser = $useos.'_'.$browser;

        return $os_browser;

    }

}
?>