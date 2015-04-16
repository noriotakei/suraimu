<?php
/**
 * monthlyUpdateQuitExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PC 月額自動更新解除処理ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$UserOBJ = User::getInstance();
$MonthlyCourseOBJ     = MonthlyCourse::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

// 更新データ生成
$updateMonthlyUserArray["is_monthly_update"] = 0; // 月額更新なし
$updateMonthlyUserArray["admin_id"] = 0; // 変更者はユーザー
$updateMonthlyUserArray["update_datetime"] = date("YmdHis");

foreach ($param["id"] as $key => $val) {
    // 月額更新が「解除」でなければ処理しない
    if (!$param["monthly_update_change"][$key]) {
        continue;
    } else {
        // 更新
        if (!$MonthlyCourseOBJ->updateMonthlyCourseUserData($updateMonthlyUserArray, array("id = " . $val))) {
            $errSessOBJ->errMsg[] = "月額自動更新解除ができませんでした。<br />お手数ですが<a href=\"mailto:" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "\">" . QuitRequest::INFO_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"] . "</a>までご連絡下さい。<br>";
            header("Location: ./?action_MonthlyUpdateQuit=1" . ($comURLparam ? "&" . $comURLparam : ""));
            exit;
        }
    }
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_MonthlyUpdateQuitEnd=1" . ($comURLparam ? "&" . $comURLparam : ""));
exit;

?>