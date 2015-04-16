<?php

/**
 * orderingDisplaySetting.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面予約注文表示管理ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
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

$AdmOrderingOBJ = AdmOrdering::getInstance();

$orderingDisplayData = $AdmOrderingOBJ->getOrderingDisplaySettingList();

$smartyOBJ->assign("orderingDisplayData", $orderingDisplayData);
// 予約注文表示コード
$smartyOBJ->assign("ordringDisplayCd", AdmOrdering::$_ordringDisplayCd);
// 表示状態
$smartyOBJ->assign("isDisplay", AdmOrdering::$_isDisplay);

?>
