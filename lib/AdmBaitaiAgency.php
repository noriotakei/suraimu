<?php
/**
 * AdmBaitaiAgency.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側 代理店媒体集計クラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */
class AdmBaitaiAgency extends ComCommon {

    /* 認証方法 */
    public static $_isAuthIpAddress = array(
                                    "0" => "認証しない",
                                    "1" => "認証する(推奨)"
                                );

    /* 表示状態  入金額*/
    public static $_isDisplayPay = array(
                                    "0" => "非表示",
                                    "1" => "表示中"
                                );

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
     * 媒体集計リストの取得
     *
     * @param  integer $param パラメーター
     * @param  array $addWhereArray 追加条件
     * @param  array $columnArray 列名
     * @param  array $otherArray その他
     *
     * @return array ユーザーデータ
     */
    public function getMediaCalculation($columnArray, $whereArray, $otherArray = "") {

        if (!$columnArray OR !$whereArray) {
            return FALSE;
        }

        $sql = $this->makeSelectQuery("v_trade_user AS vtu", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * 媒体CHK代理店情報の取得。
     *
     * @param  integer $id ユーザーID
     * @return mixed ユーザー情報、失敗ならFALSE
     */
    public function getUserData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("baitai_agency_list", $columnArray, $whereArray);

        // ユーザー情報をメンバ変数に格納
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     * 媒体CHK代理店ログインID重複チェック。
     *
     * @param  integer $loginId ログインID
     * @param  integer $id 更新するID
     * @return boolean
     */
    public function duplicateLoginId($loginId, $id = null) {

        if (!$loginId) {
            return FALSE;
        }

        $columnArray[] = "id";

        // 更新するID以外を取得
        if ($id) {
            $whereArray[] = "id != " . $id;
        }
        $whereArray[] = "login_id = '" . $loginId . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("baitai_agency_list", $columnArray, $whereArray);

        // ユーザー情報をメンバ変数に格納
        if ($data = $this->executeQuery($sql, "fetchRow")) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    /**
     * 媒体CHK代理店情報リストの取得。
     *
     * @return mixed ユーザー情報リスト、失敗ならFALSE
     */
    public function getUserList($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("baitai_agency_list", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            //ユーザー情報をメンバ変数に格納
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     * $passwordKeyを返す。
     *
     * @param string $password キー生成に使用するパスワード
     *
     * @return string $passwordKey パスワードキー
     */
    public function createPasswordKey($password)  {
        if (!$password) {
            return FALSE;
        }

        $passwordKey   = md5($password . "__" . $this->_configOBJ->define->PROJECT_NAME);

        return $passwordKey;
    }

    /**
     * 媒体CHK代理店情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("baitai_agency_list", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 媒体CHK代理店情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("baitai_agency_list", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 本登録ユーザーデータ数の取得
     *
     * @param  array $param 抽出条件配列
     *
     * @return array データリスト
     */
    public function getRegistUserCount($param) {

        if (!$param) {
            return FALSE;
        }

        $columnArray[] = "v_user.media_cd";
        $columnArray[] = "COUNT(v_user.user_id) count";

        $whereArray[] = "v_user.regist_datetime >= '" . $param["date_hour"] . ":00:00'";
        $whereArray[] = "v_user.regist_datetime <= '" . $param["date_hour"] . ":59:59'";

        /** 媒体コード */
        if($param["media_cd"]){
            $whereArray[] = "v_user.media_cd LIKE '" . $param["media_cd"] . "'";
        }

        $whereArray[] = "v_user.admin_id = 0";
        $whereArray[] = "v_user.user_disable = 0";

        $otherArray[] = " GROUP BY v_user.media_cd";

        $sql = $this->makeSelectQuery("v_user_profile v_user", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["media_cd"]]["count"] = $data["count"];
        }

        return $dataArray;
    }

    /**
     * 入金金額の取得
     *
     * @param  array $param 抽出条件配列
     *
     * @return array データリスト
     *
     */
    public function getTradeAmount($param) {

        if (!$param) {
            return FALSE;
        }

        $columnArray[] = "v_user.media_cd media_cd";
        $columnArray[] = "SUM(p.receive_money) trade_amount";

        // 入金金額取得
        $whereArray[] = "p.create_datetime >= '" . $param["date_hour"] . ":00:00'";
        $whereArray[] = "p.create_datetime <= '" . $param["date_hour"] . ":59:59'";

        /** 媒体コード */
        if($param["media_cd"]){
            $whereArray[] = "v_user.media_cd LIKE '" . $param["media_cd"] . "'";
        }

        $whereArray[] = "o.id = p.ordering_id";
        $whereArray[] = "o.user_id = v_user.user_id";
        $whereArray[] = "p.is_cancel = 0";
        $whereArray[] = "v_user.admin_id = 0";
        $whereArray[] = "v_user.user_disable = 0";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "p.disable = 0";

        $otherArray[] = " GROUP BY media_cd";

        $sql = $this->makeSelectQuery("payment_log p, ordering o, v_user_profile v_user", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["media_cd"]]["trade_amount"] = $data["trade_amount"];
        }

        return $dataArray;
    }

    /**
     * 媒体集計の登録。
     *
     * @param  array $mediaAnalyzeAry  媒体データ配列
     * @param  array $param 挿入データ配列
     *
     * @return boolean
     */
    public function insertDuplicateMediaAnalyzeData($mediaAnalyzeAry, $param) {

        if (!$param) {
            return FALSE;
        }

        foreach ($mediaAnalyzeAry as $key => $val) {

            $insertArray = "";
            $updateAry = "";

            $insertArray["analyze_datetime"] = "'" . $param["date_hour"] . ":00:00'";
            $insertArray["media_cd"] = "'" . $key . "'";
            $insertArray["regist_count"] = $val["count"] ? $val["count"] : 0;
            $insertArray["trade_amount"] = $val["trade_amount"] ? $val["trade_amount"] : 0;
            $insertArray["create_datetime"] = "'" . date("YmdHis") . "'";

            $updateAry["regist_count"] = $val["count"] ? $val["count"] : 0;
            $updateAry["trade_amount"] = $val["trade_amount"] ? $val["trade_amount"] : 0;
            $updateAry["create_datetime"] = "'" . date("YmdHis") . "'";

            if (!$dbResultOBJ = $this->insertDuplicate("media_analyze", $insertArray, $updateAry, FALSE)) {
                $this->_errorMsg[] = "データ登録できませんでした。";
                return FALSE;
            }
        }

        return $dbResultOBJ;
    }

    /**
     * 媒体集計の初期化。
     *
     * @param  array $param 初期化条件配列
     *
     * @return boolean
     */
    public function initializationMediaAnalyzeData($param) {

        if (!$param) {
            return FALSE;
        }

        $updateArray["regist_count"] = 0;
        $updateArray["trade_amount"] = 0;
        $updateArray["create_datetime"] = date("YmdHis");

        /** 媒体コード */
        if($param["media_cd"]){
            $whereArray[] = "media_cd = '" . $param["media_cd"] . "'";
        }

        $whereArray[] = "analyze_datetime = '" . $param["date_hour"] . ":00:00'";

        if (!$this->updateMediaAnalyzeData($updateArray, $whereArray)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 媒体集計の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateMediaAnalyzeData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("media_analyze", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 集計実行処理。
     *
     * @param  array $param パラメータ
     *
     * @return boolean
     */
    public function execMediaAnalyze($param) {

        if (!$param){
            return FALSE;
        }

        // 本登録ユーザーデータ数の取得
        if (!$registUserCountAry = $this->getRegistUserCount($param)) {
            $registUserCountAry = array();
        }

        // 入金金額の取得
        if (!$tradeAmountAry = $this->getTradeAmount($param)) {
            $tradeAmountAry = array();
        }

        // 二つ以上の配列をマージします
        $mediaAnalyzeAry = array_merge_recursive($registUserCountAry, $tradeAmountAry);

        // 媒体集計初期化
        if (!$this->initializationMediaAnalyzeData($param)) {
            return FALSE;
        }

        // 媒体集計登録
        if ($mediaAnalyzeAry) {
            if (!$this->insertDuplicateMediaAnalyzeData($mediaAnalyzeAry, $param)) {
                return FALSE;
            }
        }

        return TRUE;
    }

}
?>