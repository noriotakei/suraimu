<?php
/**
 * RegistSite.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ユーザー側サイト間登録クラス
 *  サイト間登録を管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SameTimeRegist extends ComCommon {

    // 登録入り口種別
    //const SAME_TIME_REGIST_SURAIMU = 1;  // '高配当',
    const SAME_TIME_REGIST_CHIMERA = 2;  // 'エージェント)',
    const SAME_TIME_REGIST_BEHOMA = 3;  // '3競チャンネル',
    const SAME_TIME_REGIST_GIZMO = 4;  // 的中のシナリオ',
    const SAME_TIME_REGIST_GOLEM = 5;  // '大川慶次郎',

    /** @var array サイト登録ＵＲＬ */
    public static $_registUrl = array(
                //self::SAME_TIME_REGIST_SURAIMU     => "http://ko-haito.com/cushion.php",
                self::SAME_TIME_REGIST_CHIMERA     => "http://tatuya.jp/cushion.php",
                self::SAME_TIME_REGIST_BEHOMA     => "http://3kch.jp/cushion.php",
                self::SAME_TIME_REGIST_GIZMO     => "http://t-scenario.jp/cushion.php",
                self::SAME_TIME_REGIST_GOLEM     => "http://okawa-god.jp/cushion.php",
                 );

    /** @var array サイト登録媒体コード */
    public static $_registMediaCd = array(
                //self::SAME_TIME_REGIST_SURAIMU     => "te20025",
                self::SAME_TIME_REGIST_CHIMERA     => "te20042",
                self::SAME_TIME_REGIST_BEHOMA     => "te20041",
                self::SAME_TIME_REGIST_GIZMO     => "te20043",
                self::SAME_TIME_REGIST_GOLEM     => "te20039",
                 );

    /** @var array サイト登録入り口ID */
    public static $_registPageId = array(
                //self::SAME_TIME_REGIST_SURAIMU     => "te20025",
                self::SAME_TIME_REGIST_CHIMERA     => "magazine",
                self::SAME_TIME_REGIST_BEHOMA     => "34b2cbaa64",
                self::SAME_TIME_REGIST_GIZMO     => "8f71b6aab1",
                self::SAME_TIME_REGIST_GOLEM     => "7ae9911af6",
                 );


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
     *同時登録情報の送信。
     *
     * @param  string $mailAddress メールアドレス
     *
     * @return boolean
     */
    public function sendSameTimeRegist($mailAddress) {

        if (!$mailAddress) {
            return FALSE;
        }

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );

        foreach (self::$_registUrl as $key => $val) {
            $dataArray = "";
            $dataArray["mail"] = $mailAddress;
            $dataArray["id"] = self::$_registPageId[$key] ;
            $dataArray["advcd"] = self::$_registMediaCd[$key] ;
            $dataArray["noRemail"] = 1 ;
            try {
                // http通信
                $ComHttpOBJ = new ComHttp($val, $httpParam);
                $ComHttpOBJ->setParameterPost($dataArray);
                $result = $ComHttpOBJ->request("POST");
            } catch (Zend_Exception $e) {
                continue;
            }
        }
        return TRUE;
    }
}
?>