<?php
/**
 * keyConvertCategoryList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面システム変換カテゴリー設定リストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);
// 入力項目の取得
$param = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

$dataList = $AdmKeyConvertOBJ->getKeyConvertCategoryList();

// 戻り値設定
if ($param["return_type"] == 1) {
    $smartyOBJ->assign("param", $param);
} else if ($param["return_type"] == 2) {
    $smartyOBJ->assign("paramAry", $param);
} else {
    $param["return_type"] = 0;
    $smartyOBJ->assign("param", $param);
}
$smartyOBJ->assign("param", $param);

$smartyOBJ->assign("dataList", $dataList);


?>
