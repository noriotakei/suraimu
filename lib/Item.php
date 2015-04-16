<?php
/**
 * Item.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  web側商品管理クラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class Item extends ComCommon implements InterfaceItem {

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
     * 商品データの取得
     *
     * @param  array $cartList 商品ID
     * @param  array $userData ユーザーデータ
     *
     * @return array データ配列
     */
    public function getItemData($userData, $itemSearchKey) {

        if (!is_array($itemSearchKey) || !is_array($userData)) {
            return FALSE;
        }

        $columnArray[] = "i.*";

        // 検索条件(入金状態)設定
        if ($userData["total_payment"] > 0) {
            $userData["pay_status"] = self::PAY_STATUS_NOT_PAY;
        } else {
            $userData["pay_status"] = self::PAY_STATUS_PAY;
        }

        // 検索条件(商品ID)設定
        if ($itemSearchKey["id"]) {
            $whereArray[] = "i.id = " . $itemSearchKey["id"];
        }
        // 検索条件(アクセスキー)設定
        if ($itemSearchKey["access_key"]) {
            $whereArray[] = "i.access_key = " .  "'" . $itemSearchKey["access_key"] . "'";
        }

        $whereArray[] = "i.item_category_id = ic.id";
        $whereArray[] = "i.payment_status != " . $userData["pay_status"];
        $whereArray[] = "i.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "(i.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR i.sales_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(i.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR i.sales_end_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "i.disable = 0";
        $whereArray[] = "ic.disable = 0";

        $sql = $this->makeSelectQuery("item as i, item_category as ic", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        // 商品表示条件チェック(表示条件クリアしてるデータのみ抽出)
        if ($this->itemDisplayConditionCheck($data, $userData)) {
            // ユーザー側表示商品名はデコード
            if ($data["html_text_name_pc"]) {
                $data["html_text_name_pc"] = htmlspecialchars_decode($data["html_text_name_pc"], ENT_QUOTES);
            }
            if ($data["html_text_name_mb"]) {
                $data["html_text_name_mb"] = htmlspecialchars_decode($data["html_text_name_mb"], ENT_QUOTES);
            }

            return $data;

        } else {
            return FALSE;
        }
    }

    /**
     *
     * 商品リストデータの取得
     *
     * @param  array $userData ユーザーデータ
     * @param  array $itemSearchKey 検索条件
     *
     * @return array データ配列
     */
    public function getItemList($userData, $itemSearchKey = array()) {

        if (!is_array($userData)) {
            return FALSE;
        }

        $columnArray = "";
        $whereArray = "";
        $fromArray = "";

        $fromArray[] = "item as i";
        $fromArray[] = "item_category as ic";

        $columnArray[] = "SQL_CALC_FOUND_ROWS i.*";

        // 検索条件(入金状態)設定
        if ($userData["total_payment"] > 0) {
            $userData["pay_status"] = self::PAY_STATUS_NOT_PAY;
        } else {
            $userData["pay_status"] = self::PAY_STATUS_PAY;
        }

        // 月額コース設定
        if ($itemSearchKey["monthly_course_id"]) {
            $whereArray[] = "i.monthly_course_id = " .  "'" . $itemSearchKey["monthly_course_id"] . "'";
        }

        // 月額コース設定
        if ($itemSearchKey["monthly_course_group_id"]) {
            $whereArray[] = "mc.monthly_course_group_id = " .  "'" . $itemSearchKey["monthly_course_group_id"] . "'";
            $whereArray[] = "i.monthly_course_id = mc.id";
            $whereArray[] = "mcg.id = mc.monthly_course_group_id";
            $whereArray[] = "mcg.is_display = 1";
            $whereArray[] = "mc.disable = 0";
            $whereArray[] = "mcg.disable = 0";

            $fromArray[] = "monthly_course as mc";
            $fromArray[] = "monthly_course_group as mcg";
        }

        // 商品カテゴリー
        if ($itemSearchKey["item_category_id"]) {
            $whereArray[] = "i.item_category_id = " . $itemSearchKey["item_category_id"];
        }

        // 商品カテゴリーグループ
        if ($itemSearchKey["item_category_group_id"]) {
            $whereArray[] = "ic.item_category_group_id = " . $itemSearchKey["item_category_group_id"];
        }

        // FROM句を生成
        if ($fromArray) {
            $tableName = implode(",", $fromArray);
        }

        $whereArray[] = "i.item_category_id = ic.id";
        $whereArray[] = "i.payment_status != " . $userData["pay_status"];
        $whereArray[] = "i.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "(i.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR i.sales_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(i.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR i.sales_end_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "i.disable = 0";
        $whereArray[] = "ic.disable = 0";

        $sql = $this->makeSelectQuery($tableName, $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        $itemDataList = "";
        foreach ($dataList as $key => $val) {
            if ($this->itemDisplayConditionCheck($val, $userData)) {

                // ユーザー側表示商品名はデコード
                if ($val["html_text_name_pc"]) {
                    $val["html_text_name_pc"] = htmlspecialchars_decode($val["html_text_name_pc"], ENT_QUOTES);
                }
                if ($val["html_text_name_mb"]) {
                    $val["html_text_name_mb"] = htmlspecialchars_decode($val["html_text_name_mb"], ENT_QUOTES);
                }

                $itemDataList[] = $val;
            }
        }

        /*
        // データリスト取得
        $dataList = array();
        while ($data = $dbResultOBJ->fetch()) {

            // 商品表示条件チェック(表示条件クリアしてるデータのみ抽出)
            if ($this->itemDisplayConditionCheck($data, $userData)) {
                // ユーザー側表示商品名はデコード
                if ($data["html_text_name_pc"]) {
                    $data["html_text_name_pc"] = htmlspecialchars_decode($data["html_text_name_pc"], ENT_QUOTES);
                }
                if ($data["html_text_name_mb"]) {
                    $data["html_text_name_mb"] = htmlspecialchars_decode($data["html_text_name_mb"], ENT_QUOTES);
                }

                $dataList[] = $data;

            //} else {
            //    continue;
            }

        }
        */

        return $dataList;

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
        $columnArray[] = "ordering_detail.create_datetime as ordering_detail_create_datetime";
        $columnArray[] = "ordering_detail.update_datetime as ordering_detail_update_datetime";
        $columnArray[] = "ordering_detail.disable as ordering_detail_disable";

        $whereArray[] = "ordering_detail.ordering_id = " . $orderingId;
        $whereArray[] = "item.id = ordering_detail.item_id";
        $whereArray[] = "ordering_detail.is_cancel = 0";
        $whereArray[] = "ordering_detail.disable = 0";
        $whereArray[] = "item.disable = 0";

        $sql = $this->makeSelectQuery("item, ordering_detail", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        while ($data = $dbResultOBJ->fetch()) {
            // ユーザー側表示商品名はデコード
            if ($data["html_text_name_pc"]) {
                $data["html_text_name_pc"] = htmlspecialchars_decode($data["html_text_name_pc"], ENT_QUOTES);
            }
            if ($data["html_text_name_mb"]) {
                $data["html_text_name_mb"] = htmlspecialchars_decode($data["html_text_name_mb"], ENT_QUOTES);
            }
            $dataList[] = $data;
        }

        return $dataList;

    }

    /**
     *
     * キャンセル注文詳細のアイテムリストの取得
     *
     * @param  integer $orderingId 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getOrderingDetailCancelItemList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.*";
        $columnArray[] = "ordering_detail.id as detail_id";
        $columnArray[] = "ordering_detail.ordering_id";
        $columnArray[] = "ordering_detail.price";
        $columnArray[] = "ordering_detail.create_datetime as ordering_detail_create_datetime";
        $columnArray[] = "ordering_detail.update_datetime as ordering_detail_update_datetime";
        $columnArray[] = "ordering_detail.disable as ordering_detail_disable";

        $whereArray[] = "ordering_detail.ordering_id = " . $orderingId;
        $whereArray[] = "item.id = ordering_detail.item_id";
        $whereArray[] = "ordering_detail.is_cancel = 1";
        $whereArray[] = "ordering_detail.disable = 0";
        $whereArray[] = "item.disable = 0";

        $sql = $this->makeSelectQuery("item, ordering_detail", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        while ($data = $dbResultOBJ->fetch()) {
            // ユーザー側表示商品名はデコード
            if ($data["html_text_name_pc"]) {
                $data["html_text_name_pc"] = htmlspecialchars_decode($data["html_text_name_pc"], ENT_QUOTES);
            }
            if ($data["html_text_name_mb"]) {
                $data["html_text_name_mb"] = htmlspecialchars_decode($data["html_text_name_mb"], ENT_QUOTES);
            }
            $dataList[] = $data;
        }

        return $dataList;

    }

    /** ※現在は使用してないのでコメント(いつか使うかも)
     *
     * 強制注文アイテムリストの取得
     *
     * @param  integer $orderingId 注文ID
     *
     * @return array $dataList データ配列
     *
    public function getSelfOrderItemList($comUserData) {

        if (!is_array($comUserData)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS i.*";

        // 検索条件(入金状態)設定
        if ($comUserData["total_payment"] > 0) {
            $userData["pay_status"] = self::PAY_STATUS_NOT_PAY;
        } else {
            $userData["pay_status"] = self::PAY_STATUS_PAY;
        }

        $whereArray[] = "i.item_category_id = ic.id";
        $whereArray[] = "i.payment_status != " . $userData["pay_status"];
        $whereArray[] = "i.is_self_order = 1";
        $whereArray[] = "i.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "(i.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR i.sales_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(i.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR i.sales_end_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "i.disable = 0";
        $whereArray[] = "ic.disable = 0";

        $otherArray[] = "ORDER BY i.sort_seq DESC, i.id DESC";

        $sql = $this->makeSelectQuery("item AS i, item_category AS ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        if (!$dataList = $this->fetchAll($dbResultOBJ)) {
            return FALSE;
        }

        // 商品表示条件チェック(表示条件クリアしてるデータのみ抽出)
        $itemDataList = array();
        foreach ($dataList as $key => $val) {
            if ($this->itemDisplayConditionCheck($val, $comUserData)) {
                $itemDataList[] = $val;
            }
        }

        return $itemDataList;

    }
    */

    /**
     * itemDisplayConditionCheckメソッド
     *
     * 商品表示条件チェック処理
     *
     * @param  integer $data   商品データ
     * @param  integer $userId ユーザデータ
     * @return array   $data   表示条件に合った情報データ
     */
    public function itemDisplayConditionCheck($data, $userData) {

        // 引数が不正ならFALSE
        if (!is_array($data) || !is_array($userData)) {
            return FALSE;
        }

        //ユニットクラスのインスタンス生成
        $UnitOBJ = Unit::getInstance();

        //注文クラスのインスタンス生成
        $OrderingOBJ = Ordering::getInstance();

        /************************ [情報表示条件] *****************************/
        /*  unit_id                          = TRUE;  // ユニットID（表示）  */
        /*  except_unit_id                   = FALSE; // ユニットID（非表示）*/
        /*  item_id                          = TRUE;  // 購入商品ID（表示）  */
        /*  except_item_id                   = FALSE; // 購入商品ID（非表示）*/
        /*  user_search_conditions_id        = TRUE; // 検索条件保存ID(表示）*/
        /*  except_user_search_conditions_id = FALSE; // 購入商品ID（非表示）*/
        /*********************************************************************/

        //ユニットID（表示）チェック
        if ($data["unit_id"]) {
            // ユニットIDが「無ければ」情報閲覧不可
            if (!$UnitOBJ->isInUnitUser($userData["user_id"], $data["unit_id"])) {
                return FALSE;
            }
        }

        //ユニットID（非表示）チェック
        if ($data["except_unit_id"]) {
            // ユニットIDが「有れば」情報閲覧不可
            if ($UnitOBJ->isInUnitUser($userData["user_id"], $data["except_unit_id"])) {
                return FALSE;
            }
        }

        // 購入商品ID（表示）チェック
        if ($data["item_id"]) {
            // ユニットIDが「無ければ」情報閲覧不可
            if (!$OrderingOBJ->isBoughtItem($userData["user_id"], $data["item_id"])) {
                return FALSE;
            }
        }

        // 購入商品ID（非表示）チェック
        if ($data["except_item_id"]) {
            // ユニットIDが「有れば」情報閲覧不可
            if ($OrderingOBJ->isBoughtItem($userData["user_id"], $data["except_item_id"])) {
                return FALSE;
            }
        }

        // 検索条件保存ID(表示)※「AND検索→すべて該当する場合/OR検索→1つでも該当する場合」⇒ 表示
        if ($data["user_search_conditions_id"]) {
            // 管理用ユーザークラスのインスタンス生成
            $AdmUserOBJ = AdmUser::getInstance();
            $searchConditionAry = explode(",", $data["user_search_conditions_id"]);
            $searchConditionIdCount = count($searchConditionAry);

            foreach ($searchConditionAry as $val) {
                $searchSaveData = "";
                $searchValue = "";
                if ($searchSaveData = $AdmUserOBJ->getUserSearchConditionData($val)) {
                    $searchValue = unserialize($searchSaveData["search_condition"]);

                    $columnArray = "";
                    $whereArray = "";

                    $columnArray[] = "user_id";

                    $whereArray = $AdmUserOBJ->setWhereString($searchValue);
                    $whereArray[] = "user_id = " . $userData["user_id"];

                    $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

                    // ユーザー検索情報の取得
                    if (!$this->executeQuery($sql, "fetchRow")) {
                        // 検索結果が取れてこなかった場合
                        if ($data["user_search_conditions_type"]) {
                            // AND検索(1つでも該当なしならFALSE)
                            return FALSE;
                        } else {
                            // OR検索(該当なしなら件数からマイナス)
                            $searchConditionIdCount --;
                        }
                    } else {
                        // 検索結果が取れてきた場合(OR検索)
                        if (!$data["user_search_conditions_type"]) {
                            // OR検索(1つでも該当したらループ抜ける)
                            break;
                        }
                    }
                }
            }
            // (OR検索で)1件も該当なしならFALSE
            if ($searchConditionIdCount == 0) {
                return FALSE;
            }
        }

        // 検索条件保存ID(非表示) ※「AND検索→すべて該当する場合/OR検索→1つでも該当する場合」⇒ 非表示
        if ($data["except_user_search_conditions_id"]) {
            // 管理用ユーザークラスのインスタンス生成
            $AdmUserOBJ = AdmUser::getInstance();
            $exceptSearchConditionAry = explode(",", $data["except_user_search_conditions_id"]);
            $exceptSearchConditionIdCount = count($exceptSearchConditionAry);

            foreach ($exceptSearchConditionAry as $val) {
                $searchSaveData = "";
                $searchValue = "";
                if ($searchSaveData = $AdmUserOBJ->getUserSearchConditionData($val)) {
                    $searchValue = unserialize($searchSaveData["search_condition"]);

                    $columnArray = "";
                    $whereArray = "";

                    $columnArray[] = "user_id";

                    $whereArray = $AdmUserOBJ->setWhereString($searchValue);
                    $whereArray[] = "user_id = " . $userData["user_id"];

                    $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

                    // ユーザー検索情報の取得
                    if ($this->executeQuery($sql, "fetchRow")) {
                        // 検索結果が取れてきた場合
                        if ($data["except_user_search_conditions_type"]) {
                            // AND検索(「該当あり」なら件数からマイナス)
                            $exceptSearchConditionIdCount --;
                        } else {
                            // OR検索(「非表示」なので、1件でも「該当あり」ならFALSE)
                            return FALSE;
                        }
                    } else {
                        // 検索結果が取れてこない場合(AND検索)
                        if ($data["except_user_search_conditions_type"]) {
                            // AND検索(1件でも該当なしならループ抜ける)
                            break;
                        }
                    }
                }
            }
            // AND検索の場合はすべて「該当あり」ならFALSE
            if ($exceptSearchConditionIdCount == 0) {
                return FALSE;
            }
        }

        // 曜日間の情報表示縛り設定
        if ($data["is_display_week"] != 0) {
            if($data["display_week_string"]) {

                //その週の日曜日の日付（weekStartDate）を取得します
                $nowDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                $nowDateArray = getdate($nowDate);
                $nowWeekNum = $nowDateArray['wday']; //指定日の曜日番号
                $weekStartDate = date("Y-m-d",($nowDate - $nowWeekNum * 24 * 60 * 60));

                $currentWeekArray = explode("-",$weekStartDate);

                //設定値を取得、整形します
                $displayWeekStringArray = explode("_",$data["display_week_string"]);

                $startValueArray = explode(",",$displayWeekStringArray[0]);
                $lastValueArray  = explode(",",$displayWeekStringArray[1]);

                //その週での表示開始、終了曜日
                $firstWeekNum = $startValueArray[0];
                $lastWeekNum  = $lastValueArray[0];

                $startTimeArray = explode(":",$startValueArray[1]);
                $lastTimeArray  = explode(":",$lastValueArray[1]);

                //その週での開始日時、終了日時を取得します
                $StartDatetime = mktime($startTimeArray[0], $startTimeArray[1], $startTimeArray[2], $currentWeekArray[1], $currentWeekArray[2] + $firstWeekNum, $currentWeekArray[0]);
                $lastDatetime  = mktime($lastTimeArray[0],  $lastTimeArray[1],  $lastTimeArray[2],  $currentWeekArray[1], $currentWeekArray[2] + $lastWeekNum,  $currentWeekArray[0]);
                //現時点でのタイムスタンプ
                $nowTime = time();

                //表示する場合
                if($data["is_display_week"] == 1){

                    if( ($StartDatetime > $nowTime) OR ($lastDatetime < $nowTime) ){
                        return FALSE;
                    }

/*
                    //金曜(5)～月曜(1)設定の場合
                    if($StartDatetime > $lastDatetime){
                        //『表示終了時刻（月曜設定）より前か、表示開始時刻（金曜設定）より後』の条件満たす排他的論理和
                        if( ($StartDatetime < $nowTime) XOR ($lastDatetime > $nowTime) ){
                            //おｋなので何もしません
                        }else{
                            return FALSE;
                        }
                    }else{

                        if( ($StartDatetime > $nowTime) OR ($lastDatetime < $nowTime) ){
                            return FALSE;
                        }
                    }
*/
                //表示しない場合
                }elseif($data["is_display_week"] == 2){

                    if( ($StartDatetime < $nowTime) AND ($lastDatetime > $nowTime) ){
                        return FALSE;
                    }
                }
            }
        }
        return TRUE;
    }

}
?>