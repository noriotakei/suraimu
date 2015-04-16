<?php
/**
 * baitaiAgencyAdminUserUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 代理店媒体CHK管理者ユーザー管理
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmBaitaiAgencyAdminOBJ = AdmBaitaiAgencyAdmin::getInstance();

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

// 管理者データを取得
$baitaiAgencyData = $AdmBaitaiAgencyAdminOBJ->getData($param["id"]);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $agencyAdminParam = $returnValue;
} else {
    $agencyAdminParam = $baitaiAgencyData;
}

// パスワードは隠す
$agencyAdminParam["blind_password"] = str_repeat('*',strlen($agencyAdminParam["password"]));

$smartyOBJ->assign("agencyAdminParam", $agencyAdminParam);

$POSTparam = $requestOBJ->makePostTag(array("id"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("disable", array("1" => "削除する"));

?>
