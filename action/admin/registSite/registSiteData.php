<?php

/**
 * registSiteData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト間登録サイトデータページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmRegistSiteOBJ = AdmRegistSite::getInstance();
$registSiteData = $AdmRegistSiteOBJ->getRegistSiteData($param["regist_site_id"]);

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
    $registSiteData = $returnValue;
}

$smartyOBJ->assign("registSiteData", $registSiteData);

// 表示状態
$smartyOBJ->assign("isUse", AdmRegistSite::$_isUse);

$tags = array(
            "regist_site_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("filePath", D_BASE_DIR . AdmRegistSite::REGIST_CSV_FILE_PATH);
?>
