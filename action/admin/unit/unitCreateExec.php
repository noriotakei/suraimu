<?php
/**
 * unitCreateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユニット登録ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

ini_set("memory_limit", "-1");
$AdmUnitOBJ = AdmUnit::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションにセットします
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$errSessOBJ = new ComSessionNamespace("err");

$requestOBJ->setParameter("sesKey", $param["sesKey"]);
$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}

$whereArray = $AdminUserOBJ->setWhereString($searchParam);
$contents = $AdminUserOBJ->getWhereContents();

$AdmUnitOBJ->beginTransaction();

// ユニット登録
$insertUnitData["create_datetime"] = date("YmdHis");
$insertUnitData["comment"] = $param["comment"];
// 検索条件登録
$insertUnitData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");

if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertUnitData($insertUnitData)) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_unit_UnitCreate=1&" . $URLparam);
    exit();
}
$unitId = $AdmUnitOBJ->getInsertId();

$columnArray[] = $unitId;
$columnArray[] = "user_id";
$columnArray[] = "NOW()";
$listSql = $AdminUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

// 検索条件SQLタグ登録
$updateUnitData["sql_part"] = $requestOBJ->getParameterEscape($listSql, "sql");
$updateUnitData["update_datetime"] = date("YmdHis");
if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->updateUnitData($updateUnitData, array("id = " . $unitId))) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_unit_UnitCreate=1&" . $URLparam);
    exit();
}

// ユニットユーザー登録
$insertColmun[] = "unit_id";
$insertColmun[] = "user_id";
$insertColmun[] = "create_datetime";

if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertUnitUserData($insertColmun, $listSql)) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_unit_UnitCreate=1&" . $URLparam);
    exit();
}

$AdmUnitOBJ->commitTransaction();

$messageSessOBJ->message = array("ユニット作成しました。");

header("Location: ./?action_user_List=1&" . $URLparam);
exit;
?>