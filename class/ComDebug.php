<?php
/**
 * ComDebug.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * var_dumpを見やすくするクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Debug.php");

class ComDebug extends Zend_Debug {

    /**
     * var_dumpの取得。
     *
     * @return string
     */
    public static function dump($var, $title = null) {
        return parent::dump($var, $title, TRUE);
    }

}
