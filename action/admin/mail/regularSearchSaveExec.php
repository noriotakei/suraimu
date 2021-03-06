<?php
/**
 * regularSearchSaveExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期メルマガ検索条件更新ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$tags = array(
            "sesKey",
            "mail_maga_regular_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1&" . $URLparam);
    exit;
}

if (!$param["mail_maga_regular_id"]) {
    $execMsgSessOBJ->message[] = "定期メルマガIDが入力されていません。";
    header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

// ユーザー検索条件SQL生成
$columnArray = "";
$whereArray = "";
$columnArray[] = "SQL_CALC_FOUND_ROWS *";
$whereArray = $AdmMailMagazineOBJ->setWhereString($value);
$listSql = $AdmMailMagazineOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

// 定期メルマガ内容の追加
$mailLog["search_sql"] = htmlspecialchars($listSql, ENT_QUOTES);
$mailLog["update_datetime"] = date("YmdHis");

// 検索条件
$mailLog["search_condition"] = $requestOBJ->getParameterEscape(serialize($value), "sql");

$idArray = explode(",", trim($param["mail_maga_regular_id"], ","));

foreach ($idArray as $val) {

    if (!$AdmMailMagazineOBJ->getMailRegularData($val)) {
        $execMsgSessOBJ->message[] = "定期メルマガID:" . $val . "のメールデータがありません。";
        continue;
    }

    // 書き込み
    if (!$AdmMailMagazineOBJ->updateMailMagaRegular($mailLog, array("id = " . $val))) {
        $execMsgSessOBJ->message[] = "定期メルマガID:" . $val . "は更新できませんでした。";
    } else {
        $execMsgSessOBJ->message[] = "定期メルマガID:" . $val . "の定期メルマガ条件を更新しました。";
    }
}

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;
?>

