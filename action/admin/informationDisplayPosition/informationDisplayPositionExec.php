<?php
/**
 * informationDisplayPositionExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面表示場所フォルダ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラー判定
$errMsg = array();

// 更新
if ($param["position_id"]) {

        foreach ($param["position_id"] as $val) {
            if (!ComValidation::isNumeric($param["cd"][$val])) {
                $errMsg[] = "情報表示場所を選択してください";
            }
            if (!ComValidation::isNumeric($param["is_display"][$val])) {
                $errMsg[] = "表示状態は数値で入力してください";
            }
            if (!ComValidation::isNumeric($param["mb_sort_seq"][$val])) {
                $errMsg[] = "MB表示順は数値で入力してください";
            }
            if (!ComValidation::isNumeric($param["pc_sort_seq"][$val])) {
                $errMsg[] = "PC表示順は数値で入力してください";
            }

            // エラー判定
            if ($errMsg) {
                $messageSessOBJ->message = $errMsg;
                header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
                exit();
            }

            $whereArray = "";
            $value = "";

            // 更新
            $value["cd"] = $param["cd"][$val];
            $value["mb_sort_seq"] = $param["mb_sort_seq"][$val];
            $value["pc_sort_seq"] = $param["pc_sort_seq"][$val];
            $value["is_display"]  = $param["is_display"][$val];
            $value["disable"]  = $param["disable"][$val];
            $value["update_datetime"] = date("YmdHis");

            $whereArray[] = "id = " . $val;

            if (!$AdmInfoDispPositionOBJ->updateInformationDisplayPositionData($value, $whereArray)) {
                $messageSessOBJ->message = $AdmInfoDispPositionOBJ->getErrorMsg();
                header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
                exit();
            }
        }
        $messageSessOBJ->message = array("更新しました。");
// 新規
} else {

    if (!ComValidation::isNumeric($param["cd"])) {
        $errMsg[] = "情報表示場所を選択してください";
    }
    if (!ComValidation::isNumeric($param["is_display"])) {
        $errMsg[] = "表示状態は数値で入力してください";
    }
    if (!ComValidation::isNumeric($param["mb_sort_seq"])) {
        $errMsg[] = "MB表示順は数値で入力してください";
    }
    if (!ComValidation::isNumeric($param["pc_sort_seq"])) {
        $errMsg[] = "PC表示順は数値で入力してください";
    }

    // エラー判定
    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_cd"] = "position";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
        exit();
    }

    $value["information_category_id"] = $param["fid"];
    $value["cd"] = $param["cd"];
    $value["mb_sort_seq"] = $param["mb_sort_seq"];
    $value["pc_sort_seq"] = $param["pc_sort_seq"];
    $value["is_display"]  = $param["is_display"];

    $value["create_datetime"] = date("YmdHis");
    $value["update_datetime"] = date("YmdHis");

    if (!$AdmInfoDispPositionOBJ->insertInformationDisplayPositionData($value)) {
        $messageSessOBJ->message = $AdmInfoDispPositionOBJ->getErrorMsg();
        $param["return_cd"] = "position";
        $returnSessOBJ->return = $param;
            header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
exit();
?>