<?php
/**
 * mailSendEnd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガ送信完了ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$admMailMagazineOBJ = AdmMailMagazine::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["mail_maga_log_id"]) {
    $logData = $admMailMagazineOBJ->getMailLogData($param["mail_maga_log_id"]);
    $smartyOBJ->assign("logData", $logData);
} else {
    $execMsgSessOBJ = new ComSessionNamespace("exec_msg");
    // メッセージの取得
    $smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
    // セッション変数の破棄
    $execMsgSessOBJ->unsetAll();
}

$tags = array(
            "sesKey",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $reloadParam);
?>
