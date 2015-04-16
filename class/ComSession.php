<?php
/**
 * ComSession.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * セッションクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Session.php");

class ComSession extends Zend_Session {

    /** @var インスタンスを保持する変数。static変数 */
    protected static $_instance = false;

    /**
     * 動作オプションの設定
     *
     * @static
     * @access public
     * @param  boolean $userOptions 設定したい配列
     */
    public static function setOptions($userOptions) {
        parent::setOptions($userOptions);
    }


    /**
     * セッションの破棄
     *
     * @static
     * @access public
     * @param  boolean $remove_cookie ユーザエージェントのセッションIDクッキーの削除
     * @param  boolean $readonly セッションデータへ書き込み設定
     */
    public static function destroy($remove_cookie = true, $readonly = true) {
        parent::destroy($remove_cookie, $readonly);
    }


    /**
     * セッション終了時に有効期限が切れるように変更
     *
     * @static
     * @access public
     */
    public static function forgetMe() {
        parent::forgetMe();
    }


    /**
     * セッションIDを取得
     *
     * @static
     * @access public
     */
    public static function getId() {
        return parent::getId();
    }

    /**
     * 登録済み名前空間をすべて取得
     *
     * @static
     * @access public
     */
    public static function getIterator() {
        return parent::getIterator();
    }

    /**
     * セッションへの読み込み可能かチェック
     *
     * @static
     * @access public
     */
    public static function isReadable() {
        return parent::isReadable();
    }

    /**
     * セッションIDの再生成が行われたかチェック
     *
     * @static
     * @access public
     */
    public static function isRegenerated() {
        return parent::isRegenerated();
    }

    /**
     * セッションが開始されたかチェック
     *
     * @static
     * @access public
     */
    public static function isStarted() {
        return parent::isStarted();
    }

    /**
     * セッションへの書き込み可能かチェック
     *
     * @static
     * @access public
     */
    public static function isWritable() {
        return parent::isStarted();
    }

    /**
     * 名前空間が存在するかチェック
     *
     * @static
     * @access public
     * @param  string $namespace 名前空間名
     */
    public static function namespaceIsset($namespace) {
        return parent::namespaceIsset($namespace);
    }

    /**
     * 名前空間を削除
     *
     * @static
     * @access public
     * @param  string $namespace 名前空間名
     */
    public static function namespaceUnset($namespace) {
        parent::namespaceUnset($namespace);
    }


    /**
     * セッションIDを再生成
     *
     * @static
     * @access public
     */
    public static function regenerateId() {
        return parent::regenerateId();
    }

    /**
     * セッションクッキーの有効期限を設定
     *
     * @static
     * @access public
     * @param  int $seconds 秒数
     */
    public static function rememberMe($seconds = null) {
        parent::rememberMe($seconds);
    }

    /**
     * 現在のリクエストに対応するセッションが既に存在するかチェック
     *
     * @static
     * @access public
     */
    public static function sessionExists() {
        return parent::sessionExists();
    }

    /**
     * セッションIDを設定
     *
     * @static
     * @access public
     * @param  int $id ID
     */
    public static function setId($id) {
        parent::setId($id);
    }

    /**
     * セッション開始
     *
     * @static
     * @access public
     * @param  array $options 設定配列
     */
    public static function start($options = false) {
        parent::start($options);
    }

    /**
     * セッションを終了(書き込み無効)
     *
     * @static
     * @access public
     */
    public static function stop() {
        parent::stop();
    }

    /**
     * セッションデータの書き込みを終了
     *
     * @static
     * @access public
     * @param  boolean $readonly セッションデータへ書き込み権限設定
     */
    public static function writeClose($readonly = true) {
        parent::writeClose($readonly);
    }
}
?>