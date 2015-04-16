<?php
/**
 * baitaiAgencyAdminRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 代理店媒体CHK管理者ユーザー管理
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Norihisa Hosdoa
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmBaitaiAgencyAdminOBJ = AdmBaitaiAgencyAdmin::getInstance();

$validationOBJ = new ComArrayValidation($param);

$insertData = null;

if (!$param["disable"][0]) {

    $insertData["name"]            = $param["name"];
    $insertData["login_id"]        = $param["login_id"];
    $insertData["authority_type"]  = $param["authority_type"];

    // パスワード生成（ハッシュ化）
    if ($param["password"]) {
        $insertData["password"] = $AdmBaitaiAgencyAdminOBJ->createPasswordKey($param["password"]);
    } else {
        if (!$param["id"]) {
            $validationOBJ->setErrorMessage("password", "パスワードは必須です");
        }
    }

    $validationOBJ->check("name", "名前",
                    array("Value" => null),
                    array("Value" => "名前： は必須項目です"));

    $validationOBJ->check("login_id", "ログインID",
                    array("Value" => null),
                    array("Value" => "ログインIDは必須項目です"));

    // ログインID重複チェック
    if ($AdmBaitaiAgencyAdminOBJ->duplicateLoginId($param["login_id"], $param["id"])) {
        $validationOBJ->setErrorMessage("duplicate", "ログインIDが重複しています");
    }

    // エラーチェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;

        if ($param["id"]) {
            header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserList=1");
        }
        exit;
    }

    if ($param["id"]) {
        $insertData["update_datetime"] = date("YmdHis");
        if (!$AdmBaitaiAgencyAdminOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyAdminOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserUpd=1&id=" . $param["id"]);
            exit;
        }
        $execMsgSessOBJ->exec_msg = array("更新しました。");

        // 代理店更新画面からのアクセスなら同ページへ
        header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserUpd=1&id=" . $param["id"]);
        exit();
    } else {
        if (!$AdmBaitaiAgencyAdminOBJ->insertData($insertData)) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyAdminOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserList=1");
            exit;
        }
        $execMsgSessOBJ->exec_msg = array("登録しました。");
    }
} else {
    $insertData["update_datetime"] = date("YmdHis");
    $insertData["disable"] = $param["disable"][0];

    if (!$AdmBaitaiAgencyAdminOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyAdminOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserList=1");
        exit;
    }
    $execMsgSessOBJ->exec_msg = array("削除しました。");
}
header("location: ./?action_baitaiAgency_BaitaiAgencyAdminUserList=1");
exit;



?>
