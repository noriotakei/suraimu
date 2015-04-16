<?php

/**
 * userCount.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面会員数合計リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$serializeParam = $requestOBJ->getParameterExcept($exceptArray);
$param = $serializeParam + unserialize(urldecode($serializeParam["serialize"]));

$AdmCalculationOBJ = AdmCalculation::getInstance();
$AdmCalculationOBJ->setDebugFlag(false);

// 期間指定
if (ComValidation::isDate($param["start_date"])) {
    $defaultWhereArray[] = "u.regist_datetime >= '" . $param["start_date"] . " 00:00:00'";
}

// 期間指定
if (ComValidation::isDate($param["end_date"])) {
    $defaultWhereArray[] = "u.regist_datetime <= '" . $param["end_date"] . " 23:59:59'";
}

$dataList = $AdmCalculationOBJ->getCalcUserCount($param, "", $defaultWhereArray);
foreach ((array)$dataList as $val) {
    $val["total_user"] = $val["pre_user"] + $val["user"] + $val["quit_user"];
    $val["total_pc_is_mailmagazine"] = $val["pc_is_mailmagazine_ok"] + $val["pc_is_mailmagazine_ng"];
    $val["total_mb_is_mailmagazine"] = $val["mb_is_mailmagazine_ok"] + $val["mb_is_mailmagazine_ng"];
    $val["total_pc_send_status"] = $val["send_status_ok_pc"] + $val["send_status_ng_pc"];
    $val["total_mb_send_status"] = $val["send_status_ok_mb"] + $val["send_status_ng_mb"];
    $val["total_pc_address_status"] = $val["send_ok_pc"] + $val["no_addr_pc"] + $val["refusal_pc"] + $val["no_domain_pc"] + $val["fail_auto_pc"];
    $val["total_mb_address_status"] = $val["send_ok_mb"] + $val["no_addr_mb"] + $val["refusal_mb"] + $val["no_domain_mb"] + $val["fail_auto_mb"];

    $jsonData[] = array("group" => "登録状態", "count" => $val["pre_user"], "name" => "仮登録人数", "persent" =>  ($val["pre_user"] / $val["total_user"] * 100));
    $jsonData[] = array("group" => "登録状態","count" => $val["user"], "name" => "本登録人数", "persent" =>  ($val["user"] / $val["total_user"] * 100));
    $jsonData[] = array("group" => "登録状態","count" => $val["quit_user"], "name" => "解除会員人数", "persent" =>  ($val["quit_user"] / $val["total_user"] * 100));
    $jsonData[] = array("group" => "PCメルマガ受信状態", "count" => $val["pc_is_mailmagazine_ok"], "name" => "PCメール受け取る", "persent" =>  ($val["pc_is_mailmagazine_ok"] / $val["total_pc_is_mailmagazine"] * 100));
    $jsonData[] = array("group" => "PCメルマガ受信状態", "count" => $val["pc_is_mailmagazine_ng"], "name" => "PCメール受け取らない", "persent" =>  ($val["pc_is_mailmagazine_ng"] / $val["total_pc_is_mailmagazine"] * 100));
    $jsonData[] = array("group" => "PCメルマガ管理用受信状態", "count" => $val["send_status_ok_pc"], "name" => "PCメールする(管理用)", "persent" =>  ($val["send_status_ok_pc"] / $val["total_pc_send_status"] * 100));
    $jsonData[] = array("group" => "PCメルマガ管理用受信状態", "count" => $val["send_status_ng_pc"], "name" => "PCメールしない(管理用)", "persent" =>  ($val["send_status_ng_pc"] / $val["total_pc_send_status"] * 100));
    $jsonData[] = array("group" => "PCアドレスステータス状態", "count" => $val["send_ok_pc"], "name" => "PCｱﾄﾞﾚｽｽﾃｲﾀｽする", "persent" =>  ($val["send_ok_pc"] / $val["total_pc_address_status"] * 100));
    $jsonData[] = array("group" => "PCアドレスステータス状態", "count" => $val["no_addr_pc"], "name" => "PCｱﾄﾞﾚｽｽﾃｲﾀｽしない(拒否)", "persent" =>  ($val["no_addr_pc"] / $val["total_pc_address_status"] * 100));
    $jsonData[] = array("group" => "PCアドレスステータス状態", "count" => $val["refusal_pc"], "name" => "PCｱﾄﾞﾚｽｽﾃｲﾀｽしない(ｱﾄﾞﾚｽ無し)", "persent" =>  ($val["refusal_pc"] / $val["total_pc_address_status"] * 100));
    $jsonData[] = array("group" => "PCアドレスステータス状態", "count" => $val["no_domain_pc"], "name" => "PCｱﾄﾞﾚｽｽﾃｲﾀｽしない(ﾄﾞﾒｲﾝ無し)", "persent" =>  ($val["no_domain_pc"] / $val["total_pc_address_status"] * 100));
    $jsonData[] = array("group" => "PCアドレスステータス状態", "count" => $val["fail_auto_pc"], "name" => "PCｱﾄﾞﾚｽｽﾃｲﾀｽしない自動", "persent" =>  ($val["fail_auto_pc"] / $val["total_pc_address_status"] * 100));
    $jsonData[] = array("group" => "MBメルマガ受信状態", "count" => $val["mb_is_mailmagazine_ok"], "name" => "MBメール受け取る", "persent" =>  ($val["mb_is_mailmagazine_ok"] / $val["total_mb_is_mailmagazine"] * 100));
    $jsonData[] = array("group" => "MBメルマガ受信状態", "count" => $val["mb_is_mailmagazine_ng"], "name" => "MBメール受け取らない", "persent" =>  ($val["mb_is_mailmagazine_ng"] / $val["total_mb_is_mailmagazine"] * 100));
    $jsonData[] = array("group" => "MBメルマガ管理用受信状態", "count" => $val["send_status_ok_mb"], "name" => "MBメールする(管理用)", "persent" =>  ($val["send_status_ok_mb"] / $val["total_mb_send_status"] * 100));
    $jsonData[] = array("group" => "MBメルマガ管理用受信状態", "count" => $val["send_status_ng_mb"], "name" => "MBメールしない(管理用)", "persent" =>  ($val["send_status_ng_mb"] / $val["total_mb_send_status"] * 100));
    $jsonData[] = array("group" => "MBアドレスステータス状態", "count" => $val["send_ok_mb"], "name" => "MBｱﾄﾞﾚｽｽﾃｲﾀｽする", "persent" =>  ($val["send_ok_mb"] / $val["total_mb_address_status"] * 100));
    $jsonData[] = array("group" => "MBアドレスステータス状態", "count" => $val["no_addr_mb"], "name" => "MBｱﾄﾞﾚｽｽﾃｲﾀｽしない(拒否)", "persent" =>  ($val["no_addr_mb"] / $val["total_mb_address_status"] * 100));
    $jsonData[] = array("group" => "MBアドレスステータス状態", "count" => $val["refusal_mb"], "name" => "MBｱﾄﾞﾚｽｽﾃｲﾀｽしない(ｱﾄﾞﾚｽ無し)", "persent" =>  ($val["refusal_mb"] / $val["total_mb_address_status"] * 100));
    $jsonData[] = array("group" => "MBアドレスステータス状態", "count" => $val["no_domain_mb"], "name" => "MBｱﾄﾞﾚｽｽﾃｲﾀｽしない(ﾄﾞﾒｲﾝ無し)", "persent" =>  ($val["no_domain_mb"] / $val["total_mb_address_status"] * 100));
    $jsonData[] = array("group" => "MBアドレスステータス状態", "count" => $val["fail_auto_mb"], "name" => "MBｱﾄﾞﾚｽｽﾃｲﾀｽしない自動", "persent" =>  ($val["fail_auto_mb"] / $val["total_mb_address_status"] * 100));
    $jsonData[] = array("group" => "総会員人数", "count" => $val["total_user"], "name" => "総会員人数");
}
$res = array(
          'success' => true,
          'rows' => $jsonData
      );

header("Content-Type:application/x-json; charset=UTF-8");
echo json_encode($res);
exit;

?>
