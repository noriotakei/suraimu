<?php
/**
 * baitaiAgencyAdminUserList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 代理店媒体CHK 管理者リスト
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmBaitaiAgencyAdminOBJ = AdmBaitaiAgencyAdmin::getInstance();


$agencyAdminList = $AdmBaitaiAgencyAdminOBJ->getList();
$smartyOBJ->assign("agencyAdminList", $agencyAdminList);

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
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();


?>
