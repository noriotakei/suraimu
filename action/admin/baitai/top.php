<?php

/**
 * top.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体集計リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$culcMenu = array(
                array("file_name" => "action_baitai_Check", "name" => "媒体集計", "blank" => "", "changeline" => ""),
                //array("file_name" => "action_baitai_Monthly", "name" => "日付別媒体集計(月間)", "blank" => "", "changeline" => "on"),
         );

$smartyOBJ->assign("culcMenu", $culcMenu);

$server["REMOTE_ADDR"] = $requestOBJ->getParameter("REMOTE_ADDR", "", "server");
if (array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"]) OR $server["REMOTE_ADDR"] == "220.156.98.13") {
    $remakeFlag = true;
}
$smartyOBJ->assign("remakeFlag", $remakeFlag);
?>
