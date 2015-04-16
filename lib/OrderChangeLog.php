<?php
/**
 * OrderChangeLog.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  web側注文変更ログ管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class OrderChangeLog extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

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
     * 注文変更ログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertOrderingChangeLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("order_change_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 注文変更ログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateOrderingChangeLogData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("order_change_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

     /**
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

}
?>