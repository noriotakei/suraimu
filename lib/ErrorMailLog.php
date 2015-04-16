<?php
/**
 * ErrorMailLog.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側エラーメールログを管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ErrorMailLog extends ComCommon {

    const ERROR_LOG_DIR = "/home/devel/bounce";

    /* エラーデバイス */
    const DEVICE_TYPE_PC = 0;
    const DEVICE_TYPE_MB = 1;

    /* 反転基準回数 */
    const REVERSE_LINE = 1;

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
     * 対象ユーザーのエラーログの存在チェック
     *
     * @param  integer $userId      ユーザーid
     * @param  string  $mailAddress 送信先メールアドレス
     * @return integer データ有：エラーログID 無：False
     */
    public function isErrorMailLog($userId, $mailAddress) {

        if (!$userId OR !$mailAddress) {
            return false;
        }

        $columnArray[] = "id";

        $whereArray[] = "user_id = " . $userId;
        $whereArray[] = "mail_address = '" . $mailAddress . "'";
        $whereArray[] = "disable = 0";

        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("error_mail_log", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data["id"];

    }

    /**
     *
     * 更新対象(エラーカウントREVERSE_LINE回以上)のエラーログデータ取得
     *
     * @return mixed 成功：エラーログデータ 失敗：False
     */
    public function getErrorLog() {


        $columnArray[] = "*";

        $whereArray[] = "error_count >= " . self::REVERSE_LINE;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("error_mail_log", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * エラーログ情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     *
     * @return boolean
     */
    public function insertErrorMailLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("error_mail_log", $insertArray)) {
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * エラーログ情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean データ有：True 無：False
     */
    public function updateErrorMailLogData($updateArray, $whereArray = null, $autoQuotes = true) {

        if (!$dbResultOBJ = $this->update("error_mail_log", $updateArray, $whereArray, $autoQuotes)) {
            return false;
        }

        return $dbResultOBJ;
    }

}
?>
