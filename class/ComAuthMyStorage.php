<?php

/**
 * ComAuthMyStorage.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 認証ストレージクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ComAuthMyStorage extends Zend_Auth_Storage_Session {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

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
     * コンストラクタ。
     */
    public function __construct($namespace = self::NAMESPACE_DEFAULT, $member = self::MEMBER_DEFAULT) {
        parent::__construct();
        // 認証の有効期限を設定する
        $this->_session->setExpirationSeconds(60*60*5);
    }

}
?>