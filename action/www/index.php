<?php
/**
 * index.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCインデックスページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/pre_common.php");

header("Location: http://fm.ko-haito.com/?action_FrontDesk=true&id=9c5fb6ff76&ad_code=zz99999");

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

// 登録ページの取得
$RegistPageOBJ = RegistPage::getInstance();
$registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd($userSessOBJ->psd, $mailToConvertArray);
if (!$registPageData) {
    $registPageData = $RegistPageOBJ->getRegistPageDataForRegistCd("index", $mailToConvertArray);
}
$smartyOBJ->assign("registPageData", $registPageData);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>
