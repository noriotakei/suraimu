<?php
/**
 * ComHttp.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * HTTP接続クラス。
 *
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Http/Client.php");

class ComHttp extends Zend_Http_Client {

    /**
     * コンストラクタ
     *
     * @param Zend_Uri_Http|string $uri
     * @param array $config Configuration key-value pairs.
     */
    public function __construct($uri = null, $config = null) {
        parent::__construct($uri, $config);
    }

}
