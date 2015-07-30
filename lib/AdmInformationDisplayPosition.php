<?php
/**
 * AdmInformationDisplayPosition.php
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

class AdmInformationDisplayPosition extends ComCommon implements InterfaceInformation {

    /** 表示位置プルダウン配列 */
    public static $_displayPositionName = array(
            self::DISPLAY_POSITION_TOP                       => "ログイン後トップ",
            self::DISPLAY_POSITION_POST_FREE_INFORMATION     => "ログイン後フリー情報",
            self::DISPLAY_POSITION_PRE_FREE_INFORMATION      => "ログイン前フリー情報",
            self::DISPLAY_POSITION_POST_TOP_CAMP             => "ログイン後TOPキャンペーン",
            self::DISPLAY_POSITION_HOME_TOP_CAMP             => "ログイン後HOMEキャンペーン",
            self::DISPLAY_POSITION_ITEM_EXPLANATION          => "アイテムリストタイトル",
            self::DISPLAY_POSITION_ITEM_LIST                 => "アイテムリスト",
            self::DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION   => "PCログイン前サイド表示情報",
            self::DISPLAY_POSITION_PC_POST_SIDE_INFORMATION  => "PCログイン後サイド表示情報",
            self::DISPLAY_POSITION_PC_PRE_TOP_CAMP           => "PCログイン前TOPキャンペーン",
            self::DISPLAY_POSITION_INFORMATION_OPEN          => "情報公開",
            self::DISPLAY_POSITION_INFORMATION_LIST          => "情報リストページ",
            self::DISPLAY_POSITION_MB_HOME_MIDDLE_CAMP          => "MB購入キャンペーンの情報公開中",
            self::DISPLAY_CD_QUIT_WEEKLY_RACE          => "今週の注目レース",
            self::DISPLAY_POSITION_MB_HOME_INFORMATION_OPEN          => "MBチケット情報 公開中",
        );

    /* 入金状態状態 */
    public static $_paymentStatus = array(
                                    "0" => "設定しない",
                                    "1" => "入金有り",
                                    "2" => "入金無し"
                                );

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示中"
                                );

    /** 検索タイプ配列 */
    public static $_searchTypeAry = array(
                            "0" => "気にしない"
                            ,"1" => "情報ID"
                            ,"2" => "管理用情報名"
                            ,"3" => "表示開始日時"
        );

    /** キーワード特定配列 */
    public static $_specifyKeywordAry = array(
                            "0" => "前方一致"
                            ,"1" => "後方一致"
                            ,"2" => "完全一致"
        );

    /* 検索用表示状態 */
    public static $_searchIsDisplay = array(
                                    "0" => "気にしない",
                                    "1" => "非表示",
                                    "2" => "表示中"
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
     * 情報表示場所設定データの取得
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
     * 情報表示場所設定データリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ
     */
    public function getInformationDisplayPositionList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS idp.*";
        $columnArray[] = "ic.id information_category_id";
        $columnArray[] = "ic.name name";
        $columnArray[] = "ic.sort_seq sort_seq";

        $whereArray[] = "idp.disable = 0";
        $whereArray[] = "ic.disable = 0";
        $whereArray[] = "ic.id = idp.information_category_id    ";

        if (ComValidation::isNumeric($param["fid"])) {
            $whereArray[] = "idp.information_category_id = " . $param["fid"];
        }

        if (ComValidation::isNumeric($param["position_id"])) {
            $whereArray[] = "idp.cd = " . $param["position_id"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_display_position idp, information_category ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     *  情報表示場所設定の追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *
     *  @return boolean
     */
    public function insertInformationDisplayPositionData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("information_display_position", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 情報表示場所設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *
     * @return boolean
     */
    public function updateInformationDisplayPositionData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("information_display_position", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * selectbox用情報リストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getInformationDisplayPositionForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("information_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }
        return $dataArray;
    }

    /**
     * 情報フォルダ設定データの取得
     *
     * @param  integer $id データID
     *
     * @return array $data データ
     */
    public function getInformationCategoryData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("information_category", $columnArray, $whereArray);

        // 画像情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 情報フォルダ設定データリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ
     */
    public function getInformationCategoryList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_category", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     *  情報フォルダ設定の追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *
     *  @return boolean
     */
    public function insertInformationCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("information_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 情報フォルダ設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *
     * @return boolean
     */
    public function updateInformationCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("information_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

}

?>