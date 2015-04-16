<?php
/**
 * baitaiAgencyCdSettingExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 媒体コード設定更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmBaitaiAgencyCdSettingOBJ = AdmBaitaiAgencyCdSetting::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$validationOBJ = new ComArrayValidation($param);

// エラー判定
$errMsg = array();

// 更新
if ($param["agency_id"]) {
    foreach ($param["agency_id"] as $val) {

        if (!ComValidation::isValue($param["media_name"][$val])) {
            $errMsg[] = "媒体名を入力してください";
        }
        if (!ComValidation::isValue($param["media_cd"][$val])) {
            $errMsg[] = "媒体コードを入力してください";
        }
        if (!ComValidation::isNumeric($param["advertise_expenses"][$val])  && $param["advertise_expenses"][$val]) {
            $errMsg[] = "広告費は数値で入力してください";
        }
        if (!ComValidation::isNumeric($param["advertise_expenses_once"][$val])  && $param["advertise_expenses_once"][$val]) {
            $errMsg[] = "広告費(一回払い)は数値で入力してください";
        }
        if (!ComValidation::isNumeric($param["advertise_expenses_apiece"][$val])  && $param["advertise_expenses_apiece"][$val]) {
            $errMsg[] = "広告費（単価）は数値で入力してください";
        }
        if (!ComValidation::isNumeric($param["advertise_expenses_percent"][$val]) && $param["advertise_expenses_percent"][$val]) {
            $errMsg[] = "成果報酬は数値で入力してください";
        }
        if (!ComValidation::isDate($param["advertise_period_from"][$val]) AND $param["advertise_period_from"][$val] != "0000-00-00") {
            $errMsg[] = "適切な広告期間fromを入力してください";
        }
        if (!ComValidation::isDate($param["advertise_period_to"][$val]) AND $param["advertise_period_to"][$val] != "0000-00-00") {
            $errMsg[] = "適切な広告期間toを入力してください";
        }

        // エラー判定
        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit();
        }

        $whereArray = "";
        $value = "";

        // 更新
        $value["media_name"]      = $param["media_name"][$val];
        $value["media_cd"]        = $param["media_cd"][$val];
        $value["advertise_expenses_type"]        = $param["advertise_expenses_type"][$val];
        $value["advertise_expenses"]        = $param["advertise_expenses"][$val];
        $value["advertise_expenses_once"]        = $param["advertise_expenses_once"][$val];
        $value["advertise_expenses_apiece"]        = $param["advertise_expenses_apiece"][$val];
        $value["advertise_expenses_percent"]        = $param["advertise_expenses_percent"][$val];
        $value["advertise_period_from"]        = $param["advertise_period_from"][$val] ;
        $value["advertise_period_to"]        = $param["advertise_period_to"][$val] ;
        //$value["advertise_expenses_percent_span"]        = $param["span_for_percent"][$val];
        $value["disable"]         = $param["disable"][$val];
        $value["update_datetime"] = date("YmdHis");

        $whereArray[] = "id = " . $val;

        if (!$AdmBaitaiAgencyCdSettingOBJ->updateData($value, $whereArray)) {
            $messageSessOBJ->message = $AdmBaitaiAgencyCdSettingOBJ->getErrorMsg();
            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit();
        }
    }
    $messageSessOBJ->message = array("更新しました。");
// 新規
} else {

    if (!ComValidation::isValue($param["media_name"])) {
        $errMsg[] = "媒体名を入力してください";
    }
    if (!ComValidation::isValue($param["media_cd"])) {
        $errMsg[] = "媒体コードを入力してください";
    }

    // エラー判定
    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_cd"] = "setting";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
        exit();
    }

    $value["baitai_agency_id"] = $param["id"];
    $value["media_name"]       = $param["media_name"];
    $value["media_cd"]         = $param["media_cd"];
    $value["create_datetime"]  = date("YmdHis");
    $value["update_datetime"]  = date("YmdHis");

    if (!$AdmBaitaiAgencyCdSettingOBJ->insertData($value)) {
        $messageSessOBJ->message = $AdmBaitaiAgencyCdSettingOBJ->getErrorMsg();
        $param["return_cd"] = "setting";
        $returnSessOBJ->return = $param;
            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
exit();
?>