<?php
/**
 * autoMailSettingData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面リメール文言編集ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmAutoMailOBJ = AdmAutoMail::getInstance();
$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// コンテンツデータ
$contentsData = $AdmAutoMailOBJ->getAutoMailContentsData($param["auto_mail_contents_id"]);
$smartyOBJ->assign("contentsData", $contentsData);

// エレメントデータ
$data = $AdmAutoMailOBJ->getAutoMailElementData($param["auto_mail_contents_id"]);
$requestOBJ->setParameter("auto_mail_elements_id",  $data["id"]);

$data["is_use"] = $contentsData["is_use"];

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnValue) {
    // リターンデータで上書き
    foreach($returnValue as $key => $val) {
        $data[$key] = $val;
    }
}
$smartyOBJ->assign("data", $data);

$pcImgList = $AdmAutoMailOBJ->getAutoMailImageData($data["id"], false);
$mbImgList = $AdmAutoMailOBJ->getAutoMailImageData($data["id"], true);

// imgタグの変換
$pcHtmlBodyDecode = htmlspecialchars_decode($data["pc_html_body"], ENT_QUOTES);
$mbHtmlBodyDecode = htmlspecialchars_decode($data["mb_html_body"], ENT_QUOTES);
if ($pcImgList) {
    foreach ($pcImgList as $value) {
        $tmp = explode(".", $value["file_name"]);
        list($id, $no, $imgDevice) = explode("_", $tmp[0]);

        $imageSize = getimagesize("./img/mail/auto/" . $value["file_name"]);

        $search = '<img src="00' . $no . '">';
        $replace = '<img src="' . "./img/mail/auto/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0">';

        $pcHtmlBodyDecode = str_replace($search, $replace, $pcHtmlBodyDecode);
        $pcImgTagAry[$no] = $replace;
    }
}

if ($mbImgList) {
    foreach ($mbImgList as $value) {
        $tmp = explode(".", $value["file_name"]);
        list($id, $no, $imgDevice) = explode("_", $tmp[0]);

        $imageSize = getimagesize("./img/mail/auto/" . $value["file_name"]);

        $search = '<img src="00' . $no . '">';
        $replace = '<img src="' . "./img/mail/auto/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0">';

        $mbHtmlBodyDecode = str_replace($search, $replace, $mbHtmlBodyDecode);
        $mbImgTagAry[$no] = $replace;
    }
}

$smartyOBJ->assign("pc_html_body", $pcHtmlBodyDecode);
$smartyOBJ->assign("mb_html_body", $mbHtmlBodyDecode);
$smartyOBJ->assign("pcImgTagAry", $pcImgTagAry);
$smartyOBJ->assign("mbImgTagAry", $mbImgTagAry);

$requestOBJ->setParameter("auto_mail_elements_id", $data["id"]);
$reloadTags = array(
            "auto_mail_contents_id",
            "auto_mail_elements_id"
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);
// 使用状況フラグ
$smartyOBJ->assign("isUse", AdmAutoMail::$_isUse);

$smartyOBJ->assign("RemailAddress", AdmAutoMail::REMAIL_ADDRESS . $_config["define"]["MAIL_DOMAIN"]);

?>
