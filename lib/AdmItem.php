<?php
/**
 * AdmItem.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側ユーザー側用商品ID管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmItem extends ComCommon implements InterfaceItem {

    /* 入金状態状態 */
    public static $_paymentStatus = array(
                                    "0" => "設定しない",
                                    self::PAY_STATUS_PAY => "入金有り",
                                    self::PAY_STATUS_NOT_PAY => "入金無し"
                                );

    /* 強制注文フラグ
    public static $_isSelfOrder = array(
                                    "0" => "OFF",
                                    "1" => "ON",
                                );
    */

    /* 検索用強制注文
    public static $_searchIsSelfOrder = array(
                                    "0" => "気にしない",
                                    "1" => "ON",
                                    "2" => "OFF"
                                );
     */

    /** 検索タイプ配列 */
    public static $_searchTypeAry = array(
                            "0" => "気にしない"
                            //,"1" => "商品ID"
                            //,"2" => "商品アクセスキー"
                            ,"3" => "商品名"
                            //,"4" => "表示開始日時"
                            ,"5" => "検索条件保存ID"
        );

    /** 表示日時指定配列 */
    public static $_searchDisplayDateTimeTypeAry = array(
                            "0" => "気にしない"
                            ,"1" => "期間中"
                            ,"2" => "期間切れ"
                            ,"3" => "日時指定"
        );

    /* 検索用表示状態 */
    public static $_searchIsDisplay = array(
                                    "0" => "気にしない",
                                    "1" => "非表示",
                                    "2" => "表示"
                                );
    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示"
                                );

    /* 商品データ一括操作内容 */
    public static $_batchOperateItemSelectAry = array(
                                    "1" => "表示状態変更",
                                    "2" => "カテゴリー移動",
                                    "3" => "商品データコピー",
                                    "4" => "削除",
                                );
    /** 商品名検索配列 */
    public static $_searchItemNameAry = array(
                            "1" => "管理側表示用"
                            ,"2" => "PC注文確認用"
                            ,"3" => "MB注文確認用"
                            ,"4" => "注文完了リメール用"
        );

    /* 商品カテゴリーグループ */
    public static $_categoryGroupAry = array(
                                    self::ITEM_CATEGORY_GROUP_CAMP => "キャンペーン",
                                    self::ITEM_CATEGORY_GROUP_POINT => "ポイント",
                                    self::ITEM_CATEGORY_GROUP_MONTHLY => "月額"
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
     * アイテムデータの取得
     *
     * @param  integer $id     アイテムID
     * @param  boolean $decord デコード処理フラグ
     *
     * @return array データ配列
     */
    public function getItemData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;

        $sql = $this->makeSelectQuery("item", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * アイテムリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @param  boolean $decord デコード処理フラグ
     *
     * @return array $dataList データ配列
     */
    public function getItemList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.*";

        $columnArray[] = "item_category.name AS category_name";

        $whereArray[] = "item.item_category_id = item_category.id";
        $whereArray[] = "item.disable = 0";
        $whereArray[] = "item_category.disable = 0";

        // カテゴリー検索
        if ($param["search_category_id"]) {
            $whereArray[] = "item.item_category_id = " . $param["search_category_id"];
        }
        // 表示状態検索
        if ($param["search_is_display"] == 1) {
            $whereArray[] = "item.is_display = 0";
        } elseif ($param["search_is_display"] == 2) {
            $whereArray[] = "item.is_display = 1";
        }

        // 強制フラグ ※現在は使用してないのでコメント(いつか使うかも)
        /*
        if ($param["search_is_self_order"] == 1) {
            $whereArray[] = "item.is_self_order = 1";
        } elseif ($param["search_is_display"] == 2) {
            $whereArray[] = "item.is_self_order = 0";
        }
        */

        // 商品ID
        if ($param["search_item_id"]) {
            // 末尾のカンマ削除(あれば)
            $param["search_item_id"] = rtrim($param["search_item_id"], ",");
            $whereArray[] = "item.id IN( " . $param["search_item_id"] . ")";
        }

        // 商品アクセスキー
        if ($param["search_item_key"]) {
            // 複数の場合、文字列としてそれぞれ指定しないといけない
            $searchItemKeyAry = array();
            $searchItemKeyAry = explode(",", $param["search_item_key"]);

            $searchItemKey = array();
            foreach ($searchItemKeyAry as $key => $val) {
                $searchItemKey[] = "'" . $val . "'";
            }

            // 再度、カンマで連結
            $searchItemKeyString = "";
            $searchItemKeyString = implode(",", $searchItemKey);

            $whereArray[] = "item.access_key IN (" . $searchItemKeyString . ")";
        }

        if ($param["search_sales_datetime_type"] == 1) {
            // 期間中(開始日時<=現在日時, 現在日時<=終了日時 or 終了日時=0000-00-00 00:00:00)
            $whereArray[] = "item.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "'";
            $whereArray[] = "(item.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR item.sales_end_datetime = '0000-00-00 00:00:00')";
        } elseif ($param["search_sales_datetime_type"] == 2) {
            // 期間切れ(終了日時 < 現在日時)
            $whereArray[] = "item.sales_end_datetime != '0000-00-00 00:00:00'";
            $whereArray[] = "item.sales_end_datetime < '" . date("Y-m-d H:i:s") . "'";
        }  else {
            // 表示日時開始日
            if ($param["searchDatetimeFrom"]) {
                // 表示開始日検索
                $whereArray[] = "item.sales_start_datetime <= '" . $param["searchDatetimeFrom"] . "'";
                $whereArray[] = "(item.sales_end_datetime >= '" . $param["searchDatetimeFrom"] . "' OR item.sales_end_datetime = '0000-00-00 00:00:00')";
            }
            // 表示日時終了日
            if ($param["searchDatetimeTo"]) {
                // 表示開始日検索
                $whereArray[] = "item.sales_end_datetime <= '" . $param["searchDatetimeTo"] . "'";
                $whereArray[] = "item.sales_end_datetime != '0000-00-00 00:00:00'";
            }
        }

        // 検索対象
        if ($param["search_type"] == 3) {
            // 管理用商品名検索
            if ($param["search_string"] && $param["search_item_name_type"]) {
                foreach ($param["search_item_name_type"] as $val) {
                    if ($val == 1) {
                        // 管理側表示用
                        $searchColumnArray[] = "item.name";
                    } elseif ($val == 2) {
                        // PC注文確認用
                        $searchColumnArray[] = "item.html_text_name_pc";
                    } elseif ($val == 3) {
                        // MB注文確認用
                        $searchColumnArray[] = "item.html_text_name_mb";
                    } else {
                        // 注文完了リメール用
                        $searchColumnArray[] = "item.remail_name";
                    }
                }
                $whereItemNameArray = implode(", " , $searchColumnArray);
                $whereArray[] = " (CONCAT(" . $whereItemNameArray . ") LIKE '%" .  $param["search_string"] . "%')";
            }
        } elseif ($param["search_type"] == 5 && $param["search_conditions_id"] && $param["search_conditions_type"]) {

            // 検索条件保存ID
            $searchConditionsIdArray = explode(",",rtrim($param["search_conditions_id"], ","));

            // 検索条件保存IDの表示タイプで参照カラム設定
            if ($param["search_conditions_display_type"]) {
                // 表示
                $isSearchConditionsClm = "item.user_search_conditions_id";
            } else {
                // 非表示
                $isSearchConditionsClm = "item.except_user_search_conditions_id";
            }

            if ($param["search_conditions_type"] == 1) {
                //AND検索
                foreach($searchConditionsIdArray as $key => $value){
                    $whereArray[] = "FIND_IN_SET( '" . $value . "' , " . $isSearchConditionsClm . ")";
                }
            } else {
                //OR検索 正規表現間違ってたらゴメンなさい
                $searchConditionsRegString = "(" . implode("|",array_unique($searchConditionsIdArray)) . ")";
                $whereArray[] = $isSearchConditionsClm . " REGEXP '^" . $searchConditionsRegString . "\$|^".$searchConditionsRegString.",|,".$searchConditionsRegString."\$|,".$searchConditionsRegString.",'";
            }
            //$whereArray[] = "item.user_search_conditions_id = " . $param["search_conditions_id"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("item, item_category", $columnArray, $whereArray, $otherArray);


        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        while ($data = $dbResultOBJ->fetch()) {
            // デコード
            $data["html_text_name"] = htmlspecialchars_decode($data["html_text_name"], ENT_QUOTES);
            $dataList[] = $data;
        }

        return $dataList;

    }


    /**
     * アイテムの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertItemData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("item", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * アイテムの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateItemData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("item", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * アイテムカテゴリーデータの取得
     *
     * @param  integer $id アイテムID
     *
     * @return array データ配列
     */
    public function getItemCategoryData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("item_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * アイテムカテゴリーリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getItemCategoryList($param, $offset = 0, $order = null, $limit = 0) {

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

        $sql = $this->makeSelectQuery("item_category", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * selectbox用商品カテゴリーリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getItemCategoryForSelect() {


        $columnArray[] = "*";

        $whereArray[] = "is_display = 1";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("item_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }
        return $dataArray;
    }

    /**
     *
     *  商品カテゴリーの追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *
     *  @return boolean
     */
    public function insertItemCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("item_category", $insertArray)) {
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
    public function updateItemCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("item_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
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
     * access_keyの重複が無い様にaccess_keyを返す。
     *
     *
     * @param datetime $registDatetime キー生成に使用するデータ
     *
     * @return string accessKey　を連想配列で返す
     */
    public function getNewAccessKey($data)  {

        if (!$data) {
            return false;
        }

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $accessKey   = md5($data . "__" . time());
            $accessKey   = substr($accessKey,0,16);

            $columnArray[] = "*";

            $whereArray[] = "access_key = '" . $accessKey . "'";
            $whereArray[] = "disable = 0";

            $sql = $this->makeSelectQuery("item", $columnArray, $whereArray);

            $i++;

            // ループ回数は100回
            if ($i > 100) {
                return FALSE;
            }

        } while ($data = $this->executeQuery($sql, "fetchRow"));

        return $accessKey;
    }

    /**
     *
     * 注文詳細のアイテムリストの取得
     *
     * @param  integer $orderingId 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getOrderingDetailItemList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.*";
        $columnArray[] = "ordering_detail.id as detail_id";
        $columnArray[] = "ordering_detail.ordering_id";
        $columnArray[] = "ordering_detail.price";
        $columnArray[] = "ordering_detail.is_rest";
        $columnArray[] = "ordering_detail.create_datetime as ordering_detail_create_datetime";
        $columnArray[] = "ordering_detail.update_datetime as ordering_detail_update_datetime";
        $columnArray[] = "ordering_detail.disable as ordering_detail_disable";

        $whereArray[] = "ordering_detail.ordering_id = " . $orderingId;
        $whereArray[] = "ordering_detail.is_cancel = 0";
        $whereArray[] = "ordering_detail.disable = 0";

        $sql = $this->makeSelectQuery("item RIGHT OUTER JOIN ordering_detail ON item.id = ordering_detail.item_id", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }
}
?>