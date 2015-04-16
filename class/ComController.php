<?php
/**
 * ComController.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * フロントコントローラー制御クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComController {

    /** @var string アクション */
    protected $_actionName = null;

    /** @var object 設定データオブジェクト */
    protected $_configOBJ = null;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->_configOBJ = ComConfig::getInstance();
    }

    /**
     * アクション名をセットする。
     *
     * @param  string $actionName アクション名
     * @return boolean
     */
    public function setActionName($actionName) {

        if (!$actionName) {
            return false;
        }

        // アクション名をセット
        $this->_actionName = $actionName;

        return true;
    }

    /**
     * アクション名の取得。
     *
     * @return string アクション名
     */
    public function getActionName() {
        return $this->_actionName;
    }

    /**
     * アクション名をディレクトリ対応型に変換する。
     *
     * @return mixed
     */
    public function convertActionName() {

        if (!$this->_actionName) {
            return false;
        }

          // アクション指定部分を「_」区切りで分解する
        $actionArray = explode("_", $this->_actionName);
        $actionName = "";

        foreach ($actionArray as $value) {
            //先頭1文字を小文字に変換
            $actionName[] = substr_replace($value, strtolower(substr($value,0,1)), 0, 1);
        }

        return implode("/", $actionName);

    }

    /**
     * getTrackingTagメソッド
     *
     * トラッキングタグの取得
     *
     * @return string
     */
    public function getTrackingTag($key = null) {

        $_config = $this->_configOBJ->toArray();
        if (is_null($key) || !$_config["common_config"]["tracking_url"][$key]) {
            return "";
        }

        if (!array_key_exists($_SERVER["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"])) {
            $url = "http://" . $_SERVER["SERVER_NAME"] . "/" . $this->getActionName();
            $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";
            $trackingUrl = sprintf($_config["common_config"]["tracking_url"][$key], urlencode($url), urlencode($referer));
            if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
               $trackingTag = "<img src=\"" . $trackingUrl . "\" width=\"0\" height=\"0\" border=\"0\">";
            }
        }

        return $trackingTag;
    }
}

?>
