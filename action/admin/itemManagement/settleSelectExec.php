<?php
/**
 * settleSelectExec.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面管理ユーザー登録処理ページファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$settlementOBJ = Settlement::getInstance();

$insertData = null;

if ($param["settle_select"]) {

    $insertData["direct_settle_name"]  = $param["settle_select"] ;
    $insertData["update_datetime"]  = date("Y-m-d H:i:s");

    $validationOBJ = new ComArrayValidation($param);

    $validationOBJ->check("settle_select", "決済種別",
                    array("Value" => null),
                    array("Value" => "決済種別を選択して下さい"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_flag"] = true;
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;

        header("location: ./?action_itemManagement_ItemList=1");
        exit;
    }

    if (!$settlementOBJ->updateSettleSelectData($insertData)) {
        $execMsgSessOBJ->exec_msg = $settlementOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_itemManagement_ItemList=1");
        exit;
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");

}

header("location: ./?action_itemManagement_ItemList=1");
exit;

?>