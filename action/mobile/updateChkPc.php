<?php
/**
 * updateChkPc.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後PCアド変更確認ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

$validationOBJ = new ComArrayValidation($param);

// 登録アドレスドメインのチェック
if ($param["pc_mail_address"]) {
    // @以降の文字列を取得
    $mailHost = substr(strstr($param["pc_mail_address"], "@"), 1);

    if (!$UserOBJ->chkRegistUserAddressDomain($mailHost)) {
        // NGドメインなのでさようなら
        header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : ""));
        exit;
    }
}

$validationOBJ->check("pc_mail_address", "PCメールアドレス",
                array("MailAddress" => null));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Update=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}
$tags = array(
            "pc_mail_address",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("param", $param);
?>
