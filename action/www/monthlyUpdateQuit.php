<?php
/**
 * monthlyUpdateQuit.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後登録情報変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$UserOBJ = User::getInstance();
$MonthlyCourseOBJ     = MonthlyCourse::getInstance();

$errSessOBJ = new ComSessionNamespace("err_msg");

// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

$returnSessOBJ = new ComSessionNamespace("return");
$returnValue = $returnSessOBJ->return;
$smartyOBJ->assign("returnValue", $returnValue);
$returnSessOBJ->unsetAll();

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 変更選択
$smartyOBJ->assign("monthlyCourseUpdateStatus", array("続ける", "解除する"));

// 月額コースリスト取得
$whereArray = "";
$whereArray[] = "mcu.user_id = " . $comUserDataId;
$whereArray[] = "mcu.is_monthly_update = 1";
$monthlyCourseUserList = $MonthlyCourseOBJ->getMonthlyCourseList($whereArray);

// 月額更新があるコースが無ければサヨナラ
if (!$monthlyCourseUserList) {
    $errMsg = "現在、月額更新は付与されていません。<br>";
    $smartyOBJ->assign("errMsg", $errMsg);
    //header("Location: ./?action_MonthlyUpdateQuitEnd=1" . ($comURLparam ? "&" . $comURLparam : ""));
    //exit;
} else {
    $smartyOBJ->assign("monthlyCourseUserList", $monthlyCourseUserList);
}

?>
