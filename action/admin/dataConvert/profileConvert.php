<?php
/**
 * profileConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面プロフィールデータコンバートページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
require_once(D_BASE_DIR . "/common/admin_common.php");

$UserOBJ = User::getInstance();
ini_set("memory_limit","256M");

$columnArray = "";
$columnArray[] = "user_id";
$columnArray[] = "sex_cd";
$columnArray[] = "birth_date";
$columnArray[] = "credit_certify_phone_number";
$columnArray[] = "mb_is_mailmagazine";
$columnArray[] = "total_payment";
$columnArray[] = "buy_count";
$columnArray[] = "point";
$columnArray[] = "total_addition_point";
$columnArray[] = "total_use_point";
$columnArray[] = "last_buy_datetime";
$columnArray[] = "by_user_update_datetime";
$columnArray[] = "update_datetime";
$columnArray[] = "disable";

$selectColumnArray = "";
$selectColumnArray[] = "user_id";
$selectColumnArray[] = "sex_cd";
$selectColumnArray[] = "birth_date";
$selectColumnArray[] = "credit_certify_phone_number";
$selectColumnArray[] = "CASE WHEN is_mailmagazine = 0 THEN 1 ELSE 0 END";
$selectColumnArray[] = "total_payment";
$selectColumnArray[] = "buy_count";
$selectColumnArray[] = "point";
$selectColumnArray[] = "total_addition_point";
$selectColumnArray[] = "total_use_point";
$selectColumnArray[] = "last_buy_datetime";
$selectColumnArray[] = "by_user_update_datetime";
$selectColumnArray[] = "update_datetime";
$selectColumnArray[] = "disable";

$selectSql= "";
$selectSql = "SELECT " . implode(",", $selectColumnArray) . " FROM kohaito.profile";
if (!$dbResultOBJ = $UserOBJ->insertSelect("profile", $columnArray, $selectSql)) {
    exit("profileエラー");
}
print("profile OK<br>");
exit("COMPLETE");

?>