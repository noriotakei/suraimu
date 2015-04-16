<?php
/**
 * error.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBエラーページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

// 各種エラーメッセージの取得
$ComErrSessOBJ = new ComSessionNamespace("common_err");
if ($ComErrSessOBJ->errMsg) {
    $errMsg = implode("<br>", $ComErrSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $ComErrSessOBJ->unsetAll();
}

$loginSessOBJ = new ComSessionNamespace("login");
if ($loginSessOBJ->errMsg) {
    $errMsg = implode("<br>", $loginSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $loginSessOBJ->unsetAll();
}

$errSessOBJ = new ComSessionNamespace("err_msg");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}
?>