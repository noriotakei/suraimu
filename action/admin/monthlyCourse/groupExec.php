<?php
/**
 * groupExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面月額コースグループ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラー判定
$errMsg = array();
if (!$param["disable"]) {
    if (!$param["name"]) {
        $errMsg[] = "管理用商品名を入力してください";
    }

    if (!ComValidation::isNumeric($param["is_display"])) {
        $errMsg[] = "表示状態は数値で入力してください";
    }

    if (!ComValidation::isNumeric($param["sort_seq"])) {
        $errMsg[] = "表示順は数値で入力してください";
    }

    // エラー判定
    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;

        if (!$param["mcgid"]) {
            header("Location: ./?action_MonthlyCourse_GroupList=1");
            exit();
        } else {
            header("Location: ./?action_MonthlyCourse_CourseData=1&mcgid=" . $param["mcgid"]);
            exit();
        }
    }
}

$value["name"]       = $param["name"];
$value["sort_seq"]   = $param["sort_seq"];
$value["is_display"] = $param["is_display"];

// 更新
if ($param["mcgid"]) {
    $whereArray[] = "id = " . $param["mcgid"];

    // 削除
    if ($param["disable"]) {
        $value = array(); // 一度初期化
        $value["disable"] = true;
        $value["update_datetime"] = date("YmdHis");

        if (!$admMonthlyCourseOBJ->updateMonthlyCourseGroupData($value, $whereArray)) {
            $messageSessOBJ->message = $admMonthlyCourseOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_MonthlyCourse_GroupList=1");
            exit();
        }
        $messageSessOBJ->message = array("削除しました。");
    } else {
        // 更新
        $value["update_datetime"] = date("YmdHis");

        if (!$admMonthlyCourseOBJ->updateMonthlyCourseGroupData($value, $whereArray)) {
            $messageSessOBJ->message = $admMonthlyCourseOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_MonthlyCourse_CourseData=1&mcgid=" . $param["mcgid"]);
            exit();
        }
        $messageSessOBJ->message = array("更新しました。");
    }
// 新規
} else {
    $value["create_datetime"] = date("YmdHis");
    $value["update_datetime"] = date("YmdHis");

    if (!$admMonthlyCourseOBJ->insertMonthlyCourseGroupData($value)) {
        $messageSessOBJ->message = $admMonthlyCourseOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_MonthlyCourse_GroupList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_MonthlyCourse_GroupList=1");
exit();
?>