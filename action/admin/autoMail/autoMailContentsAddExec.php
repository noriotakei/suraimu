<?php
/**
 * autoMailContentsAddExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面リメールコンテンツ設定処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$admAutoMailOBJ = AdmAutoMail::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"]) {

    $param["return_type"] = 2;
    $admAutoMailOBJ->beginTransaction();

    foreach ($param["id"] as $key => $val) {

        if (!$param["name"][$key]) {
            $errMsg[] = "ID " . $val . ":名前を入力してください";
        }

        if (!$param["page_name"][$key]) {
            $errMsg[] = "ID " . $val . ":ページ名を入力してください";
        }

        if (!$param["variable_name"][$key]) {
            $errMsg[] = "ID " . $val . ":変数名を入力してください";
        }

        if (!ComValidation::isNumeric($param["sort_seq"][$key])) {
            $errMsg[] = "ID " . $val . ":表示順は数値で入力してください";
        }

        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $returnSessOBJ->return = $param;
            $admAutoMailOBJ->rollbackTransaction();
            header("Location: ./?action_autoMail_AutoMailContentsList=1");
            exit();
        }

        $value["update_datetime"] = date("YmdHis");
        $value["name"] = $param["name"][$key];
        $value["page_name"] = $param["page_name"][$key];
        $value["variable_name"] = $param["variable_name"][$key];
        $value["sort_seq"] = $param["sort_seq"][$key];
        $value["is_use"] = $param["is_use"][$key];

        if (!$admAutoMailOBJ->updateAutoMailContentsData($value , array("id = " . $val))) {
            $messageSessOBJ->message = $admAutoMailOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $admAutoMailOBJ->rollbackTransaction();
            header("Location: ./?action_autoMail_AutoMailContentsList=1");
            exit();
        }
    }

    $admAutoMailOBJ->commitTransaction();
    $messageSessOBJ->message = array("更新しました。");

} else {

    $param["return_type"] = 1;

    if (!$param["name"]) {
        $errMsg[] = "名前を入力してください";
    }

    if (!$param["page_name"]) {
        $errMsg[] = "ページ名を入力してください";
    }

    if (!$param["variable_name"]) {
        $errMsg[] = "変数名を入力してください";
    }

    if (!ComValidation::isNumeric($param["sort_seq"])) {
        $errMsg[] = "表示順は数値で入力してください";
    }

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_autoMail_AutoMailContentsList=1");
        exit();
    }

    $value["create_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];
    $value["page_name"] = $param["page_name"];
    $value["variable_name"] = $param["variable_name"];
    $value["sort_seq"] = $param["sort_seq"];

    if (!$admAutoMailOBJ->insertAutoMailContentsData($value)) {
        $messageSessOBJ->message = $admAutoMailOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_autoMail_AutoMailContentsList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}
header("Location: ./?action_autoMail_AutoMailContentsList=1");
exit();
?>