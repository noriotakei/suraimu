<?php
/**
 * supportMailDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール定型文更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmSupportMailOBJ = AdmSupportMail::getInstance();

$tags = array(
            "support_mail_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$insertData = null;

$insertData["name"]            = $param["name"];
$insertData["sort_seq"]        = $param["sort_seq"];
$insertData["pc_subject"]         = $param["pc_subject"];
$insertData["pc_text_body"]       = $param["pc_text_body"];
$insertData["mb_subject"]         = $param["mb_subject"];
$insertData["mb_text_body"]       = $param["mb_text_body"];
$insertData["update_datetime"] = date("YmdHis");
if (!$param["disable"]) {
    $validationOBJ = new ComArrayValidation($insertData);

    $validationOBJ->check("name", "定型文名",
                    array("Value" => null),
                    array("Value" => "定型文名を入力してください"));

    $validationOBJ->check("sort_seq", "優先順位",
                    array("Numeric" => null),
                    array("Numeric" => "優先順位を数値で入力してください"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->errMsg = $errorMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_SupportMailData=1&" . $URLparam);
        exit;
    }
}
if ($param["support_mail_id"]) {

    if ($param["disable"]) {
        $insertData["disable"] = $param["disable"];
    }
    if (!$AdmSupportMailOBJ->updateSupportMailData($insertData, array("id = " . $param["support_mail_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmSupportMailOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_SupportMailData=1&" . $URLparam);
        exit;
    }

    if ($param["disable"]) {
        $execMsgSessOBJ->errMsg = array("削除しました。");
        header("location: ./?action_ordering_SupportMailList=1&" . $URLparam);
    } else {
        $execMsgSessOBJ->errMsg = array("更新しました。");
        header("location: ./?action_ordering_SupportMailData=1&" . $URLparam);
    }
    exit;

} else {

    if (!$AdmSupportMailOBJ->insertSupportMailData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmSupportMailOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_ordering_SupportMailData=1&" . $URLparam);
        exit;
    }
    $execMsgSessOBJ->errMsg = array("登録しました。");
    header("location: ./?action_ordering_SupportMailList=1");
    exit;

}


?>