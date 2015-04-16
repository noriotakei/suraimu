<?php
/**
 * User.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザーデータの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class User extends ComCommon {

    /** @var string エラーメッセージ */
    private $_errorMsg = null;

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
     * ユーザーデータの取得
     *
     * @param  integer $id ユーザーID
     * @return array ユーザーデータ
     */
    public function getUserData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "user_id = " . $id;
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "danger_status = 0";
        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

        // ユーザー情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     *
     * メールアドレスからユーザーデータの取得
     *
     * @param  string $mailAddress メールアドレス
     *
     * @return array $data データ
     */
    public function getUserDataFromMailAddress ($mailAddress) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";

        if (ComValidation::isMobileAddress($mailAddress)) {
            $whereArray[] = "mb_address = '" . $mailAddress . "'";
        } else {
            $whereArray[] = "pc_address = '" . $mailAddress . "'";
        }
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 過去メールアドレスを含むユーザーデータの取得
     *
     * @param  string $mailAddress メールアドレス
     *
     * @return array $data データ
     */
    public function getUserDataFromMailAddressDuplication ($mailAddress) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";

        if (ComValidation::isMobileAddress($mailAddress)) {
            $whereArray[] = "mb_address = '" . $mailAddress . "'";
        } else {
            $whereArray[] = "pc_address = '" . $mailAddress . "'";
        }
        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 過去メールアドレスを含むユーザーデータの取得
     *
     * @param  string $mailAddress メールアドレス
     *
     * @return array $data データ
     */
    public function getLastUserDataFromMailAddress ($mailAddress) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";

        if (ComValidation::isMobileAddress($mailAddress)) {
            $whereArray[] = "mb_address = '" . $mailAddress . "'";
        } else {
            $whereArray[] = "pc_address = '" . $mailAddress . "'";
        }
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";
        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }


    /**
     *
     * リメールキーからユーザーデータの取得
     *
     * @param  string $remailKey リメールキー
     *
     * @return array $data データ
     */
    public function getUserDataFromRemailKey ($remailKey) {

        if (!$remailKey) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "remail_key = '" . $remailKey . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "danger_status = 0";
        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * アクセスキーから登録ステータスを見ないでユーザーデータの取得
     *
     * @param  string $accessKey アクセスキー
     *
     * @return array $data データ
     */
    public function getRegStatusNotFindUserDataFromAccessKey ($accessKey) {

        if (!$accessKey) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "access_key = '" . $accessKey . "'";
        $whereArray[] = "danger_status = 0";
        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * メールアドレスから全ユーザーデータの取得
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function getAllUserDataFromMailAddress ($mailAddress) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";

        if (ComValidation::isMobileAddress($mailAddress)) {
            $whereArray[] = "mb_address = '" . $mailAddress . "'";
        } else {
            $whereArray[] = "pc_address = '" . $mailAddress . "'";
        }

        $whereArray[] = "user_disable = 0";
        $whereArray[] = "danger_status = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * ユーザー情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertUserData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("user", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザー情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function updateUserData($updateArray, $whereArray = null, $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("user", $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト固有ユーザー情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertProfileData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("profile", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }
        return $dbResultOBJ;
    }

    /**
     * サイト固有ユーザー情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function updateProfileData($updateArray, $whereArray = null, $autoQuotes = TRUE) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("profile", $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * 重複PCメールアドレスのチェック
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromPcMailAddress ($mailAddress, $userId = null) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "pc_address = '" . $mailAddress . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 過去重複PCメールアドレスのチェック
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromPcMailAddressDuplication ($mailAddress, $userId = null) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "pc_address = '" . $mailAddress . "'";
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 重複MBメールアドレスのチェック
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromMbMailAddress ($mailAddress, $userId = null) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "mb_address = '" . $mailAddress . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 重複ログインIDのチェック
     *
     * @param  string $loginId ログインID
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromLoginId ($loginId, $userId = null) {

        if (!$loginId) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "login_id = '" . $loginId . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 過去重複ログインIDのチェック
     *
     * @param  string $loginId ログインID
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromLoginIdDuplication ($loginId, $userId = null) {

        if (!$loginId) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "login_id = '" . $loginId . "'";
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 重複個体識別番号のチェック
     *
     * @param  string $mbSerialNumber 個体識別番号
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromMbSerialNumber ($mbSerialNumber, $userId = null) {

        if (!$mbSerialNumber) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "mb_serial_number = '" . $mbSerialNumber . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 過去重複個体識別番号のチェック
     *
     * @param  string $mbSerialNumber 個体識別番号
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromMbSerialNumberDuplication ($mbSerialNumber, $userId = null) {

        if (!$mbSerialNumber) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "mb_serial_number = '" . $mbSerialNumber . "'";
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 有効ドメインかどうかチェック
     *
     * @param  string $addressDomain      登録アドレスドメイン
     * @param  string $ngAddressDomainAry NGドメイン配列
     *
     * @return boolean 有効ドメインであればTRUE、でなければFALSE
     */
    public function chkRegistUserAddressDomain ($addressDomain) {

        if (!$addressDomain) {
            return FALSE;
        }

        // NGドメイン配列生成
        $registNgDomain = $this->_configOBJ->web_config->regist_ng_domain;

        foreach ($registNgDomain as $val) {
            // NGドメインに「ドット」があればエスケープ
            $val = str_replace(".", "\.", $val);
            $ngAddress = "/[\w\.\-]*(" . $val . ")$/";
            if (preg_match($ngAddress, $addressDomain)) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     *
     * 「退会者」and「ブラック有効」ユーザーチェック
     *
     * @param  string $addressDomain      登録アドレスドメイン
     * @param  string $mbSerialNumber     個体識別番号
     *
     * @return boolean データあればTRUE、なければFALSE
     */
    public function chkQuitBlackUser($mailAddress, $mbSerialNumber = "") {

        if (!$mailAddress) {
            return false;
        }

        $whereString = "";

        $columnArray[] = "*";

        if (ComValidation::isMobileAddress($mailAddress)) {
            if ($mbSerialNumber) {
                $whereString .= " OR mb_serial_number = '" . $mbSerialNumber . "'";
            }
            $whereArray[] = "(mb_address = '" . $mailAddress . "'" . $whereString . ")";
        } else {
            $whereArray[] = "pc_address = '" . $mailAddress . "'";
        }

        $whereArray[] = "regist_status = " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT;
        $whereArray[] = "danger_status = " . $this->_configOBJ->define->DANGER_VALID;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     *
     * access_keyの重複が無い様にaccess_keyを返す。
     *
     *
     * @param datetime $registDatetime キー生成に使用する登録日付
     * @return string accessKey　を連想配列で返す
     */
    public function getNewAccessKey( $registDatetime )  {
        if ( !$registDatetime ) {
            return false;
        }

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $securityKey = ComUtility::getRamdomNumber(6);    //6桁のランダム数値
            $accessKey   = md5($registDatetime . "__" . $securityKey );
            $accessKey   = substr($accessKey,0,16);

            $columnArray = array() ;
            $columnArray[] = "*";

            $whereArray = array() ;
            $whereArray[] = "access_key = '" . $accessKey . "'";
            $whereArray[] = "user_disable = 0";

            $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

            $i++;

            if ($i > 100) {
                return FALSE;
            }

        } while ( $data = $this->executeQuery($sql, "fetchRow") );

        return $accessKey;
    }

    /**
     *
     * remail_keyの重複が無い様にremail_keyを返す。
     *
     *
     * @param datetime $preRegistDatetime キー生成に使用する仮登録日付
     * @return string remailKeyを返す
     */
    public function getNewRemailKey( $preRegistDatetime )  {
        if ( !$preRegistDatetime ) {
            return false;
        }

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $securityKey = ComUtility::getRamdomNumber(6);    //6桁のランダム数値
            $remailKey   = md5($preRegistDatetime . "__" . $securityKey );
            $remailKey   = substr($remailKey, 0, 16);

            $columnArray = array() ;
            $columnArray[] = "*";

            $whereArray = array() ;
            $whereArray[] = "remail_key = '" . $remailKey . "'";
            $whereArray[] = "user_disable = 0";

            $i++;

            if ($i > 100) {
                return FALSE;
            }

            $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

        } while ( $data = $this->executeQuery($sql, "fetchRow") );

        return $remailKey;
    }

    /**
     *
     * $passwordKeyを返す。
     *
     * @param string $password キー生成に使用するパスワード
     *
     * @return string $passwordKey パスワードキー
     */
    public function createPasswordKey($password)  {
        if (!$password) {
            return false;
        }

        $passwordKey   = md5($password . "__" . $this->_configOBJ->define->PROJECT_NAME);

        return $passwordKey;
    }

    /**
     *
     * ポイント更新処理
     *
     * @param  array $userData   ユーザーデータ
     * @param  integer $point ポイント
     * @param  integer $pointType ポイントタイプ
     * @param  integer $orderingId 注文ID
     * @param  integer $infoStatusId 情報表示条件ID
     *
     * @return boolean
     */
    public function updatePoint($userData, $point, $orderingId = 0, $infoStatusId = 0) {

        if (!$userData OR !is_numeric($point)) {
            return FALSE;
        }

        // ユーザーポイントがマイナスになるなら処理をしない
        if ($userData["point"] + $point < 0 ) {
            return FALSE;
        }

        $updateArray = array();
        $updateArray["point"]           = "point + (" . $point . ")";
        $updateArray["update_datetime"] = "'" . date("YmdHis") . "'";

        $whereArray[] = "user_id = " . $userData["user_id"];

        if ($point < 0) {
            // ポイントがマイナスなら消費ポイントに加える
            $updateArray["total_use_point"] = "total_use_point - (" . $point . ")";
        } else {
            // ポイントがプラスなら付加ポイントに加える
            $updateArray["total_addition_point"] = "total_addition_point + " . $point;
        }

        if (!$this->updateProfileData($updateArray, $whereArray, FALSE)) {
            return FALSE;
        }

        //ログを残します
        $insertArray = array();
        $insertArray["ordering_id"]           = $orderingId;
        $insertArray["information_status_id"] = $infoStatusId;
        $insertArray["user_id"]               = $userData["user_id"];
        $insertArray["point"]                 = $point;
        $insertArray["create_datetime"] = date("YmdHis");

        $pointLogOBJ = PointLog::getInstance();
        if (!$pointLogOBJ->insertPointLog($insertArray)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     *
     * 銀行振込情報の取得
     *
     * @param  integer $userId ユーザーID
     *
     * @return array データ配列
     */
    public function getBankDetailData($userId) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("bank_detail", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }


    /**
     * 銀行振込情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertBankDetailData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("bank_detail", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 銀行振込情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateBankDetailData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("bank_detail", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * 住所情報の取得
     *
     * @param  integer $userId ユーザーID
     *
     * @return array データ配列
     */
    public function getAddressDetailData($userId) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        $column[] = "*";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("address_detail", $column, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }


    /**
     * 住所情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertAddressDetailData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("address_detail", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 住所情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateAddressDetailData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("address_detail", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 前日登録ユーザーリストの取得。
     *
     * @return array ユーザーリスト $dataArray
     */
    public function getYesterdayRegistUserList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS pc_address, mb_address";

        $whereArray[] = "user_disable = 0";

        $whereArray[] = "pre_regist_datetime >= '" . date("Ymd000000", strtotime("-1 day")) . "'";
        $whereArray[] = "pre_regist_datetime <= '" . date("Ymd235959", strtotime("-1 day")) . "'";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     * ユーザーポイントログの取得
     *
     * @param  array $param ﾃﾞﾌｫﾙﾄパラメーター
     * @param  array $addWhere 追加パラメーター
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getPointLogList($param,$addWhere, $order = "id DESC", $limit = "") {

        if (!is_numeric($param["user_id"])) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "user_id = " . $param["user_id"];
        $whereArray[] = "disable = 0";

        foreach($addWhere as $key => $val){
             $whereArray[] = $key ." = ". $val;
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($limit)) {
            $otherArray[] = " LIMIT " . $limit;
        }

        $sql = $this->makeSelectQuery("point_log", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }
}

?>
