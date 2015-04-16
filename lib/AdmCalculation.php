<?php
/**
 * AdmCalculation.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側集計クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmCalculation extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

     /** @var Array 曜日配列 */
    public static $_weekArray = array(
            "0" => "日",
            "1" => "月",
            "2" => "火",
            "3" => "水",
            "4" => "木",
            "5" => "金",
            "6" => "土",
        );

     /** @var Array アドレス有無配列 */
    public static $_specifyArray = array(
            "0" => "気にしない",
            "1" => "あり",
            "2" => "なし",
        );


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
     * 集計用ユーザーデータリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $columnArray 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcUserList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);

        $sql = $this->makeSelectQuery("v_user_profile u", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用注文データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $columnArray 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcOrderingList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = o.user_id";

        $sql = $this->makeSelectQuery("v_user_profile u, ordering o", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用購入回数別集計データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $columnArray 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcContributionList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "o.id = od.ordering_id";

        $sql = $this->makeSelectQuery("v_user_profile u, ordering o, ordering_detail od", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用売り上げデータリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $column 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcSalesList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "p.ordering_id = o.id";

        $sql = $this->makeSelectQuery("v_user_profile u, ordering o, payment_log p", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用会員数合計データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcUserCount($param = "", $columnArray = "", $addWhereArray, $otherArray = null) {

        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_PRE_MEMBER . " ,1, NULL)) AS pre_user";
        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER . " ,1, NULL)) AS user";
        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . " ,1, NULL)) AS quit_user";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "),1, NULL)) AS pc_is_mailmagazine_ok";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_FAIL . "),1, NULL)) AS pc_is_mailmagazine_ng";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "),1, NULL)) AS send_status_ok_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_FAIL . "),1, NULL)) AS send_status_ng_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_DO . "),1, NULL)) AS send_ok_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_NO_ADDR . "),1, NULL)) AS no_addr_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_REFUSAL . "),1, NULL)) AS refusal_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_NO_DOMAIN . "),1, NULL)) AS no_domain_pc";
        $columnArray[] = "COUNT(IF((u.pc_address != '' AND u.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_FAIL_AUTO . "),1, NULL)) AS fail_auto_pc";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "),1, NULL)) AS mb_is_mailmagazine_ok";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_FAIL . "),1, NULL)) AS mb_is_mailmagazine_ng";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "),1, NULL)) AS send_status_ok_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_FAIL . "),1, NULL)) AS send_status_ng_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_DO . "),1, NULL)) AS send_ok_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_NO_ADDR . "),1, NULL)) AS no_addr_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_REFUSAL . "),1, NULL)) AS refusal_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_NO_DOMAIN . "),1, NULL)) AS no_domain_mb";
        $columnArray[] = "COUNT(IF((u.mb_address != '' AND u.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_FAIL_AUTO . "),1, NULL)) AS fail_auto_mb";

        $whereArray = $this->setWhereString($param, $addWhereArray);

        $sql = $this->makeSelectQuery("v_user_profile u", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 集計用会員数月別合計データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcUserCountGroupMonth($param = "", $columnArray = "", $addWhereArray, $otherArray = null) {

        $columnArray[] = "DATE_FORMAT(u.pre_regist_datetime, '%Y年%m月') AS pre_regist_month";
        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_PRE_MEMBER . " ,1, NULL)) AS pre_user";
        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER . " ,1, NULL)) AS user";

        $whereArray = $this->setWhereString($param, $addWhereArray);

        $otherArray[] = "GROUP BY pre_regist_month";
        $otherArray[] = "ORDER BY pre_regist_month";

        $sql = $this->makeSelectQuery("v_user_profile u", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 集計用退会会員数月別合計データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcQuitUserCountGroupMonth($param = "", $columnArray = "", $addWhereArray, $otherArray = null) {

        $columnArray[] = "DATE_FORMAT(u.quit_datetime, '%Y年%m月') AS quit_month";
        $columnArray[] = "COUNT(IF(u.regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . " ,1, NULL)) AS quit_user";

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.quit_datetime > '0000-00-00 00:00:00'";

        $otherArray[] = "GROUP BY quit_month";
        $otherArray[] = "ORDER BY quit_month";

        $sql = $this->makeSelectQuery("v_user_profile u", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * 集計用商品別売り上げデータリストの取得
     *
     * @param  array $param パラメーター
     *
     * @return array $dataList データ配列
     */
    public function getCalcItemList($param) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS SUM(od.price) AS total_pay";
        $columnArray[] = "COUNT(od.id) AS ordering_cnt";
        $columnArray[] = "od.price";
        $columnArray[] = "od.is_rest";
        $columnArray[] = "item.id AS item_id";
        $columnArray[] = "item.name AS item_name";
        $columnArray[] = "item.item_category_id";
        $columnArray[] = "item_category.name as item_category_name";

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "od.ordering_id = o.id";
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.is_paid = 1";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "o.paid_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
        $whereArray[] = "o.paid_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";

        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "o.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
        }

        if ($param["item_id"]) {
            $whereArray[] = "item.id IN (" . trim($param["item_id"], ",") . ")";
        }

        if ($param["item_category_id"]) {
            $whereArray[] = "item.item_category_id IN (" . trim($param["item_category_id"], ",") . ")";
        }

        $otherArray[] = " GROUP BY item.id, od.price";
        $otherArray[] = " ORDER BY item.id";

        $sql = $this->makeSelectQuery("ordering o, v_user_profile u, ordering_detail od LEFT OUTER JOIN item LEFT OUTER JOIN item_category ON item.item_category_id = item_category.id ON item.id = od.item_id", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * 集計用当月登録商品別売り上げデータリストの取得
     *
     * @param  array $param パラメーター
     *
     * @return array $dataList データ配列
     */
    public function getCalcItemMonthList($param) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS SUM(od.price) AS total_pay";
        $columnArray[] = "COUNT(od.id) AS ordering_cnt";
        $columnArray[] = "od.price";
        $columnArray[] = "od.is_rest";
        $columnArray[] = "item.id AS item_id";
        $columnArray[] = "item.name AS item_name";
        $columnArray[] = "item.item_category_id";
        $columnArray[] = "item_category.name as item_category_name";

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "od.ordering_id = o.id";
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.is_paid = 1";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "o.paid_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
        $whereArray[] = "o.paid_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";
        $whereArray[] = "u.regist_datetime >= '" . date("Y-m-01 00:00:00", strtotime($param["date"])) . "'";
        $whereArray[] = "u.regist_datetime <= '" . date("Y-m-t 23:59:59", strtotime($param["date"])) . "'";

        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "o.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
        }

        if ($param["item_id"]) {
            $whereArray[] = "item.id IN (" . trim($param["item_id"], ",") . ")";
        }

        if ($param["item_category_id"]) {
            $whereArray[] = "item.item_category_id IN (" . trim($param["item_category_id"], ",") . ")";
        }

        $otherArray[] = " GROUP BY item.id, od.price";
        $otherArray[] = " ORDER BY item.id";

        $sql = $this->makeSelectQuery("ordering o, v_user_profile u, ordering_detail od LEFT OUTER JOIN item LEFT OUTER JOIN item_category ON item.item_category_id = item_category.id ON item.id = od.item_id", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * 集計用商品ランキングデータリストの取得
     *
     * @param  array $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $addOtherArray その他
     *
     * @return array $dataList データ配列
     */
    public function getItemRankingList($param, $addWhereArray, $addOtherArray = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.id AS item_id";
        $columnArray[] = "item.item_category_id";
        $columnArray[] = "item_category.name as item_category_name";
        $columnArray[] = "COUNT(IF(o.is_paid = 1 && (o.status = " . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE
         . " || o.status = " . AdmOrdering::ORDERING_STATUS_COMPLETE . " || o.status = " . AdmOrdering::ORDERING_STATUS_REST . ") ,1, NULL)) AS item_cnt";
        $columnArray[] = "COUNT(o.id) order_cnt";
        $columnArray[] = "SUM(IF(o.is_paid = 1 && (o.status = " . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE
         . " || o.status = " . AdmOrdering::ORDERING_STATUS_COMPLETE . " || o.status = " . AdmOrdering::ORDERING_STATUS_REST . "), od.price, 0)) AS price";
        $columnArray[] = "SUM(od.price) AS order_price";
        $columnArray[] = "item.name AS item_name";
        $columnArray[] = "item.sales_start_datetime AS sales_start_datetime";
        $columnArray[] = "item.sales_end_datetime AS sales_end_datetime";
        $columnArray[] = "item.access_key AS item_access_key";
        $columnArray[] = "(COUNT(IF(o.is_paid = 1 && (o.status = " . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE
         . " || o.status = " . AdmOrdering::ORDERING_STATUS_COMPLETE . " || o.status = " . AdmOrdering::ORDERING_STATUS_REST . ") ,1, NULL)) / COUNT(o.id)) * 100 AS buy_persent";
        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "item.id = od.item_id";
        $whereArray[] = "od.ordering_id = o.id";
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "o.disable = 0";
        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "o.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
        }

        $otherArray[] = "GROUP BY item.id";
        $otherArray = array_merge($otherArray, (array)$addOtherArray);

        $sql = $this->makeSelectQuery("ordering o, v_user_profile u, ordering_detail od ,item LEFT OUTER JOIN item_category ON item.item_category_id = item_category.id", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 集計用退会ユーザーデータリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcQuitUserList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);

        $whereArray[] = "u.regist_status IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")";

        $sql = $this->makeSelectQuery("v_user_profile u", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用入金データリストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $column 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcPaymentList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = o.user_id";
        $whereArray[] = "u.user_id = p.user_id";
        $whereArray[] = "o.id = p.ordering_id";
        $whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.is_paid = 1";
        $whereArray[] = "p.is_cancel = 0";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "p.disable = 0";

        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "p.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
        }

        $sql = $this->makeSelectQuery("v_user_profile u, ordering o, payment_log p", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用銀行振込データリストの取得
     *
     * @param  array $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $column 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcBasLogList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = bas.user_id";
        $whereArray[] = "bas.disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile u, bas_log bas", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用エラー銀行振込データリストの取得
     *
     * @param  array $addWhereArray 追加条件
     * @param  array $column 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcErrBasLogList($columnArray, $whereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray[] = "bas.disable = 0";
        $whereArray[] = "bas.user_id = 0";

        $sql = $this->makeSelectQuery("bas_log bas", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 集計用情報閲覧回数データリストの取得
     *
     * @param  array $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $column 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getCalcInformationStatusLogList($param = "", $columnArray, $addWhereArray, $otherArray = null) {

        if (!$columnArray) {
            return false;
        }

        $whereArray = $this->setWhereString($param, $addWhereArray);
        $whereArray[] = "u.user_id = isl.user_id";
        $whereArray[] = "isl.information_status_id = infs.id";
        $whereArray[] = "isl.disable = 0";
        $whereArray[] = "infs.disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile u, information_status_log isl, information_status infs", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }


    /**
     * ユーザー検索の条件文の作成
     *
     * @param  array $param データ配列
     * @param  array $addWhereArray 追加条件*
     *
     * @return array 検索条件文配列
     */
    public function setWhereString($param, $addWhereArray) {

        $addWhereArray[] = "u.user_disable = 0";
        $addWhereArray[] = "u.admin_id = 0";

        if (!$param AND !$addWhereArray) {
            return $where;
        }

        $where = $addWhereArray;

        // PCアドレス
        if ($param["pc_address_specify"]) {
            // あり
            if ($param["pc_address_specify"] == 1) {
                $where[] = "u.pc_address != ''";
            // なし
            } else if ($param["pc_address_specify"] == 2) {
                $where[] = "u.pc_address = ''";
            }
        }

        // MBアドレス
        if ($param["mb_address_specify"]) {
            // あり
            if ($param["mb_address_specify"] == 1) {
                $where[] = "u.mb_address != ''";
            // なし
            } else if ($param["mb_address_specify"] == 2) {
                $where[] = "u.mb_address = ''";
            }
        }

        // PCデバイス
        if (ComValidation::isArray($param["pc_device_cd"])) {
            $where[] = "u.pc_device_cd IN (" . implode(",", $param["pc_device_cd"]) . ")";
        }

        // MBデバイス
        if (ComValidation::isArray($param["mb_device_cd"])) {
            $where[] = "u.mb_device_cd IN (" . implode(",", $param["mb_device_cd"]) . ")";
        }

        // 性別
        if(ComValidation::isArray($param["sex_cd"])){
            $where[] = "u.sex_cd IN (" . implode(",", $param["sex_cd"]) . ")";
        }

        /** 媒体コード */
        if($param["media_cd"]){
            $mediaCdArray = explode(",", $param["media_cd"]);
            foreach ($mediaCdArray as $key => $val) {
                $mediaCdArray[$key] = "u.media_cd LIKE '" . $val . "'";
            }
            $where[] = "(" . implode(" OR ", $mediaCdArray) . ")";
        }

        // 登録入口カテゴリー
        if ($param["regist_page_category_id"]) {
            // ダイレクト登録
            if (is_numeric(array_search(0, $param["regist_page_category_id"]))) {
                $subWhere = " OR u.regist_page_id = 0";
            }
            $where[] = "(EXISTS ("
                    ." SELECT u.user_id FROM regist_page"
                    ." WHERE regist_page.regist_page_category_id IN (" . implode(",", $param["regist_page_category_id"]) . ")"
                    ." AND regist_page.id = u.regist_page_id)" . $subWhere . ")";
        }

        // 登録入口ID
        if ($param["regist_page_id"]) {
            if (!in_array("", explode(",", $param["regist_page_id"]))) {
                $where[] = "u.regist_page_id IN (" . $param["regist_page_id"] . ")";
            }
        }

        // 対象外登録入り口ID
        if ($param["except_regist_page_id"]) {
            if (!in_array("", explode(",", $param["except_regist_page_id"]))) {
                $where[] = "u.regist_page_id NOT IN (" . $param["except_regist_page_id"] . ")";
            }
        }

        /** 媒体コード */
        if($param["select_media_cd"]){
            $where[] = "u.media_cd = '" . $param["select_media_cd"] . "'";
        }

        return $where;
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