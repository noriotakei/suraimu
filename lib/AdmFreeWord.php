<?php
/**
 * AdmRegistSite.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側フリーワード設定登録クラス
 *  フリーワード設定を管理するクラス
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */
class AdmFreeWord extends ComCommon {

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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     *
     *フリーワード設定の取得(編集、表示用)
     *
     * @param  integer $freeWordType タイプ（ﾕｰｻﾞｰ任意型か管理設定型かどうか）
     * @param  integer $freeWordCd コード(％～の数値)
     * @param  integer $freeWordVal 値
     *
     * @return array ﾃﾞｰﾀ配列
     */
    public function getFreeWordDataForEdit($freeWordType = NULL,$freeWordCd = NULL,$freeWordVal = NULL) {

        if (!$freeWordType) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "free_word_type = " . $freeWordType;

        if($freeWordCd){
            $whereArray[] = "free_word_cd = " . $freeWordCd;
        }

        if($freeWordVal){
            $whereArray[] = "free_word_value = " . $freeWordVal;
        }

        $otherArray[] = "ORDER BY id ASC";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("free_word_set", $column, $whereArray,$otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * フリーワード管理設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateFreeWordData($updateArray, $whereArray) {

        if (!is_array($whereArray)) {
            return false;
		}

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("free_word_set", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }


    /**
     *
     * ユーザーフリーワードの取得
     *
     * @param  integer $userId ユーザーID
     * @param  integer $freeWordType 1 ﾕｰｻﾞｰ任意 ,2 管理設定
     * @param  integer $freeWordCd -%free_word_タイプ_～-
     *
     * @return array データ配列
     */
    public function getFreeWordData($userId,$freeWordType = NULL,$freeWordCd = NULL) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";

        if($freeWordType){
            $whereArray[] = "free_word_type = " . $freeWordType;
        }
        if($freeWordCd){
            $whereArray[] = "free_word_cd = " . $freeWordCd;
        }

        $sql = $this->makeSelectQuery("convert_free_word", $column, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * ユーザーフリーワード設定の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertFreeWordData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("free_word_set", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザーフリーワード設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateConvertFreeWordData($updateArray, $whereArray) {

        if (!is_array($whereArray)) {
            return false;
		}

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("convert_free_word", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * ユーザーフリーワードの取得
     *
     * @param  $user_id ﾕｰｻﾞｰID
     *
     * @return array ﾃﾞｰﾀ配列
     */
    public function getFreeWordIndividualUserData($user_id) {

        if (!$user_id) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "user_id = " . $user_id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("convert_free_word", $column, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

}
?>