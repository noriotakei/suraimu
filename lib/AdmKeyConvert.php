<?php

/**
 * AdmKeyConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * システム変換管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */


class AdmKeyConvert extends ComCommon {

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
     * システム変換リストの取得
     *
     * @return array データ配列
     */
    public function getKeyConvertAll() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY type";

        $sql = $this->makeSelectQuery("key_convert_list", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * システム変換リストの取得(表示中のもののみ)
     * @return array $dataList データ配列
     */
    public function getKeyConvertList($param) {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        if ($param["key_convert_list_category_id"]) {
            $whereArray[] = "key_convert_list_category_id = " . $param["key_convert_list_category_id"];
        }
        $whereArray[] = "disable = 0";
        $otherArray[] = "ORDER BY type";

        $sql = $this->makeSelectQuery("key_convert_list", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * システム変換データの取得
     * @param  int $id システム変換データID
     * @return array $data データ配列
     */
    public function getKeyConvertData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("key_convert_list", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * システム変換キー重複チェック
     *
     * @param  string $convertKeyName ファイル名
     * @return boolean
     */
    public function duplicateKeyConvertKeyName($convertKeyName, $id = null) {

        if (!$convertKeyName) {
            return FALSE;
        }

        $columnArray[] = "id";

        // 更新するID以外を取得
        if ($id) {
            $whereArray[] = "id != " . $id;
        }

        $whereArray[] = "key_name = '" . $convertKeyName . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("key_convert_list", $columnArray, $whereArray);

        // ログインユーザー情報をメンバ変数に格納
        if ($data = $this->executeQuery($sql, "fetchRow")) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     *
     * システム変換データ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("key_convert_list", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * システム変換情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("key_convert_list", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * システム変換コンテンツデータの取得
     *
     * @param  integer $keyConvertListId システム変換リストID
     * @return array $data データ配列
     */
    public function keyConvertContentsData($keyConvertListId) {

        if (!$keyConvertListId) {
            return FALSE;
        }

        // 変換内容の取得
        $subColumnArray[] = "*";

        $subWhereArray[] = "display_start_datetime <= '" . date("Y-m-d H:i:s") . "'";
        $subWhereArray[] = "(display_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR display_end_datetime = '0000-00-00 00:00:00')";
        $subWhereArray[] = "disable = 0";

        $subOtherArray[] = "ORDER BY id DESC";

        $subSql = $this->makeSelectQuery("key_convert_contents", $subColumnArray, $subWhereArray, $subOtherArray);

        $columnArray[] = "kcc.*";

        $whereArray[] = "kcl.id = " . $keyConvertListId;
        $whereArray[] = "kcl.id = kcc.key_convert_list_id";
        $whereArray[] = "kcl.disable = 0";

        $otherArray[] = "GROUP BY kcl.id";
        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("key_convert_list kcl, (" . $subSql . ") kcc", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     *
     * システム変換コンテンツリストの取得
     *
     * @param  array $param パラメータ
     * @return array $dataList データ配列
     */
    public function getKeyConvertContentsList($keyConvertListId) {

        if (!$keyConvertListId) {
            return false;
        }
        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "key_convert_list_id = " . $keyConvertListId;
        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY display_start_datetime DESC, id DESC";

        $sql = $this->makeSelectQuery("key_convert_contents", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }


    /**
     *
     * システム変換コンテンツデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertKeyConvertContentsData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("key_convert_contents", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * システム変換コンテンツデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateKeyConvertContentsData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("key_convert_contents", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * システム変換カテゴリーリストの取得
     *
     * @return array データ配列
     */
    public function getKeyConvertCategoryList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("key_convert_list_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * システム変換カテゴリーデータの取得
     *
     * @param  int $keyConvertCategoryId システム変換カテゴリーID
     * @return array $data データ配列
     */
    public function getKeyConvertCategoryData($keyConvertCategoryId) {

        if (!is_numeric($keyConvertCategoryId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $keyConvertCategoryId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("key_convert_list_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * selectbox用システム変換カテゴリーコードリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getKeyConvertCategoryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("key_convert_list_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }

        return $dataArray;

    }

    /**
     *
     * システム変換カテゴリーデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertKeyConvertCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("key_convert_list_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * システム変換カテゴリーデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateKeyConvertCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("key_convert_list_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

}

?>