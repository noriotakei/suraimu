<?php

/**
 * orderingSet.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面商品予約ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$smartyOBJ->assign("param", $param);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();
$smartyOBJ->assign("returnValue", $returnValue);

// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
// 注文ステータス
$smartyOBJ->assign("orderStatus", AdmOrdering::$_registOrderStatus);

$tags = array(
            "user_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

?>
