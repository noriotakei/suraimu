<?php

/**
 * createEnd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報作成完了ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// メッセージの取得
$execMsgSessOBJ = new ComSessionNamespace("execMsg");
// メッセージの取得
$msg = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

?>
