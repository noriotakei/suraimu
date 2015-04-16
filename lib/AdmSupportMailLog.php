<?php
/**
 * AdmSupportMailLog.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側サポートメールログ管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmSupportMailLog extends ComCommon {

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
     *
     * サポートメールログデータの取得
     *
     * @param  integer $id サポートメールID
     *
     * @return array データ配列
     */
    public function getSupportMailLogData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_log", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * サポートメールログリストの取得
     *
     * @param  integer $id 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getSupportMailLogList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY id DESC";

        $sql = $this->makeSelectQuery("support_mail_log", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * サポートメールログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertSupportMailLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("support_mail_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * サポートメールログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateSupportMailLogData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("support_mail_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * サポートメール送信ログデータの取得。
     *
     * @param  integer $id サポートメール送信ログID
     * @return mixed サポートメール送信ログデータ、失敗ならfalse
     */
    public function getSupportMailSendLogData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_send_log", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * サポートメール送信ログリストの取得。
     *
     * @return mixed サポートメール送信ログリスト、失敗ならfalse
     */
    public function getSupportMailSendLogList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";


        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if (ComValidation::isArray($param["mail_reserve_type"])) {
            $whereArray[] = "mail_reserve_type IN (" . implode(",", $param["mail_reserve_type"]) . ")";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("support_mail_send_log", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }


    /**
     *
     *  サポートメール送信ログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertSupportMailSendLog($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("support_mail_send_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  サポートメール送信ログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateSupportMailSendLog($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("support_mail_send_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
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