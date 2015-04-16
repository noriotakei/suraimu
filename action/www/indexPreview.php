<?php
/**
 * indexPreview.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCインデックスプレビューページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/user_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
if ($param[RegistPage::PAGE_CD_NAME]) {
    $userSessOBJ->psd = $param[RegistPage::PAGE_CD_NAME];
}

// 登録ページの取得
$RegistPageOBJ = RegistPage::getInstance();
$registPageData = $RegistPageOBJ->getRegistPagePreviewDataForRegistCd($userSessOBJ->psd);
if (!$registPageData) {
    $registPageData = $RegistPageOBJ->getRegistPagePreviewDataForRegistCd("index");
}
$smartyOBJ->assign("registPageData", $registPageData);

require_once($controllerOBJ->getIncludeBusinessLogic("include"));

?>
