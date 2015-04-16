<?php
/**
 * preLogin.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログインフォームページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("login");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

?>
