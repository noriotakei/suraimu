<?php
/**
 * This class work with 'user_profile_flag' table
 *
 * @author Hoang Minh
 * @since 2014-11-27
 */

class AdmUserProfileFlag extends ComCommon {

    /** @var object $_instance  **/
    protected static $_instance = null;

    /** @var string $_errorMsg  **/
    private $_errorMsg = null;

    /** @var string $_listSql  **/
    private $_listSql = null;

    /** @var array $_contents  **/
    private $_contents = null;

    public function __construct() {
        parent::__construct();
    }

    /**
     * getInstance
     *
     * @param null
     * @return object $_instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * getErrorMsg
     *
     * @param NULL
     * @return string $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * getListSql
     *
     * @param NULL
     * @return string $_listSql
     */
    public function getListSql() {
        return $this->_listSql;
    }

    /**
     * getWhereContents
     *
     * @param NULL
     * @return array $_contents
     */
    public function getWhereContents() {
        return $this->_contents;
    }

    /**
     * get user_profile_flag by conditions
     *
     * @param  array $param (conditions)
     * @param  integer $offset (from)
     * @param  string $order (sort)
     * @param  integer $limit (number of records)
     * @return array
     */
    public function getUserProfileFlag($param = null, $offset = null, $order = null, $limit = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray = $this->setWhereString($param);

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $this->_listSql = $this->makeSelectQuery("user_profile_flag", $columnArray, $whereArray, $otherArray);
        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * setWhereString
     *
     * @param  array $param
     * @return array $where
     */
    public function setWhereString($param) {
        $where[] = "user_profile_flag.disable = 0";

        //user_profile_flag_code
        if ($param["code"] || $param["code"]=== 0) {
            $where[] = "user_profile_flag.code IN (" . $param["code"] . ")";
            $this->_contents["user profile flag code"] = $param["code"];
        }

        return $where;
    }

    /**
     * insertUserProfileFlagData。
     *
     * @param  array $insertArray
     * @return boolean
     */
    public function insertUserProfileFlagData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("user_profile_flag", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * updateUserProfileFlagData
     *
     * @param  array $updateArray
     * @param  array $whereArray
     * @param  string $table
     * @param  int   $autoQuotes
     *
     * @return boolean
     */
    public function updateUserProfileFlagData($updateArray, $whereArray = null, $table = "user_profile_flag", $autoQuotes = true) {

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









