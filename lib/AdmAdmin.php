<?php
/**
 * AdmAdmin.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側ユーザー管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AdmAdmin extends ComCommon {

    /** @var array 管理ユーザー情報 */
    private $_adminData = null;

    /** @var array 管理ユーザーIDカラム名 */
    private $_idColumn = null;

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array 管理ユーザー検索種別 */
    static $_searchArray = array("0" => "一般");


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
     * 管理データ取得
     *
     * @return array
     */
    public function getAdminData() {
        return $this->_adminData;
    }

    /**
     * 管理ユーザー情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("admin", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return true;
    }

    /**
     * 管理ユーザー情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("admin", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return true;
    }

    /**
     * 管理ユーザー情報の取得。
     *
     * @param  integer $id ユーザーID
     * @return mixed ユーザー情報、失敗ならfalse
     */
    public function getData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("admin", $columnArray, $whereArray);

        // ログインユーザー情報をメンバ変数に格納
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }


    /**
     * 管理ユーザーログインID重複チェック。
     *
     * @param  integer $loginId ログインID
     * @param  integer $id 更新するID
     * @return boolean
     */
    public function duplicateLoginId($loginId, $id = null) {

        if (!$loginId) {
            return FALSE;
        }

        $columnArray[] = "id";

        // 更新するID以外を取得
        if ($id) {
            $whereArray[] = "id != " . $id;
        }
        $whereArray[] = "login_id = '" . $loginId . "'";
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("admin", $columnArray, $whereArray);

        // ログインユーザー情報をメンバ変数に格納
        if ($data = $this->executeQuery($sql, "fetchRow")) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    /**
     * 管理ユーザー情報リストの取得。
     *
     * @return mixed ユーザー情報リスト、失敗ならfalse
     */
    public function getList($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("admin", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            // ログインユーザー情報をメンバ変数に格納
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 管理ユーザー情報select用リストの取得。
     *
     * @return mixed ユーザー情報リスト、失敗ならfalse
     */
    public function getListForSelect($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("admin", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }

        return $dataArray;
    }

    /**
     *
     * $passwordKeyを返す。
     *
     * @param string $password キー生成に使用するパスワード
     *
     * @return string $passwordKey パスワードキー
     */
    public function createPasswordKey($password)  {
        if (!$password) {
            return false;
        }

        $passwordKey   = md5($password . "__" . $this->_configOBJ->define->PROJECT_NAME);

        return $passwordKey;
    }
}
?>
