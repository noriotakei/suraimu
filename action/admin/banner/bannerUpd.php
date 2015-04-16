<?php
/**
 * bannerUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面画像編集ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

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

$AdmBannerOBJ = AdmBanner::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$bannerData = $AdmBannerOBJ->getBannerData($param["banner_id"]);

// カテゴリーの取得
$categoryList = $AdmBannerOBJ->getBannerImageCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $param = $returnValue;
    $param["file_name"] = $bannerData["file_name"];
    $param["extension_type"] = $bannerData["extension_type"];
} else {
    $param = $bannerData;
}

// 戻り値の取得
$smartyOBJ->assign("param", $param);

$tags = array(
            "banner_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$extensionTypeArray = ComImgFileUpload::$extensionTypeArray;

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);
$smartyOBJ->assign("extensionTypeArray", $extensionTypeArray);
$smartyOBJ->assign("bannerPath", AdmBanner::BANNER_PATH);
?>

