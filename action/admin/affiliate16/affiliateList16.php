<?php
/**
 * affiliateList16.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面アフィリエイト一覧ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AffiliateControlOBJ = AffiliateControl16::getInstance();

$affiliateList = $AffiliateControlOBJ->getAffiliateList("", "id DESC");
if ($affiliateList) {
    foreach ($affiliateList as $key => $val) {
        if ($val["return_variable"]) {
            $returnVariable = explode(",", $val["return_variable"]);
            $changeVariable = explode(",", $val["change_variable"]);
            foreach ($returnVariable as $returnKey => $returnVal) {
                $affiliateList[$key]["variable"][] = $returnVal . " = " . $changeVariable[$returnKey];
            }
        }
    }
}
$smartyOBJ->assign("affiliateList", $affiliateList);

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

// 送信種別
$smartyOBJ->assign("sendType", AffiliateControl::$_sendType);
// 発行種別
$smartyOBJ->assign("connectType", AffiliateControl::$_connectType);
// 登録フラグ
$smartyOBJ->assign("isPreRegist", AffiliateControl::$_isPreRegist);
// 登録成功時のみ送信設定
$smartyOBJ->assign("isSuccessOnly", AffiliateControl::$_isSuccessOnly);
?>
