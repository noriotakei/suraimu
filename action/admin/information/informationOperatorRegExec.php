<?php
/**
 * informationOpetatorRegExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 問い合わせ管理者処理ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmInfoOperatorOBJ = AdmInformationOperator::getInstance();

$insertData = null;

if (!$param["disable"][0]) {

    $insertData["name"]       = $param["name"];
    $insertData["is_display"] = $param["is_display"];
    $insertData["admin_id"]   = $param["admin_id"];

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("name", "名前",
                    array("Value" => null),
                    array("Value" => "名前は必須項目です"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        if ($param["id"]) {
            header("location: ./?action_information_InformationOperatorUpd=1&id=" . $param["id"]);
        } else {
            header("location: ./?action_information_InformationOperatorList=1");
        }
        exit;
    }

    // 更新
    if ($param["id"]) {
        $insertData["update_datetime"] = date("YmdHis");
        if (!$AdmInfoOperatorOBJ->updateData($insertData, array("id = " . $param["id"]))) {
            $execMsgSessOBJ->exec_msg = $AdmInfoOperatorOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_information_InformationOperatorUpd=1&id=" . $param["id"]);
            exit;
        }

        $execMsgSessOBJ->errMsg = array("更新しました。");

    } else {
        // 新規

        // トランザクション開始
        $AdmInfoOperatorOBJ->beginTransaction();
        $insertData["create_datetime"] = date("YmdHis");
        if (!$AdmInfoOperatorOBJ->insertData($insertData)) {
            // ロールバック
            $AdmInfoOperatorOBJ->rollbackTransaction();
            $execMsgSessOBJ->exec_msg = $AdmInfoOperatorOBJ->getErrorMsg();
            $returnSessOBJ->return = $param;
            header("location: ./?action_information_InformationOperatorList=1");
            exit;
        }

        // カラム「sakura」にIDを更新する
        $infoOperatorId = $AdmInfoOperatorOBJ->getInsertId();
        $insertData["sakura"] = $infoOperatorId;

        if (!$AdmInfoOperatorOBJ->updateData($insertData, array("id = " . $infoOperatorId))) {
            // ロールバック
            $AdmInfoOperatorOBJ->rollbackTransaction();
            $execMsgSessOBJ->exec_msg = $AdmInfoOperatorOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("location: ./?action_information_InformationOperatorList=1");
            exit;
        }
        // コミット
        $AdmInfoOperatorOBJ->commitTransaction();

        $execMsgSessOBJ->errMsg = array("登録しました。");
    }
} else {

    $insertData["disable"] = $param["disable"][0];
    $insertData["update_datetime"] = date("YmdHis");
    if (!$AdmInfoOperatorOBJ->updateData($insertData, array("id = " . $param["id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmInfoOperatorOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_information_InformationOperatorList=1");
        exit;
    }

    $execMsgSessOBJ->exec_msg = array("削除しました。");
}

header("location: ./?action_information_InformationOperatorList=1");
exit;


?>
