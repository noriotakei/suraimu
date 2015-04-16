<?php
/**
 * PreRegist.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 仮登録データの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class PreRegist extends ComCommon {

    const REMAIL_KEY_NAME = "rmkey";

    /** @var string エラーメッセージ */
    private $_errorMsg = null;

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
     * 仮登録データの取得
     *
     * @param  integer $id 仮登録ID
     * @return array 仮登録データ
     */
    public function getPreRegistData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "is_regist = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("pre_regist", $columnArray, $whereArray);

        // 仮登録情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     *
     * リメールキーから仮登録データの取得
     *
     * @param  string $remailKey メールアドレス
     *
     * @return array $data データ
     */
    public function getPreRegistDataFromRemailKey ($remailKey) {

        if (!$remailKey) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "remail_key = '" . $remailKey . "'";
        $whereArray[] = "is_regist = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("pre_regist", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 仮登録情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function insertPreRegistData($insertArray, $autoQuotes = true) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("pre_regist", $insertArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *仮登録情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updatePreRegistData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("pre_regist", $updateArray, $whereArray)) {
            return false;
        }

        return $dbResultOBJ;
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

            $columnArray[] = "*";

            $whereArray[] = "remail_key = '" . $remailKey . "'";

            $i++;

            if ($i > 100) {
                return FALSE;
            }

            $sql = $this->makeSelectQuery("pre_regist", $columnArray, $whereArray);

        } while ( $data = $this->executeQuery($sql, "fetchRow") );

        return $remailKey;
    }

    /**
     *
     * 直接登録時の登録情報を返す。
     *
     *
     * @param string $toAddress 送信先アドレス
     * @return array $directRegistData 登録情報
     */
    public function getDirectRegistData( $toAddress )  {
        if ( !$toAddress ) {
            return false;
        }
        $configArray = $this->_configOBJ->toArray();

        $directRegistData = $configArray["define"]["DIRECT_REGIST"][$toAddress];

        return $directRegistData;
    }



}

?>
