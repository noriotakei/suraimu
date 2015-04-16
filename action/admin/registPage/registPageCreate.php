<?php
/**
 * registPageCreate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録ページ登録ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmRegistPageOBJ = AdmRegistPage::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnValue) {
        $data = $returnValue;
}
$smartyOBJ->assign("data", $data);

$smartyOBJ->assign("isUseAry", AdmRegistPage::$_isUse);
$smartyOBJ->assign("sendAddress", AdmRegistPage::REGIST_PAGE_REMAIL_ADDRESS . $_config["define"]["MAIL_DOMAIN"]);

// カテゴリーの取得
$categoryList = $AdmRegistPageOBJ->getRegistPageCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
?>

