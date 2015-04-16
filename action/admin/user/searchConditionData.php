<?php
/**
 * searchConditionData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面検索条件データページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$AdminUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$searchConditionData = $AdminUserOBJ->getUserSearchConditionData($param["id"]);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $AdminUserOBJ->setWhereString(unserialize($searchConditionData["search_condition"]));
    $searchConditionData["where_contents"] = $AdminUserOBJ->getWhereContents();
    $param = $searchConditionData;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$tags = array(
            "id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("update_permission", array(0=>"無効",1=>"有効"));

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
// カテゴリーの取得
$categoryList = $AdminUserOBJ->getUserSearchConditionsCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
?>

