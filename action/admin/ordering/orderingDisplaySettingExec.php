<?php
/**
 * orderingDisplaySettingExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 予約注文表示管理登録処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmOrderingOBJ = AdmOrdering::getInstance();

$insertData = null;

if ($param["display_cd"]) {
    // トランザクション開始
    $AdmOrderingOBJ->beginTransaction();

    foreach ($param["display_cd"] as $cd) {

        $insertData["is_display"]         = $param["is_display"][$cd];
        $insertData["update_datetime"]  = date("YmdHis");


        $validationOBJ = new ComArrayValidation($insertData);

        $validationOBJ->check("is_display", "表示状態",
                        array("Value" => null, "Numeric" => null),
                        array("Value" => "表示状態を選択してください",
                              "Numeric" => "表示状態を選択してください"));

        if ($validationOBJ->isError()) {
            $errorMsg = $validationOBJ->getErrorMessage();
            $execMsgSessOBJ->exec_msg = $errorMsg;
            // ロールバック
            $AdmOrderingOBJ->rollbackTransaction();
            header("location: ./?action_keyConvert_KeyConvertList=1");
            exit;
        }

        if ($orderingDisplaySettingData = $AdmOrderingOBJ->getOrderingDisplaySettingData($cd)) {
                if (!$AdmOrderingOBJ->updateOrderingDisplaySettingData($insertData, array("id = " . $orderingDisplaySettingData["id"]))) {
                    $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                    // ロールバック
                    $AdmOrderingOBJ->rollbackTransaction();
                    header("location: ./?action_ordering_OrderingDisplaySetting=1");
                    exit;
                }
        } else {

            $insertData["display_cd"] = $cd;
            if (!$AdmOrderingOBJ->insertOrderingDisplaySettingData($insertData)) {
                $execMsgSessOBJ->exec_msg = $AdmOrderingOBJ->getErrorMsg();
                // ロールバック
                $AdmOrderingOBJ->rollbackTransaction();
                    header("location: ./?action_ordering_OrderingDisplaySetting=1");
                exit;
            }
        }
    }

    // トランザクション終了
    $AdmOrderingOBJ->commitTransaction();

    $execMsgSessOBJ->errMsg = array("更新しました。");

} else {
    $execMsgSessOBJ->errMsg = array("更新データがありません。");
}

header("location: ./?action_ordering_OrderingDisplaySetting=1");
exit;

?>