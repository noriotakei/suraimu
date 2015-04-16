<?php
/**
 * taikai.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後退会ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

$SiteContentsOBJ = SiteContents::getInstance();

$quitPrStartData = $SiteContentsOBJ->getSiteContentsData(SiteContents::DISPLAY_CD_QUIT_START_PR,$comUserData["user_id"]);

$smartyOBJ->assign("quitPrStartData", $quitPrStartData["html_contents_pc"]);

?>
