<?php
/**
 * orderingPayTypeExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面支払い種別ステータスデータ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdmPaymentLogOBJ = AdmPaymentLog::getInstance();

$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);

$tags = array(
            "sesKey",
            "ordering_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$insertData = null;

$insertData["pay_type"]       = $param["pay_type"];
$insertData["update_datetime"]  = date("YmdHis");

$validationOBJ = new ComArrayValidation($insertData);

$validationOBJ->check("pay_type", "支払い種別ステータス",
                array("Numeric" => null),
                array("Numeric" => "支払い種別ステータスを選択してください"));

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $param["return_flag"] = true;
    $param["return_cd"] = "pay_type";
    $returnSessOBJ->return = $param;
    header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
    exit;
}

// トランザクション開始
$AdmOrderingOBJ->beginTransaction();

if ($param["ordering_id"]) {

    if (!$AdmOrderingOBJ->updateOrderingData($insertData, array("id = " . $param["ordering_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $param["return_cd"] = "pay_type";
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmOrderingOBJ->rollbackTransaction();
        header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
        exit;
    }

    $execMsgSessOBJ->errMsg = array("更新しました。");
}

// コミット
$AdmOrderingOBJ->commitTransaction();

header("location: ./?action_ordering_OrderingData=1&" . $URLparam);
exit;
?>