<?php
/**
 * RegistSite.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側サイト間登録クラス
 *  サイト間登録を管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class RegistSite extends ComCommon {

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
     * コードからサイト間登録データの取得
     *
     * @param  string $cd サイト間登録CD
     * @return array データ配列
     */
    public function getRegistSiteDataFromCd($cd) {

        if (!$cd) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "cd = '" . $cd . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_site", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

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
     * サイト間登録リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getRegistSiteList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "is_use = 1";
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
     * サイト間登録ログ,user_idの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistSiteLogUserId($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!is_array($whereArray)) {
            return false;
        }

        $autoQuotes = FALSE ;

        if (!$dbResultOBJ = $this->update("regist_site_log as rsl,user as u", $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

        /**
     * サイト間登録情報の送信。
     *
     * @param  string $mailAddress メールアドレス
     *
     * @return boolean
     */
    public function sendRegistSiteData($mailAddress) {

        if (!$mailAddress) {
            return FALSE;
        }

        $registSiteList = self::getRegistSiteList();

        if (!$registSiteList) {
            return FALSE;
        }

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        foreach ($registSiteList as $val) {
            $dataArray = "";
            $dataArray["mail"] = $mailAddress;
            $dataArray["reg_site_cd"] = $this->_configOBJ->define->SITE_CD;

            try {
                // http通信
                $ComHttpOBJ = new ComHttp($val["path"], $httpParam);
                $ComHttpOBJ->setParameterPost($dataArray);
                $result = $ComHttpOBJ->request("POST");
            } catch (Zend_Exception $e) {
                continue;
            }
        }
        return TRUE;
    }
}
?>