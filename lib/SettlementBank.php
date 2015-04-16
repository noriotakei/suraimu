<?php
/**
 * SettlementBank.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  銀行振込決済クラス
 *   銀行振込決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class SettlementBank extends Settlement {

    const BANK_NAME = "楽天銀行";
    const BRANCH_NAME = "第一営業支店（251）";
    const ACCOUNT_NUMBER = "普）7115544";
    const TRANSFER_DESTINATION = "カ）メイ";

    const RAKUTEN_BANK_NAME = "楽天銀行";
    const RAKUTEN_BRANCH_NAME = "******支店";
    const RAKUTEN_ACCOUNT_NUMBER = "普)*******";
    const RAKUTEN_TRANSFER_DESTINATION = "カ）トツプ";

    //const NET_BANK_URL = "https://credit.zeroweb.ne.jp/cgi-bin/ebank.cgi";
    const NET_BANK_URL = "https://gw.axes-payment.com/cgi-bin/ebank.cgi";

    const NET_BANK_CLIENT_IP_PC = "1081000417";
    const NET_BANK_CLIENT_IP_MB = "1081000275";

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
     * ネットバンクhiddenタグの取得
     *
     * @param  array $orderingData 注文データ配列
     * @param  array $userData ユーザーデータ配列
     * @param  boolean $isMobile モバイル決済かどうか
     * @param  srting $sessionId セッション名とセッションIDの文字列 (例: PHPSESSID=s8f42324d3123r324r1)
     *
     * @return array データ配列
     */
    public function getNetBankHiddenTag($orderingData, $userData, $isMobile, $sessionId = "") {

        if (!$orderingData OR !$userData) {
            return FALSE;
        }

        if ($isMobile) {
             if (!$sessionId) {
                return FALSE;
            }
            $mailAddress = $userData["mb_address"] ? $userData["mb_address"] : $userData["pc_address"];
            $siteUrl = $this->_configOBJ->define->SITE_URL_MOBILE . "?action_Home=1&" . $sessionId;
            $netBankHiddenTag["act"] = "mobile_order";
            $netBankHiddenTag["clientip"] = self::NET_BANK_CLIENT_IP_MB;
        } else {
            $mailAddress = $userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"];
            $siteUrl = $this->_configOBJ->define->SITE_URL . "?action_Home=1";
            $netBankHiddenTag["act"] = "order";
            $netBankHiddenTag["clientip"] = self::NET_BANK_CLIENT_IP_PC;
        }

        //ネットバンク用リンクの生成

        $netBankHiddenTag["money"] = $orderingData["pay_total"];
        $netBankHiddenTag["email"] = $mailAddress;
        $netBankHiddenTag["sendid"] = $userData["user_id"];
        $netBankHiddenTag["sendpoint"] = $orderingData["id"];
        // ネットバンク側で文字化けするためコメントアウト
        //$netBankHiddenTag["siteurl"] = $siteUrl;
        //$netBankHiddenTag["sitestr"] = $this->_configOBJ->define->SITE_NAME . "へ戻る";

        return $netBankHiddenTag;

    }

    /**
     * 銀行振り込みログ情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertBasLogData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("bas_log", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 銀行振り込みログの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateBasLogData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("bas_log", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }
}
?>