<?php
/**
 * InfomationStatusLog.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * WEB側 画情報データの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class InformationStatusLog extends ComCommon {

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
     * getInformationStatusLogListForAccessedメソッド
     *
     * 既読チェック用情報データログリストの取得
     *
     * @param integer $userId ユーザID
     * @return boolean
     */
    public function getInformationStatusLogListForAccessed($userId) {

        if (!is_numeric($userId) ) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS isl.*";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";
        $otherArray[] = " GROUP BY information_status_id";

        $sql = $this->makeSelectQuery("information_status_log isl", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        // 情報IDだけの配列生成
        $infomationIdAry = "";
        foreach ($dataList as $val) {
            $infomationIdAry[] = $val["information_status_id"];
        }

        return $infomationIdAry;
    }

    /**
     * isAccessedメソッド
     *
     * ユーザが情報にアクセスしているかを調べる
     * @param integer $unitId ユニットID
     * @param integer $userId ユーザID
     * @return boolean
     */
    public function isAccessed($infoStatusId, $userId) {

        if (!is_numeric($infoStatusId) || !is_numeric($userId) ) {
            return FALSE;
        }

        $columnArray[] = "id";

        $whereArray[] = "information_status_id = " . $infoStatusId;
        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";


        $sql = $this->makeSelectQuery("information_status_log", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        if (!$row = $this->fetchAll($dbResultOBJ)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * insertInformationStatusLogメソッド
     *
     * 情報アクセスログインサート
     *
     * @param array $insertArray INSERTデータ配列
     * @return mixed インサートID
     */
    public function insertInformationStatusLog ($insertArray) {

        if (!isset($insertArray) || !is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("information_status_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }
}
?>