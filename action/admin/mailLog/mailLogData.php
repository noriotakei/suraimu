<?php
/**
 * mailLogData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガログ表示ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$admMailMagazineOBJ = AdmMailMagazine::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$logData = $admMailMagazineOBJ->getMailLogData($param["mail_maga_id"]);
$AdminUserOBJ->setWhereString(unserialize($logData["search_condition"]));
$logData["where_contents"] = $AdminUserOBJ->getWhereContents();

$smartyOBJ->assign("logData", $logData);

$reloadTags = array(
            "mail_maga_id",
            );

$reloadParam = $requestOBJ->makePostTag($reloadTags);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$smartyOBJ->assign("mailReserveType", AdmMailMagazine::$_mailReserveType);
$smartyOBJ->assign("intervalSecond", AdmMailMagazine::$_intervalSecond);
?>

