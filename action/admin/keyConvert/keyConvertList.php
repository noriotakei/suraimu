<?php
/**
 * keyConvertList.php
 *
 * システム変換一覧
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();
$KeyConvertOBJ = KeyConvert::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $param["return_flag"] = 0;
}

$keyConvertList = $AdmKeyConvertOBJ->getKeyConvertAll();
while (list($key, $val) = each($keyConvertList)) {
    $keyConvertList[$key]["contents"] = $AdmKeyConvertOBJ->keyConvertContentsData($val["id"]);
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$smartyOBJ->assign("keyConvertList", $keyConvertList);

$categoryList = $AdmKeyConvertOBJ->getKeyConvertCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);

?>