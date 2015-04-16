<?php
/**
 * SettlementCcheck.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  C-check決済クラス
 *  C-check決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */
class SettlementCcheck extends Settlement {

    const CCHECK_IP  = "CC3352380A";
    const CCHECK_URL = "https://www.digitalcheck.jp/settle/settle3/bp3.dll?";

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array コンビニダイレクト%変換用変数 */
    protected $_keyconvData = null;

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
     * getSidメソッド
     *
     * 認証IDの発行と取得
     *
     * @return int $sid 認証用ID
     */
    function getSid() {
        mt_srand((double)microtime()*1000000);
        $rand_val = mt_rand("10","99");
        $today = date("YmdHis");
        $sid = $today.$rand_val;

        return $sid;
    }

   /**
     * getCcheckSettleUrlメソッド
     *
     * CCHEECK決済の決済URL取得
     * デジタルチェックへ遷移
     */
    function getCcheckSettleUrl($orderingData, $userData){

        if (!$orderingData OR !$userData) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }

        //通信パラメータ
        $postDataAry["SID"]     = "SID=" . $sid;
        $postDataAry["K1"]      = "K1=" . $orderingData["pay_total"];
        $postDataAry["IP"]      = "IP=". self::CCHECK_IP;
        $postDataAry["FUKA"]    = "FUKA=" . $orderingData["id"];
        $postDataAry["KAKUTEI"] = "KAKUTEI=1";
        $postDataAry["STORE"]   = "STORE=11";
        $postDataString = implode("&", $postDataAry);
        //通信先URL
        $baseUrl = self::CCHECK_URL;
        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");

        if(!$this->insertCcheckData($orderingData, $userData, $postDataString)){
            return false;
        }
        return $baseUrl.$encodePostData;
    }




    /**
     * insertCcheckLogDataメソッド
     *
     * 申込結果の登録
     *
     * @param integer $orderingData 注文データ
     * @param integer $userData ユーザーデータ
     * @param string  $postDataString 申し込みパラメータ
     *
     * @return boolen 失敗したらfalse
     */
    function insertCcheckData($orderingData, $userData, $postDataString) {

        if(!$orderingData OR !$userData OR !$postDataString){
            return false;
        }

        parse_str($postDataString, $postDataAry);

        //申込データのインサート
        $ccheckLogInsertArray["user_id"] = $userData["user_id"];
        $ccheckLogInsertArray["ordering_id"] = $orderingData["id"];
        $ccheckLogInsertArray["pay_money"] = $postDataAry["K1"];
        $ccheckLogInsertArray["sid"] = $postDataAry["SID"];
        $ccheckLogInsertArray["parameter"] = $postDataString;
        $ccheckLogInsertArray["create_datetime"] = date("YmdHis");

        if (!$this->insertConvenienceCheckData($ccheckLogInsertArray)) {
            return false;
        }

        return true;
    }

    /**
     * C-check決済ログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertConvenienceCheckData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("convenience_check", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * C-check決済ログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateConvenienceCheckData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("convenience_check", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * C-checkデータの取得
     *
     * @param  integer $orderingId 注文ID
     * @param  integer $userData ユーザーデータ
     *
     * @return array C-checkデータ
     */
    public function getConvenienceCheckData($orderingId, $userData) {

        if (!$orderingId OR !$userData) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "user_id = " . $userData["user_id"];
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("convenience_check", $columnArray, $whereArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * C-checkデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array C-checkデータ
     */
    public function getNoPaidCcheckData($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("convenience_check", $columnArray, $whereArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * sidからC-checkデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array C-checkデータ
     */
    public function getCcheckDataFromSid($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY id DESC LIMIT 1";

        $sql = $this->makeSelectQuery("convenience_check", $columnArray, $whereArray, $otherArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

}
?>