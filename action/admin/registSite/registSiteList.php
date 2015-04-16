<?php

/**
 * registSiteList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト間登録サイトデータリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmRegistSiteOBJ = AdmRegistSite::getInstance();
$registSiteList = $AdmRegistSiteOBJ->getRegistSiteList();

$smartyOBJ->assign("registSiteList", $registSiteList);

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

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $registSiteData = $returnValue;
} else {
    $registSiteData["return_flag"] = 0;
}

$smartyOBJ->assign("registSiteData", $registSiteData);

// 表示状態
$smartyOBJ->assign("isUse", AdmRegistSite::$_isUse);

?>
