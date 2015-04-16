<?php
/**
 * Ordering.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  web側注文管理クラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class Ordering extends ComCommon implements InterfaceOrdering {

    /** @var array 支払方法配列 */
    public static $_settleName = array(
                self::PAY_TYPE_BANK_AUTOMATIONBAS     => "銀行振込",
                self::PAY_TYPE_BANK_AUTOMATION => "ネット銀行",
                self::PAY_TYPE_CREDIT    => "クレジット",
                self::PAY_TYPE_TELECOM    => "テレコムクレジット",
                self::PAY_TYPE_CVD    => "コンビニ決済",
                self::PAY_TYPE_CCHECK    => "C-check決済",
                self::PAY_TYPE_DIGITALEDY => "Edy決済",
                self::PAY_TYPE_BITCASH    => "ビットキャッシュ",
                self::PAY_TYPE_BANK_RAKUTEN    => "楽天銀行",
                  );

    public static $_SettleUrl = array(
                self::PAY_TYPE_BANK_AUTOMATIONBAS     => "Bank",
                self::PAY_TYPE_BANK_AUTOMATION => "NetBank",
                self::PAY_TYPE_CREDIT    => "Credit",
                self::PAY_TYPE_TELECOM    => "Telecom",
                self::PAY_TYPE_CVD    => "Cvd",
                self::PAY_TYPE_CCHECK    => "Ccheck",
                self::PAY_TYPE_DIGITALEDY => "DigitalEdy",
                self::PAY_TYPE_BITCASH    => "Bitcash",
                self::PAY_TYPE_BANK_RAKUTEN    => "Rakuten",
                  );

    const ONE_POINT_RATE = 100;     // 余り金の付与ポイントレート

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
     * 注文データの取得
     *
     * @param  integer $id 注文ID
     * @param  integer $userId ユーザーID
     *
     * @return array データ配列
     */
    public function getOrderingData($id, $userId) {

        if (!$id OR !is_numeric($userId)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "is_cancel = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 最新注文データの取得
     *
     * @param  integer $userId ユーザーID
     *
     * @return array データ配列
     */
    public function getLastOrderingData($userId) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $subColumn[] = "sub_od.ordering_id";

        $subWhereArray[] = "sub_o.id = sub_od.ordering_id";
        $subWhereArray[] = "sub_o.user_id = sub_v_user.user_id";
        $subWhereArray[] = "sub_od.item_id = i.id";
        $subWhereArray[] = "i.item_category_id = ic.id";
        $subWhereArray[] = "sub_v_user.user_disable = 0";
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


        $subOtherArray[] = " GROUP BY sub_od.ordering_id";

        $subSql = $this->makeSelectQuery("ordering sub_o, ordering_detail sub_od, v_user_profile sub_v_user, item as i, item_category as ic", $subColumn, $subWhereArray, $subOtherArray);

        $column[] = "o.*";

        $whereArray[] = "o.user_id = " . $userId;
        $whereArray[] = "o.is_paid = 0";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.status NOT IN (" . self::ORDERING_STATUS_PRE_COMPLETE . ", " . self::ORDERING_STATUS_COMPLETE . ", " . self::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.disable = 0";
        $whereArray[] = "o.id NOT IN (" . $subSql . ")";

        $otherArray[] = " ORDER BY o.id DESC LIMIT 1";

        $sql = $this->makeSelectQuery("ordering o", $column, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 注文IDから注文データの取得
     *
     * @param  integer $id 注文ID
     *
     * @return array データ配列
     */
    public function getOrderingDataFromOrderId($id) {

        if (!$id) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "is_cancel = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * アクセスキーから注文データの取得
     *
     * @param  string $accessKey 注文アクセスキー
     * @param  integer $userId ユーザーID
     *
     * @return array データ配列
     */
    public function getOrderingDataFromAccessKey($accessKey, $userId) {

        if (!$accessKey OR !is_numeric($userId)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "access_key = '" . $accessKey . "'";
        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "is_cancel = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 注文リストの取得
     *
     * @param  integer $userId ユーザーID
     *
     * @return array $dataList データ配列
     */
    public function getOrderingList($userId) {

        if (!is_numeric($id) OR !is_numeric($userId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY id DESC";

        $sql = $this->makeSelectQuery("ordering", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
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
     * アイテムIDを含む注文データを取得
     *
     * @param  integer $userId ユーザーID
     * @param  string $otherString 
     *
     * @return array $dataList データ配列
     */
    public function getOrderingDetailListFromOerderingId($userId = NULL, $otherString = NULL) {

        if (!is_numeric($userId)) {
            return FALSE;
        }
        $columnArray = array() ;
        $columnArray[] = "SQL_CALC_FOUND_ROWS o.*,od.*";

       // $whereArray[] = "od.item_id IN (" . implode(",", $orderingDetailIdList) . ")";

        $whereArray[] = "o.disable = 0";
        $whereArray[] = "o.is_cancel = 0";
        $whereArray[] = "o.is_paid = 1";
        $whereArray[] = "o.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_COMPLETE . ", " . AdmOrdering::ORDERING_STATUS_REST . ")";
        $whereArray[] = "o.user_id = " . $userId;
        $whereArray[] = "o.id = od.ordering_id";

        $whereArray[] = "od.is_cancel = 0";
        $whereArray[] = "od.disable = 0";

        if($otherString){
            $otherArray[] = $otherString;
        }

        $sql = $this->makeSelectQuery("ordering o, ordering_detail od", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

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
     * アイテムIDから注文詳細データを取得
     *
     * @param  integer $orderingId 注文ID
     * @param  integer $itemId 注文ID
     *
     * @return array $data データ配列
     */
    public function getOrderingDetailDataFromItemId($orderingId, $itemId) {

        if (!is_numeric($orderingId) OR !is_numeric($itemId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "item_id = " . $itemId;
        $whereArray[] = "is_cancel = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("ordering_detail", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

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

        $ItemOBJ = Item::getInstance();

        // 注文商品
        if ($orderingData["order_detail"] = $ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
            $setBuyItem = "";
            foreach ($orderingData["order_detail"] as $key => $val) {
                $setBuyItem .= $val["remail_name"] . "<br>";
            }
        }

        // キャンセル注文商品
        if ($cancelItemData = $ItemOBJ->getOrderingDetailCancelItemList($orderingData["id"])) {
            $setCancelItem = "";
            foreach ($cancelItemData as $key => $val) {
                $setCancelItem .= $val["remail_name"] . "<br>";
            }
        }

        // データ成形
        // 受付日時
        $setBuyDatetime  = date("Y年m月d日 H時i分", strtotime($orderingData["create_datetime"]));

        // 支払い方法
        $setPayType = AdmOrdering::$_payType[$orderingData["pay_type"]];

        // 注文アクセスキー
        $setAccessKey = $orderingData["access_key"];

        // 合計
        $setPayTotal = $orderingData["pay_total"] . "円";

        // 別途%変換用にセット
        $setArray = array(
                "-%buy_datetime-"          => $setBuyDatetime,
                "-%pay_type-"              => $setPayType,
                "-%buy_item-"              => $setBuyItem,
                "-%cancel_item-"              => $setCancelItem,
                "-%ordering_access_key-"  => $setAccessKey,
                "-%order_id-"               => $orderingData["id"],
                "-%pay_total-"             => $setPayTotal,
        );

        return $setArray;
    }

    /**
     * mailToメソッド
     *
     * メール送信実行
     *
     * @param string　$mailAddress    送信するメアド
     * @param array   $$mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function mailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {
        $SendMailOBJ = SendMail::getInstance();
        return $SendMailOBJ->mailTo($mailElements, $sec, $imageData, $imageType);
    }

    /**
     * convertMailElementsメソッド
     *
     * メールタイトル、文言、HTML等の％変換処理を実施
     *
     * @param array   $contents   メールコンテンツ
     * @param integer $userId     送信相手のUserテーブルID
     * @param array   $convertAry %変換用配列(個別処理用)
     * @return array 変換済みメール要素配列
     */
    public function convertMailElements($elements, $userId = "", $convertAry = "") {
        $SendMailOBJ = SendMail::getInstance();
        return $SendMailOBJ->convertMailElements($elements, $userId, $convertAry);
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

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $accessKey   = md5($data . "__" . time());
            $accessKey   = substr($accessKey,0,16);

            $columnArray[] = "*";

            $whereArray[] = "access_key = '" . $accessKey . "'";
            $whereArray[] = "disable = 0";

            $sql = $this->makeSelectQuery("ordering", $columnArray, $whereArray);

            $i++;

            // ループ回数は100回
            if ($i > 100) {
                return FALSE;
            }

        } while ($data = $this->executeQuery($sql, "fetchRow"));

        return $accessKey;
    }

    /**
     * isBoughtItemメソッド
     *
     * 購入済み商品チェックメソッド
     * @param  integer $userId ユーザID
     * @param  integer $itemId 商品ID
     * @return boolean
     */
    public function isBoughtItem($userId, $itemId) {

        // 引数が不正ならFALSE
        if (!is_numeric($userId) || !isset($itemId)) {
            return FALSE;
        }

        $columnArray[] = "ordering_detail.id";

        $whereArray[] = "ordering_detail.ordering_id = ordering.id";
        $whereArray[] = "ordering.disable = 0";
        $whereArray[] = "ordering_detail.disable = 0";
        $whereArray[] = "ordering.is_cancel = 0";
        $whereArray[] = "ordering_detail.is_cancel = 0";
        $whereArray[] = "ordering.status IN ('" . self::ORDERING_STATUS_COMPLETE ."', '" . self::ORDERING_STATUS_PRE_COMPLETE . "')";
        $whereArray[] = "ordering.user_id = " . $userId;
        $whereArray[] = "ordering_detail.item_id IN (" . $itemId . ")";

        $sql = $this->makeSelectQuery("ordering, ordering_detail", $columnArray, $whereArray);

        if (!$this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return TRUE;

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
}
?>