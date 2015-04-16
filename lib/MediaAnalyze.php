<?php
/**
 * MediaAnalyzeLog.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側媒体集計管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class MediaAnalyze extends ComCommon {

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
     * 媒体集計の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @param  array $updateArray 更新データ配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function insertDuplicateMediaAnalyzeData($insertArray, $updateAry, $autoQuotes = true) {

        if (!is_array($insertArray) OR !is_array($updateAry)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insertDuplicate("media_analyze", $insertArray, $updateAry, $autoQuotes)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

}
?>