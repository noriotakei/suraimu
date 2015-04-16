<?php
/**
 * adminRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面管理ユーザー登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$admAdminOBJ = AdmAdmin::getInstance();

$insertData = null;

if (!$param["disable"][0]) {

    $insertData["name"]          = $param["name"];
    $insertData["login_id"]      = $param["login_id"];
    if ($param["password"]) {
        $insertData["password"]      = $admAdminOBJ->createPasswordKey($param["password"]);
    }

    $insertData["auto_update_flag"]  = 0 ;
    if($param["auto_update_flag"][0]){
        $insertData["auto_update_flag"] = $param["auto_update_flag"][0] ;
    }

    $insertData["send_mail_address"]      = $param["send_mail_address"];

    $insertData["authority_type"] = $param["authority_type"];
    $insertData["update_datetime"] = date("YmdHis");

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "名前",
                    array("Value" => null),
                    array("Value" => "名前は必須項目です"));

    $validationOBJ->check("login_id", "ログインID",
                    array("Value" => null),
                    array("Value" => "ログインIDは必須項目です"));

    $validationOBJ->check("authority_type", "管理区分",
                    array("Value" => null, "Numeric" => null),
                    array("Value" => "管理区分を選択してください",
                          "Numeric" => "管理区分を選択してください"));

    $validationOBJ->check("send_mail_address", "メールアドレス",
                    array("Value" => null),
                    array("Value" => "メールアドレスは必須項目です"));

    // ログインID重複チェック
    if ($admAdminOBJ->duplicateLoginId($param["login_id"], $param["id"])) {
        $validationOBJ->setErrorMessage("duplicate", "ログインIDが重複しています");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        if ($param["id"]) {
            header("location: ./?action_adminUser_AdminUserUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_adminUser_AdminUserList=1");
        }
        exit;
    }

    if ($param["id"]) {
        if (!$admAdminOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $admAdminOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_adminUser_AdminUserUpd=1&id=" . $param["id"]);
            exit;
        }

        $execMsgSessOBJ->errMsg = array("更新しました。");

    } else {
        if (!$admAdminOBJ->insertData($insertData)) {
            $execMsgSessOBJ->exec_msg = $admAdminOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            header("location: ./?action_adminUser_AdminUserList=1");
            exit;
        }
        $execMsgSessOBJ->errMsg = array("登録しました。");
    }
} else {

    $insertData["disable"] = $param["disable"][0];

    if (!$admAdminOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $admAdminOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_adminUser_AdminUserList=1");
        exit;
    }

    $execMsgSessOBJ->exec_msg = array("削除しました。");
}


// 変更がログインユーザーと同じユーザーならログインしなおし
if ($param["id"] == $loginAdminData["id"]) {

    $adminData = $admAdminOBJ->getData($param["id"]);
    // ログインデータの破棄
    $adminAuthOBJ->clearIdentity();
    // 認証する
    if (!$adminAuthOBJ->authentication($adminData["login_id"], $adminData["password"], true)){
        // セッション変数の破棄
        $execMsgSessOBJ->unsetAll();
        $returnSessOBJ->unsetAll();
        header("Location: ./?action_logout=1");
        exit;
    }
}

header("location: ./?action_adminUser_AdminUserList=1");
exit;

?>