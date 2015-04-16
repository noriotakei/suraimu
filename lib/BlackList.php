<?php
/*
 * Created on 2010/08/10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class BlackList extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    const GET_BLACKLIST_URL = "http://blackhorse.fraise.jp/getXml/";

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
     * 現行ブラックリストデータの取得(全部)
     *
     * @return array データ配列
     */
    public function getBlackListAll() {

        $columnArray = array("mail_address", "mb_contract_id");

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("black_user", $columnArray, $whereArray);

        $resultArray = $this->executeQuery($sql, "fetchRow");
        $blackUserData = array();

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;

    }


    /**
     * ブラックリストデータの登録
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$this->insert("black_user", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return TRUE;
    }



    /**
     *
     * ブラックリストデータの更新処理
     *
     * @return array データ配列
     */
    public function updateData($updateArray, $whereArray=null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("black_user", $updateArray, $whereArray)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * ｱﾄﾞﾚｽより該当情報取得(1件しかないはずですが一応最新を)
     *
     * @param varchar $address ｱﾄﾞﾚｽ（PC、MB問わず)
     * @return array
     */
    public function searchBlackListByAddress($address) {

        //値チェック
        if (!ComValidation::isValue($address)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";
        $whereArray[] = "mail_address = '".$address."'";
        $otherArray[] = "ORDER BY update_datetime DESC LIMIT 1";


        $sql = $this->makeSelectQuery("black_user", $columnArray, $whereArray,$otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 個体識別値より該当情報取得(1件しかないはずですが一応最新を)
     *
     * @param varchar $mbSerialNumber 個体識別値
     * @return array
     */
    public function searchBlackListByMbSerialNumber($mbSerialNumber) {

        //値チェック
        if (!ComValidation::isValue($mbSerialNumber)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";
        $whereArray[] = "mb_contract_id = '".$mbSerialNumber."'";
        $otherArray[] = "ORDER BY update_datetime DESC LIMIT 1";


        $sql = $this->makeSelectQuery("black_user", $columnArray, $whereArray,$otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * ブラックサーバから削除されたブラックユーザは正常に戻す
     *
     * @param   array   $newBlackUserList ユーザID
     * @return  boolean TRUE:成功 FALSE:失敗
     *
     */
    public function updateUserNormal($newBlackUserList=null) {

        $updateArray = array("danger_status" => $this->_configOBJ->define->FALSE
                             ,"update_datetime" => date("Y-m-d H:i:s")
                            );
        //値チェック
        if (ComValidation::isValue($newBlackUserList)) {
            $userIdList = implode(",", $newBlackUserList);
            $whereArray[]  = "danger_status = ".$this->_configOBJ->define->TRUE." AND id NOT IN (" . $userIdList . ")";
        }else{
            $whereArray[]  = "danger_status = ".$this->_configOBJ->define->TRUE;
        }

        if (!$dbResultOBJ = $this->update("user", $updateArray, $whereArray)) {
            return FALSE;
        }

        return $dbResultOBJ;

    }

}
?>
