<?php
/**
 * groupData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面月額コースグループ更新ページ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 商品カテゴリーデータ取得
$monthlyCourseGroupData = $admMonthlyCourseOBJ->getMonthlyCourseGroupData($param["mcgid"]);
$smartyOBJ->assign("monthlyCourseGroupData", $monthlyCourseGroupData);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmItem::$_isDisplay);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $param = $monthlyCourseGroupData;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$tags = array(
            "mcgid",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
?>

