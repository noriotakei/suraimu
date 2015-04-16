<?php
/**
 * ComUserAgentMobile.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * モバイルキャリア情報を扱うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComUserAgentMobile {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var object キャリア別クラスオブジェクト */
    protected $_carrierOBJ = null;

    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;

    /** @var string キャリア名 */
    protected $_carrier = null;

    /** @var string IPアドレス */
    protected $_ipAddress = null;

    /**
     * コンストラクタ
     */
    public function __construct() {

        $requestOBJ = ComRequest::getInstance();

        // ユーザーエージェント情報をセット
        $this->_httpUserAgent = $requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");
        // キャリア名をにセット
        $this->setCarrier($this->_httpUserAgent);
        // IPアドレスをセット
        $this->_ipAddress = $requestOBJ->getParameter("REMOTE_ADDR", "", "server");

        // キャリア別クラス指定
        $className = __CLASS__ . $this->_carrier;
        $classFile = dirname(__FILE__) . "/" . $className . ".php";

        if (!$this->_carrier || !file_exists($classFile)) {
            exit($this->_carrier . "用クラスファイルが存在しません！");
        }

        // キャリア別クラスインスタンスを生成
        $this->_carrierOBJ = new $className($this->_httpUserAgent);
    }

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
     */
    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            $className = __CLASS__;
            self::$_instance = new $className();
        }

        return self::$_instance;
    }

    /**
     * キャリア名をセットする。
     *
     * @param  string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     * @return string キャリア名
     */
    private function setCarrier($httpUserAgent) {

        if (!$httpUserAgent) {
            return false;
        }

        // モバイルキャリア判別用正規表現文字列
        $docomoRegex    = "^DoCoMo/\d\.\d[ /]";
        $ezwebRegex     = "^(?:KDDI-[A-Z]+\d+[A-Z]? )?UP\.Browser\/";
        $softbankRegex  = "^(?:(?:SoftBank|Vodafone|J-PHONE)/\d\.\d|MOT-)";

        // 正規表現文字列に「/」を使用するため「!」がデリミタ
        $mobileRegex = "!(?:(" . $docomoRegex . ")|(" . $ezwebRegex . ")|(" . $softbankRegex . "))!";

        // モバイルキャリア判別
        if (preg_match($mobileRegex, $httpUserAgent, $matches)) {
            // Docomoの場合
            if (@$matches[1]) {
                $this->_carrier = "Docomo";
            // AUの場合
            } else if (@$matches[2]) {
                $this->_carrier = "Ezweb";
            // SoftBankの場合
            } else if (@$matches[3]) {
                $this->_carrier = "Softbank";
            } else {
                return false;
            }
        // PCその他の場合
        } else {
            $this->_carrier = "NonMobile";
        }

        return true;
    }

    /**
     * ユーザーエージェント情報を取得する。
     *
     * @return string ユーザーエージェント情報
     */
    public function getHttpUserAgent() {
        return $this->_httpUserAgent;
    }

    /**
     * キャリア名を取得する。
     *
     * @return string キャリア名
     */
    public function getCarrier() {
        return $this->_carrier;
    }

    /**
     * IPアドレスを取得する。
     *
     * @return string IPアドレス
     */
    public function getIpAddress() {
        return $this->_ipAddress;
    }

    /**
     * 3G端末(第三世代携帯電話)であるかのチェック。
     *
     * ここでの基本的な3Gの定義としては、テーブルタグ&CSSが使えるかどうか。
     *
     * @return boolean 3G端末であればtrue、そうでなければfalse
     */
    public function is3G() {

        switch ($this->_carrier) {
            case "Docomo":
                $methodName = "isFoma3G";
                break;
            case "Ezweb":
                $methodName = "isWin";
                break;
            case "Softbank":
                $methodName = "isType3Gc";
                break;
            default:
                return false;
        }

        if (!method_exists($this->_carrierOBJ, $methodName)) {
            return false;
        }
        return $this->_carrierOBJ->$methodName($this->_httpUserAgent);
    }

    /**
     * 未定義メソッドのオーバーロード。
     *
     * @param  string $methodName 呼び出したメソッド名
     * @param  array $params 渡された引数
     * @return mixed
     */
    public function __call($methodName, $params) {

        $arguments = implode(",", $params);

        if (!method_exists($this->_carrierOBJ, $methodName)) {
            return false;
        }

        return $this->_carrierOBJ->$methodName($arguments);
    }
}

?>
