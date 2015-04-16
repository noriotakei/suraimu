<?php
/**
 * AdmTmpAdminAccess.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理画面アクセス情報管理クラス
 *
 * @copyright   2011 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmTmpAdminAccess extends ComCommon {

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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * 管理画面アクセス情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @param  array $updateArray 更新データ配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function insertDuplicateAdmAccessData($insertArray, $updateAry, $autoQuotes = true) {

        if (!is_array($insertArray) OR !is_array($updateAry)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insertDuplicate("tmp_admin_access", $insertArray, $updateAry, $autoQuotes)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 管理画面アクセス情報の取得。
     *
     * @return mixed 管理画面アクセスリスト、失敗ならfalse
     */

    public function getList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        //$whereArray[] = "disable = 0";

        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if ($param["admin_id"]) {
            $whereArray[] = "admin_id = " .$param["admin_id"] ;
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("tmp_admin_access", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

}
?>