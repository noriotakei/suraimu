<?php
/**
 * AdmOrderChangeLog.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側注文変更ログ管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmOrderChangeLog extends ComCommon {

    // 変更時ステータス
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID = 1;
    const STATUS_PRE_PAID = 2;

    /** @var array 変更時ステータス配列 */
    public static $_status = array(
                self::STATUS_NOT_PAID => "未入金",
                self::STATUS_PAID            => "入金済み",
                self::STATUS_PRE_PAID     => "仮購入",
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
     * 注文変更ログリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getOrderingChangeLogList($param, $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.name";
        $columnArray[] = "ordering.create_datetime as ordering_create_datetime";
        $columnArray[] = "order_change_log.ordering_id";
        $columnArray[] = "order_change_log.price";
        $columnArray[] = "order_change_log.status";
        $columnArray[] = "order_change_log.create_datetime as order_change_log_create_datetime";

        $whereArray[] = "item.id = order_change_log.item_id";
        $whereArray[] = "order_change_log.ordering_id = ordering.id";
        $whereArray[] = "ordering.disable = 0";
        $whereArray[] = "order_change_log.disable = 0";

        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "ordering.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
        }

        if (ComValidation::isArray($param["status"])) {
            $whereArray[] = "order_change_log.status IN (" . implode(",", $param["status"]) . ")";
        }

        if (ComValidation::isNumeric($param["search_ordering_id"])) {
            $whereArray[] = "ordering.id = " . $param["search_ordering_id"];
        }

        if (ComValidation::isDateTime($param["order_start_datetime"])) {
            $whereArray[] = "ordering.create_datetime >= '" . $param["order_start_datetime"] . "'";
        }

        if (ComValidation::isDateTime($param["order_end_datetime"])) {
            $whereArray[] = "ordering.create_datetime <= '" . $param["order_end_datetime"] . "'";
        }

        if (ComValidation::isDate($param["change_start_datetime"])) {
            $whereArray[] = "order_change_log.create_datetime >= '" . $param["change_start_datetime"] . "'";
        }

        if (ComValidation::isDate($param["change_end_datetime"])) {
            $whereArray[] = "order_change_log.create_datetime <= '" . $param["change_end_datetime"] . "'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("order_change_log, ordering, item", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * 注文変更アイテムリストの取得
     *
     * @param  integer $orderingId 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getChangeItemList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }


        $columnArray[] = "SQL_CALC_FOUND_ROWS item.name";
        $columnArray[] = "item.access_key";
        $columnArray[] = "order_change_log.id";
        $columnArray[] = "order_change_log.item_id";
        $columnArray[] = "order_change_log.ordering_id";
        $columnArray[] = "order_change_log.price";
        $columnArray[] = "order_change_log.status";

        $whereArray[] = "order_change_log.ordering_id = ordering.id";
        $whereArray[] = "ordering.disable = 0";
        $whereArray[] = "order_change_log.disable = 0";
        $whereArray[] = "ordering.id = " . $orderingId;

        $otherArray[] = " ORDER BY order_change_log.id DESC";

        $sql = $this->makeSelectQuery("ordering, order_change_log LEFT OUTER  JOIN item ON item.id = order_change_log.item_id", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

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