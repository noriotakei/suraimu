<?php

/**
 * siteContentsList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト表示内容リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmSiteContentsOBJ = AdmSiteContents::getInstance();
$siteContentsList = $AdmSiteContentsOBJ->getSiteContentsList();
foreach((array)$siteContentsList as $key => $val){
    if (($val["end_datetime"] > 0 AND strtotime($val["end_datetime"]) <= strtotime("NOW")) OR !$val["is_display"]) {
        $siteContentsList[$key]["style"] = "background-color:red;";
    }
}
$smartyOBJ->assign("siteContentsList", $siteContentsList);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 表示状態
$smartyOBJ->assign("displayFlag", AdmSiteContents::$_disableFlag);
// 表示場所コード
$smartyOBJ->assign("disableCd", AdmSiteContents::$_disableCd);
?>
