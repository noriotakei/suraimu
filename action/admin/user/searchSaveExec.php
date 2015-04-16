<?php
/**
 * searchSaveExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー検索条件登録ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

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
            "search_conditions_id"
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1");
    exit;
}

if ($param["search_conditions_id"]) {

    if (!ComValidation::isNumeric($param["search_conditions_id"])) {
        $messageSessOBJ->message[] = "更新する検索条件保存IDを数値で入力してください。";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit();
    }

    if (!$AdminUserOBJ->getUserSearchConditionData($param["search_conditions_id"])) {
        $messageSessOBJ->message[] = "検索条件保存データがありません";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit();
    }
    // 検索条件登録
    $updateSearchConditionData["update_datetime"] = date("YmdHis");
    if ($param["comment"]) {
        $updateSearchConditionData["comment"] = $param["comment"];
    }
    $updateSearchConditionData["search_conditions_category_id"] = $param["search_conditions_category_id"];
    $updateSearchConditionData["update_permission"] = $param["update_permission"];

    // 検索条件登録
    $updateSearchConditionData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");

    if (!$AdminUserOBJ->updateUserSearchConditionData($updateSearchConditionData , array("id = " . $param["search_conditions_id"]))) {
        $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit();
    }
} else {

    // 検索条件登録
    $insertSearchConditionData["create_datetime"] = date("YmdHis");
    $insertSearchConditionData["update_datetime"] = date("YmdHis");
    $insertSearchConditionData["comment"] = $param["comment"] ? $param["comment"] : "件名なし";
    $insertSearchConditionData["search_conditions_category_id"] = $param["search_conditions_category_id"];
    $insertSearchConditionData["update_permission"] = $param["update_permission"];

    // 検索条件登録
    $insertSearchConditionData["search_condition"] = $requestOBJ->getParameterEscape(serialize($searchParam), "sql");

    if (!$AdminUserOBJ->insertUserSearchConditionData($insertSearchConditionData)) {
        $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit();
    }

}
$messageSessOBJ->message = array("ユーザー検索条件を保存しました。");

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;
?>

