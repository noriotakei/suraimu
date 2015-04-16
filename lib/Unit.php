<?php
/**
 * Unit.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * WEB側ユニット管理クラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class Unit extends ComCommon {

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
     * isInUnitUserメソッド
     *
     * ユーザがユニットに含まれているかを調べる
     * @param  integer $unitId ユニットID
     * @param  integer $userId ユーザID
     * @return boolean
     */
    public function isInUnitUser($userId, $unitId) {

        // 引数が不正ならFALSE
        if (!is_numeric($userId) || !isset($unitId)) {
            return FALSE;
        }

        $columnArray[] = "uu.id";

        $whereArray[] = "u.id = uu.unit_id";
        $whereArray[] = "uu.unit_id IN (" . $unitId . ")";
        $whereArray[] = "uu.user_id = " . $userId;
        $whereArray[] = "u.disable = 0";
        $whereArray[] = "uu.disable = 0";

        $sql = $this->makeSelectQuery("unit_user AS uu, unit AS u", $columnArray, $whereArray);

        if (!$this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return TRUE;
    }

}

?>