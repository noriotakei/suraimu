<?php
/**
 * unitCreateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面抽選ユニット登録ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));
ini_set("memory_limit", "-1");
$AdmUnitOBJ = AdmUnit::getInstance();
$AdmUserOBJ = AdmUser::getInstance();

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

if (!ComValidation::isNumeric($param["number"])) {
    $messageSessOBJ->message[] = "抽出件数がありません";
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_lotteryUnit_UnitCreate=1&" . $URLparam);
    exit();
}

$whereArray = $AdmUserOBJ->setWhereString($searchParam);
$contents = $AdmUserOBJ->getWhereContents();

$AdmUnitOBJ->beginTransaction();

// ユニット登録
$insertLotteryUnitData["create_datetime"] = date("YmdHis");
$insertLotteryUnitData["comment"] = $param["comment"];
$insertLotteryUnitData["number"] = $param["number"];
// 検索条件登録
$insertLotteryUnitData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");

if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertLotteryUnitData($insertLotteryUnitData)) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_lotteryUnit_UnitCreate=1&" . $URLparam);
    exit();
}
$lotteryUnitId = $AdmUnitOBJ->getInsertId();

$columnArray[] = $lotteryUnitId;
$columnArray[] = "user_id";
$columnArray[] = "NOW()";

$otherArray[] = "ORDER BY rand() LIMIT 0, " . $param["number"];

$listSql = $AdmUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

// 検索条件SQLタグ登録
$updateLotteryUnitData["sql_part"] = $requestOBJ->getParameterEscape($listSql, "sql");
$updateLotteryUnitData["update_datetime"] = date("YmdHis");
if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->updateLotteryUnitData($updateLotteryUnitData, array("id = " . $lotteryUnitId))) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_lotteryUnit_UnitCreate=1&" . $URLparam);
    exit();

}

// ユニットユーザー登録
$insertColmun[] = "lottery_unit_id";
$insertColmun[] = "user_id";
$insertColmun[] = "create_datetime";

if (!$AdmUnitReturnOBJ = $AdmUnitOBJ->insertLotteryUnitUserData($insertColmun, $listSql)) {
    $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
    $returnSessOBJ->return = $param;
    $AdmUnitOBJ->rollbackTransaction();
    header("Location: ./?action_lotteryUnit_UnitCreate=1&" . $URLparam);
    exit();
}

$AdmUnitOBJ->commitTransaction();

$messageSessOBJ->message = array("抽選ユニット作成しました。");

header("Location: ./?action_user_List=1&" . $URLparam);
exit;
?>