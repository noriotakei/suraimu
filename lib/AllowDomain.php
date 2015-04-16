<?php
/*
 * Created on 2010/08/10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class AllowDomain extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    const GET_DOMAINLIST_URL = "http://blackhorse.fraise.jp/getDomainXml/";

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

    public function getNonAllowDomainList() {

        $columnArray[] = "domain";

        $whereArray[] = "is_deny = 1";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("allow_domain", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    public function getAllowDomainList($nonAllowDomain = null) {
        $columnArray[] = "domain";
        $whereArray[] = "is_deny = 0";
        $whereArray[] = "disable = 0";
        if($nonAllowDomain){
            $whereArray[] = "domain LIKE '%" . $nonAllowDomain . "'";
        }
        $sql = $this->makeSelectQuery("allow_domain", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     *
     * 非許可ドメインリストと正規表現にて照会
     *
     * @return array データ配列
     */
    public function searchNonAllowDomain($value) {

        if( !ComValidation::isMailAddress($value)) {
            return FALSE;
        }

        $dangerFlag = FALSE;
        $nonAllowDomainList = $this->getNonAllowDomainList();

        //非許可リストと照会します
        if($nonAllowDomainList){
            foreach($nonAllowDomainList as $nonAllowDomainData){
                if( (preg_match('/'.preg_quote($nonAllowDomainData['domain']).'$/',$value) == TRUE) ){
                    $dangerFlag = TRUE;
                    break;
                }
            }
        }
        //非許可に該当するなら、許可リストと照会します
        if($dangerFlag == TRUE){
            $allowDomainList = $this->getAllowDomainList();

            if($allowDomainList){
                foreach($allowDomainList as $allowDomainData){
                    if( (preg_match('/'.preg_quote($allowDomainData['domain']).'$/',$value) == TRUE) ){
                        $dangerFlag = FALSE;
                        break;
                    }
                }
            }
        }

        return $dangerFlag;
    }

    /**
     * ドメインリストデータの登録
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$this->insert("allow_domain", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return TRUE;
    }

    /**
     *
     * ドメインリストデータの更新処理
     *
     * @return array データ配列
     */
    public function updateData($updateArray, $whereArray=null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("allow_domain", $updateArray, $whereArray)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 許可ドメインの重複チェック
     *
     * @param  integer $domain ドメイン
     * @param  integer $id 許可フラグ
     * @return boolean
     */
    public function duplicateDomainData($domain, $isDeny) {
        if (!$domain || !is_numeric($isDeny)) {
            return FALSE;
        }

        $whereArray[] = "domain = '" . $domain . "'";
        $whereArray[] = "is_deny = " . $isDeny;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("allow_domain", array("*"), $whereArray);

        if ($data = $this->executeQuery($sql, "fetchRow")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
?>
