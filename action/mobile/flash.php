<?php
/**
 * flash.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後flashページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */
require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray,"" ,"get");

$queryStringAry = $param;
unset($queryStringAry["swf"]);

$queryStringAry["user_id"] = $comUserData["user_id"];
$queryStringAry["login_id"] = $comUserData["login_id"];
$queryStringAry["point"] = $comUserData["point"];
$queryStringAry["regist_datetime"] = $comUserData["regist_datetime"];

$srcswf = D_BASE_DIR . "/image/img/" . $param["swf"] . ".swf";
header("Content-Type: application/x-shockwave-flash");
echo ComSwfWrapper::swfWrapper($srcswf, $queryStringAry);
exit;
?>