<?php
/**
 * AdmRegistSite.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側サイト間登録クラス
 *  サイト間登録を管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmRegistSite extends ComCommon {

    const REGIST_CSV_FILE_PATH = "/log/registSite/";

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array 表示状態配列 */
    public static $_isUse = array(
                    "0" => "未使用",
                    "1" => "使用中",
                  );

    /** @var array 登録状態配列 */
    public static $_specifyRegistSite = array(
                    "0" => "未登録",
                    "1" => "登録済み",
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
     *
     * サイト間登録データの取得
     *
     * @param  integer $id サイト間登録ID
     * @return array データ配列
     */
    public function getRegistSiteData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * サイト間登録リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getRegistSiteList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * サイト間登録の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertRegistSiteData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_site", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト間登録の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistSiteData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_site", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト間登録情報select用リストの取得。
     *
     * @return mixed サイト間登録情報リスト、失敗ならfalse
     */
    public function getListForSelect($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["cd"]] = $data["name"];
        }

        return $dataArray;
    }

    /**
     *
     * メアドからサイト間登録ログデータの取得
     *
     * @param  string $mailAddress 、メールアドレス
     * @return array データ配列
     */
    public function getRegistSiteLogDataFromMailAddress($mailAddress) {

        if (!$mailAddress) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "mail_address = '" . $mailAddress . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site_log", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * サイト間登録ユーザーIDログデータの取得
     *
     * @param  integer $userId ユーザーID
     * @return array データ配列
     */
    public function getRegistSiteUserIdFromUserId($userId) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site_user_id", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * サイト間登録ログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertRegistSiteLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_site_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト間登録ログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistSiteLogData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_site_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト間登録ユーザーIDログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertRegistSiteUserIdData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_site_user_id", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト間登録ユーザーIDログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistSiteUserIdData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_site_user_id", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

}
?>