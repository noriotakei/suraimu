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
 * @author      norihisa_hosoda
 */

require_once(D_BASE_DIR . "/common/baitai_agency_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$culcMenu = array(
                array("file_name" => "action_agency_Days", "name" => "起点日集計", "blank" => "", "changeline" => ""),
                array("file_name" => "action_agency_Monthly", "name" => "起点月集計<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
         );

$smartyOBJ->assign("culcMenu", $culcMenu);

?>
