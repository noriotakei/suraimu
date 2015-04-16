<?php
/**
 * SettlementCredit.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  銀行振込決済クラス
 *   銀行振込決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SettlementCredit extends Settlement {

    const CREDIT_DEFAULT_SEND = "cardsv";
    const CREDIT_CLIENT_IP_PC = "1011000263";
    const CREDIT_CLIENT_IP_MB = "59199";
    const CREDIT_DEFAULT_IMODEPAY = "yes";
    const CREDIT_QUICKCHARGE_CARDNUMBER = "8888888888888888"; // クイックチャージ用カードナンバー
    const CREDIT_DEFAULT_TELSTR = "yes";
//    const CREDIT_SSL_PC_URL = "https://credit.zeroweb.ne.jp/cgi-bin/order.cgi?orders";
//    const CREDIT_SSL_MB_URL = "https://credit.zeroweb.ne.jp/cgi-bin/order.cgi";
//    const CREDIT_QUICK_URL = "https://credit.zeroweb.ne.jp/cgi-bin/secure.cgi";
    const CREDIT_SSL_PC_URL = "https://gw.axes-payment.com/cgi-bin/credit/order.cgi";
    const CREDIT_SSL_MB_URL = "https://gw.axes-payment.com/cgi-bin/credit/order.cgi";
    const CREDIT_QUICK_URL = "https://gw.axes-payment.com/cgi-bin/secure.cgi";

    const CREDIT_DEFAULT_CUSTOM = "yes";
    const CREDIT_DEFAULT_ACT = "imode";
    const CREDIT_QUICK_ENTRY = "non";
    const CREDIT_QUICK_EXPYY = "01";
    const CREDIT_QUICK_EXPMM = "01";


    /** @var string エラーメッセージ */
    protected $_errorMsg = null;
    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;
    /** @var string 決済方法 */
    private $_settleType;
    /** @var array デフォルトで渡すPOSTデータ */
    private $_defaultPostData = array();
    /** @var array セットするPOSTデータ CTI用 */
    private $_postData = array();
    /** @var array デフォルトで渡すHIDDENデータ */
    private $_hiddenData = array();

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
     * setSettleTypeメソッド
     *
     * 決済方法のセット。
     *
     * @param string $settleType  決済方法 "pc" or "mb" or "quick" or "quick_pc"
     * @return void
     *
     */
    public function setSettleType($settleType) {

        if (!isset($settleType)) {
            return false;
        }

        if (!is_null($settleType)) {
            $this->_settleType = $settleType;
        }

    }

    /**
     * setHiddenDataメソッド
     *
     * hiddenTagデータをセット。(PC,MB SSL決済用)
     *
     * @param string $name  キー名
     * @param string $value 値
     * @return void
     *
     */
    public function setHiddenData($name, $value) {

        if (!isset($name) || !isset($value)) {
            return false;
        }

        $this->_hiddenData[$name] = $value;

    }

    /**
     * setPostDataメソッド
     *
     * POSTデータをセット。(MB CTI決済用)
     *
     * @param string $name  キー名
     * @param string $value 値
     * @return void
     *
     */
    public function setPostData($name, $value) {

        if (!isset($name) || !isset($value)) {
            return false;
        }

        $this->_postData[$name] = $value;

    }

    /**
     * setDefaultPostDataメソッド
     *
     * 既定のPOSTデータをセット。
     *
     * @return void
     *
     */
    public function setDefaultPostData() {

        // 渡さなくてはならない既定のデータをセット
        switch ($this->_settleType) {
            case "pc":
                $this->_defaultPostData["send"]      = self::CREDIT_DEFAULT_SEND;
                $this->_defaultPostData["clientip"]  = self::CREDIT_CLIENT_IP_PC;
                $this->_defaultPostData["custom"]      = self::CREDIT_DEFAULT_CUSTOM;
                break;
            case "mb":
                $this->_defaultPostData["clientip"]    = self::CREDIT_CLIENT_IP_MB;
                $this->_defaultPostData["act"]         = self::CREDIT_DEFAULT_ACT;
                break;
            case "quick_pc":
                $this->_defaultPostData["send"]      = self::CREDIT_DEFAULT_SEND;
                $this->_defaultPostData["clientip"]  = self::CREDIT_CLIENT_IP_PC;
                $this->_defaultPostData["cardnumber"]  = self::CREDIT_QUICKCHARGE_CARDNUMBER;
                $this->_defaultPostData["entry"]  = self::CREDIT_QUICK_ENTRY;
                $this->_defaultPostData["expyy"]  = self::CREDIT_QUICK_EXPYY;
                $this->_defaultPostData["expmm"]  = self::CREDIT_QUICK_EXPMM;
                break;
            case "quick":
                $this->_defaultPostData["send"]      = self::CREDIT_DEFAULT_SEND;
                $this->_defaultPostData["clientip"]  = self::CREDIT_CLIENT_IP_MB;
                $this->_defaultPostData["cardnumber"]  = self::CREDIT_QUICKCHARGE_CARDNUMBER;
                $this->_defaultPostData["entry"]  = self::CREDIT_QUICK_ENTRY;
                $this->_defaultPostData["expyy"]  = self::CREDIT_QUICK_EXPYY;
                $this->_defaultPostData["expmm"]  = self::CREDIT_QUICK_EXPMM;
                break;
            default:
                $this->_defaultPostData["send"]      = self::CREDIT_DEFAULT_SEND;
                $this->_defaultPostData["clientip"]  = self::CREDIT_CLIENT_IP_MB;
                $this->_defaultPostData["imodepay"]  = self::CREDIT_DEFAULT_IMODEPAY;
                $this->_defaultPostData["telstr"]    = self::CREDIT_DEFAULT_TELSTR;
                break;
        }
    }

    /**
     * makeCreditHiddenTagsメソッド
     *
     * hiddenTagデータを生成。(PC,MB SSL決済用)
     *
     * @return string $hiddenTags
     *
     */
    public function makeCreditHiddenTags() {

        $hiddenTags = "";

        if (is_array($this->_hiddenData)) {
            foreach ($this->_hiddenData as $keyName => $value) {
                $hiddenTags .= "<input type=\"hidden\" name=\"" . $keyName . "\" value=\"" . $value . "\">\n";
            }
        } else {
            return false;
        }

        // 既定のデータをセット
        $this->setDefaultPostData();

        if (is_array($this->_defaultPostData)) {
            foreach ($this->_defaultPostData as $keyNameDefault => $valueDefault) {
                $hiddenTags .= "<input type=\"hidden\" name=\"" . $keyNameDefault . "\" value=\"" . $valueDefault . "\">\n";
            }
        } else {
            return false;
        }

        return $hiddenTags;
    }

    /**
     * sendToCreditメソッド
     *
     * クレジットサーバー決済問い合わせ。
     *
     * @return string or boolean クイック決済の場合はtrue
     *
     */
    public function sendToCredit() {

        // 規定値のセット
        $this->setDefaultPostData();

        // POSTデータ成形
        if (is_array($this->_postData) && is_array($this->_defaultPostData)) {
            $dataArray = array_merge($this->_postData, $this->_defaultPostData);
        }

        // 決済URL取得
        $url = $this->getCreditSettleUrl();

        $parse = parse_url($url);

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        // http通信
        $ComHttpOBJ = new ComHttp($url, $httpParam);
        $ComHttpOBJ->setParameterPost($dataArray);
        $result = $ComHttpOBJ->request("POST");

        if ($result->isSuccessful()) {
            $return = $result->getBody();
            if (preg_match("/Success_order/", $return)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * getCreditSettleUrlメソッド
     *
     * 決済申込URLを取得。
     *
     * @return string
     *
     */
    public function getCreditSettleUrl() {

        if (!isset($this->_settleType)) {
            return false;
        }

        $settleType = strtolower($this->_settleType);

        $creditSettleUrl = "";

        switch ($settleType) {
            // PC SSL
            case "pc":
                $creditSettleUrl = self::CREDIT_SSL_PC_URL;
                break;
            // MB SSL
            case "mb":
                $creditSettleUrl = self::CREDIT_SSL_MB_URL;
                break;
            // クイックチャージ
            case "quick":
                $creditSettleUrl = self::CREDIT_QUICK_URL;
                break;
            // クイックチャージ PC
            case "quick_pc":
                $creditSettleUrl = self::CREDIT_QUICK_URL;
                break;
            default:
                return false;
                break;
        }

        return $creditSettleUrl;

    }

}

?>
