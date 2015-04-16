<?php
/**
 * AdmInfomationListSetting.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 情報リスト設定データの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class AdmInformationListSetting extends ComCommon implements InterfaceInformation {

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示中"
                                );

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
     *
     * 情報リストデータの取得
     *
     * @param  int $id 情報リストID
     *
     * @return array $data データ配列
     */
    public function getInformationListSettingData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "ils.*";
        $columnArray[] = "ilg.name";
        $columnArray[] = "ilg.access_key";
        $columnArray[] = "ic.name category_name";

        $whereArray[] = "ils.id = " . $id;
        $whereArray[] = "ils.information_list_group_id = ilg.id";
        $whereArray[] = "ils.information_category_id = ic.id";
        $whereArray[] = "ils.disable = 0";

        $sql = $this->makeSelectQuery("information_list_setting AS ils, information_list_group AS ilg, information_category AS ic", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 情報リスト一覧の取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ
     */
    public function getInformationListSettingList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS ils.*";
        $columnArray[] = "ilg.name";
        $columnArray[] = "ilg.access_key";
        $columnArray[] = "ic.name category_name";

        $whereArray[] = "ils.information_list_group_id = ilg.id";
        $whereArray[] = "ils.information_category_id = ic.id";
        $whereArray[] = "ils.disable = 0";
        $whereArray[] = "ilg.disable = 0";
        $whereArray[] = "ic.disable = 0";

        // リストIDで抽出
        if (ComValidation::isNumeric($param["sid"])) {
            $whereArray[] = "ils.id = " . $param["sid"];
        }

        // フォルダIDで抽出
        if (ComValidation::isNumeric($param["fid"])) {
            $whereArray[] = "ils.information_category_id = " . $param["fid"];
        }

        // グループIDで抽出
        if (ComValidation::isNumeric($param["gid"])) {
            $whereArray[] = "ils.information_list_group_id = " . $param["gid"];
        }

        // グループアクセスキーで抽出
        if (ComValidation::isNumeric($param["gack"])) {
            $whereArray[] = "ilg.access_key = " . $param["gack"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_list_setting AS ils, information_list_group AS ilg, information_category AS ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 情報リストデータの登録
     * @param  array $aryInsertData INSERTデータ配列
     *
     * @return boolean
     */
    public function insertInformationListSettingData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("information_list_setting", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 情報リストデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     *
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateInformationListSettingData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("information_list_setting", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }
}

?>
