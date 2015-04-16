<?php
/**
 * baitaiUserUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体CHKユーザー更新ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

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
    $param = $returnValue;
// 更新の場合
} else {
    $param = $AdmBaitaiOBJ->getUserData($param["id"]);
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$POSTparam = $requestOBJ->makePostTag(array("id"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("disable", array("1" => "削除する"));

?>