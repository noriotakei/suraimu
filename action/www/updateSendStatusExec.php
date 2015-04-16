<?php
/**
 * updateSendStatusExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後登録変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$UserOBJ = User::getInstance();
$errSessOBJ = new ComSessionNamespace("err_msg");

$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$param = $requestOBJ->getParameterExcept($exceptArray);
if (ComValidation::isNumeric($param["pc_is_mailmagazine"])) {
    $updateProfileData["pc_is_mailmagazine"] = $param["pc_is_mailmagazine"];
}
if (ComValidation::isNumeric($param["mb_is_mailmagazine"])) {
    $updateProfileData["mb_is_mailmagazine"] = $param["mb_is_mailmagazine"];
}

// トランザクション開始
$UserOBJ->beginTransaction();

if ($updateProfileData) {

    $updateProfileData["by_user_update_datetime"] = date("YmdHis");
    if (!$UserOBJ->updateProfileData($updateProfileData, array("id=" . $comUserData["profile_id"]))) {
        $errSessOBJ->errMsg = $UserOBJ->getErrorMsg;
        // ロールバック
        $UserOBJ->rollbackTransaction();
        header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit();
    }

    // コミット
    $UserOBJ->commitTransaction();
} else {
    $errSessOBJ->errMsg[] = "配信の変更を選択してください。";
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

header("Location: ./?action_UpdateSendStatusComplete=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
