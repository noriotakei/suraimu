<?php
/**
 * informationListSettingExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 情報リストグループ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmInfoListGroupOBJ = AdmInformationListGroup::getInstance();
$AdmInfoSettingOBJ   = AdmInformationListSetting::getInstance();
$messageSessOBJ      = new ComSessionNamespace("exec_msg");
$returnSessOBJ       = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラー判定
$errMsg = array();

// 更新
if ($param["sid"]) {

    // 共通更新項目データ
    $value["information_list_group"]  = $param["gid"];
    $value["update_datetime"]         = date("YmdHis");

    foreach ($param["sid"] as $val) {
        if (!ComValidation::isNumeric($param["sid"][$val])) {
            $errMsg[] = "情報フォルダを選択してください";
        }
        if (!ComValidation::isNumeric($param["is_display"][$val])) {
            $errMsg[] = "表示状態は数値で入力してください";
        }
        if (!ComValidation::isNumeric($param["mb_sort_seq"][$val])) {
            $errMsg[] = "MB表示順は数値で入力してください";
        }
        if (!ComValidation::isNumeric($param["pc_sort_seq"][$val])) {
            $errMsg[] = "PC表示順は数値で入力してください";
        }

        // エラー判定
        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
            exit();
        }

        // 更新
        $value = "";
        $value["information_category_id"] = $param["fid"][$val];
        $value["mb_sort_seq"]             = $param["mb_sort_seq"][$val];
        $value["pc_sort_seq"]             = $param["pc_sort_seq"][$val];
        $value["is_display"]              = $param["is_display"][$val];
        $value["disable"]                 = $param["disable"][$val];

        $whereArray = "";
        $whereArray[] = "id = " . $val;

        if (!$AdmInfoSettingOBJ->updateInformationListSettingData($value, $whereArray)) {
            $messageSessOBJ->message = $AdmInfoSettingOBJ->getErrorMsg();
            header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
            exit();
        }
    }
    $messageSessOBJ->message = array("更新しました。");
// 新規(フォルダ追加)
} else {

    if (!ComValidation::isNumeric($param["folder_id"])) {
        $errMsg[] = "情報フォルダを選択してください";
    }
    if (!ComValidation::isNumeric($param["is_display"])) {
        $errMsg[] = "表示状態は数値で入力してください";
    }
    if (!ComValidation::isNumeric($param["mb_sort_seq"])) {
        $errMsg[] = "MB表示順は数値で入力してください";
    }
    if (!ComValidation::isNumeric($param["pc_sort_seq"])) {
        $errMsg[] = "PC表示順は数値で入力してください";
    }

    // エラー判定
    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_cd"] = "folder";
        $returnSessOBJ->return = $param;
        header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
        exit();
    }

    $value["information_list_group_id"] = $param["gid"];
    $value["information_category_id"]   = $param["folder_id"];
    $value["mb_sort_seq"]               = $param["mb_sort_seq"];
    $value["pc_sort_seq"]               = $param["pc_sort_seq"];
    $value["is_display"]                = 1;
    $value["create_datetime"]           = date("YmdHis");
    $value["update_datetime"]           = date("YmdHis");

    if (!$AdmInfoSettingOBJ->insertInformationListSettingData($value)) {
        $messageSessOBJ->message = $AdmInfoSettingOBJ->getErrorMsg();
        $param["return_cd"] = "folder";
        $returnSessOBJ->return = $param;
            header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
}

header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
exit();
?>