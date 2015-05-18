<?php
/**
 * AdmMailMagazine.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * メルマガデータの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AdmMailMagazine extends AdmUser {

	const SMTP_HOST = "122.202.21.33";
	//const SMTP_HOST = "127.0.0.1";

    // メルマガタイプ
    const MAILMAGAZINE_TYPE_NORMAL  = 0;  // 通常
    const MAILMAGAZINE_TYPE_TIMER   = 1;  // タイマー
    const MAILMAGAZINE_TYPE_REGULAR = 2;  // 定期

    // 定期メルマガタイプ
    const SEND_CONDITION_TYPE_HOUR  = 0;  // 毎時
    const SEND_CONDITION_TYPE_DAY   = 1;  // 毎日
    const SEND_CONDITION_TYPE_WEEK  = 2;  // 毎週
    const SEND_CONDITION_TYPE_MONTH = 3;  // 毎月

    const MAIL_IMAGE_PATH = "/admin/img/mail/log/";
    const MAIL_REGULAR_IMAGE_PATH = "/admin/img/mail/regular/";
    const MAIL_RESERVE_IMAGE_PATH = "/admin/img/mail/reserve/";

    const MAIL_MAGAZINE_RETURN_PATH = "bounce@mail.";
    const MAIL_MAGAZINE_ADDRESS_ACCOUNT = "info";

    const MAIL_MAGAZINE_SEND_LOG_COUNT = 50;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string 検索条件内容 */
    private $_contents = null;

    /** @var string メールサーバIP */
    private $_mailServerIp = null;

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    // メルマガタイプ
    public static $_mailReserveType = array(
                                    self::MAILMAGAZINE_TYPE_NORMAL => "通常",
                                    self::MAILMAGAZINE_TYPE_TIMER => "予約",
                                    self::MAILMAGAZINE_TYPE_REGULAR => "定期",
                                );

    // メルマガインターバル
    public static $_intervalSecond = array(
                                  "0" => "0",
                                  "1" => "15",
                                  "2" => "30",
                                  "3" => "45",
                              );

    // メルマガインターバル
    public static $_sendConditionTypeHourSecond = array(
                                                  "0" => "0",
                                                  "1" => "15",
                                                  "2" => "30",
                                                  "3" => "45",
                                              );

    // 定期メルマガタイプ
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
     * ユーザーデータリストの取得
     *
     * @param  integer $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @return array ユーザーデータ
     */
    public function getUserListCount($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray = $this->setWhereString($param);

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        $dataList = "";
        while ($data = $this->fetch($dbResultOBJ)) {
            if ($data["pc_address"]) {
                $dataList["pc"][$data["pc_address_status"]]++;
            }
            if ($data["mb_address"]) {
                $dataList["mb"][$data["mb_address_status"]]++;
            }
        }

        return $dataList;
    }

    /**
     *
     *  メルマガログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertMailMagaLog($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("mailmagazine_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  メルマガログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     *  @return boolean
     */
    public function updateMailMagaLog($updateArray, $whereArray = null, $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_log", $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  メルマガ画像ログの追加
     *
     *  @param  array   $mailMagaId メルマガID
     *  @param  array   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertMailImageLog($mailMagaId, $imageName, $isMobile = false) {

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
                                   D_BASE_DIR . self::MAIL_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_log_id" => $mailMagaId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$this->insert("mailmagazine_image_log", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
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
    public function insertMailImageLogByCron($mailMagaId, $imageList, $imagePath, $isMobile = false) {

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
                                   D_BASE_DIR . self::MAIL_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_log_id" => $mailMagaId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("mailmagazine_image_log", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     * メルマガログリストの取得。
     *
     * @return mixed メルマガログリスト、失敗ならfalse
     */
    public function getMailLogList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";
        $columnArray[] = "truncate((access_count_pc / send_total_count_pc) * 100 , 1) as pc_access_percent";
        $columnArray[] = "truncate((access_count_mb / send_total_count_mb) * 100 , 1) as mb_access_percent";

        $whereArray[] = "disable = 0";


        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if (ComValidation::isArray($param["mail_reserve_type"])) {
            $whereArray[] = "mail_reserve_type IN (" . implode(",", $param["mail_reserve_type"]) . ")";
        }

        if ($param["mailmagazine_regular_id"]) {
            $whereArray[] = "mailmagazine_regular_id IN (" . trim($param["mailmagazine_regular_id"], ",") . ")";
        }

        if ($param["mailmagazine_reserve_id"]) {
            $whereArray[] = "mailmagazine_reserve_id IN (" . trim($param["mailmagazine_reserve_id"], ",") . ")";
        }

        if ($param["mailmagazine_body"]) {
            $whereArray[] = "(pc_text_body like '%" . $param["mailmagazine_body"] . "%' OR pc_html_body like '%" . $param["mailmagazine_body"] . "%'"
                          . " OR mb_text_body like '%" . $param["mailmagazine_body"] . "%' OR mb_html_body like '%" . $param["mailmagazine_body"] . "%')";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("mailmagazine_log", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * メルマガログ定期ID毎リストの取得。
     *
     * @return mixed メルマガログリスト、失敗ならfalse
     */
    public function getMailLogGroupList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS mailmagazine_regular_id";
        $columnArray[] = "SUM(send_total_count_pc) send_total_count_pc";
        $columnArray[] = "SUM(send_err_count_pc) send_err_count_pc";
        $columnArray[] = "SUM(send_total_count_mb) send_total_count_mb";
        $columnArray[] = "SUM(send_err_count_mb) send_err_count_mb";
        $columnArray[] = "SUM(err_count) err_count";
        $columnArray[] = "SUM(access_count_pc) access_count_pc";
        $columnArray[] = "SUM(access_count_mb) access_count_mb";
        $columnArray[] = "truncate((access_count_pc / send_total_count_pc) * 100 , 1) as pc_access_percent";
        $columnArray[] = "truncate((access_count_mb / send_total_count_mb) * 100 , 1) as mb_access_percent";
        $columnArray[] = "pc_subject";
        $columnArray[] = "mb_subject";


        $whereArray[] = "disable = 0";
        $whereArray[] = "mailmagazine_regular_id > 0";

        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        if ($param["mailmagazine_regular_id"]) {
            $whereArray[] = "mailmagazine_regular_id IN (" . trim($param["mailmagazine_regular_id"], ",") . ")";
        }

        $otherArray[] = " GROUP BY mailmagazine_regular_id";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("mailmagazine_log", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * メルマガログの取得。
     *
     * @param  integer $id メルマガID
     * @return mixed メルマガログ、失敗ならfalse
     */
    public function getMailLogData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";
        $columnArray[] = "truncate((access_count_pc / send_total_count_pc) * 100 , 1) as pc_access_percent";
        $columnArray[] = "truncate((access_count_mb / send_total_count_mb) * 100 , 1) as mb_access_percent";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_log", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * メルマガ画像ログの取得。
     *
     * @param  integer $id メルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat メルマガ画像ログリスト、失敗ならfalse
     */
    public function getMailImageLogData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "mailmagazine_log_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_image_log", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * メールサーバIPの設定
     *
     * @param  integer $id メルマガID
     * @return arrat メルマガ画像ログリスト、失敗ならfalse
     */
    public function setMailServerIp($mailServerIp) {

        $this->_mailServerIp = $mailServerIp;
        return TRUE;
    }

    /**
     * mailToメソッド
     *
     * メール送信実行
     *
     * @param string $mailAddress    送信するメアド
     * @param array   $mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @param int $sec    送信待機秒
     * @param array $imageData    画像データ
     * @param array $imageType    画像タイプ
     * @param resource $mh    curl用multiHandle
     * @return 送信成功:True 送信失敗:False
     */
    public function mailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null, $mh = null) {
        if (!isset($mailElements["to_address"]) || !isset($mailElements)) {
            return FALSE;
        }

        if (!$this->_mailServerIp) {
            $this->_mailServerIp = $this->_configOBJ->common_config->mail_server_ip->sendMagic;
        }

        $mailServer = "http://" . $this->_mailServerIp . "/maildelivery.php";

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        $sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = $mailElements["to_address"];
        $postdata["to_nm"] = $mailElements["to_name"];
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::MAIL_MAGAZINE_RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = $mailElements["from_address"];
        $postdata["from_nm"] = $mailElements["from_name"];
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $sendHtmlBody;
        $postdata["sec"] = $sec;

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata["image"][] = base64_encode($image);
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata["image_type"][] = $type;
            }
        }

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        $ComHttpOBJ = new ComHttp($mailServer, $httpParam);
        $ComHttpOBJ->setParameterPost($postdata);
        $result = $ComHttpOBJ->request("POST");

        if ($result->isSuccessful()) {
            return true;
        } else {
            return false;
        }

/*
        // curl送信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        $sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = $mailElements["to_address"];
        $postdata["to_nm"] = $mailElements["to_name"];
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::MAIL_MAGAZINE_RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = $mailElements["from_address"];
        $postdata["from_nm"] = $mailElements["from_name"];
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $sendHtmlBody;
        $postdata["sec"] = $sec;

        $postdata = http_build_query($postdata);

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata .= "&image[]=" . urlencode(base64_encode($image));
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata .= "&image_type[]=" . urlencode($type);
            }
        }


        if (!$mh) {
            $mh = curl_multi_init();
        }

        $conn= curl_init($mailServer);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($conn, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($conn, CURLOPT_MAXREDIRS,3);
        curl_setopt($conn, CURLOPT_POST, TRUE);
        curl_setopt($conn, CURLOPT_POSTFIELDS, $postdata);

        //タイムアウト
        curl_setopt($conn, CURLOPT_TIMEOUT, 0);
        curl_multi_add_handle($mh, $conn);

        $return["mh"] = $mh;
        $return["conn"] = $conn;
        return $return;
*/
    }

    /**
     * execCurlSendメソッド
     *
     * curlmulti送信実行
     *
     * @param resource $conn curlリソース
     * @return array $return 送信カウント
     *
     */
    public function execCurlSend($mh, $conn) {

        if (!$mh OR !$conn) {
            return false;
        }

        //すべて取得するまでループ
        $active = null;
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active and $mrc == CURLM_OK) {
            if (curl_multi_select($mh) != -1) {
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        if ($mrc != CURLM_OK) {
            return false;
        }

        foreach ($conn as $val) {
            if (($err = curl_error($val)) == '') {
                $return["sendOkCnt"]++;
            } else {
                $return["sendNgCnt"]++;
            }
            curl_multi_remove_handle($mh, $val);
            curl_close($val);
        }

        return $return;

    }

    /**
     * curlMultiCloseメソッド
     *
     * curlMultiClose
     *
     * @return boolean
     *
     */
    public function curlMultiClose($mh) {

        if (!$mh) {
            return false;
        }

        curl_multi_close($mh);

        return true;

    }

    /**
     * smtpMailToメソッド
     *
     * smtpメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function smtpMailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {

        if (!isset($mailElements["to_address"]) || !isset($mailElements)) {
            return FALSE;
        }

        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postdata["to"] = $mailElements["to_address"];
        //$postdata["to_nm"] = $mailElements["to_name"];
        $postdata["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : self::RETURN_PATH . $this->_configOBJ->define->MAIL_DOMAIN);
        $postdata["from"] = $mailElements["from_address"];
        $postdata["from_nm"] = $mailElements["from_name"];
        $postdata["sbj"] = $sendSubject;
        $postdata["body"] = $sendTextBody;
        $postdata["html"] = $mailElements["html_body"];
        $postdata["sec"] = $sec;

        // 画像があったら画像も送信
        if ($imageData && $imageType) {
            foreach ($imageData as $image) {
                // base64エンコード
                $postdata["image"][] = $image;
                //$postdata["image"][] = base64_encode($image);
            }
            foreach ($imageType as $type) {
                // base64エンコード
                $postdata["image_type"][] = $type;
            }
        }

        return $postdata;

        //$ComSendMagicDeliveryOBJ = ComSendMagicDelivery::getInstance();

        //return $ComSendMagicDeliveryOBJ->sendMagicDelivery($postdata);

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
        if (!isset($elements)) {
            return FALSE;
        }
        $KeyConvertOBJ = KeyConvert::getInstance();
        // 変換処理
        $elements = $KeyConvertOBJ->execConvertArray($elements, $userId, $convertAry);
        $elements["text_body"]    = str_replace("<br>", "\n", $elements["text_body"]);
        $elements["html_body"]    = str_replace("&amp;", "&", $elements["html_body"]);

        return $elements;
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
     * 予約メルマガデータの取得。
     *
     * @param  integer $id 予約メルマガID
     * @return mixed 予約メルマガ、失敗ならfalse
     */
    public function getMailReserveData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_reserve", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 予約メルマガリストの取得。
     *
     * @return mixed 予約メルマガリスト、失敗ならfalse
     */
    public function getMailReserveList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if ( ! ComValidation::isValue($param['do_not_care_datetime'])) {
            if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
                $whereArray[] = "send_datetime >= '" . $param["dispDatetimeFrom"] . "'";
            }

            if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
                $whereArray[] = "send_datetime <= '" . $param["dispDatetimeTo"] . "'";
            }
        }

        if ($param["mailmagazine_id"]) {
            $whereArray[] = "id IN (" . trim($param["mailmagazine_id"] ,",") . ")";
        }

        if ($param["mailmagazine_subject"]) {
            $whereArray[] = "(pc_subject like '%" . $param["mailmagazine_subject"] . "%'"
                    . " OR mb_subject like '%" . $param["mailmagazine_subject"] . "%')";
        }

        if ($param["mailmagazine_body"]) {
            $whereArray[] = "(pc_text_body like '%" . $param["mailmagazine_body"] . "%' OR pc_html_body like '%" . $param["mailmagazine_body"] . "%'"
                    . " OR mb_text_body like '%" . $param["mailmagazine_body"] . "%' OR mb_html_body like '%" . $param["mailmagazine_body"] . "%')";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("mailmagazine_reserve", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 予約メルマガ画像の取得。
     *
     * @param  integer $id 予約メルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat 予約メルマガ画像リスト、失敗ならfalse
     */
    public function getMailImageReserveData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "mailmagazine_reserve_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_reserve_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 送信可能予約メルマガリストの取得。
     *
     * @return mixed 予約メルマガリスト、失敗ならfalse
     */
    public function getSendMailReserveList($isMobile = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $whereArray[] = "is_send = 0";
        $whereArray[] = "send_datetime <= '" . date("YmdHi") . "00'";

        if($isMobile){
        	$whereArray[] = "is_mobile = 1";
        }else{
        	$whereArray[] = "is_mobile = 0";
        }

        $sql = $this->makeSelectQuery("mailmagazine_reserve", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 定期メルマガデータの取得。
     *
     * @param  integer $id 定期メルマガID
     * @return mixed 定期メルマガ、失敗ならfalse
     */
    public function getMailRegularData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_regular", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 定期メルマガリストの取得。
     *
     * @return mixed 定期メルマガリスト、失敗ならfalse
     */
    public function getMailRegularList($param = "", $offset = "", $order = "", $limit = "") {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if (ComValidation::isDatetime($param["dispDatetimeFrom"])) {
            $whereArray[] = "create_datetime >= '" . $param["dispDatetimeFrom"] . "'";
        }
        if (ComValidation::isDatetime($param["dispDatetimeTo"])) {
            $whereArray[] = "create_datetime <= '" . $param["dispDatetimeTo"] . "'";
        }

        //送信条件
        if ($param["send_condition_type"] != "") {
            if (ComValidation::isArray($param["send_condition_type"])) {
                $whereArray[] = "send_condition_type IN (" . implode("," ,$param["send_condition_type"]) . ")";
            }
        }

        //稼働状況
        if (!ComValidation::isEmpty($param["is_stop"])) {
            $whereArray[] = "is_stop = " . $param["is_stop"];
        }

        //定期メルマガID
        if ($param["id"]) {
            if ($param["id"]) {
                $whereArray[] = "id IN (" . trim($param["id"] ,",") . ")";
            }
        }

        //メルマガ件名検索
        if ($param["mailmagazine_subject"]) {
            $whereArray[] = "(pc_subject like '%" . $param["mailmagazine_subject"] . "%'"
                          . " OR mb_subject like '%" . $param["mailmagazine_subject"] . "%')";
        }

        //メルマガ本文検索
        if ($param["mailmagazine_body"]) {
            $whereArray[] = "(pc_text_body like '%" . $param["mailmagazine_body"] . "%' OR pc_html_body like '%" . $param["mailmagazine_body"] . "%'"
                          . " OR mb_text_body like '%" . $param["mailmagazine_body"] . "%' OR mb_html_body like '%" . $param["mailmagazine_body"] . "%')";
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("mailmagazine_regular", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 送信可能定期メルマガリストの取得。
     *
     * @return mixed 定期メルマガリスト、失敗ならfalse
     */
    public function getSendMailRegularList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "is_stop = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_regular", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }


    /**
     * 定期メルマガ画像の取得。
     *
     * @param  integer $id 定期メルマガID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat 定期メルマガ画像リスト、失敗ならfalse
     */
    public function getMailImageRegularData($id, $isMobile = false) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "mailmagazine_regular_id = " . $id;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_regular_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     *  予約メルマガログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertMailMagaReserve($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("mailmagazine_reserve", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  予約メルマガログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateMailMagaReserve($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_reserve", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  予約メルマガ画像の追加
     *
     *  @param  array   $mailMagaReserveId 予約メルマガID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertMailImageReserve($mailMagaReserveId, $imageName, $isMobile = false) {

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
                                   D_BASE_DIR . self::MAIL_RESERVE_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_RESERVE_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_reserve_id" => $mailMagaReserveId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("mailmagazine_reserve_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     *
     *  予約メルマガ画像の更新
     *
     *  @param  array   $mailMagaReserveId 予約メルマガID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *
     *  @return boolean
     */
    public function updateMailImageReserve($mailMagaReserveId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getMailImageReserveData($mailMagaReserveId, $isMobile);
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
                                   D_BASE_DIR . self::MAIL_RESERVE_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_RESERVE_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_reserve_id" => $mailMagaReserveId,
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
                    if (!$this->update("mailmagazine_reserve_image", $insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else {
                    if (!$dbResultOBJ = $this->insert("mailmagazine_reserve_image", $insertArray)) {
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
                if (!self::updateMailImageReserveData($updateAry, array("id = " . $val["id"]))) {
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
     *  予約メルマガ画像データの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateMailImageReserveData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_reserve_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  定期メルマガログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertMailMagaRegular($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("mailmagazine_regular", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  定期メルマガログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateMailMagaRegular($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_regular", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  定期メルマガ画像の追加
     *
     *  @param  array   $mailMagaReserveId 定期メルマガID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertMailImageRegular($mailMagaRegularId, $imageName, $isMobile = false) {

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
                                   D_BASE_DIR . self::MAIL_REGULAR_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_REGULAR_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_regular_id" => $mailMagaRegularId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("mailmagazine_regular_image", $insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return true;
    }

    /**
     *
     *  定期メルマガ画像の更新
     *
     *  @param  array   $mailMagaRegularId 定期メルマガID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *  @return boolean
     */
    public function updateMailImageRegular($mailMagaRegularId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getMailImageRegularData($mailMagaRegularId, $isMobile);
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
                                   D_BASE_DIR . self::MAIL_REGULAR_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::MAIL_REGULAR_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "mailmagazine_regular_id" => $mailMagaRegularId,
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
                    if (!$this->update("mailmagazine_regular_image", $insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else {
                    if (!$dbResultOBJ = $this->insert("mailmagazine_regular_image", $insertArray)) {
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
     *  定期メルマガ画像データの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateMailImageRegularData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_regular_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 表示用メルマガログリストの取得。
     *
     * @param  integer   $userId ユーザーID
     * @param  array   $whereArray 条件配列
     * @param  string   $order ソート文字列
     * @return mixed メルマガログリスト、失敗ならfalse
     */
    public function getDispMailMagaSendLogList($userId, $whereArray, $order = "") {

        if (!$userId) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS msl.*";
        $columnArray[] = "ml.send_start_datetime";
        $columnArray[] = "ml.send_end_datetime";

        $whereArray[] = "msl.disable = 0";
        $whereArray[] = "ml.disable = 0";
        $whereArray[] = "msl.user_id = " . $userId;

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        $sql = $this->makeSelectQuery("mailmagazine_send_log msl, mailmagazine_log ml", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        $dataArray = $this->fetchAll($dbResultOBJ);

        return $dataArray;
    }

    /**
     * メルマガログリストの取得。
     *
     * @param  integer   $userId ユーザーID
     * @param  string   $order ソート文字列
     * @return mixed メルマガログリスト、失敗ならfalse
     */
    public function getMailMagaSendLogList($userId, $order = "") {

        if (!$userId) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $whereArray[] = "user_id = " . $userId;

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        $sql = $this->makeSelectQuery("mailmagazine_send_log", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        $dataArray = $this->fetchAll($dbResultOBJ);

        return $dataArray;
    }

    /**
     *
     *  送信メルマガログの追加
     *
     *  @param  array   $insertArray 登録データ配列
     *  @return boolean
     */
    public function insertMailMagaSendLog($insertArray) {

        if (!$insertArray) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("mailmagazine_send_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  送信メルマガログの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateMailMagaSendLog($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mailmagazine_send_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  添付画像のファイルサイズ確認
     *  temp_name以下が配列である添付画像処理に対応
     * @param  $imageName　添付画像グループ名
     * @param  $limit　  目標サイズ(キロバイト単位)デフォルトは10
     * @return boolean
     */

    function checkAtatchmentImageSize($imageName,$limit=10) {

        if (ComValidation::isEmpty($imageName)) {
            return false;
        }

        if ( (!$_FILES[$imageName]["tmp_name"]) || (!is_array($_FILES[$imageName]["tmp_name"])) ) {
            return false;
        }

        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {

            if($imageData[$i] = file_get_contents($_FILES[$imageName]["tmp_name"][$i])){
                if(ceil(strlen($imageData[$i])/1024) > $limit){
                    return false;
                }
            }

        }
        return true;
    }

    /**
     *
     *  添付画像の品質低下(quarity)によるファイルサイズ縮小
     *　※GIFは品質低下リサイズが不可の為、jpegに変換
     * @param  $imgData　添付画像ﾃﾞｰﾀ
     * @param  $limit　  目標サイズ(キロバイト単位)デフォルトは10
     * @return $imageStreamData リサイズ済み画像ストリーム
     *          $type 変換後画像タイプ(gifのみjpgに変換の為)
     */
    function resizeAttachmentImage($image,$type,$limit=10) {

        if (ComValidation::isEmpty($image)) {
            return false;
        }

        $limitByte = $limit*1024;

        switch($type){

          case 1://GIF
          case 2://JPG
            $img_output_func="imagejpeg";
            $start=100;
            $end=1;
            $step=-3;
            $imageType = "image/jpeg";
            break;

          case 3://PNG
            $img_output_func="imagepng";
            $start=0;
            $end=9;
            $step=1;
            $imageType = "image/png";
            break;

          default:
            return false;
            break;
        }

        $quality = $start;
        $materialImage = imagecreatefromstring($image);

        //品質を徐々に低下させていきます
        while(true){

            ob_start();
            $img_output_func($materialImage,null,$quality);

            $quality += $step;

            $imageStreamData = ob_get_clean();
            $fileSize = strlen($imageStreamData);

            if($fileSize <= $limitByte){
                break;
            }
            if($start <= $quality && $quality <= $end){
                continue;
            }
            if($end <= $quality && $quality <= $start){
                continue;
            }
            break;
        }

        //元画像データを破棄
        imagedestroy($materialImage);

        // 圧縮限界チェック
        if($fileSize > $limitByte){
            return false;
        }

        $dataArray = array(
                            "imageData" => $imageStreamData
                           ,"type" => $imageType
                           );

        return $dataArray;
    }

    /**
     * 送信可能予約メルマガリストの取得。TEST用 2011-07-11 hosoda
     *
     * @return mixed 予約メルマガリスト、失敗ならfalse
     */
    public function testGetSendMailReserveList($whereArray = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $whereArray[] = "is_send = 0";
        $whereArray[] = "send_datetime <= '" . date("YmdHi") . "00'";

        $sql = $this->makeSelectQuery("mailmagazine_reserve", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 送信可能定期メルマガリストの取得。TEST用 2011-07-26 hosoda
     *
     * @return mixed 定期メルマガリスト、失敗ならfalse
     */
    public function testGetSendMailRegularList($whereArray = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "is_stop = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("mailmagazine_regular", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

}

?>
