<?php
/**
 * affiliateUpd16.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面アフィリエイト更新ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AffiliateControlOBJ = AffiliateControl16::getInstance();

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
    $param = $AffiliateControlOBJ->getAffiliateData($param["id"]);
    $param["return_variable"]  = explode(",", $param["return_variable"]);
    $param["change_variable"] = explode(",", $param["change_variable"]);
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$POSTparam = $requestOBJ->makePostTag(array("id"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("disable", array("1" => "削除する"));

// 送信種別
$smartyOBJ->assign("sendType", AffiliateControl::$_sendType);
// 発行種別
$smartyOBJ->assign("connectType", AffiliateControl::$_connectType);
// 登録フラグ
$smartyOBJ->assign("isPreRegist", AffiliateControl::$_isPreRegist);
// 登録成功時のみ送信設定
$smartyOBJ->assign("isSuccessOnly", AffiliateControl::$_isSuccessOnly);
?>