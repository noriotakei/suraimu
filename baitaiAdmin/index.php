<?php

/**
 * index.php
 *
 * Copyright (c) 2009 ZEN Creative, Inc.
 * All rights reserved.
 */

/**
 * 代理店媒体CHK インデックスページ。
 *
 * @copyright   2009 ZEN Creative, Inc.
 * @author      norihsa hosoda
 */

// Web側・管理側共通処理ファイルの読み込み
require_once(realpath("..") . "/common/common.php");

$controllerOBJ = new ComControllerBaitaiAdmin();

// リクエストされたアクション名をセット
$controllerOBJ->setActionName($requestOBJ->getActionName());

// PHP処理ファイルの読み込み
require_once($controllerOBJ->getBusinessLogic());

// HTML表示ファイルの読み込み
$smartyOBJ->display($controllerOBJ->getTemplate());

?>
