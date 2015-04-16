<?php
/**
 * ComConfig.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * configを読み込むクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Config.php");

class ComConfig extends Zend_Config {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    CONST CONFIG_PATH = "/etc/config-ini.php";

    /**
     * コンストラクタ
     */
    public function __construct($path ,$allowModifications = false) {
        parent::__construct(require($path), $allowModifications);
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
            self::$_instance = new self(dirname(dirname(__FILE__)) . self::CONFIG_PATH);
        }

        return self::$_instance;
    }

}
