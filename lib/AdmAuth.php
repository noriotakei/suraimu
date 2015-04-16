<?php
/**
 * AdmAuth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側ユーザー認証を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AdmAuth extends ComCommon {

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
        $this->_authOBJ->setStorage(ComAuthMyStorage::getInstance());
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
     * @param  boolean $isHash パスワードがハッシュかどうか
     *
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function authentication($id = null, $password = null, $isHash = false) {

        // カレントユーザーが認証済みか？
        if (!$this->_authOBJ->hasIdentity()) {
            if (!$id OR !$password) {
                return FALSE;
            }

            if ($isHash) {
                $passwordKey = $password;
            } else {
                $passwordKey = AdmAdmin::createPasswordKey($password);
            }

            $adapter = new ComAuthAdapterDbTable($this->getDbObject(), "admin", "login_id", "password");
            $adapter->setIdentity($id)->setCredential($passwordKey);
            $select = $adapter->getDbSelect();
            $select->where("disable = 0");
            $select->limit(1);

            // 認証処理を実行
            $result = $this->_authOBJ->authenticate($adapter);

            if (!$result->isValid()) {
                return FALSE;
            } else {
                // 必要な情報をセッションに登録
                $this->_authOBJ->getStorage()->write($adapter->getResultRowObject(NULL, array("password", "disable")));
                return TRUE;
            }
        // 認証済み
        } else {
            return TRUE;
        }
    }

    /**
     * 媒体CHK認証処理を行う。
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function baitaiAuthentication($id = null, $password = null) {

        // カレントユーザーが認証済みか？
        if (!$this->_authOBJ->hasIdentity()) {
            if (!$id OR !$password) {
                return FALSE;
            }

            $passwordKey = AdmBaitai::createPasswordKey($password);

            $adapter = new ComAuthAdapterDbTable($this->getDbObject(), "baitai_admin", "login_id", "password");
            $adapter->setIdentity($id)->setCredential($passwordKey);
            $select = $adapter->getDbSelect();
            $select->where("disable = 0");
            $select->limit(1);

            // 認証処理を実行
            $result = $this->_authOBJ->authenticate($adapter);

            if (!$result->isValid()) {
                return FALSE;
            } else {
                // 必要な情報をセッションに登録
                $this->_authOBJ->getStorage()->write($adapter->getResultRowObject(NULL, array("password", "disable")));
                return TRUE;
            }
        // 認証済み
        } else {
            return TRUE;
        }
    }

    /**
     * 代理店用媒体CHK認証処理を行う。
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function baitaiAgencyAuthentication($id = null, $password = null, $ipAddress = null, $corporation = FALSE) {

        // カレントユーザーが認証済みか？
        if (!$this->_authOBJ->hasIdentity()) {
            if (!$id OR !$password) {
                return FALSE;
            }

            // 管理画面からのアクセスは、認証テーブル変更
            if ($corporation) {
                $authTableName = "baitai_agency_admin";
            } else {
                $authTableName = "baitai_agency_list";
            }

            $passwordKey = AdmBaitaiAgency::createPasswordKey($password);

            $adapter = new ComAuthAdapterDbTable($this->getDbObject(), $authTableName, "login_id", "password");
            $adapter->setIdentity($id)->setCredential($passwordKey);
            $select = $adapter->getDbSelect();
            $select->where($authTableName . ".disable = 0");
            $select->limit(1);

            // 認証処理を実行
            $result = $this->_authOBJ->authenticate($adapter);

            // 認証（ID・パス）がOKの場合
            if ($result->isValid()) {
                // 代理店の場合
                if (!$corporation) {
                    // 「IPアドレス認証する」の場合
                    if ($adapter->getResultRowObject()->is_auth_ip_address) {
                        // ログインデータの破棄
                        $this->_authOBJ->clearIdentity();
                        $result = $this->baitaiAgencyAuthenticationIpAddress($id, $password, $ipAddress);
                    }
                }
            } else {
                return FALSE;
            }

            if (!$result->isValid()) {
                return FALSE;
            } else {
                // 必要な情報をセッションに登録
                $this->_authOBJ->getStorage()->write($adapter->getResultRowObject(NULL, array("password", "disable")));
                return TRUE;
            }
        // 認証済み
        } else {
            return TRUE;
        }
    }

    /**
     * 代理店用媒体CHK認証処理を行う。
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @param  string $ipAddress IPアドレス
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function baitaiAgencyAuthenticationIpAddress($id = null, $password = null, $ipAddress = null) {

        if (!$id OR !$password OR !$ipAddress) {
            return FALSE;
        }

        $passwordKey = AdmBaitaiAgency::createPasswordKey($password);

        $adapter = new ComAuthAdapterDbTable($this->getDbObject(), "baitai_agency_list", "login_id", "password");
        $adapter->setIdentity($id)->setCredential($passwordKey);
        $select = $adapter->getDbSelect();
        $select->where("baitai_agency_list.disable = 0");
        $select->where("baitai_agency_list.is_auth_ip_address = 1");

        // テーブル結合↓
        $select->where("baitai_agency_list.id = baitai_agency_ip_address_setting.baitai_agency_id");
        $select->where("baitai_agency_ip_address_setting.ip_address = '" . $ipAddress . "'");
        $select->where("baitai_agency_ip_address_setting.is_use = 1");
        $select->where("baitai_agency_ip_address_setting.disable = 0");
        $select->from("baitai_agency_ip_address_setting");
        $select->limit(1);

        // 認証処理を実行
        $result = $this->_authOBJ->authenticate($adapter);

        return $result;
    }

    /**
     * 管理者用媒体CHK認証処理を行う。
     *
     * @param  integer $id ユーザーID
     * @param  string $password パスワード
     * @return boolean 認証成功ならtrue、失敗ならfalse
     */
    public function baitaiAgencyAdminAuthentication($id = null, $password = null) {

        // カレントユーザーが認証済みか？
        if (!$this->_authOBJ->hasIdentity()) {
            if (!$id OR !$password) {
                return FALSE;
            }

            $passwordKey = AdmBaitaiAgency::createPasswordKey($password);

            $adapter = new ComAuthAdapterDbTable($this->getDbObject(), "baitai_agency_admin", "login_id", "password");
            $adapter->setIdentity($id)->setCredential($passwordKey);
            $select = $adapter->getDbSelect();
            $select->where("disable = 0");

            /*
            // IPアドレスあればチェック
            if ($ipAddress) {
                $select->where("ip_address = '" . $ipAddress . "'");
            }
            */

            $select->limit(1);

            // 認証処理を実行
            $result = $this->_authOBJ->authenticate($adapter);

            if (!$result->isValid()) {
                return FALSE;
            } else {
                // 必要な情報をセッションに登録
                $this->_authOBJ->getStorage()->write($adapter->getResultRowObject(NULL, array("password", "disable")));
                return TRUE;
            }
        // 認証済み
        } else {
            return TRUE;
        }
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
     * ログアウト
     *
     * @return void
     */
    public function clearIdentity() {
        return $this->_authOBJ->clearIdentity();
    }
}

?>
