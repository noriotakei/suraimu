<?php
/**
 * AdmAdminDisplayControl.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側のアクセス制限を管理するクラス
 *
 * @copyright   2011 Fraise, Inc.
 * @author      ryohei murata
 */

class AdmAdminDisplayControl extends ComCommon {

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
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
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
     * 管理表示制限情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("admin_display_control", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 管理表示制限情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("admin_display_control", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return true;
    }

    /**
     * 管理ユーザー情報ページ制限情報のチェック。
     *
     * @param  integer $authorityType 権限タイプ
     *
     * @return array   array(表示項目コード)
     */
    public function adminDisplayControlUserDetail($authorityType) {

        $columnArray[] = "key_name";

        $whereArray[] = "CONV(authority_control_data,2,10) & pow(2," . $authorityType . ")  > 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("admin_display_control", $columnArray, $whereArray);
        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);
        $data = array();
        foreach($dataList as $key=>$val){
            $data[] = $val["key_name"];
        }

        return $data;

    }

}
?>
