<?php
/**
 * __autoload.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * クラスファイルの自動読み込み。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

function __autoload($className) {

    $className = str_replace("_", "/", $className);

    if (file_exists(D_BASE_DIR . "/class/" . $className . ".php")) {
        include_once(D_BASE_DIR . "/class/" . $className . ".php");
    } else if(file_exists(D_BASE_DIR . "/lib/" . $className . ".php")) {
        include_once(D_BASE_DIR . "/lib/" . $className . ".php");
    }
}

?>
