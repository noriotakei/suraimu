<?php
/**
 * MailAddressChange.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * メールアドレス変更データの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class MailAddressChange extends ComCommon {

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
     * メールアドレス変更データの取得
     *
     * @param  integer $id メールアドレス変更ID
     * @return array メールアドレス変更データ
     */
    public function getMailAddressChangeData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "user_id = " . $id;
        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY id DESC LIMIT 1";

        $sql = $this->makeSelectQuery("mail_address_change", $columnArray, $whereArray, $otherArray);

        // メールアドレス変更情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     * メールアドレス変更情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertMailAddressChangeData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("mail_address_change", $insertArray)) {
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * メールアドレス変更情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function updateMailAddressChangeData($updateArray, $whereArray = null, $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("mail_address_change", $updateArray, $whereArray, $autoQuotes)) {
            return false;
        }

        return $dbResultOBJ;
    }


}

?>
