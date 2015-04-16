<?php
/**
 * PointLog.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * WEB側 ポイントログ管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class PointLog extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string 検索条件内容 */
    private $_contents = null;

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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * insertPointLogメソッド
     *
     * ポイントログインサート
     *
     * @param array $insertArray INSERTデータ配列
     * @return mixed インサートID
     */
    public function insertPointLog ($insertArray) {

        if (!isset($insertArray) || !is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("point_log", $insertArray)) {
            return false;
        }

        return $this->getInsertId();
    }

}
?>