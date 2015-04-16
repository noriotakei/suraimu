<?php
/**
 * AdmBaitaiAgencyIpAddressSetting.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側 代理店認証IPアドレス設定クラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */
class AdmBaitaiAgencyIpAddressSetting extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /* 表示状態 */
    public static $_isUse = array(
                                    "0" => "未使用",
                                    "1" => "使用中",
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
     * 代理店媒体コード設定データの取得。
     *
     * @param  integer $id ユーザーID
     * @return mixed ユーザー情報、失敗ならFALSE
     */
    public function getBaitaiAgencyIpAddressSettingData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("baitai_agency_ip_address_setting", $columnArray, $whereArray);

        // メンバ変数に格納
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     * 代理店媒体コード設定リストの取得。
     *
     * @return mixed ユーザー情報リスト、失敗ならFALSE
     */
    public function getBaitaiAgencyIpAddressSettingList($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("baitai_agency_ip_address_setting", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            //ユーザー情報をメンバ変数に格納
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 代理店媒体コード設定情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("baitai_agency_ip_address_setting", $insertArray)) {
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

        if (!$dbResultOBJ = $this->update("baitai_agency_ip_address_setting", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return TRUE;
    }
}
?>