<?php
/**
 * registSiteCsvDataExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サイト間登録csv登録処理ページファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
ini_set("memory_limit", "-1");
$messageSessOBJ = new ComSessionNamespace("exec_msg");

$param = $requestOBJ->getAllParameter();

$AdmRegistSiteOBJ = AdmRegistSite::getInstance();
$UserOBJ = User::getInstance();

$tags = array(
            "regist_site_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$registSiteData = $AdmRegistSiteOBJ->getRegistSiteData($param["regist_site_id"]);
if (!$registSiteData) {
    $messageSessOBJ->message[] = "登録サイトデータがありません";
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
    exit();
}
$binRegistSiteId =  pow(2, $registSiteData["cd"]);

$tmp = file(D_BASE_DIR . AdmRegistSite::REGIST_CSV_FILE_PATH . $param["file_name"]);
if (!$tmp) {
    $messageSessOBJ->message[] = "csvデータがありません";
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
    exit();
}

// トランザクション開始
$AdmRegistSiteOBJ->beginTransaction();

$i = 0;
while ($i < count($tmp)) {
    $val = explode("\n", $tmp[$i]);
    $userData = $UserOBJ->getLastUserDataFromMailAddress($val[0]);
    if (ComValidation::isMailAddress($val[0])) {
        if ($registSiteLogData = $AdmRegistSiteOBJ->getRegistSiteLogDataFromMailAddress($val[0])) {
            // 登録済みでなければ更新
            if ((bindec($registSiteLogData["regist_site_data_id"]) & $binRegistSiteId) == 0) {
                $updateData = "";
                // データ10進数にして加算し、2進数の形で格納する
                $updateData["regist_site_data_id"] = decbin(bindec($registSiteLogData["regist_site_data_id"]) + $binRegistSiteId);
                $updateData["update_datetime"] = date("YmdHis");
                $updateData["user_id"] = $userData["user_id"];

                $whereArray = "";
                $whereArray[] = "id = " . $registSiteLogData["id"];
                if (!$AdmRegistSiteOBJ->updateRegistSiteLogData($updateData, $whereArray)) {
                    // ロールバック
                    $AdmRegistSiteOBJ->rollbackTransaction();
                    $messageSessOBJ->message = $AdmRegistSiteOBJ->getErrorMsg();
                    $param["return_flag"] = true;
                    $returnSessOBJ->return = $param;
                    header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
                    exit();
                }
            }
        } else {
            $insertData = "";
            // データ10進数にして加算し、2進数の形で格納する
            $insertData["regist_site_data_id"] = decbin($binRegistSiteId);
            $insertData["user_id"] = $userData["user_id"];
            $insertData["mail_address"] = $val[0];
            $insertData["update_datetime"] = date("YmdHis");
            if (!$AdmRegistSiteOBJ->insertRegistSiteLogData($insertData)) {
                // ロールバック
                $AdmRegistSiteOBJ->rollbackTransaction();
                $messageSessOBJ->message = $AdmRegistSiteOBJ->getErrorMsg();
                $param["return_flag"] = true;
                $returnSessOBJ->return = $param;
                header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
                exit();
            }
        }
    }
    $i++;
}

// コミット
$AdmRegistSiteOBJ->commitTransaction();
$messageSessOBJ->message[] = "更新しました。";
header("Location: ./?action_registSite_RegistSiteData=1&" . $URLparam);
exit();


?>