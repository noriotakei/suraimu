<?php
/**
 * logDeleteSetList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ログ削除設定リストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmLogDeleteOBJ = AdmLogDelete::getInstance();

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

$dataList = $AdmLogDeleteOBJ->getLogDeleteSetList();

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

// 単体削除除外テーブル
$deleteException = implode("、", AdmLogDelete::$_deleteException);
$smartyOBJ->assign("deleteException", $deleteException);
?>
