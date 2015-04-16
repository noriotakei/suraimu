<?php
/**
 * mailLogData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメール送信ログ表示ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();
$AdmOrderingOBJ = AdmOrdering::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$logData = $AdmSupportMailLogOBJ->getSupportMailSendLogData($param["support_mail_log_id"]);
$AdmOrderingOBJ->setWhereString(unserialize($logData["search_condition"]));
$logData["where_contents"] = $AdmOrderingOBJ->getWhereContents();

$smartyOBJ->assign("logData", $logData);

$reloadTags = array(
            "support_mail_log_id",
            );

$reloadParam = $requestOBJ->makePostTag($reloadTags);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$smartyOBJ->assign("mailReserveType", AdmSupportMail::$_mailReserveType);
$smartyOBJ->assign("intervalSecond", AdmSupportMail::$_intervalSecond);
?>

