<?php
/**
 * SettlementCvd.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  コンビニダイレクト決済クラス
 *  コンビニダイレクト決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SettlementCvd extends Settlement {

    const CVD_IP = "D33363556A";
    const CVD_ADR = "東京都渋谷区";   //表記会社の住所で申請
    const CVD_URL = "https://www.digitalcheck.jp/settle/settle2/ubp3.dll";

    const CV_CD_LOPPI = 1;
    //const CV_CD_SEVEN = 2;
    const CV_CD_FAMIMA = 3;
    const CV_CD_ACD = 71; // 現在では『Empire Maker』しか使用してない

    const CV_NAME_LAWSON = 1;
    const CV_NAME_CD_SEICO = 2;
    const CV_NAME_CD_FAMIMA = 3;
    const CV_NAME_CD_AMPM = 4; // 現在では『Empire Maker』しか使用してない
    const CV_NAME_CD_DAILY = 5; // 現在では『Empire Maker』しか使用してない
    const CV_NAME_CD_MINI = 7;

    /** @var array コンビニ決済タイプデータ変数 */
    public static $_cvSettleCd = array(
                                          self::CV_NAME_LAWSON     => self::CV_CD_LOPPI,
                                          //self::CV_CD_SEVEN => "セブンイレブン",
                                          self::CV_NAME_CD_SEICO   => self::CV_CD_LOPPI,
                                          self::CV_NAME_CD_FAMIMA => self::CV_CD_FAMIMA,
                                          self::CV_NAME_CD_MINI => self::CV_CD_LOPPI,
                                          );

    /** @var array コンビニ名データ変数 */
    public static $_cvName = array(
                                      self::CV_NAME_LAWSON => "ローソン",
                                      self::CV_NAME_CD_SEICO => "セイコーマート",
                                      self::CV_NAME_CD_FAMIMA => "ファミリーマート",
                                      self::CV_NAME_CD_MINI => "ミニストップ",
                                    );

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
     * sendToCvdメソッド
     *
     * コンビニダイレクト決済の申込処理
     *
     * @param array $orderingData 注文データ
     * @param array $userData ユーザーデータ
     * @param array $param 申し込みパラメータ
     * @param boolean $isMobile モバイルフラグ
     *
     * @return boolean 成功：true　失敗：false
     */
    function sendToCvd($orderingData, $userData, $param, $isMobile) {

        if (!$orderingData OR !$userData OR !$param) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }
        $postDataAry[] = "SID=" . $sid;

        //名前は全角
        $postDataAry[] = "NAME1=" . mb_convert_kana($param["name1"], "AHKNSR", "UTF-8");
        $postDataAry[] = "NAME2=" . mb_convert_kana($param["name2"], "AHKNSR", "UTF-8");

        //電話番号
        $postDataAry["TEL"] = "TEL=" . $param["telno"];

        //申請住所も全角
        //表記会社の住所で申請
        $postDataAry["ADR1"] = "ADR1=" . mb_convert_kana(self::CVD_ADR, "AHKNSR", "UTF-8");

        //メールアドレスセット
        if ($isMobile) {
            $postDataAry["MAIL"] = "MAIL=" . ($userData["mb_address"] ? $userData["mb_address"] : $userData["pc_address"]);
        } else {
            $postDataAry["MAIL"] = "MAIL=" . ($userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"]);
        }

        //通信パラメータ
        $postDataAry["IP"] = "IP=" . self::CVD_IP;
        $postDataAry["K1"] = "K1=" . $orderingData["pay_total"];
        $postDataAry["N1"] = "N1=" . "商品購入代金";
        $postDataAry["STORE"] = "STORE=" . $param["cv_cd"];
        $postDataAry["FUKA"] = "FUKA=" . $orderingData["id"];

        $postDataString = implode("&", $postDataAry);

        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");

        parse_str($encodePostData, $postData);
        $return[] = "ok";

        // 決済URL取得
        $url = self::CVD_URL;

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
                if(!$this->insertCvdData($orderingData, $userData, $return, $postDataString)) {
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
     * testSendToCvdメソッド
     *
     * テスト環境用コンビニダイレクト決済の申込処理
     *
     * @param array $orderingData 注文データ
     * @param array $userData ユーザーデータ
     * @param array $param 申し込みパラメータ
     * @param boolean $isMobile モバイルフラグ
     *
     * @return boolean 成功：true　失敗：false
     */
    function testSendToCvd($orderingData, $userData, $param, $isMobile) {

        if (!$orderingData OR !$userData OR !$param) {
            return false;
        }

        //申込に必要な値を準備
        if (!$sid = $this->getSid()) {
            $this->_errorMsg[] = "認証用IDが発行できません。";
            return false;
        }
        $postDataAry[] = "SID=" . $sid;

        //名前は全角
        $postDataAry[] = "NAME1=" . mb_convert_kana($param["name1"], "AHKNSR", "UTF-8");
        $postDataAry[] = "NAME2=" . mb_convert_kana($param["name2"], "AHKNSR", "UTF-8");

        //電話番号
        $postDataAry["TEL"] = "TEL=" . $param["telno"];

        //申請住所も全角
        //表記会社の住所で申請
        $postDataAry["ADR1"] = "ADR1=" . mb_convert_kana(self::CVD_ADR, "AHKNSR", "UTF-8");

        //メールアドレスセット
        if ($isMobile) {
            $postDataAry["MAIL"] = "MAIL=" . ($userData["mb_address"] ? $userData["mb_address"] : $userData["pc_address"]);
        } else {
            $postDataAry["MAIL"] = "MAIL=" . ($userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"]);
        }

        // TESTパラメータ
        $postDataAry["TEST"] = "テスト決済";
        $postDataAry["IP"] = "IP=" . self::CVD_IP;
        $postDataAry["K1"] = "K1=" . $orderingData["pay_total"];
        $postDataAry["N1"] = "N1=" . "商品購入代金";
        $postDataAry["STORE"] = "STORE=" . $param["cv_cd"];
        $postDataAry["FUKA"] = "FUKA=" . $orderingData["id"];

        $postDataString = implode("&", $postDataAry);

        //シフトJISに変換
        $encodePostData = mb_convert_encoding($postDataString, "sjis-win", "auto");

        parse_str($encodePostData, $postData);
        //$return[] = "ok";

        // 店舗コード
        $storeCD = $param["cv_cd"];

        // システムにメール
        $postDataTest = print_r($postData, TRUE);
        mail("ml_sys_com_portal@ichi5.asia", "SYSTEM TEST = postDataTest", $postDataTest);

        // TESTなので、最低限のものだけチェック(こんなに要らないかも...。)

        if ($postData["IP"] && $postData["K1"] && $postData["N1"] && $postData["TEL"] && $postData["ADR1"] && $postData["MAIL"]) {

            if ($storeCD == self::CV_CD_ACD) {
                $testNumber = "00000000000000000000000000000000000000000000";
                $testSettleUrl = "http://mocopit.jp/acd-distributor/ShowBarcode.do?tid=00000000000000000";
            } else {
                $testNumber = "00000000000000000";
                $testSettleUrl = "";
            }

            $return = "OK\n"
                    . (int)date("YmdHis") . "00\n" // 16桁(月日分秒+00)
                    . $orderingData["pay_total"] . "\n"
                    . $testNumber . "\n" // テスト用申し込み番号(適当です)
                    . date("Ymd", strtotime("+14 day")) . "\n" // 期限は2週間
                    . $orderingData["id"] . "\n"
                    . $testSettleUrl . "\n";

            //シフトJISに変換
            //$return = mb_convert_encoding($return, "sjis-win", "auto");

            $return = print_r($return, TRUE);
            mail("ml_sys_com_portal@ichi5.asia", "SYSTEM TEST = returnTest", $return);

            if (preg_match("/OK/", $return)) {
                //申込結果をセット
                if(!$this->insertCvdData($orderingData, $userData, $return, $postDataString)) {
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
     * insertCvdLogDataメソッド
     *
     * 申込結果の登録
     *
     * @param integer $orderingData 注文データ
     * @param integer $userData ユーザーデータ
     * @param string $return 決済の戻り値
     * @param string $postDataString 申し込みパラメータ
     *
     * @return boolen 失敗したらfalse
     */
    function insertCvdData($orderingData, $userData, $return, $postDataString) {

        if(!$orderingData OR !$userData OR !$return OR !$postDataString){
            return false;
        }

        parse_str($postDataString, $postDataAry);

        $return = rtrim($return);
        $return = str_replace(array("\r","\n"), array("",","), $return);
        $returnAry = explode(",",$return);

        $sid = trim($returnAry[1]);
        $sid = strip_tags($sid);

        $payMoney = trim($returnAry[2]);
        $payMoney = strip_tags($payMoney);

        $number = trim($returnAry[3]);
        $number = strip_tags($number);

        $payLimit = trim($returnAry[4]);
        $payLimit = strip_tags($payLimit);

        //申込データのインサート
        $cvdLogInsertArray["user_id"] = $userData["user_id"];
        $cvdLogInsertArray["ordering_id"] = $orderingData["id"];
        $cvdLogInsertArray["pay_money"] = $payMoney;
        $cvdLogInsertArray["sid"] = $sid;
        $cvdLogInsertArray["store_cd"] = $postDataAry["STORE"];
        $cvdLogInsertArray["number"] = $number;
        $cvdLogInsertArray["parameter"] = $postDataString;
        $cvdLogInsertArray["create_datetime"] = date("YmdHis");
        $cvdLogInsertArray["pay_limit_datetime"] = $payLimit;

        if (!$this->insertConvenienceDirectData($cvdLogInsertArray)) {
            return false;
        }

        // %変換データの作成
        //ファミリーマートの場合、企業コードと申込番号の組み合わせになっている
        if($postDataAry["STORE"] == "3"){
            $number_1st = substr($number,0,5);
            $number_2nd = substr($number,6);

            $numberString  = "企業コード：".$number_1st;
            $numberString .= "<br>注文番号：".$number_2nd;

            $numberMailString = $number_2nd;
        }else{
            $numberString  = $number;
            $numberMailString = $number;
        }

        $this->_keyconvData = array();
        $this->_keyconvData['shno']           = $number;
        $this->_keyconvData['shnoString']     = $numberString;
        $this->_keyconvData['shnoMailString'] = $numberMailString;
        $this->_keyconvData['payLimit']       = $payLimit;
        $this->_keyconvData['sid']            = $sid;

        return true;
    }

   /**
     * getCvdKeyconvDataメソッド
     *
     * キーコンバート用データの取得
     *
     * @return array キーコンバート用データ
     */
    function getCvdKeyconvData() {
        return $this->_keyconvData;
    }

    /**
     * コンビニダイレクト決済ログの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertConvenienceDirectData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("convenience_direct", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * コンビニダイレクト決済ログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateConvenienceDirectData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("convenience_direct", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * コンビニダイレクトデータの取得
     *
     * @param  integer $orderingId 注文ID
     * @param  integer $userData ユーザーデータ
     *
     * @return array コンビニダイレクトデータ
     */
    public function getConvenienceDirectData($orderingId, $userData) {

        if (!$orderingId OR !$userData) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "ordering_id = " . $orderingId;
        $whereArray[] = "user_id = " . $userData["user_id"];
        $whereArray[] = "disable = 0";
        $otherArray[] = " ORDER BY id DESC";
        $sql = $this->makeSelectQuery("convenience_direct", $columnArray, $whereArray, $otherArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * コンビニダイレクトデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array コンビニダイレクトデータ
     */
    public function getNoPaidCvdData($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "is_paid = 0";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("convenience_direct", $columnArray, $whereArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * sidからコンビニダイレクトデータの取得
     *
     * @param  integer $sid 申込ID
     *
     * @return array コンビニダイレクトデータ
     */
    public function getCvdDataFromSid($sid) {

        if (!$sid) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "sid = " . $sid;
        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY id DESC LIMIT 1";

        $sql = $this->makeSelectQuery("convenience_direct", $columnArray, $whereArray, $otherArray);

        // 情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

}
?>