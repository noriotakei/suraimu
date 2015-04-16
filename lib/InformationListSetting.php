<?php
/**
 * InformationListSetting.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザー側 情報リストデータの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class InformationListSetting extends ComCommon implements InterfaceInformation {

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
     * getInformationListSettingDataメソッド
     *
     * 情報リストデータの取得
     *
     * @param integer $infoListId 情報リストID
     * @return array  $data       情報一覧
     */
    public function getInformationListSettingData($infoListId) {

        // 引数が不正ならFALSE
        if (!isset($infoListId)) {
            return FALSE;
        }

        $columnArray[] = "ils.*";
        $columnArray[] = "ilg.access_key";

        $whereArray[] = "ils.id = " . $infoListId;
        $whereArray[] = "ils.information_list_group_id = ilg.id";
        $whereArray[] = "ils.information_category_id = imc.id";
        $whereArray[] = "ils.is_display = 1";
        $whereArray[] = "ilg.is_display = 1";
        $whereArray[] = "imc.is_display = 1";
        $whereArray[] = "ils.disable = 0";
        $whereArray[] = "ilg.disable =0" ;
        $whereArray[] = "imc.disable =0" ;

        $sql = $this->makeSelectQuery("information_list_setting AS ils, information_list_group AS ilg, information_category AS imc", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * getInformationListSettingListメソッド
     *
     * 情報リスト一覧の取得
     *
     * @param integer $infoListIdArray 情報リストID
     * @return array  $dataList        情報一覧
     */
    public function getInformationListSettingList($infoListIdArray, $order = null) {

        // 引数が不正ならFALSE
        if (!is_array($infoListIdArray)) {
            return FALSE;
        }

        $columnArray[] = "ils.*";
        $columnArray[] = "ilg.name";
        $columnArray[] = "ilg.access_key";

        // リストIDで抽出
        if ($infoListIdArray["lid"]) {
            $whereArray[] = "ils.id = " . $infoListIdArray["lid"];
        }

        // グループIDで抽出
        if ($infoListIdArray["gid"]) {
            $whereArray[] = "ils.information_list_group_id = " . $infoListIdArray["gid"];
        }

        // グループアクセスキーで抽出
        if ($infoListIdArray["gack"]) {
            $whereArray[] = "ilg.access_key = '" . $infoListIdArray["gack"] . "'";
        }

        // フォルダIDで抽出
        if ($infoListIdArray["cid"]) {
            $whereArray[] = "ils.information_category_id = " . $infoListIdArray["cid"];
        }

        $whereArray[] = "ils.information_list_group_id = ilg.id";
        $whereArray[] = "ils.information_category_id = imc.id";
        $whereArray[] = "ils.is_display = 1";
        $whereArray[] = "ilg.is_display = 1";
        $whereArray[] = "imc.is_display = 1";
        $whereArray[] = "ils.disable = 0";
        $whereArray[] = "ilg.disable =0" ;
        $whereArray[] = "imc.disable =0" ;

        $otherArray[] = "GROUP BY ils.id";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        $sql = $this->makeSelectQuery("information_list_setting AS ils, information_list_group AS ilg, information_category AS imc, information_status AS ims", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }
}

?>