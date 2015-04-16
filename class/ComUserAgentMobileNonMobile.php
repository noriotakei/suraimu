<?php
/**
 * ComUserAgentMobileNonMobile.php
 * 
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 主要3キャリア以外の端末情報を扱うクラス。
 * 
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComUserAgentMobileNonMobile {
    
    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;
    
    /**
     * コンストラクタ
     * 
     * @param string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     */
    function __construct($httpUserAgent) {
        $this->_httpUserAgent = $httpUserAgent;
    }
}

?>
