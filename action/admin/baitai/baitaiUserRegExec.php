<?php
/**
 * baitaiRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体CHKユーザー登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$insertData = null;

if (!$param["disable"][0]) {

    $insertData["name"]          = $param["name"];
    $insertData["login_id"]      = $param["login_id"];
    $insertData["password"]      = $AdmBaitaiOBJ->createPasswordKey($param["password"]);
    $insertData["authority_type"] = $param["authority_type"];
    $insertData["update_datetime"] = date("YmdHis");

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "名前",
                    array("Value" => null),
                    array("Value" => "名前は必須項目です"));

    $validationOBJ->check("login_id", "ログインID",
                    array("Value" => null),
                    array("Value" => "ログインIDは必須項目です"));

    $validationOBJ->check("password", "パスワード",
                    array("Value" => null),
                    array("Value" => "パスワードは必須項目です"));

    // ログインID重複チェック
    if ($AdmBaitaiOBJ->duplicateLoginId($param["login_id"], $param["id"])) {
        $validationOBJ->setErrorMessage("duplicate", "ログインIDが重複しています");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        if ($param["id"]) {
            header("location: ./?action_baitai_BaitaiUserUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_baitai_BaitaiUserList=1");
        }
        exit;
    }

    if ($param["id"]) {
        if (!$AdmBaitaiOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            print_r();
            header("location: ./?action_baitai_BaitaiUserUpd=1&id=" . $param["id"]);
            exit;
        }

        $execMsgSessOBJ->exec_msg = array("更新しました。");
    } else {
        if (!$AdmBaitaiOBJ->insertData($insertData)) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            header("location: ./?action_baitai_BaitaiUserList=1");

            exit;
        }
        $execMsgSessOBJ->exec_msg = array("登録しました。");
    }
} else {

    $insertData["disable"] = $param["disable"][0];

    if (!$AdmBaitaiOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmBaitaiOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_baitai_BaitaiUserList=1");
        exit;
    }

    $execMsgSessOBJ->exec_msg = array("削除しました。");
}

header("location: ./?action_baitai_BaitaiUserList=1");
exit;

?>