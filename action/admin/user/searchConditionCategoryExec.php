<?php
/**
 * searchConditionCategoryExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録ページカテゴリー更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"]) {

    $param["return_type"] = 2;
    $AdminUserOBJ->beginTransaction();

    foreach ($param["id"] as $key => $val) {

        $value = "";

        if (!$param["name"][$key]) {
            $errMsg[] = "ID " . $val . ":名前を入力してください";
        }

        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $returnSessOBJ->return = $param;
            $AdminUserOBJ->rollbackTransaction();
            header("Location: ./?action_user_SearchConditionCategoryList=1");
            exit();
        }

        $value["update_datetime"] = date("YmdHis");
        $value["name"] = $param["name"][$key];
        $value["disable"] = $param["disable"][$key];

        if (!$AdminUserOBJ->updateUserSearchConditionsCategoryData($value , array("id = " . $val))) {
            $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $AdminUserOBJ->rollbackTransaction();
            header("Location: ./?action_user_SearchConditionCategoryList=1");
            exit();
        }
    }

    $AdminUserOBJ->commitTransaction();
    $messageSessOBJ->message = array("更新しました。");

} else {

    $param["return_type"] = 1;

    if (!$param["name"]) {
        $errMsg[] = "名前を入力してください";
    }

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_SearchConditionCategoryList=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];

    if (!$AdminUserOBJ->insertUserSearchConditionsCategoryData($value)) {
        $messageSessOBJ->message = $AdminUserOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_user_SearchConditionCategoryList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}
header("Location: ./?action_user_SearchConditionCategoryList=1");
exit();
?>