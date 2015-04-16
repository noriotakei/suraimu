<?php

/**
 * siteContentsData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト表示内容データページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmSiteContentsOBJ = AdmSiteContents::getInstance();
$siteContentsData = $AdmSiteContentsOBJ->getSiteContentsData($param["page_banner_id"]);

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
    $siteContentsData = $returnValue;
}

$smartyOBJ->assign("siteContentsData", $siteContentsData);

// 表示状態
$smartyOBJ->assign("displayFlag", AdmSiteContents::$_disableFlag);
// 表示場所コード
$smartyOBJ->assign("disableCd", AdmSiteContents::$_disableCd);

$tags = array(
            "page_banner_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
?>
