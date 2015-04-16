<?php
/**
 * informationListGroupExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 情報リストグループ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmInfoListGroupOBJ = AdmInformationListGroup::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// エラー判定
$errMsg = array();

// 更新
if ($param["gid"]) {

    // 削除
    if ($param["disable"]) {
        $value = array(); // 一度初期化

        $value["disable"] = true;
        $value["update_datetime"] = date("YmdHis");

        foreach ($param["gid"] as $val) {
            $whereArray = array();
            $whereArray[] = "id = " . $val;

            if (!$AdmInfoListGroupOBJ->updateInformationListGroupData($value, $whereArray)) {
                $messageSessOBJ->message = $AdmInfoListGroupOBJ->getErrorMsg();
                $param["return_flag"] = true;
                $returnSessOBJ->return = $param;
                header("Location: ./?action_informationListManagement_InformationListGroup=1");
                exit();
            }
        }
        $messageSessOBJ->message = array("削除しました。");
        header("Location: ./?action_informationListManagement_InformationListGroup=1");
        exit();
    } else {
        // 更新
        if (!$param["name"]) {
            $errMsg[] = "グループ名を入力してください";
        }
        if (!ComValidation::isNumeric($param["is_display"])) {
            $errMsg[] = "表示状態は数値で入力してください";
        }

        if (!ComValidation::isNumeric($param["sort_seq"])) {
            $errMsg[] = "表示順は数値で入力してください";
        }

        // エラー判定
        if ($errMsg) {
            $messageSessOBJ->message = $errMsg;
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
            exit();
        }

        $value["name"]        = $param["name"];
        $value["sort_seq"]    = $param["sort_seq"];
        $value["is_display"]  = $param["is_display"];

        // 更新
        $whereArray[] = "id = " . $param["gid"];
        $value["update_datetime"] = date("YmdHis");

        if (!$AdmInfoListGroupOBJ->updateInformationListGroupData($value, $whereArray)) {
            $messageSessOBJ->message = $AdmInfoListGroupOBJ->getErrorMsg();
            $param["return_flag"] = true;
            $returnSessOBJ->return = $param;
            header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
            exit();
        }
        $messageSessOBJ->message = array("更新しました。");
        header("Location: ./?action_informationListManagement_InformationListSettingUpd=1&gid=" . $param["gid"]);
        exit();
    }
} else {
    // 新規
    if (!$param["name"]) {
        $errMsg[] = "グループ名を入力してください";
    }
    if (!ComValidation::isNumeric($param["is_display"])) {
        $errMsg[] = "表示状態は数値で入力してください";
    }

    if (!ComValidation::isNumeric($param["sort_seq"])) {
        $errMsg[] = "表示順は数値で入力してください";
    }

    // エラー判定
    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_informationListManagement_InformationListGroup=1");
        exit();
    }

    $value["name"]        = $param["name"];
    $value["sort_seq"]    = $param["sort_seq"];
    $value["is_display"]  = $param["is_display"];
    $value["create_datetime"] = date("YmdHis");
    $value["update_datetime"] = date("YmdHis");

    // トランザクション開始
    $AdmInfoListGroupOBJ->beginTransaction();

    if (!$AdmInfoListGroupOBJ->insertInformationListGroupData($value)) {
        // ロールバック
        //$AdmInfoListGroupOBJ->rollbackTransaction();
        $messageSessOBJ->message = $AdmInfoListGroupOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_informationListManagement_InformationListGroup=1");
        exit();
    }

    // インサートした情報グループIDを取得
    $infoGroupId = $AdmInfoListGroupOBJ->getInsertId();

    // アクセスキー生成
    if(!$accessKey = $AdmInfoListGroupOBJ->getNewAccessKey($infoGroupId)) {
        // ロールバック
        $AdmInfoListGroupOBJ->rollbackTransaction();
        $messageSessOBJ->message = array("アクセスキーを生成に失敗しました");
        header("Location: ./?action_informationListManagement_InformationListGroup=1&" . $URLparam);
        exit;
    }

    // アクセスキーの書き込み
    $registAccessKeyData = "";
    $whereArray = "";
    $registAccessKeyData["access_key"] = $accessKey;
    $whereArray[] = "id = " . $infoGroupId;

    if (!$AdmInfoListGroupOBJ->updateInformationListGroupData($registAccessKeyData, $whereArray)) {
        // ロールバック
        $AdmInfoListGroupOBJ->rollbackTransaction();
        $messageSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_informationListManagement_InformationListGroup=1&" . $URLparam);
        exit;
    }
    // コミット
    $AdmInfoListGroupOBJ->commitTransaction();

    $messageSessOBJ->message = array("登録しました。");
    header("Location: ./?action_informationListManagement_InformationListGroup=1");
    exit();
}

?>