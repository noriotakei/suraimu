<?php
/**
 * unitCreate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユニット登録フォームページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

ini_set("memory_limit", "-1");

$adminUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションにセットします
$userSearchSessOBJ = new ComSessionNamespace("user_search");
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

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
}

$userList = $adminUserOBJ->getUserList($searchParam, "", "", 1);
$totalCount = $adminUserOBJ->getFoundRows();

$smartyOBJ->assign("totalCount", $totalCount);

if ($adminUserOBJ->getErrorMsg()) {
    $errSessOBJ->errMsg = $adminUserOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}

$smartyOBJ->assign("whereContents", $adminUserOBJ->getWhereContents());

$requestOBJ->setParameter("sesKey", $param["sesKey"]);
$tags = array(
            "sesKey",
            );
$reloadTags = array(
            "sesKey",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

