<?php
/**
 * ComDate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 日付クラス。
 *
 * 2038年問題解消や、日付の加算、減算など使えるクラスがたくさんあるので、
 * http://framework.zend.com/manual/ja/zend.date.html
 * を参照
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

//require_once("Zend/Date.php");

class ComDate extends Zend_Date {

    /**
     * コンストラクタ
     */
    public function __construct($date = null, $part = null, $locale = null) {
        parent::__construct($date, $part, $locale);
    }

}
