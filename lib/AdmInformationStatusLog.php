<?php
/**
 * AdmInformationStatusLog.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報ログデータの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class AdmInformationStatusLog extends ComCommon {

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
     * 情報リストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getInformationStatusLogList($param, $offset = 0, $order = null, $limit = 0) {

        if (!is_numeric($param["user_id"])) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS ims.*";
        $columnArray[] = "log.create_datetime log_create_datetime";

        $whereArray[] = "ims.id = log.information_status_id";
        $whereArray[] = "log.user_id = " . $param["user_id"];
        $whereArray[] = "ims.disable = 0";
        $whereArray[] = "log.disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_status AS ims, information_status_log AS log", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

}
?>