<?php
/**
 * SettlementDigitalEdy.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  デジタルチェックEdy決済クラス
 *  デジタルチェックEdy決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */
class SettlementDigitalEdy extends Settlement {

    const EDY_IP  = "ED3352380A";
    const EDY_URL_PC = "https://www.digitalcheck.jp/settle/settle3/bp3.dll?";
    const EDY_URL_MB = "https://www.digitalcheck.jp/settle/settle2/ubp3.dll";
    const EDY_STORE_MB = 65;
    const EDY_STORE_PC = 66;

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array コンビニダイレクト%変換用変数 */
    protected $_keyconvData = null;

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
     * getSidメソッド
     *
     * 認証IDの発行と取得
     *
     * @return int $sid 認証用ID
     */
    function getSid() {
        mt_srand((double)microtime()*1000000);
        $rand_val = mt_rand("10","99");
        $today = date("YmdHis");
        $sid = $today.$rand_val;

        return $sid;
    }

   /**
     * getEdySettleUrlメソッド
     *
     * Edy決済の決済URL取得
     * デジタルチェックへ遷移
     */
    function getEdySettleUrl($orderingData, $userData){

        if (!$orderingData OR !$userData) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }

        //通信パラメータ
        $postDataAry["IP"]      = "IP=". self::EDY_IP;
        $postDataAry["SID"]     = "SID=" . $sid;
        $postDataAry["N1"]      = "N1=商品購入代金";
        $postDataAry["K1"]      = "K1=" . $orderingData["pay_total"];
        $postDataAry["FUKA"]    = "FUKA=" . $orderingData["id"];
        $postDataAry["STORE"]   = "STORE=" . self::EDY_STORE_PC;

        $postDataString = implode("&", $postDataAry);
        //通信先URL
        $baseUrl = self::EDY_URL_PC;
        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");

