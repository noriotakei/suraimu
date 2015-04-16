<?php
/**
 * mailLogConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メール系データコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit","256M");
$MailAddressChangeOBJ = MailAddressChange::getInstance();

$columnArray = "";
$columnArray[] = "user_id";
$columnArray[] = "mail_address";
$columnArray[] = "error_count";
$columnArray[] = "error_type";
$columnArray[] = "device_cd";
$columnArray[] = "create_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.error_mail_log";
if (!$dbResultOBJ = $MailAddressChangeOBJ->insertSelect("error_mail_log", $columnArray, $selectSql)) {
    exit("error_mail_logエラー");
}

$columnArray = "";
$columnArray[] = "user_id";
$columnArray[] = "mail_address";
$columnArray[] = "create_datetime";
$columnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $columnArray) . " FROM kohaito.mail_address_change";
if (!$dbResultOBJ = $MailAddressChangeOBJ->insertSelect("mail_address_change", $columnArray, $selectSql)) {
    exit("mail_address_changeエラー");
}

exit("COMPLETE");

?>