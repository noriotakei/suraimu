<?php
/**
 * deleteExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーデータ削除ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err");

$adminUserOBJ = AdmUser::getInstance();
$setData["disable"] = 1;
$setData["update_datetime"] = date("YmdHis");

if ($param["user_id"]) {

    if (!$adminUserOBJ->updateUserData($setData, array("id = " . $param["user_id"]))) {
        $errSessOBJ->exec_msg = $adminUserOBJ->getErrorMsg();
        header("Location: ./?action_User_detail=1&user_id=" . $param["user_id"]);
        exit;
    }
    $errSessOBJ->exec_msg = array("削除しました。");
}

header("Location: ./?action_User_detail=1");
exit;

?>