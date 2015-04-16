<?php
/**
 * ComXmlRpcClient.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * XML通信クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ComXmlRpcClient extends Zend_XmlRpc_Client {

    /**
     * コンストラクタ
     *
     * @param  string $server      Full address of the XML-RPC service
     *                             (e.g. http://time.xmlrpc.com/RPC2)
     * @param  Zend_Http_Client $httpClient HTTP Client to use for requests
     */
    public function __construct($server, $httpClient = null) {
        parent::__construct($server, $httpClient);
    }
}
?>