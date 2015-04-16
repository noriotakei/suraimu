<?php
/**
 * registPageDataExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録ページ更新ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmRegistPageOBJ = AdmRegistPage::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// 戻り値の格納
$returnSessOBJ->return = $param;

$tags = array(
            "regist_page_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("from_address", "送信アドレス",
                array("Value" => null),
                array("Value" => "送信アドレスは必須項目です"));

$validationOBJ->check("is_use", "使用状況",
                array("Numeric" => null),
                array("Numeric" => "使用状況を入力してください"));
/*
if ($param["regist_url_pc"]) {
    $validationOBJ->check("regist_url_pc", "PC本登録用リダイレクトURL",
                    array("Url" => null));
}
*/
$validationOBJ->check("regist_page_category_id", "カテゴリー",
                array("Numeric" => null),
                array("Numeric" => "カテゴリーは必須項目です"));

$validationOBJ->check("name", "登録ページ名",
                array("Value" => null),
                array("Value" => "登録ページ名は必須項目です"));

$validationOBJ->check("cd", "登録コード",
                array("Value" => null),
                array("Value" => "登録コードは必須項目です"));

$validationOBJ->check("sort_seq", "優先順位",
                array("Numeric" => null),
                array("Numeric" => "優先順位は数値で入力してください"));

$validationOBJ->check("from_address", "登録リメール送信アドレス",
                array("MailAddress" => null),
                array("MailAddress" => "登録リメール送信アドレスは必須項目です"));

// 表示開始日時
$param["display_start_datetime"] = $param["display_start_datetime_Date"]
                        . " " . $param["display_start_datetime_Time"];
if (($param["display_start_datetime_Date"] OR $param["display_start_datetime_Time"]) AND !ComValidation::isDateTime($param["display_start_datetime"])) {
    $validationOBJ->setErrorMessage("表示開始日時", "表示開始日時を正しく入力してください");
}

// 表示終了日時
$param["display_end_datetime"] = $param["display_end_datetime_Date"]
                        . " " . $param["display_end_datetime_Time"];
if (($param["display_end_datetime_Date"] OR $param["display_end_datetime_Time"]) AND !ComValidation::isDateTime($param["display_end_datetime"])) {
    $validationOBJ->setErrorMessage("表示終了日時", "表示終了日時を正しく入力してください");
}

if (!($param["regist_page_id"] AND $param["disable"])) {
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        if ($param["regist_page_id"] ) {
            header("Location: ./?action_registPage_RegistPageData=1&" . $URLparam);
        } else {
            header("location: ./?action_registPage_RegistPageCreate=1");
        }
        exit;
    }

    // 登録ページの追加
    $registPageData["regist_page_category_id"] = $param["regist_page_category_id"];
    $registPageData["name"] = $param["name"];
    $registPageData["cd"] = $param["cd"];
    $registPageData["regist_url_pc"] = $param["regist_url_pc"];
    $registPageData["page_html_pc"] = $param["page_html_pc"];
    $registPageData["page_html_mb"] = $param["page_html_mb"];
    $registPageData["return_path"] = AdmRegistPage::REGIST_PAGE_RETURN_PATH . $_config["define"]["MAIL_DOMAIN"];
    $registPageData["sort_seq"] = $param["sort_seq"];
    $registPageData["is_use"] = $param["is_use"];
    $registPageData["from_address"] = $param["from_address"];
    $registPageData["from_name"] = $param["from_name"];
    $registPageData["pc_subject"] = $param["pc_subject"];
    $registPageData["pc_text_body"] = $param["pc_text_body"];
    $registPageData["pc_text_body_second"] = $param["pc_text_body_second"];
    $registPageData["pc_html_body"] = $param["pc_html_body"];
    $registPageData["mb_subject"] = $param["mb_subject"];
    $registPageData["mb_text_body"] = $param["mb_text_body"];
    $registPageData["mb_text_body_second"] = $param["mb_text_body_second"];
    $registPageData["mb_html_body"] = $param["mb_html_body"];
    $registPageData["update_datetime"] = date("YmdHis");
    $registPageData["display_start_datetime"] = $param["display_start_datetime"];
    $registPageData["display_end_datetime"] = $param["display_end_datetime"];
}

$AdmRegistPageOBJ->beginTransaction();

// 削除
if ($param["regist_page_id"] AND $param["disable"]) {

    $disableRegistPageData["update_datetime"] = date("YmdHis");
    $disableRegistPageData["disable"] = $param["disable"];

    // 書き込み
    if (!$AdmRegistPageOBJ->updateRegistPageData($disableRegistPageData, array("id = " . $param["regist_page_id"]))) {
        $AdmRegistPageOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("削除できませんでした。");
        header("Location: ./?action_registPage_RegistPageSearchList=1");
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("削除しました。");
    $AdmRegistPageOBJ->commitTransaction();
    header("Location: ./?action_registPage_RegistPageSearchList=1");
    exit;

// 更新
} else if ($param["regist_page_id"] ) {

    // 書き込み
    if (!$AdmRegistPageOBJ->updateRegistPageData($registPageData, array("id = " . $param["regist_page_id"]))) {
        $AdmRegistPageOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("更新できませんでした。");
        header("Location: ./?action_registPage_RegistPageData=1&" . $URLparam);
        exit;
    }

    // PC画像更新処理
    if (!$AdmRegistPageOBJ->updateRegistPageImage($param["regist_page_id"], "pc_image", false, $param)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_registPage_RegistPageData=1&" . $URLparam);
        exit;
    }

    // MB画像更新処理
    if (!$AdmRegistPageOBJ->updateRegistPageImage($param["regist_page_id"], "mb_image", true, $param)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_registPage_RegistPageData=1&" . $URLparam);
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("更新しました。");
    $AdmRegistPageOBJ->commitTransaction();
    header("Location: ./?action_registPage_RegistPageData=1&" . $URLparam);
    exit;

// 登録
} else {

    $registPageData["create_datetime"] = date("YmdHis");

    // 書き込み
    if (!$AdmRegistPageOBJ->insertRegistPageData($registPageData)) {
        $AdmRegistPageOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_registPage_RegistPageCreate=1");
        exit;
    }
    $registPageId = $AdmRegistPageOBJ->getInsertId();

    // PC画像登録処理
    if (!$AdmRegistPageOBJ->insertRegistPageImage($registPageId, "pc_image", false)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_registPage_RegistPageCreate=1");
        exit;
    }

    // MB画像登録処理
    if (!$AdmRegistPageOBJ->insertRegistPageImage($registPageId, "mb_image", true)){
        $AdmAutoMailOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = $AdmAutoMailOBJ->getErrorMsg();
        header("Location: ./?action_registPage_RegistPageCreate=1");
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("登録しました。");
    $AdmRegistPageOBJ->commitTransaction();
    header("Location: ./?action_registPage_RegistPageSearchList=1");
    exit;
}

?>

