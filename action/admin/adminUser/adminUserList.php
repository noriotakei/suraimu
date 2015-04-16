<?php
/**
 * adminUserList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面管理ユーザー一覧ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admAdminOBJ = AdmAdmin::getInstance();

$adminList = $admAdminOBJ->getList();
$smartyOBJ->assign("adminList", $adminList);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $param["return_flag"] = 0;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());

$smartyOBJ->assign("autoUpdateFlag", array("1" => "自動更新する"));

// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

?>
