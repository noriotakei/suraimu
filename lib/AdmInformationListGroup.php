<?php
/**
 * AdmInfomationListGroup.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 情報リストグループデータの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class AdmInformationListGroup extends ComCommon implements InterfaceInformation {

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
     * 情報リストカテゴリーデータの取得
     *
     * @param  int $id 情報ID
     *
     * @return array $data データ配列
     */
    public function getInformationListGroupData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "ilg.*";

        $whereArray[] = "ilg.id = " . $id;
        $whereArray[] = "ilg.disable = 0";

        $sql = $this->makeSelectQuery("information_list_group AS ilg", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 情報リストグループ一覧の取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ
     */
    public function getInformationListGroupList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS ilg.*";

        $whereArray[] = "ilg.disable = 0";

        if (ComValidation::isNumeric($param["lgid"])) {
            $whereArray[] = "ilg.id = " . $param["lgid"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_list_group AS ilg", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 情報リストグループデータの登録
     * @param  array $aryInsertData INSERTデータ配列
     *
     * @return boolean
     */
    public function insertInformationListGroupData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("information_list_group", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 情報リストカテゴリーデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     *
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateInformationListGroupData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("information_list_group", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * access_keyの重複が無い様にaccess_keyを返す。
     *
     *
     * @param int $data キー生成にID
     *
     * @return string accessKey　を連想配列で返す
     */
    public function getNewAccessKey($data)  {

        if (!$data) {
            return FALSE;
        }

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $accessKey   = md5($data . "__" . time());
            $accessKey   = substr($accessKey,0,16);

            $columnArray[] = "*";

            $whereArray[] = "access_key = '" . $accessKey . "'";
            $whereArray[] = "disable = 0";

            $sql = $this->makeSelectQuery("information_list_group", $columnArray, $whereArray);

            $i++;

            // ループ回数は100回
            if ($i > 100) {
                return FALSE;
            }

        } while ($data = $this->executeQuery($sql, "fetchRow"));

        return $accessKey;
    }
}
?>