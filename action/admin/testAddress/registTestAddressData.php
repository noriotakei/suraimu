<?php
/**
 * registTestAddressData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面広告用テストアドレスデータページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$AdmRegistTestAddressOBJ = AdmRegistTestAddress::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$addressData = $AdmRegistTestAddressOBJ->getRegistTestAddressData($param["id"]);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
} else {
    $param = $addressData;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$tags = array(
            "id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

$categoryList = $AdmRegistTestAddressOBJ->getRegistTestAddressCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmRegistTestAddress::$_isDisplay);
?>

