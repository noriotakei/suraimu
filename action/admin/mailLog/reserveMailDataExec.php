<?php
/**
 * reserveMailDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面予約メルマガ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "mail_maga_reserve_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if (!ComValidation::isMailAddress($param["from_address"])) {
    $errMsg[] = "送信アドレスを入力してください";
}

$timerDatetime = $param["reserve_datetime_Date"] . " " . $param["reserve_datetime_Time"] . ":00";

if (!ComValidation::isDatetime($timerDatetime)) {
    $errMsg[] = "有効な日時を入力して下さい";
}

if ($param["hour_from"] AND !ComValidation::isBetween($param["hour_from"], 0, 23)) {
    $errMsg[] = "有効な開始時間を入力して下さい";
}

if ($param["hour_to"] AND !ComValidation::isBetween($param["hour_to"], 0, 23)) {
    $errMsg[] = "有効な終了時間を入力して下さい";
}

if ($param["second"] AND !ComValidation::isNumeric($param["second"])) {
    $errMsg[] = "分に有効な数字を入力して下さい";
}

if ($param["send_day"] AND !ComValidation::isNumeric($param["send_day"])) {
    $errMsg[] = "送信日に有効な数字を入力して下さい";
}

// 戻り値の格納
$returnSessOBJ->return = $param;

if ($errMsg) {
    $execMsgSessOBJ->message = $errMsg;
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

// 予約メルマガ内容の更新
$mailLog["from_address"] = $param["from_address"];
$mailLog["from_name"] = $param["from_name"];
$mailLog["pc_subject"] = $param["pc_subject"];
$mailLog["pc_text_body"] = $param["pc_text_body"];
$mailLog["pc_html_body"] = $param["pc_html_body"];
$mailLog["mb_subject"] = $param["mb_subject"];
$mailLog["mb_text_body"] = $param["mb_text_body"];
$mailLog["mb_html_body"] = $param["mb_html_body"];
$mailLog["reverse_mail_status"] = $param["reverse_mail_status"];
$mailLog["is_mobile"] = $param["is_mobile"];
$mailLog["send_datetime"] = $timerDatetime;
$mailLog["update_datetime"] = date("YmdHis");

$AdmMailMagazineOBJ->beginTransaction();

// 書き込み
if (!$AdmMailMagazineOBJ->updateMailMagaReserve($mailLog, array("id = " . $param["mail_maga_reserve_id"]))) {
    $AdmMailMagazineOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

// PC画像更新処理
if (!$AdmMailMagazineOBJ->updateMailImageReserve($param["mail_maga_reserve_id"], "pc_image", false, $param)){
    $AdmMailMagazineOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

// MB画像更新処理
if (!$AdmMailMagazineOBJ->updateMailImageReserve($param["mail_maga_reserve_id"], "mb_image", true, $param)){
    $AdmMailMagazineOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

$AdmMailMagazineOBJ->commitTransaction();

$execMsgSessOBJ->message = array("設定しました。");

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
exit;
?>

