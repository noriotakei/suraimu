<?php
/**
 * itemCategoryExec.php
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

$admItemOBJ = AdmItem::getInstance();
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

        if (!$param["icid"]) {
            header("Location: ./?action_itemManagement_itemCategoryList=1");
            exit();
        } else {
            header("Location: ./?action_itemManagement_itemCategoryData=1&icid=" . $param["icid"]);
            exit();
        }
    }
}

$value["name"]                   = $param["name"];
$value["sort_seq"]               = $param["sort_seq"];
$value["is_display"]             = $param["is_display"];
$value["item_category_group_id"] = $param["category_group_id"];

// 更新
if ($param["icid"]) {
    $whereArray[] = "id = " . $param["icid"];

    // 削除
    if ($param["disable"]) {
        $value = array(); // 一度初期化
        $value["disable"] = true;
        $value["update_datetime"] = date("YmdHis");

        if (!$admItemOBJ->updateItemCategoryData($value, $whereArray)) {
            $messageSessOBJ->message = $admItemOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_itemManagement_itemCategoryList=1");
            exit();
        }
        $messageSessOBJ->message = array("削除しました。");
    } else {
        // 更新
        $value["update_datetime"] = date("YmdHis");

        if (!$admItemOBJ->updateItemCategoryData($value, $whereArray)) {
            $messageSessOBJ->message = $admItemOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_itemManagement_itemCategoryData=1&icid=" . $param["icid"]);
            exit();
        }
        $messageSessOBJ->message = array("更新しました。");
    }
// 新規
} else {
    $value["create_datetime"] = date("YmdHis");

    if (!$admItemOBJ->insertItemCategoryData($value)) {
        $messageSessOBJ->message = $admItemOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_itemManagement_itemCategoryList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_itemManagement_itemCategoryList=1");
exit();
?>