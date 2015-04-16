<?php
/**
 * bannerAddExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面バナー画像編集処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmBannerOBJ = AdmBanner::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$value["update_datetime"] = date("YmdHis");
$value["name"] = $param["name"];
$value["banner_image_category_id"] = $param["banner_image_category_id"];
$value["comment"] = $param["comment"];

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("name", "名前",
                array("Value" => null),
                array("Value" => "名前は必須項目です"));

$validationOBJ->check("banner_image_category_id", "カテゴリー",
                array("Numeric" => null),
                array("Numeric" => "カテゴリーは必須項目です"));

if ($param["banner_id"]) {


    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_BannerUpd=1&banner_id=" . $param["banner_id"]);
        exit;
    }

    $whereArray[] = "id = " . $param["banner_id"];
    $bannerData = $AdmBannerOBJ->getBannerData($param["banner_id"]);

    if (!$AdmBannerOBJ->updateBannerData($value, $whereArray, "design_file", $bannerData)) {
        $messageSessOBJ->message = $AdmBannerOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_BannerUpd=1&banner_id=" . $param["banner_id"]);
        exit();
    }
    $messageSessOBJ->message = array("更新しました。");
} else {

    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_List=1");
        exit;
    }

    $value["file_name"] = $param["file_name"];
    $value["create_datetime"] = date("YmdHis");
    if (!$AdmBannerOBJ->insertBannerData($value, "design_file")) {
        $messageSessOBJ->message = $AdmBannerOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_List=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_banner_List=1");
exit();
?>