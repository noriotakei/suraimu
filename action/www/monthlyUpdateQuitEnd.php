<?php
/**
 * monthlyUpdateQuitEnd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC 月額自動更新解除処理完了ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      notihisa hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");

// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

?>
