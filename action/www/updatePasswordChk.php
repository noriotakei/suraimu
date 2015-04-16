<?php
/**
 * updatePasswordChk.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後パスワード変更確認ページ処理ファイル。
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
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$tags = array(
            "old_password",
            "new_password",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("oldPassword", $param["old_password"]);
$smartyOBJ->assign("newPassword", $param["new_password"]);

?>
