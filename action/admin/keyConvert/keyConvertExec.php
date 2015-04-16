<?php
/**
 * keyConvertExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * システム変換一括更新処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

$insertData = null;

if ($param["convert_list_id"]) {
    // トランザクション開始
    $AdmKeyConvertOBJ->beginTransaction();

    foreach ($param["convert_list_id"] as $id) {

        if ($loginAdminData["authority_type"] == $configOBJ->define->AUTHORITY_TYPE_SYSTEM) {
            $insertData["is_not_update"]  = $param["not_update"][$id];
        }
        $insertData["disable"]          = $param["disable"][$id];
        $insertData["update_datetime"]  = date("YmdHis");

        if (!$AdmKeyConvertOBJ->updateData($insertData, array("id = " . $id))) {
            $execMsgSessOBJ->exec_msg = $AdmKeyConvertOBJ->getErrorMsg();
            // ロールバック
            $AdmKeyConvertOBJ->rollbackTransaction();
            header("location: ./?action_keyConvert_KeyConvertData=1&id=" . $param["id"]);
            exit;
        }
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");

    // トランザクション終了
    $AdmKeyConvertOBJ->commitTransaction();

} else {

    $insertData["key_convert_list_category_id"]         = $param["key_convert_list_category_id"];
    $insertData["key_name"]         = $param["key_name"];
    $insertData["type"]             = $param["type"];
    $insertData["description"]      = $param["description"];
    if ($loginAdminData["authority_type"] == $configOBJ->define->AUTHORITY_TYPE_SYSTEM) {
        $insertData["is_not_update"]  = $param["not_update"];
    }
    $insertData["update_datetime"]  = date("YmdHis");

    $validationOBJ = new ComArrayValidation($insertData);

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
    if ($AdmKeyConvertOBJ->duplicateKeyConvertKeyName($param["key_name"])) {
        $validationOBJ->setErrorMessage("duplicate", "変換キーが重複しています");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertList=1");
        exit;
    }

    if (!$AdmKeyConvertOBJ->insertData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmKeyConvertOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("location: ./?action_keyConvert_KeyConvertList=1");
        exit;
    }
    $execMsgSessOBJ->errMsg = array("登録しました。");
}

header("location: ./?action_keyConvert_KeyConvertList=1");
exit;

?>