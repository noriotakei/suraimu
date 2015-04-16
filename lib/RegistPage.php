<?php
/**
 * RegistPage.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  登録ページ管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class RegistPage extends ComCommon implements InterfaceRegistPage {

    const PAGE_CD_NAME = "pcd";
    const MAILTO_TOADDRESS_FIRST = "regist-";

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
     * 登録ページコードからデータの取得
     *
     * @param  integer $pageRegistCd 登録ページCD
     * @param  array $convertArray コンバート配列
     * @return array データ配列
     */
    public function getRegistPageDataForRegistCd($pageRegistCd, $convertArray = "") {

        if (!$pageRegistCd) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "cd = '" . $pageRegistCd . "'";
        $whereArray[] = "is_use = 1";
        $whereArray[] = "(display_start_datetime = '0000-00-00 00:00:00' OR display_start_datetime <= NOW())";
        $whereArray[] = "(display_end_datetime = '0000-00-00 00:00:00' OR display_end_datetime >= NOW())";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        $KeyConvertOBJ = KeyConvert::getInstance();
        if ($data["page_html_pc"]) {
            $data["page_html_pc"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["page_html_pc"], ENT_QUOTES), "", $convertArray);
        }
        if ($data["page_html_mb"]) {
            $data["page_html_mb"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["page_html_mb"], ENT_QUOTES), "", $convertArray);
        }

        return $data;

    }

    /**
     *
     * 登録ページコードからプレビューデータの取得
     *
     * @param  integer $pageRegistCd 登録ページCD
     * @param  array $convertArray コンバート配列
     * @return array データ配列
     */
    public function getRegistPagePreviewDataForRegistCd($pageRegistCd, $convertArray = "") {

        if (!$pageRegistCd) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "cd = '" . $pageRegistCd . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        $KeyConvertOBJ = KeyConvert::getInstance();
        if ($data["page_html_pc"]) {
            $data["page_html_pc"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["page_html_pc"], ENT_QUOTES), "", $convertArray);
        }
        if ($data["page_html_mb"]) {
            $data["page_html_mb"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["page_html_mb"], ENT_QUOTES), "", $convertArray);
        }

        return $data;

    }

    /**
     *
     * 登録ページデータの取得
     *
     * @param  integer $id 登録ページID
     * @return array データ配列
     */
    public function getRegistPageData($registPageId) {

        if (!is_numeric($registPageId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $registPageId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 登録ページ画像の取得。
     *
     * @param  integer $registPageId 登録ページID
     * @param  boolean $isMobile モバイル用かどうか
     *
     * @return arrat 登録ページ画像リスト、失敗ならfalse
     */
    public function getRegistPageImageData($registPageId, $isMobile = false) {

        if (!is_numeric($registPageId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "regist_page_id = " . $registPageId;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page_image", $columnArray, $whereArray);

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
     * @param  integer $registPageId 登録ページID
     * @param  string $mailAddress メールアドレス
     *
     * @return array $mailElements データリスト配列
     */
    public function getRegistPageMailData($registPageId, $mailAddress) {

        if (!$registPageId OR !$mailAddress) {
            return FALSE;
        }

        $mailElementsData = self::getRegistPageData($registPageId);

        $fromName = htmlspecialchars_decode($mailElementsData["from_name"], ENT_QUOTES);
        if (ComValidation::isMobileAddress($mailAddress)) {
            $subject = htmlspecialchars_decode($mailElementsData["mb_subject"], ENT_QUOTES);
            $textBody = htmlspecialchars_decode($mailElementsData["mb_text_body"], ENT_QUOTES);
            $textBodySecond = htmlspecialchars_decode($mailElementsData["mb_text_body_second"], ENT_QUOTES);
            $htmlBody = htmlspecialchars_decode($mailElementsData["mb_html_body"], ENT_QUOTES);
            $mailElementsImgData = self::getRegistPageImageData($registPageId, true);
        } else {
            $subject = htmlspecialchars_decode($mailElementsData["pc_subject"], ENT_QUOTES);
            $textBody = htmlspecialchars_decode($mailElementsData["pc_text_body"], ENT_QUOTES);
            $textBodySecond = htmlspecialchars_decode($mailElementsData["pc_text_body_second"], ENT_QUOTES);
            $htmlBody = htmlspecialchars_decode($mailElementsData["pc_html_body"], ENT_QUOTES);
            $mailElementsImgData = self::getRegistPageImageData($registPageId, false);
        }

        $mailElements["elements"] = array(
                "to_address"      => $mailAddress,
                "from_address"  => $mailElementsData["from_address"],
                "from_name"     => $fromName,
                "return_path"     => $mailElementsData["return_path"],
                "subject"           => $subject,
                "text_body"       => $textBody,
        		"text_body_second"   => $textBodySecond,
        		"html_body"      => $htmlBody,
        );

        for ($i = 0; $i < count($mailElementsImgData); $i++) {
            if ($mailElementsImgData[$i]["file_name"]) {
                $mailElements["image_data"][$i] = file_get_contents(D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $mailElementsImgData[$i]["file_name"]);
                $size = getimagesize(D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $mailElementsImgData[$i]["file_name"]);
                $mailElements["image_type"][$i] = $size["mime"];
            }
        }

        return $mailElements;

    }
}
?>