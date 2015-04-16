<?php
/**
 * FreeWord.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側フリーワードクラス
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */
class FreeWord extends ComCommon {

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
     * ユーザーフリーワードの更新。
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

        if (!$this->update("convert_free_word", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * ユーザーフリーワードの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertFreeWordData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("convert_free_word", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * ユーザーフリーワード設定リストの取得
     *
     * @return array データ配列
     */
    public function getFreeWordSetDataList() {

        $column[] = "free_word_cd";
        $column[] = "free_word_value";
        $column[] = "free_word_text";

        $whereArray[] = "disable = 0" ;

        $otherArray[] = " ORDER BY  free_word_cd,free_word_value";

        $sql = $this->makeSelectQuery("free_word_set", $column, $whereArray,$otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * ユーザーフリーワード設定の取得
     * @param  array $freeWordType タイプ
     * @param  array $freeWordCd コード
     * @param  array $freeWordValue 値
     * @return array データ配列
     */
    public function getFreeWordSetData($freeWordType = NULL,$freeWordCd = NULL,$freeWordValue = NULL) {

        if(!$freeWordType || !$freeWordCd || !$freeWordValue){
        	return FALSE ;
        }

        $column[] = "*";

        $whereArray[] = "free_word_type = ".$freeWordType ;
        $whereArray[] = "free_word_cd = ".$freeWordCd ;
        $whereArray[] = "free_word_value = ".$freeWordValue ;
        $whereArray[] = "disable = 0" ;

        $sql = $this->makeSelectQuery("free_word_set", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }


    /**
     *
     * ユーザーフリーワード設定表示用データ生成
     *
     * @return array データ配列
     */
    public function getFreeWordSetDisplayData($freeWordSetData = NULL) {

        if(!count($freeWordSetData)){
        	FALSE ;
        }

        foreach($freeWordSetData as $val){
        	$displayData[$val["free_word_cd"]][$val["free_word_value"]] = $val["free_word_text"] ;
        }

        return $displayData;

    }

}
?>