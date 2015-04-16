<?php

/**
 *
 * @copyright   2014 Lampart, Inc.
 * @author      hoang_minh
 */
class AdmAutoPointGrant extends ComCommon {

    /** @var string */
    protected $_errorMsg = null;

    /** @var object */
    protected static $_instance = null;

    /**
     * constructor
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
     * getInstance
        *
     * @return object $instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getReservePointGrantDataById($id) {

        if (!$id || !ComValidation::isNumeric($id)) {
            return false;
        }

        $columnArray[] = "*";
        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("reserve_point_grant", $columnArray, $whereArray);

        // ユーザー検索情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     *
     * @param  array $param
     *
     * @return array
     */
    public function getReservePointGrantData($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "update_user_point_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }

        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "update_user_point_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if (ComValidation::isValue($param["is_exec"])) {
            $whereArray[] = "is_exec = '" . $param["is_exec"] . "'";
        }

        $whereArray[] = "disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("reserve_point_grant", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * @param  array $insertArray
     *
     * @return boolean
     */
    public function insertReservePointGrantData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("reserve_point_grant", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * @param  array $updateArray, array $whereArray
     *
     * @return boolean
     */
    public function updateReservePointGrantData($updateArray, $whereArray = null, $table = "reserve_point_grant", $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update($table, $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

}
?>