<?php
/**
 * keyConvertontentsDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * システム変換コンテンツ更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$param["display_start_datetime"] = $param["disp_datetime_from_date"]
                        . " " . $param["disp_datetime_from_time"];

if ($param["disp_datetime_to_date"] AND $param["disp_datetime_to_time"]) {
    $param["display_end_datetime"] = $param["disp_datetime_to_date"]
                            . " " . $param["disp_datetime_to_time"];
} else {
    $param["display_end_datetime"] = 0;
}

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

$keyConvertData = $AdmKeyConvertOBJ->getKeyConvertData($param["key_convert_list_id"]);

$tags = array(
            "key_convert_list_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

if ($param["convert_contents_id"]) {
    $updateData = null;

    $updateData["key_convert_list_id"]  = $param["key_convert_list_id"];
    $updateData["update_datetime"]  = date("YmdHis");
    $updateData["display_start_datetime"] = $param["display_start_datetime"];
    $updateData["display_end_datetime"] = $param["display_end_datetime"];
    $updateData["disable"] = $param["disable"];

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("contents", "変換内容",
                    array("Value" => null),
                    array("Value" => "変換内容を入力してください。"));
    $updateData["contents"]         = $param["contents"];

    $validationOBJ->check("display_start_datetime", "表示開始日時",
                    array("Datetime" => null),
                    array("Datetime" => "表示開始日時を正しく入力してください。"));

    if ($param["disp_datetime_to_date"] AND $param["disp_datetime_to_time"]) {
        $validationOBJ->check("display_end_datetime", "表示終了日時",
                        array("Datetime" => null),
                        array("Datetime" => "表示終了日時を正しく入力してください。"));
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }

    if (!$AdmKeyConvertOBJ->updateKeyConvertContentsData($updateData, array("id = " . $param["convert_contents_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmKeyConvertOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");

} else {

    $insertData = null;

    $insertData["key_convert_list_id"]  = $param["key_convert_list_id"];
    $insertData["update_datetime"]  = date("YmdHis");
    $insertData["display_start_datetime"] = $param["display_start_datetime"];
    $insertData["display_end_datetime"] = $param["display_end_datetime"];

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("contents", "変換内容",
                    array("Value" => null),
                    array("Value" => "変換内容を入力してください。"));
    $insertData["contents"]         = $param["contents"];

    $validationOBJ->check("display_start_datetime", "表示開始日時",
                    array("Datetime" => null),
                    array("Datetime" => "表示開始日時を正しく入力してください。"));

    if ($param["disp_datetime_to_date"] AND $param["disp_datetime_to_time"]) {
        $validationOBJ->check("display_end_datetime", "表示終了日時",
                        array("Datetime" => null),
                        array("Datetime" => "表示終了日時を正しく入力してください。"));
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_flag"] = 1;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }

    if (!$AdmKeyConvertOBJ->insertKeyConvertContentsData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmKeyConvertOBJ->getErrorMsg();
        $param["return_flag"] = 1;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }
    $execMsgSessOBJ->errMsg = array("登録しました。");
}

header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
exit;

?>