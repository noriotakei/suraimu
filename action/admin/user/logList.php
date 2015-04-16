<?php

/**
 * logList.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ログリストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$logMenu = array(
                array("file_name" => "action_log_PointLog=1", "name" => "ポイントログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_OrderingLog=1", "name" => "注文ログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_PaymentLog=1", "name" => "入金ログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_InformationStatusLog=1", "name" => "情報アクセスログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_MailMagaSendLog=1", "name" => "送信メルマガログ", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_log_ReserveMailMagaSendLog=1", "name" => "送信予約メルマガログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_RegularMailMagaSendLog=1", "name" => "送信定期メルマガログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_FreeWordLog=1", "name" => "フリーワードログ", "blank" => "", "changeline" => ""),
                array("file_name" => "action_log_PaymentTagLog=1", "name" => "入金タグ発行ログ", "blank" => "", "changeline" => ""),
                );

$smartyOBJ->assign("logMenu", $logMenu);

$AdminUserOBJ = AdmUser::getInstance();

$userId = $requestOBJ->getParameter("user_id");
$userData =$AdminUserOBJ->getUserData($userId);
$smartyOBJ->assign("userData", $userData);

$tags = array(
            "user_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);


?>
