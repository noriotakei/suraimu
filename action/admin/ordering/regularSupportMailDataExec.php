<?php
/**
 * regularsupportMailDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期サポートメール更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "support_mail_regular_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$AdmSupportMailOBJ = AdmSupportMail::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if (!$param["from_address"]) {
    $errMsg[] = "送信アドレスを入力してください";
}

if ($param["send_condition_type"] > 0) {
    if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_DAY) {
        $sendTime = $param["send_time_day"] . ":00";
    } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_WEEK) {
        $sendTime = $param["send_time_week"] . ":00";
    } else if ($param["send_condition_type"] == AdmSupportMail::SEND_CONDITION_TYPE_MONTH) {
        $sendTime = $param["send_time_month"] . ":00";
    }
    if (!ComValidation::isTime($sendTime)) {
        $errMsg[] = "有効な日時を入力して下さい";
    }
    $param["send_time"] = $sendTime;
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
    header("Location: ./?action_ordering_RegularSupportMailData=1&" . $URLparam);
    exit;
}

// 定期メルマガ内容の追加
$mailLog["title"] = $param["title"];
$mailLog["from_address"] = $param["from_address"];
$mailLog["from_name"] = $param["from_name"];
$mailLog["pc_subject"] = $param["pc_subject"];
$mailLog["pc_text_body"] = $param["pc_text_body"];
$mailLog["pc_html_body"] = $param["pc_html_body"];
$mailLog["mb_subject"] = $param["mb_subject"];
$mailLog["mb_text_body"] = $param["mb_text_body"];
$mailLog["mb_html_body"] = $param["mb_html_body"];
$mailLog["send_condition_type"] = $param["send_condition_type"];
$mailLog["hour_from"] = $param["hour_from"];
$mailLog["hour_to"] = $param["hour_to"];
$mailLog["second"] = $param["second"];
$mailLog["week"] = $param["week"];
$mailLog["send_day"] = $param["send_day"];
$mailLog["send_time"] = $sendTime;
$mailLog["is_stop"] = $param["is_stop"];
$mailLog["update_datetime"] = date("YmdHis");

$AdmSupportMailOBJ->beginTransaction();

// 書き込み
if (!$AdmSupportMailOBJ->updateSupportMailRegular($mailLog, array("id = " . $param["support_mail_regular_id"]))) {
    $AdmSupportMailOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_ordering_RegularSupportMailData=1&" . $URLparam);
    exit;
}

// PC画像更新処理
if (!$AdmSupportMailOBJ->updateSupportMailImageRegular($param["support_mail_regular_id"], "pc_image", false, $param)){
    $AdmSupportMailOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_ordering_RegularSupportMailData=1&" . $URLparam);
    exit;
}

// MB画像更新処理
if (!$AdmSupportMailOBJ->updateSupportMailImageRegular($param["support_mail_regular_id"], "mb_image", true, $param)){
    $AdmSupportMailOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_ordering_RegularSupportMailData=1&" . $URLparam);
    exit;
}

$AdmSupportMailOBJ->commitTransaction();

$execMsgSessOBJ->message = array("設定しました。");

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_ordering_RegularSupportMailData=1&" . $URLparam);
exit;
?>

