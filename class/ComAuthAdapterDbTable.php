<?php

/**
 * ComAuth.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 認証クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Auth/Adapter/DbTable.php");

class ComAuthAdapterDbTable extends Zend_Auth_Adapter_DbTable {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /**
     * コンストラクタ。
     */
    function __construct($dbOBJ, $tableName = null, $identityColumn = null, $credentialColumn = null, $credentialTreatment = null) {
        parent::__construct($dbOBJ, $tableName, $identityColumn, $credentialColumn, $credentialTreatment);
    }

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @param  $dbOBJ DBオブジェクト
     * @param  $tableName テーブル名
     * @param  $identityColumn ユーザー名
     * @param  $credentialColumn パスワード
     * @param  $credentialTreatment 暗号化する式(md5(?)など)
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
     */
    public static function getInstance($dbOBJ, $tableName = null, $identityColumn = null, $credentialColumn = null, $credentialTreatment = null) {
        if (null === self::$_instance) {
            self::$_instance = new self($dbOBJ, $tableName, $identityColumn, $credentialColumn, $credentialTreatment);
        }

        return self::$_instance;
    }


}
?>