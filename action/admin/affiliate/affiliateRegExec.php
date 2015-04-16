<?php
/**
 * affiliateRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面アフィリエイトユーザー登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AffiliateControlOBJ = AffiliateControl::getInstance();

$insertData = null;

if (!$param["disable"]) {

    $insertData["media_cd"]                = $param["media_cd"];
    $insertData["site_name"]               = $param["site_name"];
    $insertData["path"]                    = $param["path"];
    $insertData["is_pre_regist"]           = $param["is_pre_regist"];
    $insertData["is_success_only"]         = $param["is_success_only"][0] ? $param["is_success_only"][0] : 0;
    $insertData["send_type"]               = $param["send_type"];
    $insertData["connect_type"]            = $param["connect_type"];
    $insertData["success_parameter"]       = $param["success_parameter"];
    $insertData["failure_parameter"]       = $param["failure_parameter"];
    $insertData["first_payment_parameter"] = $param["first_payment_parameter"];
    $insertData["payment_parameter"] = $param["payment_parameter"];
    $insertData["create_datetime"]         = date("YmdHis");
    $insertData["update_datetime"]         = date("YmdHis");

    foreach ($param["return_variable"] as $val) {
        if ($val) {
            $returnVariable[] = $val;
        }
    }
    foreach ($param["change_variable"] as $val) {
        if ($val) {
            $changeVariable[] = $val;
        }
    }

    $insertData["return_variable"]  = implode(",", $returnVariable);
    $insertData["change_variable"] = implode(",", $changeVariable);

    $validationOBJ = new ComArrayValidation($insertData);

    $validationOBJ->check("media_cd", "広告コード",
                    array("Value" => null),
                    array("Value" => "広告コードは必須項目です"));

    $validationOBJ->check("site_name", "サイト名",
                    array("Value" => null),
                    array("Value" => "サイト名は必須項目です"));

    if ($param["path"]) {
        $validationOBJ->check("path", "URL",
                        array("Url" => null));
    }

    $validationOBJ->check("is_pre_regist", "ファイセム用登録ステータス",
                    array("Numeric" => null),
                    array("Numeric" => "ファイセム用登録ステータスは必須項目です"));

    $validationOBJ->check("is_success_only", "送信設定",
                    array("Numeric" => null),
                    array("Numeric" => "送信設定は必須項目です"));

    $validationOBJ->check("send_type", "送信種別",
                    array("Numeric" => null),
                    array("Numeric" => "送信種別は必須項目です"));

    $validationOBJ->check("connect_type", "発行種別",
                    array("Numeric" => null),
                    array("Numeric" => "発行種別は必須項目です"));


    if ($insertData["send_type"] == AffiliateControl::SEND_TYPE_PRE_REGIST AND $insertData["connect_type"] != AffiliateControl::CONNECT_TYPE_SOCKET) {
        $validationOBJ->setErrorMessage("connect_type_2", "仮登録時発行の発行種別はソケットしか選択できません");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        if ($param["id"]) {
            header("location: ./?action_affiliate_AffiliateUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_affiliate_AffiliateList=1");
        }
        exit;
    }

    if ($param["id"]) {
        if (!$AffiliateControlOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $AffiliateControlOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_affiliate_AffiliateUpd=1&id=" . $param["id"]);
            exit;
        }

        $execMsgSessOBJ->errMsg = array("更新しました。");
        header("location: ./?action_affiliate_AffiliateUpd=1&id=" . $param["id"]);
        exit;

    } else {
        if (!$AffiliateControlOBJ->insertData($insertData)) {
            $execMsgSessOBJ->exec_msg = $AffiliateControlOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            $param["return_flag"] = true;
            header("location: ./?action_affiliate_AffiliateList=1");
            exit;
        }
        $execMsgSessOBJ->errMsg = array("登録しました。");
        header("location: ./?action_affiliate_AffiliateList=1");
        exit;
    }

} else {

    $insertData["disable"] = $param["disable"];

    if (!$AffiliateControlOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $AffiliateControlOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_affiliate_AffiliateList=1");
        exit;
    }

    $execMsgSessOBJ->exec_msg = array("削除しました。");
    header("location: ./?action_affiliate_AffiliateList=1");
    exit;
}



?>