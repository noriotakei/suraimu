<?php
/**
 * registSiteDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト間登録サイト登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmRegistSiteOBJ = AdmRegistSite::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "regist_site_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

if ($param["regist_site_id"] AND $param["disable"]) {

    $value["update_datetime"] = date("YmdHis");
    $value["disable"] = $param["disable"];

    if (!$AdmRegistSiteOBJ->updateRegistSiteData($value , array("id = " . $param["regist_site_id"]))) {
        $messageSessOBJ->message = $AdmRegistSiteOBJ->getErrorMsg();
        header("Location: ./?action_registSite_RegistSiteList=1");
        exit();
    }

    $messageSessOBJ->message = array("削除しました。");

    header("Location: ./?action_registSite_RegistSiteList=1");
    exit();

} else if ($param["regist_site_id"]) {

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "サイト名",
                    array("Value" => null),
                    array("Value" => "サイト名は必須項目です"));

    $validationOBJ->check("cd", "サイトコード",
                    array("Value" => null),
                    array("Value" => "サイトコードは必須項目です"));

    $validationOBJ->check("path", "PATH",
                    array("Url" => null),
                    array("Url" => "PATHは必須項目です"));

    $validationOBJ->check("is_use", "使用状況",
                    array("Numeric" => null),
                    array("Numeric" => "使用状況は必須項目です"));

    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];
    $value["cd"] = $param["cd"];
    $value["path"] = $param["path"];
    $value["is_use"] = $param["is_use"];

    if (!$AdmRegistSiteOBJ->updateRegistSiteData($value , array("id = " . $param["regist_site_id"]))) {
        $messageSessOBJ->message = $AdmRegistSiteOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
        exit();
    }

    $messageSessOBJ->message = array("更新しました。");
    header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
    exit();

} else {

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "サイト名",
                    array("Value" => null),
                    array("Value" => "サイト名は必須項目です"));

    $validationOBJ->check("cd", "サイトコード",
                    array("Value" => null),
                    array("Value" => "サイトコードは必須項目です"));

    $validationOBJ->check("path", "PATH",
                    array("Url" => null),
                    array("Url" => "PATHは必須項目です"));

    $validationOBJ->check("is_use", "使用状況",
                    array("Numeric" => null),
                    array("Numeric" => "使用状況は必須項目です"));

    if ($validationOBJ->isError()) {
        $messageSessOBJ->message = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_registSite_RegistSiteList=1");
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["name"] = $param["name"];
    $value["cd"] = $param["cd"];
    $value["path"] = $param["path"];
    $value["is_use"] = $param["is_use"];

    if (!$AdmRegistSiteOBJ->insertRegistSiteData($value)) {
        $messageSessOBJ->message = $AdmRegistSiteOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_registSite_RegistSiteList=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");

    header("Location: ./?action_registSite_RegistSiteList=1");
    exit();

}

?>