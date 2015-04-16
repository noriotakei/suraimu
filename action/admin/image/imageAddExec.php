<?php
/**
 * imageAddExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面画像編集処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$admImageOBJ = AdmImage::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$value["update_datetime"] = date("YmdHis");
$value["name"] = $param["name"];
$value["image_category_id"] = $param["image_category_id"];
$value["comment"] = $param["comment"];


$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("name", "名前",
                array("Value" => null),
                array("Value" => "名前は必須項目です"));

$validationOBJ->check("image_category_id", "カテゴリー",
                array("Numeric" => null),
                array("Numeric" => "カテゴリーは必須項目です"));


if ($param["image_id"]) {

    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_image_ImageUpd=1&image_id=" . $param["image_id"]);
        exit;
    }

    $whereArray[] = "id = " . $param["image_id"];
    $imageData = $admImageOBJ->getImageData($param["image_id"]);

    if (!$admImageOBJ->updateImageData($value, $whereArray, "design_file", $imageData)) {
        $messageSessOBJ->message = $admImageOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_image_ImageUpd=1&image_id=" . $param["image_id"]);
        exit();
    }
    $messageSessOBJ->message = array("更新しました。");
} else {

    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_image_List=1");
        exit;
    }

    $value["create_datetime"] = date("YmdHis");
    if (!$admImageOBJ->insertImageData($value, "design_file")) {
        $messageSessOBJ->message = $admImageOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_image_List=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_image_List=1");
exit();
?>