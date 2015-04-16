<?php
/**
 * login.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 代理店媒体集計ログインページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa_hosoda
 */

require_once(D_BASE_DIR . "/common/baitai_agency_common.php");

require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$errMsgSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
$smartyOBJ->assign("errMsg", $errMsgSessOBJ->getIterator());
// セッション変数の破棄
$errMsgSessOBJ->unsetAll();

?>
