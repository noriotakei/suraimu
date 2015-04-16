<?php
/**
 * reserveMailCopyExec.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 情報データコピー登録処理ページ。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
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

$magaData = $AdmMailMagazineOBJ->getMailReserveData($param["mail_maga_reserve_id"]);

if (!ComValidation::isMailAddress($param["from_address"])) {
    $errMsg[] = "送信アドレスを入力してください";
}

$timerDatetime = $param["reserve_datetime_Date"] . " " . $param["reserve_datetime_Time"] . ":00";

if (!ComValidation::isDatetime($timerDatetime)) {
    $errMsg[] = "有効な日時を入力して下さい";
}

// 戻り値の格納
$returnSessOBJ->return = $param;

if ($errMsg) {
    $execMsgSessOBJ->message = $errMsg;
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

// 予約メルマガ内容の更新
//前ページから渡って来た値
$mailLog["from_address"] = $param["from_address"];
$mailLog["from_name"] = $param["from_name"];
$mailLog["pc_subject"] = $param["pc_subject"];
$mailLog["pc_text_body"] = $param["pc_text_body"];
$mailLog["pc_html_body"] = $param["pc_html_body"];
$mailLog["mb_subject"] = $param["mb_subject"];
$mailLog["mb_text_body"] = $param["mb_text_body"];
$mailLog["mb_html_body"] = $param["mb_html_body"];
$mailLog["reverse_mail_status"] = $param["reverse_mail_status"];
$mailLog["send_datetime"] = $timerDatetime;
$mailLog["update_datetime"] = date("YmdHis");
$mailLog["create_datetime"] = date("YmdHis");

// 管理ユーザーID
$mailLog["admin_id"] = $loginAdminData["id"];

//コピー元メールデータからの値
$mailLog["reverse_mail_status"] = $magaData["reverse_mail_status"] ;
$mailLog["search_sql"] = $magaData["search_sql"] ;
$mailLog["search_condition"] = $magaData["search_condition"] ;
$mailLog["send_plans_count"] = $magaData["send_plans_count"] ;

$AdmMailMagazineOBJ->beginTransaction();

// 書き込み
if (!$AdmMailMagazineOBJ->insertMailMagaReserve($mailLog)) {
    // ロールバック
    $AdmMailMagazineOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("新規作成に失敗しました");
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

$mailMagaId = $AdmMailMagazineOBJ->getInsertId();

//PC添付画像があればｲﾝｻｰﾄ
if($pcImgAry = $AdmMailMagazineOBJ->getMailImageReserveData($param["mail_maga_reserve_id"],false) ){
    foreach($pcImgAry as $key => $val){
        $insertArray = array(
            "mailmagazine_reserve_id" => $mailMagaId,
            "file_name"           => $val["file_name"] ,
            "is_mobile"           => $val["is_mobile"] ,
            "create_datetime"     => date("YmdHis"),
        );
        if (!$dbResultOBJ = $AdmMailMagazineOBJ->insert("mailmagazine_reserve_image", $insertArray)) {
        $AdmMailMagazineOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("新規作成に失敗しました");
        header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
        exit;
        }
    }
}

//MB添付画像があればｲﾝｻｰﾄ
if($mbImgAry = $AdmMailMagazineOBJ->getMailImageReserveData($param["mail_maga_reserve_id"],true) ){
    foreach($mbImgAry as $key => $val){
        $insertArray = array(
            "mailmagazine_reserve_id" => $mailMagaId,
            "file_name"           => $val["file_name"] ,
            "is_mobile"           => $val["is_mobile"] ,
            "create_datetime"     => date("YmdHis"),
        );
        if (!$dbResultOBJ = $AdmMailMagazineOBJ->insert("mailmagazine_reserve_image", $insertArray)) {
        $AdmMailMagazineOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("新規作成に失敗しました");
        header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
        exit;
        }
    }
}

// PC画像更新処理
if (!$AdmMailMagazineOBJ->updateMailImageReserve($mailMagaId, "pc_image", false, $param)){
    $AdmMailMagazineOBJ->rollbackTransaction();
    $execMsgSessOBJ->message = array("更新できませんでした。");
    header("Location: ./?action_mailLog_ReserveMailData=1&" . $URLparam);
    exit;
}

// MB画像更新処理
if (!$AdmMailMagazineOBJ->updateMailImageReserve($mailMagaId, "mb_image", true, $param)){
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

