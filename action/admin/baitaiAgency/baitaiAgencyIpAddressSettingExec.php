<?php
/**
 * baitaiAgencyIpAddressSettingExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 代理店認証IPアドレス設定更新処理ページ
 *
 *
 * @copyright   2011 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmBaitaiAgencyIpAddressSettingOBJ = AdmBaitaiAgencyIpAddressSetting::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$validationOBJ = new ComArrayValidation($param);

// エラー判定
$errMsg = array();

// 更新
if ($param["ip_address_setting_id"]) {
    foreach ($param["ip_address_setting_id"] as $key => $val) {

        // IPアドレスチェック
        if ($param["ip_address"]) {
            foreach ($param["ip_address"] as $ipAry) {
                foreach ($ipAry as $ip) {
                    if (!ComValidation::isNumeric($ip)) {
                        $validationOBJ->setErrorMessage("ip_address", "IPアドレスは数値のみ入力可能です");
                    }
                }
            }
        }

        // エラーチェック
        if ($validationOBJ->isError()) {
            $errorMsg = $validationOBJ->getErrorMessage();
            $messageSessOBJ->exec_msg = $errorMsg;
            $returnSessOBJ->return = $param;

            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit();
        }

        $whereArray = "";
        $value = "";

        // IPアドレス生成
        $value["ip_address"] = implode(".", $param["ip_address"][$val]);

        // 更新
        $value["is_use"]          = $param["is_use"][$key];
        $value["disable"]         = $param["disable"][$val];
        $value["update_datetime"] = date("YmdHis");

        $whereArray[] = "id = " . $val;

        if (!$AdmBaitaiAgencyIpAddressSettingOBJ->updateData($value, $whereArray)) {
            $messageSessOBJ->message = $AdmBaitaiAgencyIpAddressSettingOBJ->getErrorMsg();
            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
            exit();
        }
    }
    $messageSessOBJ->message = array("更新しました。");
// 新規
} else {
    // IPアドレスチェック
    if ($param["ip_address"]) {
        foreach ($param["ip_address"] as $val) {
            if (!ComValidation::isNumeric($val)) {
                $validationOBJ->setErrorMessage("ip_address", "IPアドレスは数値のみ入力可能です");
            }
        }
    }

    // エラーチェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $param["return_cd"] = "ip_setting";
        $returnSessOBJ->return = $param;
        $messageSessOBJ->exec_msg = $errorMsg;
        header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
        exit();
    }

    $value["baitai_agency_id"] = $param["id"];
    $value["ip_address"]       = implode(".", $param["ip_address"]);
    $value["is_use"]           = $param["is_use"];
    $value["create_datetime"]  = date("YmdHis");

    if (!$AdmBaitaiAgencyIpAddressSettingOBJ->insertData($value)) {
        $messageSessOBJ->message = $AdmBaitaiAgencyIpAddressSettingOBJ->getErrorMsg();
        $param["return_cd"] = "ip_setting";
        $returnSessOBJ->return = $param;
            header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_baitaiAgency_BaitaiAgencyUpd=1&id=" . $param["id"]);
exit();
?>