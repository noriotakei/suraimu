<?php

/**
 * AdmUnit.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側ユニットクラス
 *  ユニットを管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmUnit extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

/** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string ユーザー検索sql文 */
    private $_listSql = null;

    /** @var string 検索条件内容 */
    private $_contents = null;

    /** @var array 検索条件内容 */
    public static $_isStayArray = array(
                                    0 => "対象",
                                    1 => "非対象"
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
     *
     * ユニットデータの取得
     *
     * @param  integer $id ユニットID
     * @return array データ配列
     */
    public function getUnitData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("unit", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * ユニットリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getUnitList($param, $offset, $order, $limit) {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        // ログ削除対象フラグ
        if ($param["is_stay"]) {
            $whereArray[] = "is_stay = " . $param["is_stay"];
        }

        // コメント
        if ($param["search_string"]) {
            $whereArray[] = "comment LIKE '%" . $param["search_string"] . "%'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("unit", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * ユニットの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertUnitData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }


        if (!$dbResultOBJ = $this->insert("unit", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユニットの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateUnitData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }


        if (!$dbResultOBJ = $this->update("unit", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * ユニットユーザー件数の取得
     *
     * @param  integer $id ユニットID
     * @return integer 件数
     */
    public function getUnitUserCountData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "unit_id = " . $id;
        $whereArray[] = "disable = 0";

        $otherArray[] = " LIMIT 1";

        $sql = $this->makeSelectQuery("unit_user", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        $totalCount = $this->getFoundRows();

        return $totalCount;

    }

    /**
     * ユニットユーザーの登録。
     *
     * @param  array $columnArray 挿入カラム
     * @param  string $sql sql文
     * @return boolean
     */
    public function insertUnitUserData($columnArray, $sql) {

        if (!$columnArray || !$sql) {
            return false;
        }

        if (!$dbResultOBJ =  $this->insertSelect("unit_user", $columnArray, $sql)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユニットユーザーの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateUnitUserData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("unit_user", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * 抽選ユニットデータの取得
     *
     * @param  integer $id ユニットID
     * @return array データ配列
     */
    public function getLotteryUnitData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("lottery_unit", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 抽選ユニットリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getLotteryUnitList($param, $offset, $order, $limit) {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        // コメント
        if ($param["search_string"]) {
            $whereArray[] = "comment LIKE '%" . $param["search_string"] . "%'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("lottery_unit", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 抽選ユニットの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertLotteryUnitData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }


        if (!$dbResultOBJ = $this->insert("lottery_unit", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 抽選ユニットの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateLotteryUnitData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }


        if (!$dbResultOBJ = $this->update("lottery_unit", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 抽選ユニットユーザーの登録。
     *
     * @param  array $columnArray 挿入カラム
     * @param  string $sql sql文
     * @return boolean
     */
    public function insertLotteryUnitUserData($columnArray, $sql) {

        if (!$columnArray || !$sql) {
            return false;
        }

        if (!$dbResultOBJ =  $this->insertSelect("lottery_unit_user", $columnArray, $sql)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 抽選ユニットユーザーの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateLotteryUnitUserData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("lottery_unit_user", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
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