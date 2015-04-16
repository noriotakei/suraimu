<?php

/**
 * create.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報作成ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err");
$returnSessOBJ = new ComSessionNamespace("return");

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻り値の取得
$smartyOBJ->assign("param", $returnValue);

// エラーメッセージの取得
$errMsg = $errSessOBJ->getIterator();
// セッション変数の破棄
$errSessOBJ->unsetAll();
$smartyOBJ->assign("errMsg", $errMsg);

$AdmAdminOBJ = AdmAdmin::getInstance();

$adminList = $AdmAdminOBJ->getListForSelect();
$smartyOBJ->assign("adminList", AdmAdmin::$_searchArray + $adminList);

?>
