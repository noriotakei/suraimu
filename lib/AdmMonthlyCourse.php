<?php
/**
 * AdmMonthlyCourse.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側g月額コース管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa ohnami
 */
class AdmMonthlyCourse extends ComCommon implements InterfaceMonthlyCourse {

    /** 検索タイプ配列 */
    public static $_searchTypeAry = array(
                            "0" => "気にしない"
                            ,"1" => "月額コースID"
                            ,"3" => "管理用商品名"
        );

    /** キーワード特定配列 */
    public static $_specifyKeywordAry = array(
                            "0" => "前方一致"
                            ,"1" => "後方一致"
                            ,"2" => "完全一致"
        );

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示"
                                );

    /* 同グループ同コース更新タイプ */
    public static $_sameMonthlyCourseType = array(
                             self::COURSE_TYPE_NEW => "新規",
                             self::COURSE_TYPE_UPDATE => "更新"
        );

    /* 同グループ別コース更新タイプ */
    public static $_differentMonthlyCourseType = array(
                             self::COURSE_TYPE_NEW => "新規",
                             self::COURSE_TYPE_UPDATE => "更新"
        );

    /* 作成タイプ */
    public static $_monthlyCourseUserCreateType = array(
                             self::COURSE_TYPE_NEW => "新規",
                             self::COURSE_TYPE_UPDATE => "更新"
        );

    /* 無効フラグ */
    public static $_iSinvalid = array(
                             "0" => "OFF",
                             "1" => "ON"
        );

    /* 月額コースデータ一括操作内容 */
    public static $_batchOperateMonthlyCourseSelectAry = array(
                                    "2" => "グループ移動",
                                    "3" => "削除",
                                );

    /* 決済時デバイス種別 */
    public static $_settleDeviceTypeSelectAry = array(
                             self::DEVICE_TYPE_PC => "PC",
                             self::DEVICE_TYPE_MB => "MB",
                             self::DEVICE_TYPE_EITHER => "どちらか"
                                );

    /* 月額更新フラグ */
    public static $_isMonthlyUpdate = array(
                             "0" => "なし",
                             "1" => "あり"
        );

    /* 月額コース一括操作内容 */
    public static $_batchOperateMonthlyCourseUserSelectAry = array(
                                    "1" => "コース変更",
                                    "2" => "コース解除(無効フラグ=ON)",
                                    "3" => "月額更新解除",
                                    "4" => "コース有効日数付与",
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
     *
     * 月額コースデータの取得
     *
     * @param  integer $id     月額コースID
     * @param  boolean $decord デコード処理フラグ
     *
     * @return array データ配列
     */
    public function getMonthlyCourseData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "mc.*";
        $column[] = "mcg.name as group_name";

        $whereArray[] = "mc.id = " . $id;
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";

        $sql = $this->makeSelectQuery("monthly_course as mc, monthly_course_group as mcg", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            $this->_errorMsg[] = "データ取得できませんでした。";
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 月額コースリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getMonthlyCourseList($param, $offset = 0, $order = null, $limit = 0) {


        $columnArray[] = "SQL_CALC_FOUND_ROWS monthly_course.*";

        $columnArray[] = "monthly_course_group.name AS group_name";

        $whereArray[] = "monthly_course.monthly_course_group_id = monthly_course_group.id";
        $whereArray[] = "monthly_course.disable = 0";
        $whereArray[] = "monthly_course_group.disable = 0";

        // カテゴリー検索
        if ($param["search_group_id"]) {
            $whereArray[] = "monthly_course.monthly_course_group_id = " . $param["search_group_id"];
        }

        // 検索対象
        if ($param["search_type"] == 1 && $param["search_course_id"]) {
            // 月額コースID
            $whereArray[] = "monthly_course.id = " . $param["search_course_id"];
        //} elseif ($param["search_type"] == 2) {
        //    // 商品アクセスキー
        //    $whereArray[] = "item.access_key = '" . $param["search_item_key"] . "'";
        } elseif ($param["search_type"] == 3) {
            // 管理用商品名検索
            if ($param["search_string"]) {
                if ($param["specify_keyword"] == 1) {
                    // 後方一致
                    $searchSql = "like '%" . $param["search_string"] . "'";
                } elseif ($param["specify_keyword"] == 2) {
                    // 完全一致
                    $searchSql = "= '" . $param["search_string"] . "'";
                } else {
                    // 前方一致
                    $searchSql = "like '" . $param["search_string"] . "%'";
                }
                $whereArray[] = "monthly_course.name " . $searchSql;
            }
        //} elseif ($param["search_type"] == 4) {
        //    // 表示開始日検索
        //    $whereArray[] = "item.sales_start_datetime >= '" . $param["searchDatetimeFrom"] . "'";
        //    $whereArray[] = "item.sales_end_datetime <= '" . $param["searchDatetimeTo"] . "'";
        //} elseif ($param["search_type"] == 5 && $param["search_conditions_id"]) {
        //    // 検索条件保存ID
        //    $whereArray[] = "item.user_search_conditions_id = " . $param["search_conditions_id"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("monthly_course, monthly_course_group", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            $this->_errorMsg[] = "データ取得できませんでした。";
            return FALSE;
        }

        // データリスト取得
        while ($data = $dbResultOBJ->fetch()) {
            // デコード
            //$data["html_text_name"] = htmlspecialchars_decode($data["html_text_name"], ENT_QUOTES);
            $dataList[] = $data;
        }

        return $dataList;

    }

    /**
     *
     * selectbox用月額コースリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getMonthlyCourseListForSelect() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS monthly_course.*";

        $columnArray[] = "monthly_course_group.name AS group_name";

        $whereArray[] = "monthly_course.monthly_course_group_id = monthly_course_group.id";
        $whereArray[] = "monthly_course.disable = 0";
        $whereArray[] = "monthly_course_group.disable = 0";

        $otherArray[] = " ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("monthly_course, monthly_course_group", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            $this->_errorMsg[] = "データ取得できませんでした。";
            return FALSE;
        }

        // データリスト取得
        while ($data = $dbResultOBJ->fetch()) {
            $dataList[$data["id"]] = $data["name"];
        }

        return $dataList;
    }

    /**
     * 月額コースの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertMonthlyCourseData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("monthly_course", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 月額コースの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateMonthlyCourseData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("monthly_course", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * 月額コースグループデータの取得
     *
     * @param  integer $id グループID
     *
     * @return array データ配列
     */
    public function getMonthlyCourseGroupData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("monthly_course_group", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 月額コースグループリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getMonthlyCourseGroupList($param, $offset = null, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        if ($param["is_disaplay"]) {
            $whereArray[] = "is_display = 1";
        }

        $whereArray[] = "disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("monthly_course_group", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * selectbox用月額コースグループリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getMonthlyCourseGroupForSelect() {


        $columnArray[] = "*";

        $whereArray[] = "is_display = 1";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("monthly_course_group", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }
        return $dataArray;
    }

    /**
     * getAllMonthlyCourseUserDataメソッド
     *
     * @param  array $id 月額コースID
     *
     * @return array $data データ配列
     */
    public function getMonthlyCourseUserData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";
        $columnArray[] = "mc.name as course_name";
        $columnArray[] = "mcg.name as group_name";

        $whereArray[] = "mcu.id = " . $id;
        $whereArray[] = "mc.id = mcu.monthly_course_id";
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";
        $whereArray[] = "mcu.disable =0";

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * getAllMonthlyCourseUserListメソッド
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getAllMonthlyCourseUserList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";
        $columnArray[] = "mc.name as course_name";
        $columnArray[] = "mcg.name as group_name";

        if($param["user_id"]){
            $whereArray[] = "mcu.user_id =" . $param["user_id"];
        }

        $whereArray[] = "mc.id = mcu.monthly_course_id";
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";
        $whereArray[] = "mcu.disable =0";

        //$whereArray[] = "mcu.limit_end_date >= '" . date("Y-m-d") . "'";
        //$whereArray[] = "mcu.is_invalid = 0";
        //$whereArray[] = "mcg.is_display = 1";
        //$whereArray[] = "mc.disable = 0";
        //$whereArray[] = "mcg.disable =0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu", $columnArray, $whereArray, $otherArray);

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
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getMonthlyCourseUserList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";
        $columnArray[] = "mc.name as course_name";
        $columnArray[] = "mcg.name as group_name";
        $columnArray[] = "i.name as item_name";

        // ユーザーID
        if($param["search_user_id"]){
            $isSearchUserIdClm = "mcu.user_id";
            $searchUserIdArray = explode(",",rtrim($param["search_user_id"], ","));
            if ($param["user_id_type"]) {
                //AND検索
                foreach($searchUserIdArray as $key => $value){
                    $whereArray[] = "FIND_IN_SET( '" . $value . "' , " . $isSearchUserIdClm . ")";
                }
            } else {
                //OR検索(デフォルト)
                $searchUserIdRegString = "(" . implode("|",array_unique($searchUserIdArray)) . ")";
                $whereArray[] = $isSearchUserIdClm . " REGEXP '^" . $searchUserIdRegString . "\$|^".$searchUserIdRegString.",|,".$searchUserIdRegString."\$|,".$searchUserIdRegString.",'";
            }
        }

        // 月額コース
        if($param["monthly_course_name"] || $param["chg_monthly_course"]){
            $whereArray[] = "mcu.monthly_course_id = " . ($param["monthly_course_name"] ? $param["monthly_course_name"] : $param["chg_monthly_course"]);
        }

        // 月額コースID
        if($param["search_monthly_course_id"]){
            $isSearchMonthlyCourseIdClm = "mcu.monthly_course_id";
            $searchMonthlyCourseIdArray = explode(",",rtrim($param["search_monthly_course_id"], ","));
            if ($param["monthly_course_id_type"]) {
                //AND検索
                foreach($searchMonthlyCourseIdArray as $key => $value){
                    $whereArray[] = "FIND_IN_SET( '" . $value . "' , " . $isSearchMonthlyCourseIdClm . ")";
                }
            } else {
                //OR検索(デフォルト)
                $searchMonthlyCourseIdRegString = "(" . implode("|",array_unique($searchMonthlyCourseIdArray)) . ")";
                $whereArray[] = $isSearchMonthlyCourseIdClm . " REGEXP '^" . $searchMonthlyCourseIdRegString . "\$|^".$searchMonthlyCourseIdRegString.",|,".$searchMonthlyCourseIdRegString."\$|,".$searchMonthlyCourseIdRegString.",'";
            }
        }

        // 月額コースグループ
        if($param["monthly_course_group_id"]){
          $whereArray[] = "mc.monthly_course_group_id = " . $param["monthly_course_group_id"];
        }

        // 月額コース有効日付(開始)
        if ($param["monthly_course_start_date"]) {
            $whereArray[] = "mcu.limit_start_date >= '" . $param["monthly_course_start_date"] . "'";
        }

        // 月額コース有効日付(終了)
        if ($param["monthly_course_end_date"]) {
            $whereArray[] = "mcu.limit_end_date <= '" . $param["monthly_course_end_date"] . "'";
        }

        // 月額更新
        if($param["specify_monthly_update"] == 1){
            // あり
            $whereArray[] = "mcu.is_monthly_update = 1";
        } elseif ($param["specify_monthly_update"] == 2) {
            // なし
            $whereArray[] = "mcu.is_monthly_update = 0";
        }

        // 付与月額更新用商品ID
        if($param["monthly_update_item_id"]){
            $isSearchMonthlyUpdateItemIdClm = "mcu.monthly_update_item_id";
            $searchMonthlyUpdateItemIdArray = explode(",",rtrim($param["monthly_update_item_id"], ","));
            if ($param["monthly_update_item_type"]) {
                //AND検索
                foreach($searchMonthlyUpdateItemIdArray as $key => $value){
                    $whereArray[] = "FIND_IN_SET( '" . $value . "' , " . $isSearchMonthlyUpdateItemIdClm . ")";
                }
            } else {
                //OR検索(デフォルト)
                $searchMonthlyCourseIdRegString = "(" . implode("|",array_unique($searchMonthlyUpdateItemIdArray)) . ")";
                $whereArray[] = $isSearchMonthlyUpdateItemIdClm . " REGEXP '^" . $searchMonthlyCourseIdRegString . "\$|^".$searchMonthlyCourseIdRegString.",|,".$searchMonthlyCourseIdRegString."\$|,".$searchMonthlyCourseIdRegString.",'";
            }
        }
        // 更新タイプ
        if($param["create_type"]){
          $whereArray[] = "mcu.create_type = " . $param["create_type"];
        }

        // 手動付与
        if($param["admin_id"]){
            // 管理手動
            $whereArray[] = "mcu.admin_id = " . $param["admin_id"];
        } elseif (is_numeric($param["admin_id"])) {
            // 一般
            $whereArray[] = "mcu.admin_id = 0";
        }

        //$whereArray[] = "mc.id = mcu.monthly_course_id";
        //$whereArray[] = "mcg.id = mc.monthly_course_group_id";
        //$whereArray[] = "mcu.monthly_update_item_id = i.id";
        $whereArray[] = "mcu.limit_end_date >= '" . date("Y-m-d") . "'";
        $whereArray[] = "mcu.is_invalid = 0";
        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable =0";
        $whereArray[] = "mcu.disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $leftJoin = "";
        $leftJoin .= "((" . $table . "monthly_course_user AS mcu LEFT JOIN monthly_course AS mc ON mcu.monthly_course_id = mc.id)";
        $leftJoin .= " LEFT JOIN monthly_course_group AS mcg ON mc.monthly_course_group_id = mcg.id)";
        $leftJoin .= " LEFT JOIN item AS i ON mcu.monthly_update_item_id = i.id";

        //$sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu, item AS i", $columnArray, $whereArray, $otherArray);
        $sql = $this->makeSelectQuery($leftJoin, $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * chkMonthlyCourseUserメソッド
     *
     * @param  array $dataArray   ユーザーデータ
     * @param integer $groupId   月額コースグループId
     * @return array  $data      商品一覧
     */
    public function chkMonthlyCourseUser($dataArray, $groupId = 0) {

        if (!is_array($dataArray)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS mcu.*";

        if ($dataArray["id"]) {
            $whereArray[] = "mcu.id !=" . $dataArray["id"];
        }

        if ($dataArray["user_id"]) {
            $whereArray[] = "mcu.user_id =" . $dataArray["user_id"];
        }

        if($groupId){
            $whereArray[] = "mc.monthly_course_group_id = " . $groupId;
        }

        $whereArray[] = "mcu.limit_end_date >= '" . date("Y-m-d") . "'";
        $whereArray[] = "mc.id = mcu.monthly_course_id";
        $whereArray[] = "mcg.id = mc.monthly_course_group_id";
        $whereArray[] = "mcu.is_invalid = 0";

        $whereArray[] = "mcg.is_display = 1";
        $whereArray[] = "mc.disable = 0";
        $whereArray[] = "mcg.disable =0";
        $whereArray[] = "mcu.disable =0";

        $sql = $this->makeSelectQuery("monthly_course AS mc, monthly_course_group AS mcg, monthly_course_user AS mcu", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        if ($dataList = $dbResultOBJ->fetchAll()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     *  月額コースグループの追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *
     *  @return boolean
     */
    public function insertMonthlyCourseGroupData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("monthly_course_group", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 商品カテゴリーの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *
     * @return boolean
     */
    public function updateMonthlyCourseGroupData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("monthly_course_group", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  月額コースユーザデータの追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *
     *  @return boolean
     */
    public function insertMonthlyCourseUserData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("monthly_course_user", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }


    /**
     * 月額コースユーザデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *
     * @return boolean
     */
    public function updateMonthlyCourseUserData($updateArray, $whereArray = null, $table = "monthly_course_user", $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update($table, $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }
}
?>