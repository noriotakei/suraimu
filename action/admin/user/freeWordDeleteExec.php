<?php
/**
 * freeWordDeleteExec.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーリスト 設定処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
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

// 条件データ生成
$freeWordType = $param["free_word_type"];
$freeWordCd = $param["free_word_cd"];

$AdmFreeWordOBJ = AdmFreeWord::getInstance();

// トランザクション開始
$AdminUserOBJ->beginTransaction();

foreach ($userList as $val) {

    $updateArray = array() ;
    $whereArray = array() ;
 
    $updateArray["disable"] = 1;
    $updateArray["update_datetime"] = date("YmdHis");
    $whereArray[] = "user_id = ".$val["user_id"] ;
    $whereArray[] = "free_word_type = ".$freeWordType ;
    $whereArray[] = "free_word_cd = ".$freeWordCd ;

    // 更新
    if (!$AdmFreeWordOBJ->updateConvertFreeWordData($updateArray, $whereArray)) {
        $messageSessOBJ->message = array("ﾌﾘｰﾜｰﾄﾞ削除に失敗しました。");
        // ロールバック
        $AdminUserOBJ->rollbackTransaction();
        $messageSessOBJ->message = $errorMsg;
        header("location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit;
    }

}

$messageSessOBJ->message = array("ﾌﾘｰﾜｰﾄﾞ削除完了しました。");

// コミット
$AdminUserOBJ->commitTransaction();

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;

?>
