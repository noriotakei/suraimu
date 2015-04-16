<?php
/**
 * common.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * Web側/管理側共通処理。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(__FILE__)));

// include pathを設定
ini_set("include_path", D_BASE_DIR . "/class");

// autoload関数定義ファイル
require_once(D_BASE_DIR . "/common/__autoload.php");

$requestOBJ = ComRequest::getInstance();
$configOBJ  = ComConfig::getInstance();
$utilityOBJ  = ComUtility::getInstance();
$smartyOBJ  = ComSmarty::getInstance();

$_config = $configOBJ->toArray();
$smartyOBJ->assign("config", $_config);
?>
