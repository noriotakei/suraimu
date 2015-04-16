<?php
/**
 * ComCommon.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側デフォルト継承クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ComCommon {

    /** @var object 設定データオブジェクト */
    public $_comDbOBJ = null;

    /** @var object 設定データオブジェクト */
    protected $_configOBJ = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        $this->_comDbOBJ  = ComDb::getInstance();
        // 設定データのインスタンスを取得
        $this->_configOBJ = ComConfig::getInstance();
    }

    /**
     * 定義されていないメソッドの場合、DBメソッドを読み込む
     *
     * @return mixed
     */
    public function __call($name, $var) {
        return call_user_func_array(array($this->_comDbOBJ , $name), $var);
    }
}
?>