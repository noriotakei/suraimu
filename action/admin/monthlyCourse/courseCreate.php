<?php
/**
 * courseCreate.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側月額登録ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnParam = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();
$smartyOBJ->assign("returnParam", $returnParam);

// select用商品カテゴリーリスト取得
if ($monthlyCourseGroupListForSelect = $AdmMonthlyCourseOBJ->getMonthlyCourseGroupForSelect()) {
    $smartyOBJ->assign("monthlyCourseGroupListForSelect", $monthlyCourseGroupListForSelect);
} else {
    $smartyOBJ->assign("monthlyCourseGroupListForSelect", array("" => "グループの登録が有りません"));
}


// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmMonthlyCourse::$_isDisplay);

// 同グループ同コース更新タイプ
$smartyOBJ->assign("sameMonthlyCourseType", AdmMonthlyCourse::$_sameMonthlyCourseType);

// 同グループ別コース更新タイプ
$smartyOBJ->assign("differentMonthlyCourseType", AdmMonthlyCourse::$_differentMonthlyCourseType);

// 入金状態
//$smartyOBJ->assign("paymentStatus", AdmMonthlyCourse::$_paymentStatus);


?>