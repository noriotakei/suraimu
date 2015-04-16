<?php

/**
 * pointGrantExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報詳細更新処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$AdmPointLogOBJ = AdmPointLog::getInstance();

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


$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("point", "ポイント",
                array("Numeric" => null),
                array("Numeric" => "ポイントは数値で入力してください"));

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

$whereArray = $AdminUserOBJ->setWhereString($searchParam);

// トランザクション開始
$AdminUserOBJ->beginTransaction();

// ポイントログ挿入
$columnArray[] = "IF (point = 0, " . $param["point"] . ", IF ((point + (" . $param["point"] . ")) <= 0, (0 -  point), " . $param["point"] . "))";
$columnArray[] = "user_id";
$columnArray[] = AdmPointLog::TYPE_GRANT;
$columnArray[] = "NOW()";

$listSql = $AdminUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

$insertColmun[] = "point";
$insertColmun[] = "user_id";
$insertColmun[] = "type";
$insertColmun[] = "create_datetime";

if (!$AdmPointLogOBJ->insertSelectPointLogData($insertColmun, $listSql)) {
    $messageSessOBJ->message = array("ポイントばらまき更新できませんでした。");
    // ロールバック
    $AdminUserOBJ->rollbackTransaction();
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

// ポイントアップロード
$setProfileParam["profile.point"] = "IF ((v_user_profile.point + (" . $param["point"] . ")) <= 0, 0, v_user_profile.point + (" . $param["point"] . "))";
// 現在ポイントに足したポイントが０より大なら、そのまま合計付与ポイントに足す
// それ以外なら、合計付与ポイントから現在ポイントを引いたポイントが0以下なら0、０より大なら合計付与ポイントから現在ポイントを引く
$setProfileParam["profile.total_addition_point"] = "IF ((v_user_profile.point + (" . $param["point"] . ")) > 0, v_user_profile.total_addition_point + (" . $param["point"] . "), IF ((v_user_profile.total_addition_point  -  v_user_profile.point) <= 0, 0, v_user_profile.total_addition_point  -  v_user_profile.point))";
$setProfileParam["profile.update_datetime"] = "'" . date("YmdHis") . "'";

$userProfileWhere = $whereArray;

$table = "profile join v_user_profile on profile.id = v_user_profile.profile_id";

if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, $table, false)) {
    $messageSessOBJ->message = array("ポイントばらまき更新できませんでした。");
    // ロールバック
    $AdminUserOBJ->rollbackTransaction();
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

$messageSessOBJ->message = array("ポイントばらまき完了しました。");

// コミット
$AdminUserOBJ->commitTransaction();

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;


?>
