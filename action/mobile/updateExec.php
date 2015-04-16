<?php
/**
 * updateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後登録変更ページ処理ファイル。
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

// 登録アドレスドメインのチェック(前ページでチェックしたけど念の為...。)
if ($param["pc_mail_address"]) {
    // @以降の文字列を取得
    $mailHost = substr(strstr($param["pc_mail_address"], "@"), 1);

    if (!$UserOBJ->chkRegistUserAddressDomain($mailHost)) {
        // NGドメインなのでさようなら
        header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

if (ComValidation::isNumeric($param["mb_is_mailmagazine"])) {
    $validationOBJ->check("mb_is_mailmagazine", "携帯配信の変更",
                    array("Numeric" => null),
                    array("Numeric" => "配信の変更は必須項目です"));
    $updateProfileData["mb_is_mailmagazine"] = $param["mb_is_mailmagazine"];
}

if (ComValidation::isNumeric($param["pc_is_mailmagazine"])) {
    $validationOBJ->check("pc_is_mailmagazine", "PC配信の変更",
                    array("Numeric" => null),
                    array("Numeric" => "配信の変更は必須項目です"));
    $updateProfileData["pc_is_mailmagazine"] = $param["pc_is_mailmagazine"];
}

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// トランザクション開始
$UserOBJ->beginTransaction();

$updateProfileData["by_user_update_datetime"] = date("YmdHis");
if (!$UserOBJ->updateProfileData($updateProfileData, array("id=" . $comUserData["profile_id"]))) {
    $errSessOBJ->errMsg[] = "データ更新できませんでした。";
    // ロールバック
    $UserOBJ->rollbackTransaction();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit();
}

// コミット
$UserOBJ->commitTransaction();
header("Location: ./?action_UpdateComplete=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
exit();
?>
