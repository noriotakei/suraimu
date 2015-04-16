<?php

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
$AdmAutoPointGrantOBJ = AdmAutoPointGrant::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$reservePointGrantData = $AdmAutoPointGrantOBJ->getReservePointGrantDataById($param["reserve_point_grant_id"]);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $AdminUserOBJ->setWhereString(unserialize($reservePointGrantData["search_condition"]));
    $searchConditionData["where_contents"] = $AdminUserOBJ->getWhereContents();
    $param = $searchConditionData;
}

$param["id"] = $reservePointGrantData["id"];
$param["description"] = $reservePointGrantData["description"];

// 戻り値設定
if ($param["return_type"] == 1) {
    $smartyOBJ->assign("param", $param);
} else if ($param["return_type"] == 2) {
    $smartyOBJ->assign("paramAry", $param);
} else {
    $param["return_type"] = 0;
    $smartyOBJ->assign("param", $param);
}

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

