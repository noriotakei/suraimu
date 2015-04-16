<?php
/**
 * AdmSupportMail.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側サポートメール管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmSupportMail extends ComCommon {

    const SUPPORT_MAIL_ADDRESS_ACCOUNT = "info";
    const SUPPORTMAIL_RETURN_PATH = "bounce@mail.";

    const SUPPORT_MAIL_LOG_IMAGE_PATH = "/admin/img/mail/supportLog/";
    const SUPPORT_MAIL_REGULAR_IMAGE_PATH = "/admin/img/mail/supportRegular/";
    const SUPPORT_MAIL_RESERVE_IMAGE_PATH = "/admin/img/mail/supportReserve/";

    // サポートメールタイプ
    const SUPPORTMAIL_TYPE_BULK  = 0;  // 一括
    const SUPPORTMAIL_TYPE_TIMER   = 1;  // タイマー
    const SUPPORTMAIL_TYPE_REGULAR = 2;  // 定期
    const SUPPORTMAIL_TYPE_INVIDUAL = 3;  // 個別サポートメール

    // 定期サポートメールタイプ
    const SEND_CONDITION_TYPE_HOUR  = 0;  // 毎時
    const SEND_CONDITION_TYPE_DAY   = 1;  // 毎日
    const SEND_CONDITION_TYPE_WEEK  = 2;  // 毎週
    const SEND_CONDITION_TYPE_MONTH = 3;  // 毎月

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    // サポートメールタイプ
    public static $_mailReserveType = array(
                                    self::SUPPORTMAIL_TYPE_BULK => "一括",
                                    self::SUPPORTMAIL_TYPE_TIMER => "予約",
                                    self::SUPPORTMAIL_TYPE_REGULAR => "定期",
                                    self::SUPPORTMAIL_TYPE_INVIDUAL => "個別サポートメール",
                                );

    // サポートメールインターバル
    public static $_intervalSecond = array(
                                  "0" => "0",
                                  "1" => "15",
                                  "2" => "30",
                                  "3" => "45",
                              );

    // サポートメールインターバル
    public static $_sendConditionTypeHourSecond = array(
                                                  "0" => "0",
                                                  "1" => "15",
                                                  "2" => "30",
                                                  "3" => "45",
                                              );

    // 定期サポートメールタイプ
    public static $_sendConditionType = array(
                                      self::SEND_CONDITION_TYPE_HOUR   => "毎時",
                                      self::SEND_CONDITION_TYPE_DAY    => "毎日",
                                      self::SEND_CONDITION_TYPE_WEEK   => "毎週",
                                      self::SEND_CONDITION_TYPE_MONTH  => "毎月",
                                  );

    // 稼働状況
    public static $_stopFlag = array(
                                  "0" => "稼動",
                                  "1" => "停止",
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
     * サポートメールデータの取得
     *
     * @param  integer $id サポートメールID
     *
     * @return array データ配列
     */
    public function getSupportMailData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * サポートメールリストの取得
     *
     *
     * @return array $dataList データ配列
     */
    public function getSupportMailList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("support_mail", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }

    /**
     *
     * selectbox用サポートメールリストの取得
     *
     *
     * @return array $dataList データ配列
     */
    public function getSupportMailListForSelect() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("support_mail", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $dbResultOBJ->fetch()) {
            $dataList[$data["id"]] = $data["name"];
        }

        return $dataList;

    }

    /**
     * サポートメールの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertSupportMailData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$this->insert("support_mail", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * サポートメールの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateSupportMailData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("support_mail", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 予約サポートメールデータの取得。
     *
     * @param  integer $id 予約サポートメールID
     * @return mixed 予約サポートメール、失敗ならfalse
     */
    public function getSupportMailReserveData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_reserve", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 予約サポートメールリストの取得。
     *
     * @return mixed 予約サポートメールリスト、失敗ならfalse
     */
    public function getSupportMailReserveList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";


        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "send_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "send_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("support_mail_reserve", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 送信可能予約サポートメールリストの取得。
     *
     * @return mixed 予約サポートメールリスト、失敗ならfalse
     */
    public function getSendSupportMailReserveList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $whereArray[] = "is_send = 0";
        $whereArray[] = "send_datetime <= '" . date("YmdHi") . "00'";

        $sql = $this->makeSelectQuery("support_mail_reserve", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     *  予約サポートメールログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertSupportMailReserve($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("support_mail_reserve", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  予約サポートメールログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateSupportMailReserve($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("support_mail_reserve", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 定期サポートメールデータの取得。
     *
     * @param  integer $id 定期サポートメールID
     * @return mixed 定期サポートメール、失敗ならfalse
     */
    public function getSupportMailRegularData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_regular", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 定期サポートメールリストの取得。
     *
     * @return mixed 定期サポートメールリスト、失敗ならfalse
     */
    public function getSupportMailRegularList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";


        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("support_mail_regular", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 送信可能定期サポートメールリストの取得。
     *
     * @return mixed 定期サポートメールリスト、失敗ならfalse
     */
    public function getSendSupportMailRegularList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "is_stop = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_regular", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     *  定期サポートメールログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertSupportMailRegular($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("support_mail_regular", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  定期サポートメールログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateSupportMailRegular($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("support_mail_regular", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
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
        return $AdmMailMagazineOBJ->mailTo($mailElements, $sec, $imageData, $imageType);
    }

    /**
     * smtpMailToメソッド
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
    public function smtpMailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {
        $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
        return $AdmMailMagazineOBJ->smtpMailTo($mailElements, $sec, $imageData, $imageType);
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
     *  予約メルマガ画像の追加
     *
     *  @param  array   $mailMagaReserveId サポート予約メルマガID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertSupportMailImageReserve($mailMagaReserveId, $imageName, $isMobile = false) {

        if (!$imageName) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // 予約メルマガ画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaReserveId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::SUPPORT_MAIL_RESERVE_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_RESERVE_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_reserve_id" => $mailMagaReserveId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("support_mail_reserve_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     * 予約サポートメルマガ画像の取得。
     *
     * @param  integer $id サポート予約メルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat 予約サポートメルマガ画像リスト、失敗ならfalse
     */
    public function getSupportMailImageReserveData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "support_mail_reserve_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_reserve_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }


    /**
     *
     *  定期メルマガ画像の追加
     *
     *  @param  array   $mailMagaRegularId サポート定期メルマガID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertSupportMailImageRegular($mailMagaRegularId, $imageName, $isMobile = false) {

        if (!$imageName) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // 定期メルマガ画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaRegularId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::SUPPORT_MAIL_REGULAR_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_REGULAR_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_regular_id" => $mailMagaRegularId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("support_mail_regular_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     * 定期サポートメルマガ画像の取得。
     *
     * @param  integer $id サポート定期メルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat 定期サポートメルマガ画像リスト、失敗ならfalse
     */
    public function getSupportMailImageRegularData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "support_mail_regular_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_regular_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * サポートメールデータの取得。
     *
     * @param  integer $id 定期サポートメールID
     * @return mixed サポートメール、失敗ならfalse
     */
    public function getSupportMailLogData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_log", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     *
     *  サポートメールメルマガ画像ログの追加
     *
     *  @param  array   $mailMagaId サポートメルマガセンドログID
     *  @param  array   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertSupportMailImageLog($mailMagaId, $imageName, $isMobile = false) {

        if (!$imageName) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // メルマガ画像ログの生成
        for ($i = 0; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像をログとして残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::SUPPORT_MAIL_LOG_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_LOG_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_send_log_id" => $mailMagaId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$this->insert("support_mail_send_log_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }


    /**
     * サポートメルマガ画像の取得。
     *
     * @param  integer $id サポートメルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat サポートメルマガ画像リスト、失敗ならfalse
     */
    public function getSupportMailSendLogImageData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "support_mail_send_log_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("support_mail_send_log_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     *  CRONでのメルマガ送信時の画像ログの追加
     *
     *  @param  int   $mailMagaId メルマガID
     *  @param  array   $imageList 画像データリスト
     *  @param  string   $imageList 画像データリスト
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertSupportMailImageLogByCron($mailMagaId, $imageList, $imagePath, $isMobile = false) {

        if (!$imageList) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // メルマガ画像ログの生成
        for ($i = 0; $i < count($imageList); $i++) {
            if ($imageList[$i]["file_name"]) {
                $tmp = explode(".", $imageList[$i]["file_name"]);
                list($id, $no, $imgDevice) = explode("_", $tmp[0]);
                $imageData = file_get_contents($imagePath . $imageList[$i]["file_name"]);
                $imageAry = getimagesize($imagePath . $imageList[$i]["file_name"]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaId . "_" . $no . $imgDeviceName . "." . $extension;

                // 添付画像をログとして残す
                copy($imagePath . $imageList[$i]["file_name"],
                                   D_BASE_DIR . self::SUPPORT_MAIL_LOG_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_LOG_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_send_log_id" => $mailMagaId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("support_mail_send_log_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     *
     *  予約サポートメルマガ画像の更新
     *
     *  @param  array   $mailMagaReserveId 予約サポートメルマガID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *
     *  @return boolean
     */
    public function updateSupportMailImageReserve($mailMagaReserveId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getSupportMailImageReserveData($mailMagaReserveId, $isMobile);
        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        $this->beginTransaction();

        // 予約メルマガ画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaReserveId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::SUPPORT_MAIL_RESERVE_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_RESERVE_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_reserve_id" => $mailMagaReserveId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );

                // 該当のレコードがあるか検索
                foreach ((array)$imageDataList as $key => $val) {
                    $tmp = explode(".", $val["file_name"]);
                    list($id, $no, $imgDevice) = explode("_", $tmp[0]);
                    if ($no == $i) {
                        $updateFlag = TRUE;
                        break;
                    }
                    $updateFlag = FALSE;
                }

                if ($updateFlag) {
                    if (!$this->update("support_mail_reserve_image", $insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else {
                    if (!$dbResultOBJ = $this->insert("support_mail_reserve_image", $insertArray)) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                }
            }
        }

        // 画像の削除
        $updateAry["disable"] = 1;
        $imageDelName = ($isMobile ? "mb_image_del" : "pc_image_del");
        foreach ((array)$imageDataList as $key => $val) {
            $tmp = explode(".", $val["file_name"]);
            list($id, $no, $imgDevice) = explode("_", $tmp[0]);
            if ($param[$imageDelName][$no]) {
                if (!self::updateSupportMailImageReserveData($updateAry, array("id = " . $val["id"]))) {
                    $this->_errorMsg[] = "削除できませんでした。";
                    $this->rollbackTransaction();
                    return FALSE;
                }
            }
        }

        $this->commitTransaction();
        return true;
    }

    /**
     *
     *  予約サポートメルマガ画像データの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateSupportMailImageReserveData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("support_mail_reserve_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  定期サポートメルマガ画像の更新
     *
     *  @param  array   $mailMagaRegularId 定期サポートメルマガID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *  @return boolean
     */
    public function updateSupportMailImageRegular($mailMagaRegularId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getSupportMailImageRegularData($mailMagaRegularId, $isMobile);
        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        $this->beginTransaction();

        // 定期メルマガ画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $mailMagaRegularId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::SUPPORT_MAIL_REGULAR_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::SUPPORT_MAIL_REGULAR_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "support_mail_regular_id" => $mailMagaRegularId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );

                // 該当のレコードがあるか検索
                foreach ((array)$imageDataList as $key => $val) {
                    $tmp = explode(".", $val["file_name"]);
                    list($id, $no, $imgDevice) = explode("_", $tmp[0]);
                    if ($no == $i) {
                        $updateFlag = TRUE;
                        break;
                    }
                    $updateFlag = FALSE;
                }

                if ($updateFlag) {
                    if (!$this->update("support_mail_regular_image", $insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else {
                    if (!$dbResultOBJ = $this->insert("support_mail_regular_image", $insertArray)) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                }
            }
        }

        // 画像の削除
        $updateAry["disable"] = 1;
        $imageDelName = ($isMobile ? "mb_image_del" : "pc_image_del");
        foreach ((array)$imageDataList as $key => $val) {
            $tmp = explode(".", $val["file_name"]);
            list($id, $no, $imgDevice) = explode("_", $tmp[0]);
            if ($param[$imageDelName][$no]) {
                if (!self::updateMailImageRegularData($updateAry, array("id = " . $val["id"]))) {
                    $this->_errorMsg[] = "削除できませんでした。";
                    $this->rollbackTransaction();
                    return FALSE;
                }
            }
        }

        $this->commitTransaction();
        return true;
    }

    /**
     *
     *  定期サポートメルマガ画像データの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateSupportMailImageRegularData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("support_mail_regular_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

}
?>