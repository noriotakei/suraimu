<?php
/**
 * MonthlyCourse.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザー側 月額コースデータの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

class MonthlyCourse extends ComCommon implements InterfaceMonthlyCourse {

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
     * getMonthlyCourseDataメソッド
     *
     * 月額コースデータの取得
     *
     * @param  integer id 月額コースID
     * @return array   data           月額コースデータ
     */
    public function getMonthlyCourseData($id) {

        // 引数が不正ならFALSE(ログイン後はユーザーデータ必要)
        //if (!isset($id) || (!is_array($userData))) {
        if (!isset($id)) {
            return FALSE;
        }

        $columnArray[] = "mc.*";

        $whereArray[] = "mc.id = " . $id;

        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable = 0";

        $whereArray[] = "mcg.id = mc.monthly_course_group_id";

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * getMonthlyCourseListFromGroupIdメソッド
     *
     * @param integer $groupId   月額コースグループId
     * @return array  $data      商品一覧
     */
    public function getMonthlyCourseListFromGroupId($groupId) {

        // 引数が不正ならFALSE
        if (!isset($groupId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS mc.*";

        $whereArray[] = "mcg.id = mc.monthly_course_group_id";

        $whereArray[] = "mc.monthly_course_group_id = " . $groupId;

        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable =0" ;

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * getMonthlyCourseUserListメソッド
     *
     * @param  array $userData   ユーザーデータ
     * @param integer $groupId   月額コースグループId
     * @return array  $data      商品一覧
     */
    public function getMonthlyCourseUserList($userData, $groupId=0) {

        if (!is_array($userData)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";
        //$columnArray[] = "mc.html_text_name_pc course_name_pc";
        //$columnArray[] = "mc.html_text_name_mb course_name_mb";

        $whereArray[] = "mcu.user_id =" . $userData["user_id"];
        $whereArray[] = "mcu.limit_end_date >= '" . date("Y-m-d") . "'";
        $whereArray[] = "mc.id = mcu.monthly_course_id";
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";
        $whereArray[] = "mcu.is_invalid = 0";

        if($groupId){
            $whereArray[] = "mc.monthly_course_group_id = " . $groupId;
        }

        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable =0";
        $whereArray[] = "mcu.disable =0";

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * getMonthlyCourseListメソッド
     *
     * @return array $dataList 月額コースリスト一覧
     */
    public function getMonthlyCourseList($whereArray = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";
        $columnArray[] = "mc.name as course_name";
        $columnArray[] = "mcg.name as group_name";
        //$columnArray[] = "mc.html_text_name_pc course_name_pc";
        //$columnArray[] = "mc.html_text_name_mb course_name_mb";

        $whereArray[] = "mcu.limit_end_date >= '" . date("Y-m-d") . "'";
        $whereArray[] = "mc.id = mcu.monthly_course_id";
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";
        $whereArray[] = "mcu.is_invalid = 0";
        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable = 0";
        $whereArray[] = "mcu.disable = 0";

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * 月額コースユーザデータの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertMonthlyCourseUserData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("monthly_course_user", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 月額コースユーザデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateMonthlyCourseUserData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("monthly_course_user", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

}

?>