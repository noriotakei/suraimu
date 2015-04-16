<?php
/**
 * informationOperatorUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 問い合わせ管理者更新ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoOperatorOBJ = AdmInformationOperator::getInstance();

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
    $param = $AdmInfoOperatorOBJ->getData($param["id"]);
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$POSTparam = $requestOBJ->makePostTag(array("id"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("disable", array("1" => "削除する"));

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationOperator::$_isDisplay);

// 管理者一覧を取得
$admAdminOBJ = AdmAdmin::getInstance();
$adminUserAry = array();
$adminUserAry = array(
            $_config["define"]["AUTHORITY_TYPE_SYSTEM"],
            $_config["define"]["AUTHORITY_TYPE_MANAGE"],
            $_config["define"]["AUTHORITY_TYPE_OPERATOR"],
            $_config["define"]["AUTHORITY_TYPE_INFORMATION"]
            );

$adminUserIdString = "";
$adminUserIdString = implode(",", $adminUserAry);
$whereArray[] = "authority_type IN(" . $adminUserIdString . ")";

$adminUserList = array();
$adminRelationUserList = array();
$adminUserList = $admAdminOBJ->getList($whereArray);
foreach ($adminUserList as $val) {
    $adminRelationUserList[$val["id"]] = $val["name"];
}
$smartyOBJ->assign("adminRelationUserList", array("99" => "未設定")+$adminRelationUserList);
?>
