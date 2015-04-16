<?php
/**
 * ComSmarty.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * smartyクラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once("Smarty/libs/Smarty.class.php");

class ComSmarty extends Smarty {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->Smarty();
        $this->template_dir="../templates";
        $this->compile_dir="../templates_c";
        // プラグインディレクトリ
        // extendsにカスタムプラグインを格納
        $this->plugins_dir=array("plugins","extends");
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

        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
