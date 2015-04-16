<?php
/**
 * Auth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザー認証を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class Auth extends ComCommon {

    const ACCESS_KEY_NAME = "ack";

    /** @var object Configオブジェクト */
    protected $_configOBJ = null;

    /** @var object 認証オブジェクト */
    private $_authOBJ = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
        $this->_authOBJ = ComAuth::getInstance();
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
     * 認証処理を行う。
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function authentication($id = null, $password = null) {

        // カレントユーザーが認証済みか？
        if (!$this->_authOBJ->hasIdentity()) {
            if (!$id OR !$password) {
                return FALSE;
            }

            $adapter = new ComAuthAdapterDbTable($this->getDbObject(), "v_user_profile", "login_id", "password");
            $adapter->setIdentity($id)->setCredential($password);
            $select = $adapter->getDbSelect();
            $select->where("user_disable = 0");
            $select->where("regist_status NOT IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")");
            $select->where("danger_status = 0");
            $select->limit(1);

            // 認証処理を実行
            $result = $this->_authOBJ->authenticate($adapter);

            if (!$result->isValid()) {
                return FALSE;
            } else {
                // 必要な情報をセッションに登録
                $this->_authOBJ->getStorage()->write($adapter->getResultRowObject(NULL, array("password", "user_disable")));
                return TRUE;
            }
        // 認証済み
        } else {
            return TRUE;
        }
    }

    /**
     * 認証したデータを取得する
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function getUserData() {
        return $this->_authOBJ->getStorage()->read();
    }


    /**
     * アクセスキーで認証処理を行う
     *
     * @param  string $accessKey アクセスキー
     * @return array ユーザーデータ
     */
    public function authenticateAccesskey($accessKey) {

        if (!$accessKey) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "access_key = '" . $accessKey . "'";
        $whereArray[] = "regist_status NOT IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")";
        $whereArray[] = "user_disable = 0";
        $whereArray[] = "danger_status = 0";

        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        // ユーザー情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 個体識別で認証処理を行う
     *
     * @param  string $mbSerialNo 個体識別
     * @return array ユーザーデータ
     */
    public function authenticateMbSerialNo($mbSerialNo) {

        if (!$mbSerialNo) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "mb_serial_number = '" . $mbSerialNo . "'";
        $whereArray[] = "regist_status NOT IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")";
        $whereArray[] = "user_disable = 0";
        $whereArray[] = "danger_status = 0";

        $otherArray[] = "LIMIT 1";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        // ユーザー情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * ユーザー情報の取得
     *
     * @return mixed|null
     */
    public function getIdentity() {
        return $this->_authOBJ->getIdentity();
    }

    /**
     * ログイン情報破棄
     *
     * @return void
     */
    public function clearIdentity() {
        return $this->_authOBJ->clearIdentity();
    }

    /**
     *
     * ログアウト
     *
     * @return void
     */
    public function logout() {
        $this->clearIdentity();
        ComSession::expireSessionCookie();
        ComSession::forgetMe();
    }

}

?>
