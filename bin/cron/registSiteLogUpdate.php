<?php
/**
 * registSiteLogUpdate.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights reserved.
 */

/**
 * サイト間登録user_idｱｯﾌﾟﾃﾞｰﾄcron処理ファイル。
 *
 * 毎日4時に実行
 *
 * @copyright   2011 Fraise, Inc.
 * @author      norio takei
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");



$RegistSiteOBJ = RegistSite::getInstance();
/*
$countData = $RegistSiteOBJ->getUpdateData();

print_r($countData) ;
*/

$updateRegistSiteData = "";

$updateRegistSiteData["rsl.user_id"] = "u.id" ;
$updateRegistSiteData["rsl.update_datetime"] = "'".date("Y-m-d H:i:s")."'";

//PCアドレスがuser,regist_site_logと合致するものをアップデート
$whereRegistSiteArray = "";
$whereRegistSiteArray[] = "u.pc_address = rsl.mail_address" ;
$whereRegistSiteArray[] = "u.pc_address != ''" ;
$whereRegistSiteArray[] = "u.disable = 0" ; 
$whereRegistSiteArray[] = "rsl.user_id = 0" ;
$whereRegistSiteArray[] = "u.regist_status != 2" ; 

$RegistSiteOBJ->updateRegistSiteLogUserId($updateRegistSiteData, $whereRegistSiteArray);

//MBアドレスがuser,regist_site_logと合致するものをアップデート
$whereRegistSiteArray = "";
$whereRegistSiteArray[] = "u.mb_address = rsl.mail_address" ;
$whereRegistSiteArray[] = "u.mb_address != ''" ;
$whereRegistSiteArray[] = "u.disable = 0" ; 
$whereRegistSiteArray[] = "rsl.user_id = 0" ;
$whereRegistSiteArray[] = "u.regist_status != 2" ; 

$RegistSiteOBJ->updateRegistSiteLogUserId($updateRegistSiteData, $whereRegistSiteArray);

exit("COMPLETE!!");
?>