        if(!$this->insertEdyData($orderingData, $userData, $postDataString)){
            return false;
        }
        return $baseUrl.$encodePostData;
    }

   /**
     * getTestEdySettleUrlメソッド
     *
     * テスト用 Edy決済の決済URL取得
     * デジタルチェックへ遷移せずにDBにデータ作成するだけ
     */
    function getTestEdySettleUrl($orderingData, $userData){

        if (!$orderingData OR !$userData) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }

        //通信パラメータ
        $postDataAry["IP"]      = "IP=". self::EDY_IP;
        $postDataAry["SID"]     = "SID=" . $sid;
        $postDataAry["N1"]      = "N1=商品購入代金";
        $postDataAry["K1"]      = "K1=" . $orderingData["pay_total"];
        $postDataAry["FUKA"]    = "FUKA=" . $orderingData["id"];
        $postDataAry["STORE"]   = "STORE=" . self::EDY_STORE_PC;

        $postDataString = implode("&", $postDataAry);
        //通信先URL
        //$baseUrl = "http//" . $this->_configOBJ->define->SITE_URL . "/?action_SettleDigitalEnd=1";
        //シフトJISに変換
        //$encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");

        if(!$this->insertEdyData($orderingData, $userData, $postDataString)){
            return false;
        }
        return TRUE;
    }

   /**
     * sendToEdyメソッド
     *
     * デジタルチェックEdy決済の申込処理
     *
     * @param array $orderingData 注文データ
     * @param array $userData ユーザーデータ
     *
     * @return boolean 成功：true　失敗：false
     */
    function sendToEdy($orderingData, $userData) {

        if (!$orderingData OR !$userData) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }

        //通信パラメータ
        $postDataAry["IP"]      = "IP=". self::EDY_IP;
        $postDataAry["SID"]     = "SID=" . $sid;
        $postDataAry["N1"]      = "N1=商品購入代金";
        $postDataAry["K1"]      = "K1=" . $orderingData["pay_total"];
        $postDataAry["FUKA"]    = "FUKA=" . $orderingData["id"];
        $postDataAry["STORE"]   = "STORE=" . self::EDY_STORE_MB;
        $postDataAry["MAIL"]    = "MAIL=" . $userData["mb_address"];

        $postDataString = implode("&", $postDataAry);

        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");
        parse_str($encodePostData, $postData);

        // 決済URL取得
        $url = self::EDY_URL_MB;

        $httpParam = array (
                        "maxredirects" => 1,
                        "timeout" => 30,
                    );
        // http通信
        $ComHttpOBJ = new ComHttp($url, $httpParam);
        $ComHttpOBJ->setParameterGet($postData);
        $result = $ComHttpOBJ->request("GET");

        if ($result->isSuccessful()) {
            $return = $result->getBody();
            if (preg_match("/OK/", $return)) {
                //申込結果をセット
                if(!$this->insertEdyData($orderingData, $userData, $postDataString)){
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

   /**
     * testSendToEdyメソッド
     *
     * テスト環境用 デジタルチェックEdy決済の申込処理
     *
     * @param array $orderingData 注文データ
     * @param array $userData ユーザーデータ
     *
     * @return boolean 成功：true　失敗：false
     */
    function testSendToEdy($orderingData, $userData) {

        if (!$orderingData OR !$userData) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }

        //通信パラメータ
        $postDataAry["IP"]      = "IP=". self::EDY_IP;
        $postDataAry["SID"]     = "SID=" . $sid;
        $postDataAry["N1"]      = "N1=商品購入代金";
        $postDataAry["K1"]      = "K1=" . $orderingData["pay_total"];
        $postDataAry["FUKA"]    = "FUKA=" . $orderingData["id"];
        $postDataAry["STORE"]   = "STORE=" . self::EDY_STORE_MB;
        $postDataAry["MAIL"]    = "MAIL=" . $userData["mb_address"];

        $postDataString = implode("&", $postDataAry);

        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");
        parse_str($encodePostData, $postData);

        $return = "OK"; // テストなのでデフォルトで「OK」にする。
        if (preg_match("/OK/", $return)) {
            //申込結果をセット
            if(!$this->insertEdyData($orderingData, $userData, $postDataString)){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * insertEdyDataメソッド
     *
     * 申込結果の登録
     *
     * @param integer $orderingData 注文データ
     * @param integer $userData ユーザーデータ
     * @param string  $postDataString 申し込みパラメータ
     *
     * @return boolen 失敗したらfalse
     */
    function insertEdyData($orderingData, $userData, $postDataString) {

        if(!$orderingData OR !$userData OR !$postDataString){
            return false;
        }

        parse_str($postDataString, $postDataAry);

        //申込データのインサート
        $edyLogInsertArray["user_id"] = $userData["user_id"];
        $edyLogInsertArray["ordering_id"] = $orderingData["id"];
        $edyLogInsertArray["pay_money"] = $postDataAry["K1"];
        $edyLogInsertArray["sid"] = $postDataAry["SID"];
        $edyLogInsertArray["parameter"] = $postDataString;
        $edyLogInsertArray["create_datetime"] = date("YmdHis");

        if (!$this->insertDigitalEdyData($edyLogInsertArray)) {
            return false;
        }

        return true;
    }

    /**
     * Edy決済ログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertDigitalEdyData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("digital_edy", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * Edy決済ログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateDigitalEdyData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("digital_edy", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * Edyデータの取得
     *
     * @param  integer $orderingId 注文ID
     * @param  integer $userData ユーザーデータ
     *
     * @return array EDYデータ
     */
    public function getDigitalEdyData($orderingId, $userData) {

        if (!$orderingId OR !$userData) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "user_id = " . $userData["user_id"];
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("digital_edy", $columnArray, $whereArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * Edyデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array Edyデータ
     */
    public function getNoPaidEdyData($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("digital_edy", $columnArray, $whereArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * sidからEdyデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array Edyデータ
     */
    public function getEdyDataFromSid($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY id DESC LIMIT 1";

        $sql = $this->makeSelectQuery("digital_edy", $columnArray, $whereArray, $otherArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

}
?>