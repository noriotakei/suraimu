<?php
/**
 * baitaiAgencyRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 代理店媒体CHKユーザー登録処理ページファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmBaitaiAgencyOBJ = AdmBaitaiAgency::getInstance();

$insertData = null;

if (!$param["disable"][0]) {

    $insertData["name"]                    = $param["name"];
    $insertData["login_id"]                = $param["login_id"];
    $insertData["display_password"]        = $param["display_password"];
    $insertData["is_auth_ip_address"]      = $param["is_auth_ip_address"];
    $insertData["is_display_trade_amount"] = $param["is_display"];

    // パスワード生成（ハッシュ化）
    if ($param["display_password"]) {
        $insertData["password"] = $AdmBaitaiAgencyOBJ->createPasswordKey($param["display_password"]);
    } else {
        $validationOBJ->setErrorMessage("display_password", "パスワードは必須です");
    }

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "代理店名",
                    array("Value" => null),
                    array("Value" => "代理店名： は必須項目です"));

    $validationOBJ->check("login_id", "ログインID",
                    array("Value" => null),
                    array("Value" => "ログインIDは必須項目です"));

    // ログインID重複チェック
    if ($AdmBaitaiAgencyOBJ->duplicateLoginId($param["login_id"], $param["id"])) {
        $validationOBJ->setErrorMessage("duplicate", "ログインIDが重複しています");
    }

    // エラーチェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;

        if ($param["id"]) {
            header("location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_baitaiAgency_BaitaiAgencyList=1");
        }
        exit;
    }

    // 更新
    if ($param["id"]) {
        $insertData["update_datetime"] = date("YmdHis");
        if (!$AdmBaitaiAgencyOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit;
        }
        $execMsgSessOBJ->exec_msg = array("更新しました。");

        // 代理店更新画面からのアクセスなら同ページへ
        if ($param["agency_upd"]) {
            header("location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit();
        }
    } else {
        // 新規
        $insertData["create_datetime"] = date("YmdHis");
        if (!$AdmBaitaiAgencyOBJ->insertData($insertData)) {
            $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            header("location: ./?action_baitaiAgency_BaitaiAgencyList=1");
            exit;
        }
        $execMsgSessOBJ->exec_msg = array("登録しました。");
    }
} else {
    $insertData["update_datetime"] = date("YmdHis");
    $insertData["disable"] = $param["disable"][0];

    if (!$AdmBaitaiAgencyOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmBaitaiAgencyOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_baitaiAgency_BaitaiAgencyList=1");
        exit;
    }
    $execMsgSessOBJ->exec_msg = array("削除しました。");
}
header("location: ./?action_baitaiAgency_BaitaiAgencyList=1");
exit;

?>