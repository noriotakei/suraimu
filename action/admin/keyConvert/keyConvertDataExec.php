<?php
/**
 * keyConvertDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * システム変換更新処理ページファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

$updateData = null;
$tags = array(
            "key_convert_list_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

if ($param["key_convert_list_id"]) {

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("key_name", "変換キー",
                    array("Value" => null),
                    array("Value" => "変換キーは必須項目です"));

    $validationOBJ->check("type", "タイプ",
                    array("Value" => null, "Numeric" => null),
                    array("Value" => "タイプを選択してください",
                          "Numeric" => "タイプを選択してください"));

    $validationOBJ->check("key_convert_list_category_id", "カテゴリー",
                    array("Value" => null, "Numeric" => null),
                    array("Value" => "カテゴリーを選択してください",
                          "Numeric" => "カテゴリーを選択してください"));

    // 重複チェック
    if ($AdmKeyConvertOBJ->duplicateKeyConvertKeyName($param["key_name"], $param["key_convert_list_id"])) {
        $validationOBJ->setErrorMessage("duplicate", "変換キーが重複しています");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $param["return_cd"] = "list";
        $param["return_flag"] = 1;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }


    $updateData["key_convert_list_category_id"]         = $param["key_convert_list_category_id"];
    $updateData["key_name"]         = $param["key_name"];
    $updateData["type"]             = $param["type"];
    $updateData["description"]      = $param["description"];

    if ($loginAdminData["authority_type"] == $configOBJ->define->AUTHORITY_TYPE_SYSTEM) {
        $updateData["is_not_update"]  = $param["is_not_update"];
    }
    $updateData["update_datetime"]  = date("YmdHis");

    if (!$AdmKeyConvertOBJ->updateData($updateData, array("id = " . $param["key_convert_list_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmKeyConvertOBJ->getErrorMsg();
        $param["return_cd"] = "list";
        $param["return_flag"] = 1;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");
}


header("location: ./?action_keyConvert_KeyConvertData=1&" . $URLparam);
exit;

?>