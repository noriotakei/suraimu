<?php
/**
 * InformationDisplayPosition.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 情報表示場所の管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class InformationDisplayPosition extends ComCommon implements InterfaceInformation {

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
     * 情報フォルダ設定データの取得
     *
     * @param  integer $id データID
     *
     * @return array $data データ
     */
    public function getInformationDisplayPositionData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("information_display_position", $columnArray, $whereArray);

        // 画像情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 情報フォルダ設定データリストの取得
     *
     * @param  array $positionId 情報表示場所ID
     * @param  string $order 表示順
     * @return array $dataList データ
     */
    public function getInformationDisplayPositionList($positionId = null, $order = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS idp.*";

        if ($positionId) {
            foreach ($positionId as $val) {
                $id .= $val . ",";
            }
            $id = rtrim($id, ",");
            $whereArray[] = "idp.cd IN(" . $id . ")";
        }

        $whereArray[] = "ic.id = idp.information_category_id    ";
        $whereArray[] = "idp.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "idp.disable = 0";
        $whereArray[] = "ic.disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        $sql = $this->makeSelectQuery("information_display_position idp, information_category ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }
}

?>