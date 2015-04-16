<?php
/**
 * itemCategoryData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面表示場所フォルダ更新ページ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$admItemOBJ = AdmItem::getInstance();

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
$itemCategoryData = $admItemOBJ->getItemCategoryData($param["icid"]);
$smartyOBJ->assign("itemCategoryData", $itemCategoryData);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmItem::$_isDisplay);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $param = $itemCategoryData;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$tags = array(
            "icid",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// カテゴリーグループ
$smartyOBJ->assign("categoryGroupSelect", AdmItem::$_categoryGroupAry);

?>

