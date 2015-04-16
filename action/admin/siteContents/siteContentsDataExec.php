<?php
/**
 * siteContentsDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト表示内容データ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$param["start_datetime"] = $param["start_datetime_Date"] . " " . $param["start_datetime_Time"];
if ($param["end_datetime_Date"] OR $param["end_datetime_Time"]) {
    $param["end_datetime"] = $param["end_datetime_Date"] . " " . $param["end_datetime_Time"];
}

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmSiteContentsOBJ = AdmSiteContents::getInstance();

$tags = array(
            "page_banner_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// データ登録、更新
if (!$param["disable"]) {

    $insertData = null;

    $insertData["display_cd"]            = $param["display_cd"];
    $insertData["title"]                 = $param["title"];
    $insertData["html_contents_pc"]         = $param["html_contents_pc"];
    $insertData["html_contents_mb"]         = $param["html_contents_mb"];
    $insertData["start_datetime"]        = $param["start_datetime"];
    $insertData["end_datetime"]          = $param["end_datetime"];
    $insertData["is_display"]            = $param["is_display"];
    $insertData["update_datetime"]       = date("YmdHis");

    $validationOBJ = new ComArrayValidation($insertData);

    $validationOBJ->check("display_cd", "表示場所コード",
                    array("Numeric" => null),
                    array("Numeric" => "表示場所コードは必須項目です"));

    $validationOBJ->check("title", "タイトル",
                    array("Value" => null),
                    array("Value" => "タイトルは必須項目です"));

    $validationOBJ->check("start_datetime", "表示開始日時",
                    array("DateTime" => null),
                    array("DateTime" => "表示開始日時は必須項目です"));

    if ($param["end_datetime"]) {
        $validationOBJ->check("end_datetime", "表示終了日時",
                        array("DateTime" => null),
                        array("DateTime" => "表示終了日時が正しくありません"));
    }

    $validationOBJ->check("is_display", "表示フラグ",
                    array("Numeric" => null),
                    array("Numeric" => "表示フラグは必須項目です"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_siteContents_SiteContentsData=1&" . $URLparam);
        exit;
    }

    if ($param["page_banner_id"]) {

        if (!$AdmSiteContentsOBJ->updateSiteContentsData($insertData, array("id = " . $param["page_banner_id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmSiteContentsOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_siteContents_SiteContentsData=1&" . $URLparam);
            exit;
        }

        $execMsgSessOBJ->errMsg = array("更新しました。");
        header("location: ./?action_siteContents_SiteContentsData=1&" . $URLparam);
        exit;

    } else {

        if ($validationOBJ->isError()) {
            $errorMsg = $validationOBJ->getErrorMessage();
            $execMsgSessOBJ->exec_msg = $errorMsg;
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_siteContents_SiteContentsList=1");
            exit;
        }

        if (!$AdmSiteContentsOBJ->insertSiteContentsData($insertData)) {
            $execMsgSessOBJ->exec_msg = $AdmSiteContentsOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_siteContents_SiteContentsList=1");
            exit;
        }

        $execMsgSessOBJ->errMsg = array("登録しました。");
        header("location: ./?action_siteContents_SiteContentsList=1");
        exit;
    }

// データ削除
} else if ($param["disable"]) {

    $insertData["disable"] = 1;
    if (!$AdmSiteContentsOBJ->updateSiteContentsData($insertData, array("id = " . $param["page_banner_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmSiteContentsOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_siteContents_SiteContentsList=1");
        exit;
    }

    header("location: ./?action_siteContents_SiteContentsList=1");
    exit;
}

?>