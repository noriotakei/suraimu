<?php
/**
 * passchangeExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後パスワード変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$UserOBJ = User::getInstance();
$errSessOBJ = new ComSessionNamespace("err_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

$validationOBJ = new ComArrayValidation($param);

if ($UserOBJ->createPasswordKey($param["old_password"]) != $comUserData["password"]) {
    $validationOBJ->setErrorMessage("old_password", "現パスワードが違います。");
}

$validationOBJ->check("old_password", "現パスワード",
                array("Alnum" => null));

$validationOBJ->check("new_password", "新パスワード",
                array("Alnum" => null));

if (mb_strlen($param["new_password"]) < 4 OR mb_strlen($param["new_password"]) > 8) {
    $validationOBJ->setErrorMessage("new_password", "新パスワードは4桁以上８桁以下で入力してください。");
}
if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Passchange=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// トランザクション開始
$UserOBJ->beginTransaction();

$updateUserData["password"] = $UserOBJ->createPasswordKey($param["new_password"]);

if (!$UserOBJ->updateUserData($updateUserData, array("id=" . $comUserData["user_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_Passchange=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

$updateProfileData["by_user_update_datetime"] = date("YmdHis");
if (!$UserOBJ->updateProfileData($updateProfileData, array("id=" . $comUserData["profile_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_Passchange=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// コミット
$UserOBJ->commitTransaction();
header("Location: ./?action_PasschangeComplete=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit();

?>
