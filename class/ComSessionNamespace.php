<?php
/**
 * ComSessionNamespace.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * セッショングループクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Session/Namespace.php");

class ComSessionNamespace extends Zend_Session_Namespace {

    /** @var インスタンスを保持する変数。static変数 */
    protected static $_instance = false;

    /**
     * コンストラクタメソッド
     *
     * セッションデータの初期化
     *
     * @static
     * @access public
     * @param  $name  設定したいセッション名 デフォルトは「SessionID」
     * @return void
     * @see    session_name()
     * @see    session_start()
     */
    public function __construct($namespace = 'Default', $singleInstance = false) {
        parent::__construct($namespace, $singleInstance);
    }

    /**
     * すべてのロックを解除
     *
     * @static
     * @access public
     */
    public static function unlockAll() {
        parent::unlockAll();
    }

    /**
     * 名前空間の名前をすべて取得
     *
     * @access public
     */
    public function getIterator() {
        return parent::getIterator();
    }

    /**
     * 名前空間がロック状態にあるかチェック
     *
     * @access public
     */
    public function isLocked() {
        return parent::isLocked();
    }

    /**
     * 名前空間をロックする
     *
     * @access public
     */
    public function lock() {
        parent::lock();
    }


    /**
     * 名前空間のロックを解除する
     *
     * @access public
     */
    public function unlock() {
        parent::unlock();
    }


    /**
     * 名前空間に含まれるすべての変数を削除
     *
     * @access public
     */
    public function unsetAll() {
        return parent::unsetAll();
    }

}
?>