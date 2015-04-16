<?php
/**
 * SiteContents.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側サイト表示内容クラス
 *  サイト表示内容を管理するクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SiteContents extends ComCommon implements InterfaceSiteContents {

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
     *
     * サイト表示内容データの取得
     *
     * @param  integer $displayCd サイト表示内容
     * @return array データ配列
     */
    public function getSiteContentsData($displayCd, $userId = FALSE) {

        if (!is_numeric($displayCd)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "display_cd = " . $displayCd;
        $whereArray[] = "is_display = 1";
        $whereArray[] = "start_datetime <= NOW()";
        $whereArray[] = "(end_datetime = '0000-00-00 00:00:00' OR end_datetime >= NOW())";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("site_contents", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }
        $KeyConvertOBJ = KeyConvert::getInstance();
        $data["html_contents_pc"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["html_contents_pc"], ENT_QUOTES), $userId);
        $data["html_contents_mb"] = $KeyConvertOBJ->execConvert(htmlspecialchars_decode($data["html_contents_mb"], ENT_QUOTES), $userId);
        return $data;

    }
}
?>