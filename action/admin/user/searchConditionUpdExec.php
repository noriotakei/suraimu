<?php
/**
 * searchConditionUpdExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面検索条件更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();

$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"] AND $param["disable"]) {

    $value["update_datetime"] = date("YmdHis");
    $value["disable"] = $param["disable"];

    if (!$AdminUserOBJ->updateUserSearchConditionData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
        header("Location: ./?action_user_SearchConditionList=1");
        exit();
    }

    $messageSessOBJ->message = array("削除しました。");
    header("Location: ./?action_user_SearchConditionList=1");
    exit();

} else if ($param["id"]) {

    $value["update_datetime"] = date("YmdHis");
    $value["comment "] = $param["comment"] ? $param["comment"] : "";
    $value["search_conditions_category_id"] = $param["search_conditions_category_id"];
    $value["update_permission"] = $param["update_permission"];

    if (!$AdminUserOBJ->updateUserSearchConditionData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_SearchConditionData=1&id=" . $param["id"]);
        exit();
    }

    $messageSessOBJ->message = array("更新しました。");
    header("Location: ./?action_user_SearchConditionData=1&id=" . $param["id"]);
    exit();
}


?>