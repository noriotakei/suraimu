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

if ($param["id"] AND $param["disable"]) {

    $value["update_datetime"] = date("YmdHis");
    $value["disable"] = $param["disable"];

    if (!$AdmRegistTestAddressOBJ->updateRegistTestAddressData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdmRegistTestAddressOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_testAddress_RegistTestAddressData=1");
        exit();
    }

    $messageSessOBJ->message = array("削除しました。");

} else if ($param["id"]) {

    if (!$param["mail_address"]) {
        $errMsg[] = "メールアドレスを入力してください";
    }

    if (!ComValidation::isNumeric($param["regist_test_mail_category_id"])) {
        $errMsg[] = "カテゴリーを選択してください";
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
        header("Location: ./?action_testAddress_RegistTestAddressData=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["mail_address"] = $param["mail_address"];
    $value["sort_seq"] = $param["sort_seq"];
    $value["regist_test_mail_category_id"] = $param["regist_test_mail_category_id"];
    $value["is_display"] = $param["is_display"];

    if (!$AdmRegistTestAddressOBJ->updateRegistTestAddressData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdmRegistTestAddressOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_testAddress_RegistTestAddressData=1");
        exit();
    }

    $messageSessOBJ->message = array("更新しました。");

} else {

    if (!ComValidation::isMailAddress($param["mail_address"])) {
        $errMsg[] = "メールアドレスを入力してください";
    }

    if (!ComValidation::isNumeric($param["regist_test_mail_category_id"])) {
        $errMsg[] = "カテゴリーを選択してください";
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
        header("Location: ./?action_testAddress_RegistTestAddressList=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["mail_address"] = $param["mail_address"];
    $value["sort_seq"] = $param["sort_seq"];
    $value["regist_test_mail_category_id"] = $param["regist_test_mail_category_id"];
    $value["is_display"] = $param["is_display"];

    if (!$AdmRegistTestAddressOBJ->insertRegistTestAddressData($value)) {
        $messageSessOBJ->message = $AdmRegistTestAddressOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_testAddress_RegistTestAddressList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}
header("Location: ./?action_testAddress_RegistTestAddressList=1");
exit();
?>