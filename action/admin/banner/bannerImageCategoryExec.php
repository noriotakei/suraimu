<?php
/**
 * bannerImageCategoryExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面バナー画像カテゴリー更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmBannerOBJ = AdmBanner::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"]) {

    $param["return_type"] = 2;
    $AdmBannerOBJ->beginTransaction();

    foreach ($param["id"] as $key => $val) {

        $value = "";

        if (!$param["name"][$key]) {
            $errMsg[] = "ID " . $val . ":名前を入力してください";
        }

        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $returnSessOBJ->return = $param;
            $AdmBannerOBJ->rollbackTransaction();
            header("Location: ./?action_banner_BannerImageCategoryList=1");
            exit();
        }

        $value["update_datetime"] = date("YmdHis");
        $value["name"] = $param["name"][$key];
        $value["disable"] = $param["disable"][$key];

        if (!$AdmBannerOBJ->updateBannerImageCategoryData($value , array("id = " . $val))) {
            $messageSessOBJ->message = $AdmBannerOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $AdmBannerOBJ->rollbackTransaction();
            header("Location: ./?action_banner_BannerImageCategoryList=1");
            exit();
        }
    }

    $AdmBannerOBJ->commitTransaction();
    $messageSessOBJ->message = array("更新しました。");

} else {

    $param["return_type"] = 1;

    if (!$param["name"]) {
        $errMsg[] = "名前を入力してください";
    }

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_BannerImageCategoryList=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];

    if (!$AdmBannerOBJ->insertBannerImageCategoryData($value)) {
        $messageSessOBJ->message = $AdmBannerOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_banner_BannerImageCategoryList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

}
header("Location: ./?action_banner_BannerImageCategoryList=1");
exit();
?>