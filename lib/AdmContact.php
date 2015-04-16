<?php
/**
 * AdmContact.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側問い合わせクラス
 *  問い合わせを管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmContact extends ComCommon {

    const SEND_MAIL_ADDRESS_ACCOUNT = "info";

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array 回答状態配列 */
    public static $_answerType = array(
                    "0" => "未回答",
                    "1" => "回答済み",
                  );

    /** @var array 表示状態配列 */
    public static $_disableFlag = array(
                    "0" => "非表示",
                    "1" => "表示",
                  );

    /** @var array 問い合わせ内容分類配列 */
    public static $_classificationType = array(
                    "0" => "未分類",
                    "1" => "クレーム",
                    "2" => "受注確認",
                    "3" => "発送確認",
                    "4" => "返信",
                    "5" => "メッセージ",
                    "6" => "企業",
                   );

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
     * 問い合わせデータの取得
     *
     * @param  integer $id 問い合わせID
     * @return array データ配列
     */
    public function getContactData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("contact", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 問い合わせリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getContactList($param, $offset, $order, $limit) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if (ComValidation::isArray($param["contact_type_id"])) {
            $whereArray[] = "type IN (" . implode(",", $param["contact_type_id"]) . ")";
        }

        if (ComValidation::isArray($param["is_answer"])) {
            $whereArray[] = "is_answer IN (" . implode(",", $param["is_answer"]) . ")";
        }

        if ($param["from_address"]) {
            $whereArray[] = "from_address LIKE '" . $param["from_address"] . "%'";
        }

        if (ComValidation::isDateTime($param["start_datetime"])) {
            $whereArray[] = "create_datetime >= '" . $param["start_datetime"] . "'";
        }

        if (ComValidation::isDateTime($param["end_datetime"])) {
            $whereArray[] = "create_datetime <= '" . $param["end_datetime"] . "'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("contact", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 問い合わせの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertContactData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("contact", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 問い合わせの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateContactData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("contact", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * 問い合わせ種別データの取得
     *
     * @param  integer $id 問い合わせID
     * @return array データ配列
     */
    public function getContactTypeData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("contact_type", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 問い合わせ種別リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getContactTypeList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $otherArray[] = "ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("contact_type", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     *
     * selectbox用問い合わせ種別リストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getContactTypeAryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";
        $otherArray[] = "ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("contact_type", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }

        return $dataArray;

    }

    /**
     * 問い合わせ種別の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertContactTypeData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("contact_type", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 問い合わせ種別の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateContactTypeData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("contact_type", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * 問い合わせメールログデータの取得
     *
     * @param  integer $id 問い合わせID
     * @return array データ配列
     */
    public function getContactMailLogData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("contact_mail_log", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 問い合わせメールログリストの取得
     *
     * @param  integer $id 問い合わせID
     *
     * @return array $dataList データ配列
     */
    public function getContactMailLogList($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "contact_id = " . $id;
        $whereArray[] = "disable = 0";
        $otherArray[] = "ORDER BY id DESC";

        $sql = $this->makeSelectQuery("contact_mail_log", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 問い合わせメールログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertContactMailLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("contact_mail_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 問い合わせメールログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateContactMailLogData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("contact_mail_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
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
        $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
        //return $AdmMailMagazineOBJ->mailTo($mailElements, $sec, $imageData, $imageType);

        $sendMailData = $AdmMailMagazineOBJ->smtpMailTo($mailElements, $sec, $imageData, $imageType);

        // リメール用インスタンス生成
        $contactComSendMagicDeliveryOBJ = new ComSendMagicDelivery();

        // SMTPホスト設定(SendMagic)
        $contactComSendMagicDeliveryOBJ->setSendMailServerIp($this->_configOBJ->common_config->smtp_mail_server_ip->sendMagic);

        // SMTP接続開始
        if (!$contactComSendMagicDeliveryOBJ->openSmtpConnect()) {
            return false;
        }

        $smtpSendResult = true;
        if ($sendMailData) {
            // リメール送信
            if (!$contactComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                $smtpSendResult = false;
            }
        } else {
            $smtpSendResult = false;
        }

        // SMTP切断
        $contactComSendMagicDeliveryOBJ->closeSmtpConnect();

        return $smtpSendResult;

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
        $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
        return $AdmMailMagazineOBJ->convertMailElements($elements, $userId, $convertAry);
    }
}
?>