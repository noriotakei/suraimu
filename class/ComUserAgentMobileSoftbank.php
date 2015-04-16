<?php
/**
 * ComUserAgentMobileSoftbank.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * SoftBank端末情報を扱うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComUserAgentMobileSoftbank {

    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;

    /** @var object リクエストobject */
    protected $_requestOBJ = null;

    /**
     * コンストラクタ
     *
     * @param string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     */
    public function __construct($httpUserAgent) {
        $this->_httpUserAgent = $httpUserAgent;
        $this->_requestOBJ = ComRequest::getInstance();
    }

    /**
     * 3GC型かどうかを判別する。
     *
     * @return boolean 3GC型ならtrue、でなければfalseを返す
     */
    public function isType3Gc() {

        if (!$this->_httpUserAgent) {
            return false;
        }

        // 正規表現文字列に「/」を使用するため、「!」がデリミタ
        $type3gcRegex = "!^(?:(?:(J-PHONE)|Vodafone|SoftBank)/\d\.\d|MOT-)!";

        if (!preg_match($type3gcRegex, $this->_httpUserAgent, $matches)) {
            return false;
        }

        // J-PHONEは3GC型ではない
        if (count($matches) > 1) {
            return false;
        }

        return true;
    }

    /**
     * 携帯機種名を取得する。
     *
     * @return mixed 取得成功なら携帯機種名、失敗ならfalse
     */
    public function getModel() {

        // J-PHONE時代から存在する環境変数が存在する場合
        if ($this->_requestOBJ->getParameter("HTTP_X_JPHONE_MSNAME", "", "server")) {
            return $this->_requestOBJ->getParameter("HTTP_X_JPHONE_MSNAME", "", "server");
        }

        // 正規表現文字列に「/」を使用するため、「!」がデリミタ
        $modelRegex = "!^(?:(?:J-PHONE|Vodafone|SoftBank)/\d\.\d/([a-zA-Z0-9-]+)/|MOT-([CV]980))!";

        if (!preg_match($modelRegex, $this->_httpUserAgent, $matches)) {
            return false;
        }

        switch (count($matches)) {
            case 2:
                $model = $matches[1];
                break;
            case 3:
                $model = $matches[2];
                break;
            default:
                return false;
        }

        return $model;
    }

    /**
     * 個体識別番号(端末シリアル番号)を取得する。
     *
     * @return string 端末シリアル番号
     */
    public function getSerialNumber() {
        return $this->_requestOBJ->getParameter("HTTP_X_JPHONE_UID", "", "server");
    }
}

?>
