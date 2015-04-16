<?php
/**
 * customer.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後お問い合わせ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$returnSessOBJ = new ComSessionNamespace("return");
$smartyOBJ->assign("value", $returnSessOBJ->return);
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$errSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

?>
