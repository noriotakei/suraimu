<?php
/**
 * AdmLogDelete.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側ログ削除管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmLogDelete extends ComCommon {

    /** 単体削除除外テーブル */
    public static $_deleteException = array(
                            "ordering_detail",
                            "unit_user",
        );

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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
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
     *
     * ログ削除設定リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getLogDeleteSetList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("log_delete", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * ログ削除設定の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertLogDeleteSetData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("log_delete", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ログ削除設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateLogDeleteSetData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("log_delete", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ログ削除。
     *
     * @param  string $table テーブル名
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function deleteLogTable($table, $whereArray = null) {

        if (!$table) {
            return false;
        }

        $columnArray[] = "id";

        $sql = $this->makeSelectQuery($table, $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        if ($dataList) {
            foreach ($dataList as $val) {
                $delWhereArray = "";
                $delWhereArray[] = "id = " . $val["id"];

                if (!$this->delete($table, $delWhereArray)) {
                    return FALSE;
                }
            }
        }

        return TRUE;
    }

}
?>