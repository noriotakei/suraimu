<?php
/**
 * baitaiAgencyList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体CHK 代理店一覧ページ
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmBaitaiAgencyOBJ = AdmBaitaiAgency::getInstance();

$baitaiAgencyList = $AdmBaitaiAgencyOBJ->getUserList();
$smartyOBJ->assign("baitaiAgencyList", $baitaiAgencyList);

// 入金額の表示/非表示
$smartyOBJ->assign("isDisplayPay", AdmBaitaiAgency::$_isDisplayPay);

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

// 認証タイプ
$smartyOBJ->assign("isAuthIpAddress", AdmBaitaiAgency::$_isAuthIpAddress);

?>

