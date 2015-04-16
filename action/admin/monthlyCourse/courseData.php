<?php
/**
 * courseData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側月額コース更新ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 商品データの取得
if ($param["mcid"]) {
    $monthlyCourseData = $admMonthlyCourseOBJ->getMonthlyCourseData($param["mcid"]);
    $smartyOBJ->assign("monthlyCourseData", $monthlyCourseData);
}

$tags = array(
            "mcid",
            "search_group_id",
            "search_is_display",
            "search_type",
            "search_monthy_course_id",
            "specify_keyword",
            "search_string",
            "sort_id",
            "sort_seq",
            "offset",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// 作るものは作ったのでもう初期化
$param = array();

// 戻り値(入力項目)の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

if ($returnValue) {

    $param = $returnValue;

} elseif ($monthlyCourseData)  {
    $param = $monthlyCourseData;
} else {
    $execMsgSessOBJ->message = array("データ取得に失敗しました。");
    header("Location: ./?action_MonthlyCourse_courseSearchList");
    exit;
}

$smartyOBJ->assign("param", $param);

// select用商品カテゴリーリスト取得
if ($monthlyCourseGroupListForSelect = $admMonthlyCourseOBJ->getMonthlyCourseGroupForSelect()) {
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

?>