<?php

/**
 * freeWordData.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * フリーワード設定処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmFreeWordOBJ = AdmFreeWord::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

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

$freeWordList = $AdmFreeWordOBJ->getFreeWordDataForEdit(2,$param["fwc"]) ;

$tags = array(
            "fwc",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("freeWordList", $freeWordList);
$smartyOBJ->assign("fwc", $param["fwc"]);
$smartyOBJ->assign("reloadParam", $POSTparam);

?>
