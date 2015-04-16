<?php
/**
 * informationTemplateExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報定型文データ登録処理ページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . '/common/admin_common.php');
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoTemplateOBJ = AdmInformationTemplate::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// 戻り値の格納
$returnSessOBJ->return = $param;

$tags = array(
            "itid",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

if (!$param["disable"]) {
    /******* 入力項目の確認 *******/
    $validationOBJ->check("name", "管理用定型文名",
    array("Value" => null),
    array("Value" => "管理用定型文名は必須項目です"));

    $validationOBJ->check("sort_seq", "表示優先度",
    array("Numeric" =>null),
    array("Numeric" => "表示優先度は数値のみ入力可能です"));

    // 全画面表示フラグ(フラグ「ON」で本文入力があるかチェック)
    if ($param["is_all_display"] && !$param["html_text_pc"]) {
        $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)本文を入力してください");
    }

    // 詳細情報(PC)
    if ($param["html_text_pc"]) {
        // 本文入力あって、フラグ「ON」ならbodyタグのチェック※フラグ「OFF」ならタグ不要
        if ($param["is_all_display"]) {
            if (!preg_match("/<body>/", htmlspecialchars_decode($param["html_text_pc"], ENT_QUOTES))) {
                $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)bodyタグを入力してください");
            }
        } else {
            if (preg_match("/<body>/", htmlspecialchars_decode($param["html_text_pc"], ENT_QUOTES))) {
                $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)bodyタグが入力されてます");
            }
        }
    } else {
        // 本文入力が無いのにフラグ「ON」ならエラー)
        if ($param["is_all_display"]) {
            $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)本文を入力してください");
        }
    }

    // 詳細情報(MB)
    if ($param["html_text_mb"]) {
        if (!preg_match("/<body.+?>/", htmlspecialchars_decode($param["html_text_mb"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(MB)", "表示情報(MB)bodyタグを入力してください");
        }
    }

    // チェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        if ($param["itid"] ) {
            header("Location: ./?action_informationTemplate_InformationTemplateData=1&" . $URLparam);
            exit();
        } else {
            header("location: ./?action_informationTemplate_InformationTemplateCreate=1");
            exit();
        }
    }
}

// 更新データ生成
$registData = array();
$registData["name"]                = $param["name"];
$registData["is_all_display"]      = $param["is_all_display"];
$registData["html_text_banner_pc"] = $param["html_text_banner_pc"];
$registData["html_text_pc"]        = $param["html_text_pc"];
$registData["html_text_banner_mb"] = $param["html_text_banner_mb"];
$registData["html_text_mb"]        = $param["html_text_mb"];
$registData["sort_seq"]            = $param["sort_seq"];

// 削除
if ($param["itid"] && $param["disable"]) {

    $whereRegistData   = array();
    $disableRegistData = array();

    $whereRegistData[] = "id = " . $param["itid"];
    $disableRegistData["update_datetime"] = date("YmdHis");
    $disableRegistData["disable"] = $param["disable"];

    // 書き込み
    if (!$AdmInfoTemplateOBJ->updateInformationTemplateData($disableRegistData, $whereRegistData)) {
        $execMsgSessOBJ->message = array("削除できませんでした。");
        header("Location: ./?action_informationTemplate_InformationTemplateList=1");
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("削除しました。");

    header("Location: ./?action_informationTemplate_InformationTemplateList=1&" . $URLparam);
    exit;

    // 更新
} else if ($param["itid"] ) {
    $whereRegistData = array();
    $whereRegistData[] = "id = " . $param["itid"];
    $registData["update_datetime"] = date("YmdHis");

    // 書き込み
    if (!$AdmInfoTemplateOBJ->updateInformationTemplateData($registData, $whereRegistData)) {
        $execMsgSessOBJ->message = array("更新できませんでした。");
        header("Location: ./?action_informationTemplate_InformationTemplateData=1&" . $URLparam);
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("更新しました。");
    header("Location: ./?action_informationTemplate_InformationTemplateData=1&" . $URLparam);
    exit;

    // 登録
} else {

    $AdmInfoTemplateOBJ->beginTransaction();

    $registData["create_datetime"] = date("YmdHis");
    $registData["update_datetime"] = date("YmdHis");

    // 書き込み
    if (!$AdmInfoTemplateOBJ->insertInformationTemplateData($registData)) {
        $AdmInfoTemplateOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_informationTemplate_InformationTemplateCreate=1" . $URLparam);
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("登録しました。");
    $AdmInfoTemplateOBJ->commitTransaction();
    header("Location: ./?action_informationTemplate_InformationTemplateList");
    exit;

}

?>