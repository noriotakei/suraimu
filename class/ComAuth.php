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

//require_once("Zend/Auth.php");

class ComAuth extends Zend_Auth {

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
     */
    public static function getInstance() {
        return parent::getInstance();
    }

    /**
     * 認証実行
     *
     * @param  Zend_Auth_Adapter_Interface $adapter
     */
    public function authenticate($adapter) {
        return parent::authenticate($adapter);
    }

    /**
     * 認証済みかを判定
     *
     * @return boolean
     */
    public function hasIdentity() {
        return parent::hasIdentity();
    }

    /**
     * ユーザー名の取得
     *
     * @return mixed|null
     */
    public function getIdentity() {
        return parent::getIdentity();
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public function clearIdentity() {
        return parent::clearIdentity();
    }

}
?>