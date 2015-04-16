<?php
/**
 * preForget.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCＩＤ・PASS忘れページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("include"));

$returnSessOBJ = new ComSessionNamespace("return");
$smartyOBJ->assign("value", $returnSessOBJ->return);
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

?>
