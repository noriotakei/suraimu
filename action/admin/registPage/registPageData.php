<?php
/**
 * registPageData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面登録ページ変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmRegistPageOBJ = AdmRegistPage::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$data = $AdmRegistPageOBJ->getRegistPageData($param["regist_page_id"]);
$pageHtmlPcDecode = htmlspecialchars_decode($data["page_html_pc"], ENT_QUOTES);
$pageHtmlMbDecode = htmlspecialchars_decode($data["page_html_mb"], ENT_QUOTES);
$smartyOBJ->assign("pageHtmlPc", $pageHtmlPcDecode);
$smartyOBJ->assign("pageHtmlMb", $pageHtmlMbDecode);

// 表示日時の初期化
$data["display_start_datetime"] = ComValidation::isDateTime($data["display_start_datetime"]) ? $data["display_start_datetime"] : "";
$data["display_end_datetime"] = ComValidation::isDateTime($data["display_end_datetime"]) ? $data["display_end_datetime"] : "";

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

$pcImgList = $AdmRegistPageOBJ->getRegistPageImageData($param["regist_page_id"], false);
$mbImgList = $AdmRegistPageOBJ->getRegistPageImageData($param["regist_page_id"], true);
// imgタグの変換
$pcHtmlBodyDecode = htmlspecialchars_decode($data["pc_html_body"], ENT_QUOTES);
$mbHtmlBodyDecode = htmlspecialchars_decode($data["mb_html_body"], ENT_QUOTES);
if ($pcImgList) {
    foreach ($pcImgList as $value) {
        $tmp = explode(".", $value["file_name"]);
        list($id, $no, $imgDevice) = explode("_", $tmp[0]);

        $imageSize = getimagesize("./img/mail/registPage/" . $value["file_name"]);

        $search = '<img src="00' . $no . '">';
        $replace = '<img src="' . "./img/mail/registPage/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0">';

        $pcHtmlBodyDecode = str_replace($search, $replace, $pcHtmlBodyDecode);
        $pcImgTagAry[$no] = $replace;
    }
}

if ($mbImgList) {
    foreach ($mbImgList as $value) {
        $tmp = explode(".", $value["file_name"]);
        list($id, $no, $imgDevice) = explode("_", $tmp[0]);

        $imageSize = getimagesize("./img/mail/registPage/" . $value["file_name"]);

        $search = '<img src="00' . $no . '">';
        $replace = '<img src="' . "./img/mail/registPage/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0">';

        $mbHtmlBodyDecode = str_replace($search, $replace, $mbHtmlBodyDecode);
        $mbImgTagAry[$no] = $replace;
    }
}

$smartyOBJ->assign("pc_html_body", $pcHtmlBodyDecode);
$smartyOBJ->assign("mb_html_body", $mbHtmlBodyDecode);
$smartyOBJ->assign("pcImgTagAry", $pcImgTagAry);
$smartyOBJ->assign("mbImgTagAry", $mbImgTagAry);

$reloadTags = array(
            "regist_page_id",
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);
$smartyOBJ->assign("isUseAry", AdmRegistPage::$_isUse);

// カテゴリーの取得
$categoryList = $AdmRegistPageOBJ->getRegistPageCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
$smartyOBJ->assign("pageCdName", RegistPage::PAGE_CD_NAME);

?>

