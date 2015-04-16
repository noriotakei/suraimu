<?php
/**
 * AdmSiteContents.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側サイト表示内容クラス
 *  サイト表示内容を管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmSiteContents extends ComCommon implements InterfaceSiteContents {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array 表示状態配列 */
    public static $_disableFlag = array(
                    "0" => "非表示",
                    "1" => "表示",
                  );

    /** @var array 表示場所コード配列 */
    public static $_disableCd = array(
                    self::DISPLAY_CD_PRE_FOOTER_MENU => "ログイン前フッターメニュー",
                    self::DISPLAY_CD_PRE_CONTENTS_MENU => "ログイン前コンテンツメニュー",
                    self::DISPLAY_CD_EASY_LOGIN    => "かんたんログイン",
                    self::DISPLAY_CD_REGIST_PAGE_FOOTER_MENU    => "登録ページ専用フッターメニュー",
                    self::DISPLAY_CD_ABOUT    => "当サイトについて",
                    self::DISPLAY_CD_RULE_ENTRY    => "応募規約",
                    self::DISPLAY_CD_PERSONAL    => "個人情報保護方針",
                    self::DISPLAY_CD_OUTLINE    => "特定商取引法による表記",
                    self::DISPLAY_CD_PRIVACY    => "プライバシーポリシー",
                    self::DISPLAY_CD_RULE    => "利用規約",
                    self::DISPLAY_CD_COMPANY    => "会社概要",
                    self::DISPLAY_CD_MOBILE_SERIAL_NUMBER    => "固体識別ONの説明",
                    self::DISPLAY_CD_OUTLINE_KEIBA    => "競馬法に基づく表記",
                    self::DISPLAY_CD_SITEMAP    => "サイトマップ",
                    self::DISPLAY_CD_FOOTER_MENU    => "ログイン後フッターメニュー",
                    self::DISPLAY_CD_CONTENTS_MENU    => "ログイン後コンテンツメニュー",
                    self::DISPLAY_CD_KEYWORD    => "メタタグkeyword",
                    self::DISPLAY_CD_DESCRIPTION    => "メタタグdescription",
                    self::DISPLAY_CD_MAILSETTING    => "メール受信設定",
                    self::DISPLAY_CD_INDEX_MAILBODY    => "競馬入り口空メール文言",
                    self::DISPLAY_CD_PR    => "PR",
                    self::DISPLAY_CD_QUIT_PR    => "退会ページ用PR",
                    self::DISPLAY_CD_MEMBER_STATUS => "会員ステータス情報",
                    self::DISPLAY_CD_PARTS => "挿し込み情報",
                    self::DISPLAY_CD_QUIT_START_PR => "退会スタートページ用PR",
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
     * サイト表示内容データの取得
     *
     * @param  integer $id サイト表示内容ID
     * @return array データ配列
     */
    public function getSiteContentsData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("site_contents", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * サイト表示内容リストの取得
     *
     * @return array $dataList データ配列
     */
    public function getSiteContentsList() {


        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";
        $otherArray[] = "ORDER BY is_display DESC, end_datetime, id DESC";

        $sql = $this->makeSelectQuery("site_contents", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * サイト表示内容の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertSiteContentsData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("site_contents", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト表示内容の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateSiteContentsData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("site_contents", $updateArray, $whereArray)) {
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

}
?>