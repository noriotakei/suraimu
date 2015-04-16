<?php

/**
 * bankCsvExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面銀行振込csv出力ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

ini_set("memory_limit", "-1");

$param = $requestOBJ->getParameterExcept($exceptArray);
// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$AdminUserOBJ = AdmUser::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = "&" . $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1");
    exit;
}

$userList = $AdminUserOBJ->getPayAmountCsvList($value);

if ($errSessOBJ->errMsg) {
    $errSessOBJ->errMsg = $AdminUserOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}

$fileName = "payAmountCsv_" . date("YmdHis") . ".csv";

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $fileName);


foreach ($userList as $val) {
    print(mb_convert_encoding($val["login_id"] . ",","SJIS","UTF-8"));
    print(mb_convert_encoding($val["total_payment"],"SJIS","UTF-8"));
    print("\n");
}

// セッション変数の破棄
$errSessOBJ->unsetAll();
exit;

?>
