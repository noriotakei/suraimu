<?php

/**
 * AdmRegistTestAddress.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側広告用テストアドレス設定管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */


class AdmRegistTestAddress extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示中",
                                );

    /** キーワード特定配列 */
    public static $_specifyKeywordAry = array(
                            "0" => "前方一致"
                            ,"1" => "後方一致"
                            ,"2" => "完全一致"
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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * 広告用テストアドレスカテゴリーリストの取得
     *
     * @return array データ配列
     */
    public function getRegistTestAddressCategoryList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("regist_test_mail_category", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 広告用テストアドレスカテゴリーデータの取得
     *
     * @param  int $registTestAddressCategoryId 広告用テストアドレスカテゴリーID
     * @return array $data データ配列
     */
    public function getRegistTestAddressCategoryData($registTestAddressCategoryId) {

        if (!is_numeric($registTestAddressCategoryId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $registTestAddressCategoryId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_test_mail_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * selectbox用広告用テストアドレスカテゴリーコードリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getRegistTestAddressCategoryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_test_mail_category", $columnArray, $whereArray);

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
     * 広告用テストアドレスカテゴリーデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertRegistTestAddressCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_test_mail_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 広告用テストアドレスカテゴリーデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistTestAddressCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_test_mail_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * 広告用テストアドレスデータリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @return array ユーザーデータ
     */
    public function getRegistTestAddressList($param, $offset, $order = "sort_seq DESC", $limit) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        // 登録アドレスカテゴリーID
        if (ComValidation::isNumeric($param["regist_test_mail_category_id"])) {
            $whereArray[] = "regist_test_mail_category_id = " . $param["regist_test_mail_category_id"];
        }

        // 登録アドレス
        if ($param["search_string"]) {
            // 後方一致
            if ($param["specify_keyword"] == 1) {
                $whereArray[] = "mail_address LIKE '%" . $param["search_string"] . "'";
            // 完全一致
            } else if ($param["specify_keyword"] == 2) {
                $whereArray[] = "mail_address = '" . $param["search_string"] . "'";
            // 前方一致
            } else {
                $whereArray[] = "mail_address LIKE '" . $param["search_string"] . "%'";
            }
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("regist_test_mail_address", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }


    /**
     *
     * 広告用テストアドレスデータの取得
     *
     * @param  int $registTestAddressCategoryId 広告用テストアドレスカテゴリーID
     * @return array $data データ配列
     */
    public function getRegistTestAddressData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_test_mail_address", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 広告用テストアドレスデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertRegistTestAddressData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_test_mail_address", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 広告用テストアドレスの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistTestAddressData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_test_mail_address", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

}

?>