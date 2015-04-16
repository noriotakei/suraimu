<?php
/**
 * errorMailUpdate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights regulard.
 */

/**
 * エラーメール反転処理ファイル。
 * デーモンファイルが午前2時位に上がるため
 * 午前3時30分にまわす
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");
$errorLogFileName = ErrorMailLog::ERROR_LOG_DIR . "/mail." . $_config["define"]["PROJECT_NAME"]
                   . "_" . date("ymd", strtotime("-1 day")) . ".txt";

// 昨日のデーモンログを取得
$buf = file_get_contents($errorLogFileName);
if (!$buf) {
    exit("NO DATA");
}

$emOBJ = ErrorMailLog::getInstance();

$UserOBJ = User::getInstance();
$getData = explode(chr(0x0a), $buf);

for ($i = 0; $i < count($getData); $i++) {

    $whereArray = "";
    $updateArray = "";
    $insertAry = "";
    $userAry = "";

    $data = explode("\t", $getData[$i]);

    $userMailAddress = $data["0"];
    $errorType = $data["1"];

    if (!$userMailAddress) {
        continue;
    }

    // ユーザー情報を(メアドから)取得(MB/PCの切り分け)
    $userData = $UserOBJ->getAllUserDataFromMailAddress($userMailAddress);
    if (!$userData) {
         continue;
    }

    if (ComValidation::isMobileAddress($userMailAddress)) {
        $deviceCd = ErrorMailLog::DEVICE_TYPE_MB;
    } else {
        $deviceCd = ErrorMailLog::DEVICE_TYPE_PC;
    }

    // 解析結果から取得したメアドの存在チェック
    $logId = $emOBJ->isErrorMailLog($userData["user_id"], $userMailAddress);

    // 既に有ればエラーカウントのアップ
    if ($logId) {
        $whereArray[] = "id = " . $logId;
        // 更新用配列生成
        $updateArray["error_count"] = "error_count + 1";
        $updateArray["error_type"] = $errorType;

        $emOBJ->updateErrorMailLogData($updateArray, $whereArray, false);
    // 無ければ新規レコード追加
    } else {

        // 挿入用配列生成
        $insertAry["error_count"]     = 1;
        $insertAry["user_id"]         = $userData["user_id"];
        $insertAry["mail_address"]    = $userMailAddress;
        $insertAry["create_datetime"] = date("Y-m-d H:i:s");
        $insertAry["error_type"]  = $errorType;
        $insertAry["device_cd"] = $deviceCd;

        $emOBJ->insertErrorMailLogData($insertAry);
    }



    if ($deviceCd == ErrorMailLog::DEVICE_TYPE_PC) {
        $userAry["pc_emsys_count"] = "pc_emsys_count + 1";
    } else {
        $userAry["mb_emsys_count"] = "mb_emsys_count + 1";
    }

    $userAry["update_datetime"] = "'" . date("Y-m-d H:i:s") . "'";

    // ユーザー情報更新
    $UserOBJ->updateUserData($userAry, array("id=" . $userData["user_id"]), false);
}

$mailDomainArray = $_config["define"]["SEND_MAIL_DOMAIN"] ;
end($mailDomainArray);//最後の要素にセット
$limitDomainCd = key($mailDomainArray);//最後の要素のキー取得

// エラーログデータ取得(カウント3回以上のみ)
$emData = $emOBJ->getErrorLog();

if (!count($emData)) {
    exit("NO UPDATE");
}

foreach ($emData as $key => $val) {

    $userData = "" ;
        $changeUserAddressStatusAry        = "";
        $changeUserAddressStatuswhereArray = "";
        $ChangeUtilityDomainUserAry = "" ;
        $ChangeUtilityDomainwhereArray = "" ;
        $updateArray = "";

    // ユーザー情報を(IDから)取得
    $userData = $UserOBJ->getUserData($val["user_id"]);

    if ($val["device_cd"] == ErrorMailLog::DEVICE_TYPE_PC) {
        $changeUserAddressStatusAry["pc_address_status"] = $val["error_type"];
        $ChangeUtilityDomainUserAry["pc_mailmagazine_from_domain_id"] = "pc_mailmagazine_from_domain_id + 1";
        $mailmagazineFromDomainId = $userData["pc_mailmagazine_from_domain_id"] ;
    } else {
        $changeUserAddressStatusAry["mb_address_status"] = $val["error_type"];
        $ChangeUtilityDomainUserAry["mb_mailmagazine_from_domain_id"] = "mb_mailmagazine_from_domain_id + 1";
        $mailmagazineFromDomainId = $userData["mb_mailmagazine_from_domain_id"] ;
    }

    if($mailmagazineFromDomainId >= $limitDomainCd){
        //アドレスステータス変更処理。
        $changeUserAddressStatusAry["update_datetime"] = date("Y-m-d H:i:s");

        $changeUserAddressStatuswhereArray = array("id=" . $val["user_id"]);
        // ユーザー情報更新
        $UserOBJ->updateUserData($changeUserAddressStatusAry, $changeUserAddressStatuswhereArray);

    }else{
        //配信メルマガドメイン変更処理。
        $ChangeUtilityDomainwhereArray = array("id=" . $val["user_id"]);
        // ユーザー情報更新
        $UserOBJ->updateUserData($ChangeUtilityDomainUserAry, $ChangeUtilityDomainwhereArray, false);
    }

    // 対象メアドのログを削除
    $whereArray = "" ;
    $whereArray[] = "id = " . $val["id"];
    $updateArray["disable"] = 1;

    $emOBJ->updateErrorMailLogData($updateArray, $whereArray);

}

// 終了
exit("COMPLETE!!");
?>
