<?php
/**
 * registTestAddressCategoryAddExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面テストアドレスカテゴリー更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmRegistTestAddressOBJ = AdmRegistTestAddress::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"]) {

    $param["return_type"] = 2;
    $AdmRegistTestAddressOBJ->beginTransaction();

    foreach ($param["id"] as $key => $val) {

        $value = "";

        if (!$param["name"][$key]) {
            $errMsg[] = "ID " . $val . ":名前を入力してください";
        }

        if (!ComValidation::isNumeric($param["is_display"][$key])) {
            $errMsg[] = "ID " . $val . ":表示状態は数値で入力してください";
        }

        if (!ComValidation::isNumeric($param["sort_seq"][$key])) {
            $errMsg[] = "ID " . $val . ":表示順は数値で入力してください";
        }

        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $returnSessOBJ->return = $param;
            $AdmRegistTestAddressOBJ->rollbackTransaction();
            header("Location: ./?action_testAddress_RegistTestAddressCategoryList=1");
            exit();
        }

        $value["update_datetime"] = date("YmdHis");
        $value["name"] = $param["name"][$key];
        $value["sort_seq"] = $param["sort_seq"][$key];
        $value["is_display"] = $param["is_display"][$key];
        $value["disable"] = $param["disable"][$key];

        if (!$AdmRegistTestAddressOBJ->updateRegistTestAddressCategoryData($value , array("id = " . $val))) {
            $messageSessOBJ->message = $AdmRegistTestAddressOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $AdmRegistTestAddressOBJ->rollbackTransaction();
            header("Location: ./?action_testAddress_RegistTestAddressCategoryList=1");
            exit();
        }
    }

    $AdmRegistTestAddressOBJ->commitTransaction();
    $messageSessOBJ->message = array("更新しました。");

} else {

    $param["return_type"] = 1;

    if (!$param["name"]) {
        $errMsg[] = "名前を入力してください";
    }

    if (!ComValidation::isNumeric($param["is_display"])) {
        $errMsg[] = "表示状態は数値で入力してください";
    }

    if (!ComValidation::isNumeric($param["sort_seq"])) {
        $errMsg[] = "表示順は数値で入力してください";
    }

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_testAddress_RegistTestAddressCategoryList=1");
        exit();
    }

    $value["create_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];
    $value["sort_seq"] = $param["sort_seq"];
    $value["is_display"] = $param["is_display"];

    if (!$AdmRegistTestAddressOBJ->insertRegistTestAddressCategoryData($value)) {
        $messageSessOBJ->message = $AdmRegistTestAddressOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_testAddress_RegistTestAddressCategoryList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}
header("Location: ./?action_testAddress_RegistTestAddressCategoryList=1");
exit();
?>