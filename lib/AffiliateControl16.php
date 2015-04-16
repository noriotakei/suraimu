<?php
/**
 * AffiliateControl.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側アフィリエイト管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AffiliateControl16 extends ComCommon {

    // 送信種別
    const SEND_TYPE_PRE_REGIST = 0; // 仮登録時発行
    const SEND_TYPE_REGIST = 1; // 本登録時発行

    // 発行種別
    const CONNECT_TYPE_SOCKET = 0; // ソケット通信
    const CONNECT_TYPE_IMG = 1; // イメージタグ

    const ROUTES_CD_LENGTH = 16; // ルーツコード桁数

    /** @var array 送信種別配列 */
    public static $_sendType = array(
                    self::SEND_TYPE_PRE_REGIST => "仮登録時発行",
                    self::SEND_TYPE_REGIST => "本登録時発行",
                  );

    /** @var array 発行種別配列 */
    public static $_connectType = array(
                    self::CONNECT_TYPE_SOCKET => "ソケット通信",
                    self::CONNECT_TYPE_IMG => "イメージタグ",
                  );

    /* 登録フラグ */
    public static $_isPreRegist = array(
                                    "1" => "仮登録フロー",
                                    "0" => "本登録フロー",
                                );

    /* 登録成功時のみ送信設定 */
    public static $_isSuccessOnly = array(
                                    "1" => "登録成功時のみ送信",
                                );

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string imgタグを保持する変数 */
    protected $_imgTag = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
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
     * アフィリエイト情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("affiliate16", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * アフィリエイト情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("affiliate16", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * アフィリエイト情報の取得。
     *
     * @param  integer $id アフィリエイトID
     * @return mixed アフィリエイト情報、失敗ならfalse
     */
    public function getAffiliateData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("affiliate16", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     * アフィリエイト情報リストの取得。
     *
     * @param  array $whereArray 条件
     * @param  string $order 順序
     * @param  integer $limit 取得数
     *
     * @return mixed アフィリエイト情報リスト、失敗ならfalse
     */
    public function getAffiliateList($whereArray = "", $order = "", $limit = "") {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }

        if (ComValidation::isNumeric($limit)) {
            $otherArray[] = " LIMIT " . $limit;
        }

        $sql = $this->makeSelectQuery("affiliate16", $columnArray, $whereArray, $otherArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * アフィリエイトデータの検索。
     *
     * @param  array $whereArray 条件
     *
     * @return mixed アフィリエイト情報リスト、失敗ならfalse
     */
    public function getSearchAffiliateData($whereArray = "") {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $otherArray[] = " ORDER BY id DESC";
        $otherArray[] = " LIMIT 1";

        $sql = $this->makeSelectQuery("affiliate16", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 広告コードからアフィリエイトデータの検索。
     *
     * @param  string $advCd 広告コード
     * @param interger $sendType 送信種別
     *
     * @return mixed アフィリエイト情報リスト、失敗ならfalse
     */
    public function getAffiliateDataFromAdvcd($advCd, $sendType = "") {

        if (!$advCd) {
            return FALSE;
        }

        // メディアコード後方一致で検索(純広用)
        //ここは編集の必要があるかも。純広は7桁で渡ってくる。
        //7桁で渡ってくるのであればこのファイルを読み込まないので、純広用の処理は必要ないかも。
        $mediaCd = substr($advCd, 10, 6);
        $whereArray[] = "media_cd like '%" . $mediaCd . "'";
        if (is_numeric($sendType)) {
            $whereArray[] = "send_type = " . $sendType;
        }
        $affiliateData = $this->getSearchAffiliateData($whereArray);

        // なければ前方一致で検索
        if (!$affiliateData) {
            $whereArray = "";

            // 自社ポータルは16桁ルールになって前方三文字がサイト識別コード
            $advKeyCd = substr($advCd, 0, 3);

            //$whereArray[] = "media_cd LIKE '" . $advKeyCd . "%'";
            $whereArray[] = "media_cd = '" . $advKeyCd . "'";
            if (is_numeric($sendType)) {
                $whereArray[] = "send_type = " . $sendType;
            }
            $affiliateData = $this->getSearchAffiliateData($whereArray);
        }

        return $affiliateData;
    }

    /**
     * sendAffiliateDataメソッド
     *
     * アフィリエイトデータを送信。
     *
     * @param interger $userId ユーザーID
     * @param array $aryAffiliateValue QUERY_STRINGの配列
     * @param interger $sendType 送信種別
     * @param interger $isSuccess 成功タグか失敗タグか
     * @return boolean
     *
     */
    public function sendAffiliateData($userId, $aryAffiliateValue, $sendType, $isSuccess = true) {

        if (!$aryAffiliateValue OR !$aryAffiliateValue["advcd"]) {
            return FALSE;
        }

        $UserOBJ = User::getInstance();
        $userData =$UserOBJ->getUserData($userId);
        if (!$userData) {
            return FALSE;
        }

        // 過去に登録済みか
        if ($userData["pc_address"] AND $UserOBJ->chkUserDataFromPcMailAddressDuplication($userData["pc_address"], $userId)) {
            return FALSE;
        } else if ($userData["mb_serial_number"] AND $UserOBJ->chkUserDataFromMbSerialNumberDuplication($userData["mb_serial_number"], $userId)) {
            return FALSE;
        }

        // アフィリエイトデータの取得
        $affiliateData = $this->getAffiliateDataFromAdvcd($aryAffiliateValue["advcd"], $sendType);
        // 成功時のみ発行の場合は失敗ならfalseを返す
        if (!$affiliateData OR !$affiliateData["path"] OR ($affiliateData["is_success_only"] AND !$isSuccess)) {

            return FALSE;
        }

        $url = $affiliateData["path"];

        if (!$aryAffiliateValue["from_first_payment"]) {
            // 成功パラメータを設定する
            if ($isSuccess AND $affiliateData["success_parameter"]) {
                $url .= (strpos($url, "?") ? "&" . $affiliateData["success_parameter"] : "?" . $affiliateData["success_parameter"]);
            // 失敗パラメータを設定する
            } else if ($affiliateData["failure_parameter"]) {
                $url .= (strpos($url, "?") ? "&" . $affiliateData["failure_parameter"] : "?" . $affiliateData["failure_parameter"]);
            }
        } else {
            // 初入金パラメータを設定する
            if ($affiliateData["first_payment_parameter"]) {
                $url .= (strpos($url, "?") ? "&" . $affiliateData["first_payment_parameter"] : "?" . $affiliateData["first_payment_parameter"]);
                $setUserParam["affiliate_tag_first_payment_status"] = 1;
            } else {
            	return FALSE;
            }
        }

        // メールアドレス変数を作成する
        $userData["mail_address"] = $userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"];

        // アドレス(「.」を「_」に変換)変数を作成する
        $userData["dot_address"] = str_replace(".","_",rawurlencode($userData["mail_address"]));

        $returnValue = explode(",", $affiliateData["return_variable"]);
        $changeValue = explode(",", $affiliateData["change_variable"]);

        // 情報を変換する
        foreach ($returnValue as $key => $val) {
            if (!$affiliateData["connect_type"] == self::CONNECT_TYPE_IMG) {
                $getData[] =  $val . "=" . ($aryAffiliateValue[$changeValue[$key]] ?  $aryAffiliateValue[$changeValue[$key]] : $userData[$changeValue[$key]]);
            } else {
                if ($aryAffiliateValue[$changeValue[$key]]) {
                    $affiliateValue = $aryAffiliateValue[$changeValue[$key]];
                } elseif ($userData[$changeValue[$key]]) {
                    $affiliateValue = $userData[$changeValue[$key]];
                } else {
                    $affiliateValue = $changeValue[$key];
                }
                $getData[] =  $val . "=" . $affiliateValue;
            }
        }

        $url = $url . (strpos($url, "?") ? "&" . implode("&" , $getData) : "?" . implode("&" , $getData));

        // タグのデコードをする
        $url = htmlspecialchars_decode($url, ENT_QUOTES);

        $httpParam = array (
                    "maxredirects" => 1,
                    "timeout" => 30,
                );

        if ($affiliateData["connect_type"] == self::CONNECT_TYPE_SOCKET) {

            // 「初入金時」は更新カラム変更
            if (!$aryAffiliateValue["from_first_payment"]) {
                $setUserParam["affiliate_tag_url"] = htmlspecialchars($url, ENT_QUOTES);
            } else {
                $setUserParam["affiliate_tag_first_payment_url"] = htmlspecialchars($url, ENT_QUOTES);
            }

            $setUserParam["update_datetime"] = date("Y-m-d H:i:s");

            $userWhere[] = "id = " . $userId;
            try {
                // ソケット通信
                $ComHttpOBJ = new ComHttp($url, $httpParam);
                $result = $ComHttpOBJ->request("GET");

                if ($result->isSuccessful()) {
                    // 「初入金時」は更新カラム変更
                    if (!$aryAffiliateValue["from_first_payment"]) {
                        $setUserParam["affiliate_tag_status"] = 1;
                    } else {
                        $setUserParam["affiliate_tag_first_payment_status"] = 1;
                    }
                } else {
                    $SendMailOBJ = SendMail::getInstance();
                    $mailElements["subject"] = "アフィリエイトソケット通信エラー";
                    $mailElements["text_body"] = "ユーザーID：" . $userId . "\nurl：" . $url . "\n\n" . $result->getMessage();
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($mailElements);
                    // 運営にエラーメール
                    $SendMailOBJ->operationMailTo($mailElements);
                }
            } catch (Exception $e) {
                $SendMailOBJ = SendMail::getInstance();
                $mailElements["subject"] = "アフィリエイトソケット通信エラー";
                $mailElements["text_body"] = "ユーザーID：" . $userId . "\nurl：" . $url . "\n\n" . $e->getMessage();
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);
            }
            if ($userId) {
                if(!$UserOBJ->updateUserData($setUserParam, $userWhere)) {
                    $this->_errorMsg[] = "データ更新できませんでした。";
                    return FALSE ;
                }
            }
            return TRUE;
        } else if ($affiliateData["connect_type"] == self::CONNECT_TYPE_IMG) {

            // アドレス部分をURLエンコードした値に置換
            $address = $userData["dot_address"];
            $encodeAddress = urlencode($address);

            $url = str_replace($address, $encodeAddress, $url);

            $this->_imgTag = "<img src=\"" . $url . "\" width=\"1\" height=\"1\">";

            // DB格納する前にURLデコード
            //$tag = urldecode($this->_imgTag);

            // 「初入金時」は更新カラム変更
            if (!$aryAffiliateValue["from_first_payment"]) {
                $setUserParam["affiliate_tag_url"] = htmlspecialchars($this->_imgTag, ENT_QUOTES);
                $setUserParam["affiliate_tag_status"] = 1;
            } else {
                $setUserParam["affiliate_tag_first_payment_url"] = htmlspecialchars($this->_imgTag, ENT_QUOTES);
                $setUserParam["affiliate_tag_first_payment_status"] = 1;
            }

            $setUserParam["update_datetime"] = date("Y-m-d H:i:s");

            $userWhere[] = "id = " . $userId;

            if ($userId) {
                if(!$UserOBJ->updateUserData($setUserParam, $userWhere)) {
                    $this->_errorMsg[] = "データ更新できませんでした。";

                    return FALSE ;
                }
            }
            return TRUE;
        }
    }

    /**
     * imgタグの取得。
     *
     * @return string imgタグ
     */
    public function getImgTag() {
        return $this->_imgTag;
    }
}

?>
