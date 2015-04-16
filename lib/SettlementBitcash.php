<?php
/**
 * SettlementBitcash.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  ビットキャッシュ決済クラス
 *  ビットキャッシュ決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SettlementBitcash extends Settlement {

    const BITCASH_SHOP_ID = "TOPA4681";
    const BITCASH_SHOP_PASS = "5SuPer71";
    const BITCASH_RATING = 99;
    const BITCASH_URL = "https://ssl.bitcash.co.jp/api/";


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
     * sendToBitcashメソッド
     *
     * bitcashサーバーと通信をする
     * ├カード認証
     * └決済実行
     *
     * @param array $orderingData 注文データ
     * @param string $card_number カード番号(ひらがな16文字)
     *
     * @return array $result ビットキャッシュからの戻り値
     *
     */
    function sendToBitcash($orderingData, $cardNumber) {

        if (!$orderingData OR !$cardNumber) {
            return FALSE;
        }

        $ComXmlRpcClientOBJ = new ComXmlRpcClient(self::BITCASH_URL);
        try {
            $ComXmlRpcClientOBJ->setSkipSystemLookup(true);
            $proxy = $ComXmlRpcClientOBJ->getProxy("Settlement");

            /* ■■■■■■■■■
             * バリデートロジック
             * ■■■■■■■■■
             * ビットキャッシュ側にカード、金額データを送信して
             * チェックを行う。
             */

            $validateParam["SHOP_ID"] = self::BITCASH_SHOP_ID;
            $validateParam["SHOP_PASSWD"] = self::BITCASH_SHOP_PASS;
            $validateParam["CARD_NUMBER"] = $cardNumber;
            $validateParam["RATING"] = self::BITCASH_RATING;
            $validateParam["PRICE"] = $orderingData["pay_total"];
            $validateParam["ORDER_ID"] = $orderingData["id"];
            $validateParam = Zend_XmlRpc_Value::getXmlRpcValue($validateParam, Zend_XmlRpc_Value::XMLRPC_TYPE_STRUCT);

            $validateResult = $proxy->validate_card($validateParam);

            if (!$validateResult) {
                $this->_errorMsg = "validate_card_false_result";
                return false;
            } else if ($validateResult["faultCode"]){
                $this->_errorMsg = "validate_card_fault_code";
                return false;
            }

            /* 返り値の取得
             *
             *
             * 1.ERRORの場合 例)カード情報が違う
             * Array
             *   ( [STATUS] => FAIL
             *     [ERROR]  => Array( [0] => 354:bad_card_number )
             *     [LOG_ID] => 43634282                            //バリデーション時の入出力ID
             *   )
             *
             * 2.OKの場合
             * Array
             *   ([BALANCE] => 100000     //バリデーション実行正常終了時のクレジット数（引き落とし前のクレジット数）
             *    [BCS_ID]  => 1581403990 //バリデーション正常終了時に発行されるセッション番号（決済実行時に使用）
             *    [ERROR]   => Array()
             *    [STATUS]  => OK
             *    [LOG_ID]  => 43634465   //バリデーション時の入出力ID
             *   )
             */

            // 有効ではない
            if ($validateResult["ERROR"]) {
                $this->_errorMsg = $validateResult["ERROR"][0];
                return false;
            }

            // 有効ではない
            if ("OK" != $validateResult["STATUS"]) {
                $this->_errorMsg = "validate_card_bad_status";
                return false;
            }

            /* ■■■■■■
             * 決済ロジック
             * ■■■■■■
             * STATUSがOKで帰ってきたらまたbitcashにデータの送信。決済を行う。
             */

            $param["SHOP_ID"] = self::BITCASH_SHOP_ID;
            $param["SHOP_PASSWD"] = self::BITCASH_SHOP_PASS;
            $param["CARD_NUMBER"] = $cardNumber;
            $param["BCS_ID"] = $validateResult["BCS_ID"];
            $param["PRICE"] = $orderingData["pay_total"];
            $param["ORDER_ID"] = $orderingData["id"];
            $param = Zend_XmlRpc_Value::getXmlRpcValue($param, Zend_XmlRpc_Value::XMLRPC_TYPE_STRUCT);

            $result = $proxy->do_settlement($param);

            if (!$result) {
                $this->_errorMsg = "do_settlement_false_result";
                return false;
            } else if ($result["faultCode"]) {
                $this->_errorMsg = "do_settlement_fault_code";
                return false;
            }

            /* 返り値の取得
             *
             * 1.ERRORの場合 例)BCS_ID(バリデート時に生成されるID)がない場合
             * Array
             *   ( [STATUS] => FAIL
             *     [ERROR] => Array([0] => 304:no_bcs_id)
             *     [LOG_ID] => 43641701                     //決済時の入出力ID
             *   )
             *
             * 2.OKの場合
             * Array
             *   ( [SALES_ID] => 28293032 //決済実行正常終了時の販売ID
             *     [BALANCE] => 99900     //決済実行正常終了時の残りクレジット数。
             *     [ERROR] => Array()
             *     [STATUS] => OK
             *     [LOG_ID] => 43641640   //決済時の入出力ID
             *   )
             */

            // 有効ではない
            if ($result["ERROR"]) {
                $this->_errorMsg = $result["ERROR"][0];
                return false;
            }

            // 有効ではない
            if ("OK" != $result["STATUS"]) {
                $this->_errorMsg = "do_settlement_bad_status";
                return false;
            }

            return $result;

        } catch (Zend_XmlRpc_Client_HttpException $e) {
            // HTTP通信エラー
            $SendMailOBJ = SendMail::getInstance();
            $mailElements["subject"] = "ビットキャッシュHTTP通信エラー";
            $mailElements["text_body"] = "注文ID:" . $orderingData["id"] . "\nカード番号:" . $cardNumber . "\n金額:" . $orderingData["pay_total"] . "\n" . $e;
            $SendMailOBJ->debugMailTo($mailElements);
            return FALSE;
        } catch (Zend_XmlRpc_Client_FaultException $e) {
            // RPC実行エラー
            $SendMailOBJ = SendMail::getInstance();
            $mailElements["subject"] = "ビットキャッシュRPC実行エラー";
            $mailElements["text_body"] = "注文ID:" . $orderingData["id"] . "\nカード番号:" . $cardNumber . "\n金額:" . $orderingData["pay_total"] . "\n" . $e;
            $SendMailOBJ->debugMailTo($mailElements);
            return FALSE;
        }
    }
}
?>