<?php
/**
 * list.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面画像リストページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admImageOBJ = AdmImage::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// 入力日時の生成
$param["searchDatetimeFrom"] = $param["search_datetime_from_Date"]
                        . " " . $param["search_datetime_from_Time"];

if (!ComValidation::isDatetime($param["searchDatetimeFrom"])) {
    $param["searchDatetimeFrom"] = date("H:00:00");
}

$param["searchDatetimeTo"] = $param["search_datetime_to_Date"]
                        . " " . $param["search_datetime_to_Time"];

if (!ComValidation::isDatetime($param["searchDatetimeTo"])) {
    $param["searchDatetimeTo"] = date("H:00:00");
}

$smartyOBJ->assign("param", $param);

$imageList = $admImageOBJ->getImageList($param, $offset, "id DESC", $dispCnt);
$totalCount = $admImageOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($imageList);

$smartyOBJ->assign("imageList", $imageList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "category_id",
            "extension_type",
            "search_type",
            "specify_keyword",
            "search_string",
            "search_datetime_from_Date",
            "search_datetime_from_Time",
            "search_datetime_to_Date",
            "search_datetime_to_Time",
            );

$reloadTags = array(
            "category_id",
            "extension_type",
            "search_type",
            "specify_keyword",
            "search_string",
            "search_datetime_from_Date",
            "search_datetime_from_Time",
            "search_datetime_to_Date",
            "search_datetime_to_Time",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "image_List=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $registParam = $returnValue;
} else {
    $registParam["return_flag"] = 0;
}

// 戻り値の取得
$smartyOBJ->assign("registParam", $registParam);

$smartyOBJ->assign("searchTypeAry", AdmImage::$searchTypeAry);

$smartyOBJ->assign("specifyKeywordAry", AdmImage::$specifyKeywordAry);

// 検索用拡張子配列
$extensionTypeArray = array(
            IMAGETYPE_GIF => "gif",
            IMAGETYPE_JPEG => "jpg",
            IMAGETYPE_PNG => "png",
            IMAGETYPE_SWF => "swf",
        );

$smartyOBJ->assign("searchExtensionTypeArray", array("0" => "気にしない") + $extensionTypeArray);

$smartyOBJ->assign("extensionTypeArray", ComImgFileUpload::$extensionTypeArray);

// カテゴリーの取得
$categoryList = $admImageOBJ->getImageCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);
$smartyOBJ->assign("searchCategoryList", array("0" => "気にしない") + $categoryList);

$smartyOBJ->assign("imagePath", AdmImage::IMAGE_PATH);
?>

