<?php
/**
 * informationCategoryExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面表示フォルダ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro Nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラー判定
$errMsg = array();

// 更新
if ($param["fid"]) {

    // 削除
    if ($param["disable"]) {
        $value = array(); // 一度初期化

        $value["disable"] = true;
        $value["update_datetime"] = date("YmdHis");

        foreach ($param["fid"] as $val) {
            $whereArray = array();
            $whereArray[] = "id = " . $val;

            if (!$AdmInfoDispPositionOBJ->updateInformationCategoryData($value, $whereArray)) {
                $messageSessOBJ->message = $AdmInfoDispPositionOBJ->getErrorMsg();
                $param["return_flag"] = true;
                $returnSessOBJ->return = $param;
                header("Location: ./?action_informationDisplayPosition_InformationCategoryList=1");
                exit();
            }
        }
        $messageSessOBJ->message = array("削除しました。");
        header("Location: ./?action_informationDisplayPosition_InformationCategoryList=1");
        exit();
    } else {

        if (!$param["name"]) {
            $errMsg[] = "フォルダ名を入力してください";
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
            header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
            exit();
        }

        $value["name"]        = $param["name"];
        $value["sort_seq"]    = $param["sort_seq"];
        $value["is_display"]  = $param["is_display"];

        // 更新
        $whereArray[] = "id = " . $param["fid"];
        $value["update_datetime"] = date("YmdHis");

        if (!$AdmInfoDispPositionOBJ->updateInformationCategoryData($value, $whereArray)) {
            $messageSessOBJ->message = $AdmInfoDispPositionOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
            exit();
        }
        $messageSessOBJ->message = array("更新しました。");
        header("Location: ./?action_informationDisplayPosition_InformationDisplayPositionUpd=1&fid=" . $param["fid"]);
        exit();
    }
// 新規
} else {

    if (!$param["name"]) {
        $errMsg[] = "フォルダ名を入力してください";
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
        header("Location: ./?action_informationDisplayPosition_InformationCategoryList=1");
        exit();
    }

    $value["name"]        = $param["name"];
    $value["sort_seq"]    = $param["sort_seq"];
    $value["is_display"]  = $param["is_display"];
    $value["create_datetime"] = date("YmdHis");
    $value["update_datetime"] = date("YmdHis");

    if (!$AdmInfoDispPositionOBJ->insertInformationCategoryData($value)) {
        $messageSessOBJ->message = $AdmInfoDispPositionOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_informationDisplayPosition_InformationCategoryList=1");
        exit();
    }
    $message[] = "登録しました。" ;
    $message[] = "フォルダ名【".$param["name"]."】の表示場所が設定されていません。" ;
    $message[] = "表示場所設定をお願いします。" ;
    $messageSessOBJ->message = $message ;
    header("Location: ./?action_informationDisplayPosition_InformationCategoryList=1");
    exit();
}

?>