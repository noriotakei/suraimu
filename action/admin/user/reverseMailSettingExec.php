<?php
/**
 * reverseMailSettingExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーリスト 強行メール設定処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdminUserOBJ = AdmUser::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$messageSessOBJ = new ComSessionNamespace("exec_msg");
$errSessOBJ = new ComSessionNamespace("err");

$param = $requestOBJ->getParameterExcept($exceptArray);

$userSearchSessOBJ = new ComSessionNamespace("user_search");

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}

$userList = $AdminUserOBJ->getUserList($searchParam);

// 更新データ生成
$setUserParam["is_pc_reverse"] = $param["is_pc_reverse"];
$setUserParam["is_mb_reverse"] = $param["is_mb_reverse"];

// トランザクション開始
$AdminUserOBJ->beginTransaction();


foreach ($userList as $val) {
    // 更新
    if (!$AdminUserOBJ->updateUserData($setUserParam, $val["id"])) {
        $messageSessOBJ->message = array("強行メール設定の更新できませんでした。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
        $messageSessOBJ->message = $errorMsg;
        header("location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit;
    }

}

$messageSessOBJ->message = array("強行メール設定完了しました。");

// コミット
$AdminUserOBJ->commitTransaction();

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;

?>
