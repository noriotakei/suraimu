<?php
/**
 * ComDb.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * データベースアクセスクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once("Zend/Db.php");

class ComDb extends Zend_Db {

    /** @var object 設定データオブジェクト */
    private $_configOBJ = null;

    /** @var object 設定データオブジェクト */
    protected $_dbOBJ = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array SQL文デバッグ出力用配列 */
    private $_debugSql = array();

    /** @var array SQL文デバッグ出力フラグ */
    private $_debugFlag = true;

    /**
     * コンストラクタ
     */
    public function __construct() {

        try {

            // 設定データのインスタンスを取得
            $this->_configOBJ = ComConfig::getInstance();
            $this->_dbOBJ = self::factory($this->_configOBJ->define->DATABASE);
            //接続が切れていたら再接続
            $this->reConnection();

        // 接続できなければ終了する
        } catch (Zend_Exception $e) {
            exit($e->getMessage());
        }

        return true;
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
     * DBオブジェクトの取得
     *
     * @return object
     */
    public function getDbObject(){
        return $this->_dbOBJ;
    }

    /**
     * 定義されていないメソッドの場合、zend_DBメソッドを読み込む
     *
     * @return mixed
     */
    public function __call($name, $var) {
        return call_user_func_array(array($this->_dbOBJ , $name), $var);
    }


    /**
     * 直近のSQL_CULC_FOUND_ROWS指定クエリ結果レコード数を取得。
     *
     * @return mixed 成功ならレコード数、失敗ならfalse
     */
    public function getFoundRows(){

        $sql = "SELECT FOUND_ROWS()";

        $foundRows = self::executeQuery($sql, "fetchOne");

        return $foundRows;
    }

    /**
     * デストラクタ
     */
    public function __destruct() {
        // デバッグ用SQL文の表示
        self::outputDebugSql();
        // データベース接続の切断
        $this->_dbOBJ->closeConnection();
    }

    /**
     * DB再接続
     */
    public function reConnection() {

            // 接続確認できなければ、再接続
            if (!$this->_dbOBJ->getConnection()->ping()) {
                // データベース接続の切断
                $this->_dbOBJ->closeConnection();
                $this->_dbOBJ = self::factory($this->_configOBJ->define->DATABASE);
            }
    }

    /**
     * デバッグ用にSQL文を表示する。
     *
     * @return boolean
     */
    private function outputDebugSql() {

        if (!($this->_debugFlag && count($this->_debugSql) && $_SERVER["REMOTE_ADDR"] == $this->_configOBJ->define->SYSTEM_IP_ADDRESS)) {
            return false;
        }

        foreach ($this->_debugSql as $val) {
            print("<!-- /* " . $val . " */ -->\n");
        }

        return true;
    }

     /**
     * SQLクエリを発行する。
     *
     * @param  string $queryString クエリ文字列
     * @param  string $fetchMethod フェッチメソッド
     *
     * @return mixed フェッチメソッドがfetch,fetchAllならオブジェクト、それ以外ならデータ配列を返す
     */
    public function executeQuery($queryString, $fetchMethod = null) {

        if (!$queryString) {
            return FALSE;
        }

        //接続が切れていたら再接続
        $this->reConnection();

        try {
            // プロファイラの取得
            $profOBJ = $this->_dbOBJ->getProfiler();

            // クエリの発行処理
            switch ($fetchMethod) {
                case "fetchRow":
                case "fetchOne":
                case "fetchCol":
                case "fetchPairs":
                    $resultSet = self::$fetchMethod($queryString);
                    break;
                default:
                    $resultSet = $this->_dbOBJ->query($queryString);
                    break;
            }

            // 最後のクエリのプロファイラの取得
            $lastQueryProfOBJ = $profOBJ->getLastQueryProfile();

            $requestOBJ = ComRequest::getInstance();
            $actionName = $requestOBJ->getActionName();

            // クエリ結果が返ってきた場合
            if ($resultSet) {
                if ($actionName != "user_convertCsvExec") {
                    // 出力用クエリログの格納 ※競馬間コンバートの場合は不要
                    self::setDebugSql($lastQueryProfOBJ, debug_backtrace());
                }
                return $resultSet;
            } else {
                return FALSE;
            }
        // クエリ結果が返らない場合
        } catch (Zend_Db_Statement_Exception $e) {
            $this->_errorMessage = mb_convert_encoding($e->getMessage() . "<br />SQL:" . $queryString, "UTF-8", "auto");
            exit($this->_errorMessage);
        // クエリ結果が返らない場合以外の例外
        } catch (Zend_Exception $e) {
            exit($e->getMessage());
        }

    }

    /**
     * デバッグフラグを変更
     *
     * @param  boolean true or false
     *
     */
    public function setDebugFlag($flag) {
        $this->_debugFlag = $flag;
    }

    /**
     * デバッグ用にSQL文をメンバ変数に格納
     *
     * @param  object $lastQueryProfOBJ クエリ処理時間
     * @param  array $traceArray クエリ発行元データ配列
     * @param  string $sql クエリ文字列
     * @return boolean
     */
    private function setDebugSql($lastQueryProfOBJ, $traceArray) {

        if (!$lastQueryProfOBJ || !$traceArray) {
            return FALSE;
        }

        $this->_debugSql[] = $lastQueryProfOBJ->getElapsedSecs() . "sec : " . $lastQueryProfOBJ->getQuery() . " in "
                           . $traceArray[0]["file"] . " on line " . $traceArray[0]["line"];

        return true;
    }

    /**
     * 指定テーブルの抽出クエリを生成する。
     *
     * @param  string $tableName テーブル名
     * @param  array $columnArray 取得カラム配列
     * @param  array $whereArray 抽出条件配列
     * @param  array $otherArray その他の指定配列
     * @return mixed 抽出SQL文字列、失敗時はfalse
     */
    public function makeSelectQuery($tableName , $columnArray , $whereArray = null, $otherArray = null) {

        if (!$tableName) {
            return false;
        }

        if (is_array($columnArray)) {
            // 取得カラムの指定
            $column = implode(", ", $columnArray);
        } else {
            return false;
        }

        if ($whereArray) {
            if (is_array($whereArray)) {
                // 抽出条件の指定
                $where  = " WHERE " . implode(" AND ", $whereArray) . " ";
            } else {
                return false;
            }
        }

        if ($otherArray) {
            if (is_array($otherArray)) {
                // 抽出条件の指定
                $other  = " " . implode(" ", $otherArray);
            } else {
                return false;
            }
        }

        // 抽出クエリの生成
        $selectQuery = "SELECT " . $column . " FROM ". $tableName . $where . $other;

        return $selectQuery;
    }

    /**
     * フェッチモードの設定
     *
     * @param $mode フェッチモード デフォルトはFETCH_ASSOC
     *        self::FETCH_ASSOC 連想配列
     *        self::FETCH_NAMED 連想配列(重複キーは入れ子の配列で返す)
     *        self::FETCH_BOUND フェッチした各フィールド値をbindColumnメソッドであらかじめマッピングされた変数にセットする
     *        self::FETCH_NUM   通常配列
     *        self::FETCH_BOTH  通常/連想配列
     *        self::FETCH_OBJ   オブジェクト
     *        self::FETCH_LAZY  FETCH_BOTH + FETCH_OBJの組合せ
     * @return boolean
     */
    public function setFetchMode($mode) {
        return $this->_dbOBJ->setFetchMode($mode);
    }

    /**
     * クエリ結果を1行返す。
     *
     * @param $sttOBJ Db_Statementオブジェクト
     * @param $mode フェッチモード デフォルトはFETCH_ASSOC
     *        self::FETCH_ASSOC 連想配列
     *        self::FETCH_NAMED 連想配列(重複キーは入れ子の配列で返す)
     *        self::FETCH_BOUND フェッチした各フィールド値をbindColumnメソッドであらかじめマッピングされた変数にセットする
     *        self::FETCH_NUM   通常配列
     *        self::FETCH_BOTH  通常/連想配列
     *        self::FETCH_OBJ   オブジェクト
     *        self::FETCH_LAZY  FETCH_BOTH + FETCH_OBJの組合せ
     * @return array
     */
    public function fetch($sttOBJ, $mode = null) {
        if (!$sttOBJ) {
            return FALSE;
        }
        return $sttOBJ->fetch($mode);
    }

    /**
     * クエリ結果全体をまとめて連想配列で返す。
     * setFetchModeでフェッチモードの変更が可能
     *
     * @param $sttOBJ Db_Statementオブジェクト
     * @param $mode
     *        self::FETCH_ASSOC 連想配列
     *        self::FETCH_NAMED 連想配列(重複キーは入れ子の配列で返す)
     *        self::FETCH_BOUND フェッチした各フィールド値をbindColumnメソッドであらかじめマッピングされた変数にセットする
     *        self::FETCH_NUM   通常配列
     *        self::FETCH_BOTH  通常/連想配列
     *        self::FETCH_OBJ   オブジェクト
     *        self::FETCH_LAZY  FETCH_BOTH + FETCH_OBJの組合せ
     *        (self::FETCH::COLUMN, 行番号)  // 取得行の指定
     *        self::FETCH::COLUMNと組み合わせ
     *        (self::FETCH::COLUMN|self::FETCH::UNIQUE, 行番号) // 先頭行をキーに指定された行が値となる連想配列
     *        (self::FETCH::COLUMN|self::FETCH::GROUP, 行番号)  // 先頭行をキーに指定された行が値となる連想配列(重複キーは入れ子の配列として返す)
     * @return array
     */
    public function fetchAll($sttOBJ, $mode = null) {
        if (!$sttOBJ) {
            return FALSE;
        }
        return $sttOBJ->fetchAll($mode);
    }

    /**
     * クエリ結果の先頭行のみ返す。
     * setFetchModeでフェッチモードの変更が可能
     *
     * @param $queryString クエリ文字列
     *
     * @return array
     */
    public function fetchRow($queryString) {
        if (!$queryString) {
            return FALSE;
        }
        return $this->_dbOBJ->fetchRow($queryString);
    }

    /**
     * クエリ結果の先頭行/先頭列の値を返す。
     *
     * @param $queryString クエリ文字列
     *
     * @return string
     */
    public function fetchOne($queryString) {
        if (!$queryString) {
            return FALSE;
        }
        return $this->_dbOBJ->fetchOne($queryString);
    }

    /**
     * クエリ結果の先頭列のみ返す。
     *
     * @param $queryString クエリ文字列
     *
     * @return array
     */
    public function fetchCol($queryString) {
        if (!$queryString) {
            return FALSE;
        }
        return $this->_dbOBJ->fetchRow($queryString);
    }

    /**
     * クエリ結果の特定の2列を、キー/値の連想配列として返す。
     *
     * @param $queryString クエリ文字列
     *
     * @return array
     */
    public function fetchPairs($queryString) {
        if (!$queryString) {
            return FALSE;
        }
        return $this->_dbOBJ->fetchPairs($queryString);
    }


    /**
     * 直近のINSERTによるオートインクリメントIDを取得する。
     *
     * @return array 成功ならID、失敗ならfalseを返す
     */
    public function getInsertId() {
        return $this->_dbOBJ->lastInsertId();
    }

    /**
     * 直近のクエリにより変更されたレコード数を取得。
     *
     * @return array 成功ならレコード数、失敗なら-1を返す
     */
    public function getNumRows($sttOBJ) {
        if (!$sttOBJ) {
            return FALSE;
        }
        return $sttOBJ->rowCount();
    }

    /**
     * 指定テーブルへレコードを挿入する。
     *
     * @param  string $tableName テーブル名
     * @param  array $insertAry 挿入データ配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     * @param  array $paramAry プレイスホルダ用挿入データ配列
     * @return boolean
     */
    public function insert($tableName , $insertAry, $autoQuotes = true){

        if (!$tableName || !is_array($insertAry)) {
            return false;
        }

        foreach ($insertAry as $key => $value) {
            $columnNameAry[] = $key;
            if ($autoQuotes) {
                $columnValueAry[] = "'" . $value . "'";
            } else {
                $columnValueAry[] = $value;
            }
        }

        $sql = "INSERT INTO " . $tableName . " "
             . "(" . implode(",", $columnNameAry) . ") "
             . "VALUES "
             . "(" . implode(",", $columnValueAry) . ") ";

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            return $dbResultOBJ;
        } else {
            return FALSE;
        }
    }

    /**
     * 指定テーブルへ抽出したレコードを挿入する。
     *
     * @param  string $tableName テーブル名
     * @param  array $insertColumnArray 挿入カラム
     * @param  array $selectString select 文
     * @return boolean
     */
    public function insertSelect($tableName , $insertColumnArray, $selectString) {

        if (!$tableName || !is_array($insertColumnArray) || !$selectString) {
            return false;
        }

        $sql = "INSERT INTO " . $tableName . " "
             . "(" . implode(",", $insertColumnArray) . ") "
             . $selectString;

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            return $dbResultOBJ;
        } else {
            return FALSE;
        }
    }

    /**
     * 指定テーブルへレコードをデータが無ければ挿入、データがあれば更新する。
     *
     * @param  string $tableName テーブル名
     * @param  array $insertAry 挿入データ配列
     * @param  array $updateAry 更新データ配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     * @param  array $paramAry プレイスホルダ用挿入データ配列
     * @return boolean
     */
    public function insertDuplicate($tableName , $insertAry, $updateAry, $autoQuotes = true){

        if (!$tableName || !is_array($insertAry)) {
            return false;
        }

        foreach ($insertAry as $key => $value) {
            $columnNameAry[] = $key;
            if ($autoQuotes) {
                $columnValueAry[] = "'" . $value . "'";
            } else {
                $columnValueAry[] = $value;
            }
        }

        foreach ($updateAry as $key => $value) {
            if ($autoQuotes) {
                $updateColumns[] = $key . "='" . $value . "'";
            } else {
                $updateColumns[] = $key . "=" . $value;
            }
        }

        $updateColumns = implode(", " , $updateColumns);

        $sql = "INSERT INTO " . $tableName . " "
             . "(" . implode(",", $columnNameAry) . ") "
             . "VALUES "
             . "(" . implode(",", $columnValueAry) . ") "
             . "ON DUPLICATE KEY UPDATE " . $updateColumns;

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            return $dbResultOBJ;
        } else {
            return FALSE;
        }
    }


    /**
     * 指定テーブルのレコードを更新する。
     *
     * @param  string $tableName テーブル名
     * @param  array $updateAry 更新データ配列
     * @param  array $whereAry 抽出条件配列
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ*
     * @param  array $paramAry プレイスホルダ用挿入データ配列
     * @return boolean
     */
    public function update($tableName , $updateAry, $whereAry = null, $autoQuotes = true){

        if (!$tableName || !is_array($updateAry)) {
            return false;
        }

        foreach ($updateAry as $key => $value) {
            if ($autoQuotes) {
                $columns[] = $key . "='" . $value . "'";
            } else {
                $columns[] = $key . "=" . $value;
            }

        }

        $columns = implode(", " , $columns);

        if ($whereAry) {
            if (is_array($whereAry)) {
                // 抽出条件の指定
                $where  = " WHERE " . implode(" AND ", $whereAry);
            } else {
                return false;
            }
        }

        $sql = "UPDATE " . $tableName . " "
             . "SET " . $columns . $where;

        if ($dbResultOBJ = $this->executeQuery($sql)) {

            return $dbResultOBJ;
        } else {
            return FALSE;
        }

    }


    /**
     * 指定テーブルのレコードを削除する。
     *
     * @param  string $tableName テーブル名
     * @param  array $whereAry 抽出条件配列
     * @return boolean
     */
    public function delete($tableName , $whereAry = null){

        if (!$tableName) {
            return false;
        }

        if ($whereAry) {
            if (is_array($whereAry)) {
                // 抽出条件の指定
                $where  = " WHERE " . implode(" AND ", $whereAry);
            } else {
                return false;
            }
        }

        $sql = "DELETE FROM " . $tableName . $where;

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            return $dbResultOBJ;
        } else {
            return FALSE;
        }

        return true;
    }


    /**
     * トランザクションを開始する。
     *
     * @return boolean
     */
    public function beginTransaction() {
        return $this->_dbOBJ->beginTransaction();
    }

    /**
     * トランザクションをロールバックする。
     *
     * @return boolean
     */
    public function rollbackTransaction() {
        return $this->_dbOBJ->rollback();
    }

    /**
     * トランザクションをコミットする。
     *
     * @return boolean
     */
    public function commitTransaction() {
        return $this->_dbOBJ->commit();
    }
}

