<?php

/**
 * AutoMail.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザー側リメール設定管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */


class AutoMail extends ComCommon implements InterfaceAutoMail {

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
     * ページ名からリメールエレメンツデータを取得
     *
     * @param  string $pageName ページ名
     * @param  string $variableName 配列キー名
     *
     * @return array $dataList データリスト配列
     */
    public function getAutoMailElements($pageName, $variableName) {

        if (!$pageName OR !$variableName) {
            return FALSE;
        }

        $columnArray[] = "ame.*";

        $whereArray[] = "amc.id = ame.auto_mail_contents_id";
        $whereArray[] = "amc.is_use = 1";
        $whereArray[] = "amc.page_name = '" . $pageName . "'";
        $whereArray[] = "amc.variable_name = '" . $variableName . "'";
        $whereArray[] = "amc.is_use = 1";
        $whereArray[] = "amc.disable = 0";
        $whereArray[] = "ame.disable = 0";

        $otherArray[] = "ORDER BY sort_seq DESC";
        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("auto_mail_contents amc, auto_mail_elements ame", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * リメールエレメント画像の取得。
     *
     * @param  integer $autoMailElementsId リメールエレメントID
     * @param  boolean $isMobile モバイル用かどうか
     *
     * @return arrat リメールエレメント画像リスト、失敗ならfalse
     */
    public function getAutoMailImageData($autoMailElementsId, $isMobile = false) {

        if (!is_numeric($autoMailElementsId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "auto_mail_elements_id = " . $autoMailElementsId;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("auto_mail_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     * リメールデータを取得
     *
     * @param  string $pageName ページ名
     * @param  string $variableName 配列キー名
     * @param  string $mailAddress メールアドレス
     *
     * @return array $mailElements データリスト配列
     */
    public function getAutoMailData($pageName, $variableName, $mailAddress) {

        if (!$pageName OR !$variableName OR !$mailAddress) {
            return FALSE;
        }

        $mailElementsData = self::getAutoMailElements($pageName, $variableName);

        $fromName = htmlspecialchars_decode($mailElementsData["from_name"], ENT_QUOTES);
        if (ComValidation::isMobileAddress($mailAddress)) {
            $subject = htmlspecialchars_decode($mailElementsData["mb_subject"], ENT_QUOTES);
            $textBody = htmlspecialchars_decode($mailElementsData["mb_text_body"], ENT_QUOTES);
            $htmlBody = htmlspecialchars_decode($mailElementsData["mb_html_body"], ENT_QUOTES);
            $mailElementsImgData = self::getAutoMailImageData($mailElementsData["id"], true);
        } else {
            $subject = htmlspecialchars_decode($mailElementsData["pc_subject"], ENT_QUOTES);
            $textBody = htmlspecialchars_decode($mailElementsData["pc_text_body"], ENT_QUOTES);
            $htmlBody = htmlspecialchars_decode($mailElementsData["pc_html_body"], ENT_QUOTES);
            $mailElementsImgData = self::getAutoMailImageData($mailElementsData["id"], false);
        }

        $mailElements["elements"] = array(
                "to_address"      => $mailAddress,
                "from_address"  => $mailElementsData["from_address"],
                "from_name"     => $fromName,
                "return_path"     => $mailElementsData["return_path"],
                "subject"           => $subject,
                "text_body"       => $textBody,
                "html_body"      => $htmlBody,
        );

        for ($i = 0; $i < count($mailElementsImgData); $i++) {
            if ($mailElementsImgData[$i]["file_name"]) {
                $mailElements["image_data"][$i] = file_get_contents(D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $mailElementsImgData[$i]["file_name"]);
                $size = getimagesize(D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $mailElementsImgData[$i]["file_name"]);
                $mailElements["image_type"][$i] = $size["mime"];
            }
        }

        return $mailElements;

    }

    /**
     * mailToメソッド
     *
     * メール送信実行
     *
     * @param array   $$mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
     /*
    public function mailTo ($mailElements, $sec = 0, $imageData = null, $imageType = null) {
        $SendMailOBJ = SendMail::getInstance();
        $SendMailOBJ->setMailServerIp($this->_configOBJ->common_config->mail_server_ip->remail);
        return $SendMailOBJ->mailTo($mailElements, $sec, $imageData, $imageType);
    }
    */

    /**
     * mailToメソッド
     *
     * メール送信実行
     *
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

        if (!$mailElements["from_address"]) {
            // from_addressなくてもエラーでは無い場合があるので、tureで返却（送信処理はしない）
            return true;
        }

        $SendMailOBJ = SendMail::getInstance();
        $SendMailOBJ->setMailServerIp($this->_configOBJ->common_config->smtp_mail_server_ip->remail);
        return $SendMailOBJ->smtpMailTo($mailElements, $sec, $imageData, $imageType);
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

}

?>