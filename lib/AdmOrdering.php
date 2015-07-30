<?php
/**
 * AdmOrdering.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側注文管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmOrdering extends ComCommon implements InterfaceOrdering {

    /** @var array 注文ステータス配列 */
    public static $_orderStatus = array(
                self::ORDERING_STATUS_WAIT_BAS => "入金待ち(銀振)",
                self::ORDERING_STATUS_WAIT_RAKUTEN => "入金待ち(楽天銀行)",
                self::ORDERING_STATUS_WAIT_BANK => "入金待ち(入金おまかせサービス)",
                self::ORDERING_STATUS_WAIT_CREDIT => "入金待ち(ゼロクレジット)",
                self::ORDERING_STATUS_WAIT_TELECOM => "入金待ち(テレコムクレジット)",
                self::ORDERING_STATUS_WAIT_BITCASH => "入金待ち(BITCASH)",
                self::ORDERING_STATUS_WAIT_CVD => "入金待ち(コンビニダイレクト)",
                self::ORDERING_STATUS_WAIT_CCHECK => "入金待ち(C-check)",
                self::ORDERING_STATUS_WAIT_DIGITALEDY => "入金待ち(デジタルチェックEdy)",
                self::ORDERING_STATUS_ERR_BAS => "入金エラー(銀振)",
                self::ORDERING_STATUS_ERR_RAKUTEN => "入金エラー(楽天銀行)",
                self::ORDERING_STATUS_ERR_BANK => "入金エラー(入金おまかせサービス)",
                self::ORDERING_STATUS_ERR_CREDIT => "入金エラー(ゼロクレジット)",
                self::ORDERING_STATUS_ERR_TELECOM => "入金エラー(テレコムクレジット)",
                self::ORDERING_STATUS_ERR_BITCASH => "入金エラー(BITCASH)",
                self::ORDERING_STATUS_ERR_CVD => "入金エラー(コンビニダイレクト)",
                self::ORDERING_STATUS_ERR_CCHECK => "入金エラー(C-check)",
                self::ORDERING_STATUS_ERR_DIGITALEDY => "入金エラー(デジタルチェックEdy)",
                self::ORDERING_STATUS_PRE_COMPLETE => "仮購入",
                self::ORDERING_STATUS_COMPLETE => "決済完了",
                self::ORDERING_STATUS_REST => "余り金決済完了",
                  );

    /** @var array 注文登録ステータス配列 */
    public static $_registOrderStatus = array(
                self::ORDERING_STATUS_WAIT_BAS     => "入金待ち(銀振)",
                self::ORDERING_STATUS_WAIT_RAKUTEN     => "入金待ち(楽天銀行)",
                self::ORDERING_STATUS_WAIT_BANK => "入金待ち(入金おまかせサービス)",
                self::ORDERING_STATUS_WAIT_CREDIT      => "入金待ち(ゼロクレジット)",
                self::ORDERING_STATUS_WAIT_TELECOM      => "入金待ち(テレコムクレジット)",
                self::ORDERING_STATUS_WAIT_CVD => "入金待ち(コンビニダイレクト)",
                self::ORDERING_STATUS_WAIT_CCHECK => "入金待ち(C-check)",
                self::ORDERING_STATUS_WAIT_DIGITALEDY => "入金待ち(デジタルチェックEdy)",
                self::ORDERING_STATUS_WAIT_BITCASH      => "入金待ち(BITCASH)",
                self::ORDERING_STATUS_PRE_COMPLETE      => "仮購入",
                self::ORDERING_STATUS_COMPLETE      => "決済完了",
          );

    /** @var array 支払方法配列 */
    public static $_payType = array(
                self::PAY_TYPE_BANK_AUTOMATIONBAS     => "銀行振込",
                self::PAY_TYPE_BANK_RAKUTEN => "銀行振込(楽天銀行)",
                self::PAY_TYPE_BANK_AUTOMATION => "銀行振込(入金おまかせサービス)",
                self::PAY_TYPE_CREDIT    => "ゼロクレジット",
                self::PAY_TYPE_TELECOM    => "テレコムクレジット",
                self::PAY_TYPE_CVD    => "コンビニダイレクト",
                self::PAY_TYPE_CCHECK => "C-check",
                self::PAY_TYPE_DIGITALEDY => "デジタルチェックEdy",
                self::PAY_TYPE_BITCASH    => "BITCASH",
                self::PAY_TYPE_ADMIN    => "管理手動入力",
                  );

    /** @var array 予約注文表示場所配列 */
    public static $_ordringDisplayCd = array(
                self::ORDERING_DISPLAY_CD_PC_HOME    => "PCログイン後TOP",
                self::ORDERING_DISPLAY_CD_PC_ITEMLIST    => "PC商品リスト",
                self::ORDERING_DISPLAY_CD_MB_HOME    => "MBログイン後TOP",
                self::ORDERING_DISPLAY_CD_MB_ITEMLIST    => "MB商品リスト",
                  );
    /** @var array キャンセルフラグ配列 */
    public static $_cancelFlag = array(
                    "0" => "正常",
                    "1" => "キャンセル",
                   );

    /** @var array 入金フラグ配列 */
    public static $_paidFlag = array(
                    "0" => "未入金",
                    "1" => "入金済み",
                  );

    /** @var array 重複フラグ配列 */
    public static $_overLapFlag = array(
                    "1" => "重複ユーザーをまとめる",
                    "0" => "重複ユーザーをまとめない",
                  );

    /** 日付選択プルダウン配列 */
    private $datetimeParameter = array(
            "2" => "-2 hour",
            "3" => "-1 day",
            "4" => "-3 day",
            "5" => "-1 week",
            "6" => "-1 month",
        );

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示中"
                                );

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string 注文検索sql文 */
    private $_listSql = null;

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
     * 注文データの取得
     *
     * @param  integer $id 注文ID
     * @return array データ配列
     */
    public function getOrderingData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

        /**
     * 注文検索の条件文の作成
     *
     * @param  array $param データ配列
     * @return array 検索条件文配列
     */
    public function setWhereString($param) {

        $whereArray[] = "v_user.user_disable = 0";

        // 注文日付
        switch ($param["specify_order_date"]) {

            case 1 :
                $orderDatetimeFrom = $param["order_start_datetime_Date"]
                                        . " " . $param["order_start_datetime_Time"];

                $orderDatetimeTo = $param["order_end_datetime_Date"]
                                        . " " . $param["order_end_datetime_Time"];

                if (ComValidation::isDatetime($orderDatetimeFrom)) {
                    $whereArray[] = "ordering.create_datetime >= '" . $orderDatetimeFrom . "'";
                    $orderDatetime["from"] = $orderDatetimeFrom;
                }
                if (ComValidation::isDatetime($orderDatetimeTo)) {
                    $whereArray[] = "ordering.create_datetime <= '" . $orderDatetimeTo . "'";
                    $orderDatetime["to"] = $orderDatetimeTo;
                }

                if ($orderDatetime) {
                    $this->_contents["注文日付"] = $orderDatetime["from"] . " ～ " . $orderDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $whereArray[] = "ordering.create_datetime >= '". date("Y-m-d H:i:00", strtotime($this->datetimeParameter[$param["specify_order_date"]])) . "'";
                $this->_contents["注文日付"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_order_date"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["order_time_from"])) {
                    $whereArray[] = "ordering.create_datetime <= '" . date("Y-m-d H:i:59", strtotime("-" . $param["order_time_from"] . " hour")) . "'";
                    $orderDatetime["from"] = $param["order_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["order_time_to"])) {
                    $whereArray[] = "ordering.create_datetime >= '" . date("Y-m-d H:i:00", strtotime("-" . $param["order_time_to"] . " hour")) . "'";
                    $orderDatetime["to"] = $param["order_time_to"] . "時間前まで";
                }

                if ($orderDatetime) {
                    $this->_contents["注文日付"] = $orderDatetime["from"] . " " . $orderDatetime["to"];
                }
                break;
            default :
                break;
        }

        // 決済完了日付
        switch ($param["specify_paid_date"]) {

            case 1 :
                $paidDatetimeFrom = $param["paid_start_datetime_Date"]
                . " " . $param["paid_start_datetime_Time"];

                $paidDatetimeTo = $param["paid_end_datetime_Date"]
                . " " . $param["paid_end_datetime_Time"];

                if (ComValidation::isDatetime($paidDatetimeFrom)) {
                    $whereArray[] = "ordering.paid_datetime >= '" . $paidDatetimeFrom . "'";
                    $paidDatetime["from"] = $paidDatetimeFrom;
                }
                if (ComValidation::isDatetime($paidDatetimeTo)) {
                    $whereArray[] = "ordering.paid_datetime <= '" . $paidDatetimeTo . "'";
                    $paidDatetime["to"] = $paidDatetimeTo;
                }

                if ($paidDatetime) {
                    $this->_contents["決済完了日付"] = $paidDatetime["from"] . " ～ " . $paidDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $whereArray[] = "ordering.paid_datetime >= '". date("Y-m-d H:i:00", strtotime($this->datetimeParameter[$param["specify_paid_date"]])) . "'";
                $this->_contents["決済完了日付"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_paid_date"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["paid_time_from"])) {
                    $whereArray[] = "ordering.paid_datetime <= '" . date("Y-m-d H:i:59", strtotime("-" . $param["paid_time_from"] . " hour")) . "'";
                    $paidDatetime["from"] = $param["paid_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["paid_time_to"])) {
                    $whereArray[] = "ordering.paid_datetime >= '" . date("Y-m-d H:i:00", strtotime("-" . $param["paid_time_to"] . " hour")) . "'";
                    $paidDatetime["to"] = $param["paid_time_to"] . "時間前まで";
                }

                if ($paidDatetime) {
                    $this->_contents["決済完了日付"] = $paidDatetime["from"] . " " . $paidDatetime["to"];
                }
                break;
            default :
                break;
        }

        if (ComValidation::isNumeric($param["user_id"])) {
            $whereArray[] = "ordering.user_id = " . $param["user_id"];
            $this->_contents["ユーザーID"] = $param["user_id"];
        }

        if (!ComValidation::isNumeric($param["is_quit"])) {
            $whereArray[] = "v_user.regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        } else {
            $this->_contents["会員解除"] = "会員解除ユーザーも含む";
        }

        if (!ComValidation::isNumeric($param["is_danger"])) {
            $whereArray[] = "v_user.danger_status != " . $this->_configOBJ->define->DANGER_VALID;
        } else {
            $this->_contents["ブラック"] = "ブラックユーザーも含む" ;
        }

        if (ComValidation::isNumeric($param["search_ordering_id"])) {
            $whereArray[] = "ordering.id = " . $param["search_ordering_id"];
            $this->_contents["注文ID"] = $param["search_ordering_id"];
        }

        if (ComValidation::isNumeric($param["search_item_id"])) {
            $whereArray[] = "ordering_detail.item_id = " . $param["search_item_id"];
            $this->_contents["商品ID"] = $param["search_item_id"];
        }

        if ($param["pc_address"]) {
            $whereArray[] = "v_user.pc_address LIKE '" . $param["pc_address"] . "%'";
            $this->_contents["PCアドレス"] = "前方一致 : " . $param["pc_address"];
        }

        if ($param["mb_address"]) {
            $whereArray[] = "v_user.mb_address LIKE '" . $param["mb_address"] . "%'";
            $this->_contents["MBアドレス"] = "前方一致 : " . $param["mb_address"];
        }

        if (ComValidation::isArray($param["order_status"])) {
            $whereArray[] = "ordering.status IN (" . implode(",", $param["order_status"]) . ")";
            foreach ($param["order_status"] as $val) {
                $orderStatus[] = AdmOrdering::$_orderStatus[$val];
            }
            $this->_contents["注文ステータス"] = implode("、", $orderStatus);
        }

        if (ComValidation::isArray($param["pay_type"])) {
            $whereArray[] = "ordering.pay_type IN (" . implode(",", $param["pay_type"]) . ")";
            foreach ($param["pay_type"] as $val) {
                $payType[] = AdmOrdering::$_payType[$val];
            }
            $this->_contents["支払方法"] = implode("、", $payType);
        }

        if (ComValidation::isArray($param["is_paid"])) {
            $whereArray[] = "ordering.is_paid IN (" . implode(",", $param["is_paid"]) . ")";
            foreach ($param["is_paid"] as $val) {
                $isPaid[] = AdmOrdering::$_paidFlag[$val];
            }
            $this->_contents["入金"] = implode("、", $isPaid);
        }

        if (ComValidation::isArray($param["is_cancel"])) {
            $whereArray[] = "ordering.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")";
            foreach ($param["is_cancel"] as $val) {
                $isCancel[] = AdmOrdering::$_cancelFlag[$val];
            }
            $this->_contents["キャンセル"] = implode("、", $isCancel);
        }

        if (ComValidation::isNumeric($param["is_invalid"])) {

            $subColumn[] = "sub_od.ordering_id";

            $subWhereArray[] = "sub_o.id = sub_od.ordering_id";
            $subWhereArray[] = "sub_o.user_id = sub_v_user.user_id";
            $subWhereArray[] = "sub_od.item_id = i.id";
            $subWhereArray[] = "sub_v_user.user_disable = 0";
            $subWhereArray[] = "i.item_category_id = ic.id";
            $subWhereArray[] = "sub_od.is_cancel = 0";
            $subWhereArray[] = "i.disable = 0";
            $subWhereArray[] = "ic.disable = 0";
            $subWhereArray[] = "sub_o.disable = 0";
            $subWhereArray[] = "sub_od.disable = 0";
            $subWhereArray[] = "(!(sub_v_user.total_payment > 0 AND i.payment_status != " . Item::PAY_STATUS_NOT_PAY . ") OR !(sub_v_user.total_payment = 0 AND i.payment_status != " . Item::PAY_STATUS_PAY . "))";
            $subWhereArray[] = "NOT (i.is_display = 1";
            $subWhereArray[] = "ic.is_display = 1";
            $subWhereArray[] = "(i.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR i.sales_start_datetime = '0000-00-00 00:00:00')";
            $subWhereArray[] = "(i.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR i.sales_end_datetime = '0000-00-00 00:00:00'))";

            $subSql = $this->makeSelectQuery("ordering sub_o, ordering_detail sub_od, v_user_profile sub_v_user, item as i, item_category as ic", $subColumn, $subWhereArray);

            $whereArray[] = "ordering.id NOT IN (" . $subSql . ")";

            $this->_contents["無効商品"] = "無効商品を含む注文を除く";
        }

        if (ComValidation::isNumeric($param["is_overlap"])) {
            $this->_contents["重複ユーザー"] = AdmOrdering::$_overLapFlag[$param["is_overlap"]];
        }

        return $whereArray;

    }

    /**
     *
     * 注文リストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getOrderingList($param, $offset = null, $order = null, $limit = 20) {

        $columnArray[] = "ordering.*";

        $whereArray = $this->setWhereString($param);

        $whereArray[] = "ordering.user_id = v_user.user_id";
        $whereArray[] = "ordering.id = ordering_detail.ordering_id";
        $whereArray[] = "ordering.disable = 0";
        $whereArray[] = "ordering_detail.disable = 0";

        $subSql = $this->makeSelectQuery("(SELECT * FROM ordering ORDER BY id DESC) ordering, ordering_detail, v_user_profile v_user", $columnArray, $whereArray, $otherArray);

        if ($param["is_overlap"]) {
            $orderingTable = "(" . $subSql . " GROUP BY user_id) ordering";
        } else {
            $orderingTable = "(" . $subSql . ") ordering";
        }

        $columnArray = "";
        $whereArray = "";
        $otherArray = "";

        $columnArray[] = "SQL_CALC_FOUND_ROWS ordering.*";

        $otherArray[] = "GROUP BY ordering.id";

        if ($order) {
            $otherArray[] = "ORDER BY " . $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = "LIMIT " . $offset . ", " . $limit;
        }

        $this->_listSql = $this->makeSelectQuery($orderingTable, $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * アイテムIDを含む注文データを取得
     *
     * @param  integer $userId ユーザーID
     * @param  array $orderingDetailIdList 注文詳細IDリスト
     *
     * @return array $dataList データ配列
     */
    public function getOrderingListFromItemId($userId, $orderingDetailIdList) {

        if (!is_numeric($userId) OR !is_array($orderingDetailIdList)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS o.*";

        $whereArray[] = "od.item_id IN (" . implode(",", $orderingDetailIdList) . ")";
        $whereArray[] = "o.user_id = " . $userId;
        $whereArray[] = "o.id = od.ordering_id";
        $whereArray[] = "o.is_paid = 0";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "od.is_cancel = 0";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "od.disable = 0";

        $otherArray[] = "GROUP BY o.id";

        $sql = $this->makeSelectQuery("ordering o, ordering_detail od", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * 期限切れ注文データの取得
     *
     *
     * @return array $dataList データ配列
     */
    public function getExpirationOrderingDataList() {

        $column[] = "o.id";

        $whereArray[] = "o.id = od.ordering_id";
        $whereArray[] = "o.user_id = v_user.user_id";
        $whereArray[] = "od.item_id = i.id";
        $whereArray[] = "i.item_category_id = ic.id";
        $whereArray[] = "v_user.user_disable = 0";
        $whereArray[] = "od.is_cancel = 0";
        $whereArray[] = "i.disable = 0";
        $whereArray[] = "ic.disable = 0";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "od.disable = 0";
        $whereArray[] = "o.is_paid = 0";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.status NOT IN (" . self::ORDERING_STATUS_PRE_COMPLETE . ", " . self::ORDERING_STATUS_COMPLETE . ", " . self::ORDERING_STATUS_REST . ")";
        $whereArray[] = "(!(v_user.total_payment > 0 AND i.payment_status != " . Item::PAY_STATUS_NOT_PAY . ") OR !(v_user.total_payment = 0 AND i.payment_status != " . Item::PAY_STATUS_PAY . "))";
        $whereArray[] = "NOT (i.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "(i.sales_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR i.sales_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(i.sales_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR i.sales_end_datetime = '0000-00-00 00:00:00'))";

        $otherArray[] = " GROUP BY od.ordering_id";

        $sql = $this->makeSelectQuery("ordering o, ordering_detail od, v_user_profile v_user, item as i, item_category as ic", $column, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * 期限切れ週の注文データを取得
     *
     * @param  integer $week 期限切れ週
     *
     * @return array $dataList データ配列
     */
    public function getExpirationWeekOrderingList($week) {

        if (!is_numeric($week)) {
            return FALSE;
        }

        $columnArray[] = "o.id";

        $whereArray[] = "o.user_id = v_user.user_id";
        $whereArray[] = "v_user.user_disable = 0";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "o.is_paid = 0";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.status NOT IN (" . self::ORDERING_STATUS_PRE_COMPLETE . ", " . self::ORDERING_STATUS_COMPLETE . ", " . self::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.update_datetime <= " . date("Ymd235959", strtotime($week . " week"));

        $sql = $this->makeSelectQuery("ordering o, v_user_profile v_user", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

     /**
     *
     * 注文金額(小計・合計)の更新
     * @param  integer $orderingId 注文ID
     *
     * @return boolean 更新の成否
     */
    public function updatePayTotal($orderingId) {
        // オーダーIDが不正ならFALSE
        if (!is_numeric($orderingId)) {
            return false;
        }
        // 注文詳細から小計を計算
        $orderDetail = $this->getOrderingDetailList($orderingId);
        if ($orderDetail) {
            foreach ((array)$orderDetail as $key => $val) {
               $payTotal += (int)$val["price"];
            }
        } else {
            $payTotal = 0;
        }

        // 計算結果を更新
        $updateArray["pay_total"]     = $payTotal;

        return $this->updateOrderingData($updateArray, array("id = " . $orderingId));

    }

    /**
     * 注文情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertOrderingData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("ordering", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 注文の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateOrderingData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("ordering", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * 注文詳細データの取得
     *
     * @param  integer $id 注文詳細ID
     * @return array データ配列
     */
    public function getOrderingDetailData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering_detail", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 注文詳細リストの取得
     *
     * @param  integer $id 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getOrderingDetailList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering_detail", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * 全注文詳細リストの取得
     *
     * @param  integer $id 注文ID
     *
     * @return array $dataList データ配列
     */
    public function getAllOrderingDetailList($orderingId) {

        if (!is_numeric($orderingId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "ordering_id = " . $orderingId;

        $sql = $this->makeSelectQuery("ordering_detail", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * 注文詳細情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertOrderingDetailData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("ordering_detail", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }


    /**
     * 注文詳細の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
    */
        public function updateOrderingDetailData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("ordering_detail", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * 注文メール用コンバート配列作成
     *
     * @param array $orderingData オーダーデータ
     *
     * @return mixd
     *
     */
    public function makeOrderConvertArray($orderingData) {

        if (!is_array($orderingData)) {
            return false;
        }

        $AdmItemOBJ = AdmItem::getInstance();

        // 注文商品
        if (!$orderingData["order_detail"] = $AdmItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
            return false;
        }
        $setBuyItem = "";
        foreach ($orderingData["order_detail"] as $key => $val) {
            $setBuyItem .= $val["remail_name"] . "\n";
        }

        // データ成形
        // 受付日時
        $setBuyDatetime  = date("Y年m月d日 H時i分", strtotime($orderingData["create_datetime"]));

        // 支払い方法
        $setPayType = AdmOrdering::$_payType[$orderingData["pay_type"]];

        // 注文アクセスキー
        $setAccessKey = $orderingData["access_key"];

        // 合計
        $setPayTotal = $orderingData["pay_total"]."円";

        // 別途%変換用にセット
        $setArray = array(
                "-%buy_datetime-"          => $setBuyDatetime,
                "-%pay_type-"              => $setPayType,
                "-%buy_item-"              => $setBuyItem,
                "-%ordering_access_key-"  => $setAccessKey,
                "-%order_id-"               => $orderingData["id"],
                "-%pay_total-"             => $setPayTotal,
        );

        return $setArray;
    }

    /**
     *
     * 注文履歴の取得
     *
     * @param  integer $userId ユーザーID
     * @param  integer $offset オフセット
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getOrderingHistoryList($userId, $offset = "", $limit = "") {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS item.*";
        $columnArray[] = "ord_d.price";
        $columnArray[] = "ord.create_datetime as order_create_datetime";

        $whereArray[] = "item.id = ord_d.item_id";
        $whereArray[] = "ord.id = ord_d.ordering_id";
        $whereArray[] = "ord_d.disable = 0";
        $whereArray[] = "ord.user_id = v_user.user_id";
        $whereArray[] = "ord.disable = 0";
        $whereArray[] = "ord.user_id = " . $userId;

        $otherArray[] = " ORDER BY ord.id DESC";

        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("item, ordering ord, ordering_detail ord_d, v_user_profile v_user", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     * 注文検索の条件内容の作成
     *
     * @return array 検索内容配列
     */
    public function getWhereContents() {

        return $this->_contents;
    }

    /**
     * 注文検索のsql文の取得
     *
     * @return string 注文検索sql文
     */
    public function getListSql() {
        return $this->_listSql;
    }

    /**
     *
     * 予約注文表示設定リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getOrderingDisplaySettingList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY display_cd";

        $sql = $this->makeSelectQuery("ordering_display_setting", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        while ($data = $this->fetch($dbResultOBJ)) {
            $dataList[$data["display_cd"]] = $data;
        }

        return $dataList;

    }

    /**
     *
     * 予約注文表示設定データの取得
     *
     * @param  string $cd 予約注文表示CD
     * @return array データ配列
     */
    public function getOrderingDisplaySettingData($cd) {

        if (!$cd) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "display_cd = " . $cd;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering_display_setting", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }


    /**
     * 予約注文表示設定の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertOrderingDisplaySettingData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("ordering_display_setting", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 予約注文表示設定の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateOrderingDisplaySettingData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("ordering_display_setting", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * access_keyの重複が無い様にaccess_keyを返す。
     *
     *
     * @param int $data キー生成に使用するデータ
     *
     * @return string accessKey　を連想配列で返す
     */
    public function getNewAccessKey($data)  {

        if (!$data) {
            return FALSE;
        }

        $OrderingOBJ = Ordering::getInstance();

        return $OrderingOBJ->getNewAccessKey($data);
    }

}
?>