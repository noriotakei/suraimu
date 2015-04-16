<?php
/**
 * logDeleteSetExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ログ削除更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmLogDeleteOBJ = AdmLogDelete::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"]) {

    $param["return_type"] = 2;
    $AdmLogDeleteOBJ->beginTransaction();

    foreach ($param["id"] as $key => $val) {

        $value = "";

        if (!$param["table_name"][$key]) {
            $errMsg[] = "ID " . $val . ":テーブル名を入力してください";
        }

        if (!is_numeric($param["days"][$key])) {
            $errMsg[] = "ID " . $val . ":日数を数値で入力してください";
        }

        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $returnSessOBJ->return = $param;
            $AdmLogDeleteOBJ->rollbackTransaction();
            header("Location: ./?action_log_LogDeleteSetList=1");
            exit();
        }

        $value["update_datetime"] = date("YmdHis");
        $value["table_name"] = $param["table_name"][$key];
        $value["days"] = $param["days"][$key];
        $value["disable"] = $param["disable"][$key];

        if (!$AdmLogDeleteOBJ->updateLogDeleteSetData($value , array("id = " . $val))) {
            $messageSessOBJ->message = $AdmLogDeleteOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $AdmLogDeleteOBJ->rollbackTransaction();
            header("Location: ./?action_log_LogDeleteSetList=1");
            exit();
        }
    }

    $AdmLogDeleteOBJ->commitTransaction();
    $messageSessOBJ->message = array("更新しました。");

} else {

    $param["return_type"] = 1;

    if (!$param["table_name"]) {
        $errMsg[] = "テーブル名を入力してください";
    }

    if (!is_numeric($param["days"])) {
        $errMsg[] = "日数を数値で入力してください";
    }

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_log_LogDeleteSetList=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["table_name"] = $param["table_name"];
    $value["days"] = $param["days"];

    if (!$AdmLogDeleteOBJ->insertLogDeleteSetData($value)) {
        $messageSessOBJ->message = $AdmLogDeleteOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_log_LogDeleteSetList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}

header("Location: ./?action_log_LogDeleteSetList=1");
exit();
?>