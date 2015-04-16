<?php
/**
 * Contact.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側問い合わせクラス
 *  問い合わせを管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class Contact extends ComCommon {

    const SEND_MAIL_ADDRESS_ACCOUNT = "info@";

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
     *
     * selectbox用問い合わせ種別リストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getContactTypeAryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "is_display = 1";
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

}
?>