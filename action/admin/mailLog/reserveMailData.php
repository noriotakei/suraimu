<?php
/**
 * reserveMailData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面予約メルマガ表示ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$data = $AdmMailMagazineOBJ->getMailReserveData($param["mail_maga_reserve_id"]);
$AdminUserOBJ->setWhereString(unserialize($data["search_condition"]));
$data["where_contents"] = $AdminUserOBJ->getWhereContents();

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
    $data["send_datetime"] = $data["reserve_datetime_Date"] . " " . $data["reserve_datetime_Time"] . ":00";
}

$smartyOBJ->assign("data", $data);

$pcImgList = $AdmMailMagazineOBJ->getMailImageReserveData($param["mail_maga_reserve_id"], false);
$mbImgList = $AdmMailMagazineOBJ->getMailImageReserveData($param["mail_maga_reserve_id"], true);

// imgタグの変換
foreach ((array)$pcImgList as $value) {

    $imageSize = getimagesize("./img/mail/reserve/" . $value["file_name"]);
    $replace = '<img src="' . "./img/mail/reserve/" . $value["file_name"] . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';
    $pcImgTagAry[$no] = $replace;
}

foreach ((array)$mbImgList as $value) {
    $imageSize = getimagesize("./img/mail/reserve/" . $value["file_name"]);
    $replace = '<img src="' . "./img/mail/reserve/" . $value["file_name"] . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';
    $mbImgTagAry[$no] = $replace;
}

$smartyOBJ->assign("pcImgTagAry", $pcImgTagAry);
$smartyOBJ->assign("mbImgTagAry", $mbImgTagAry);

$reloadTags = array(
            "mail_maga_reserve_id",
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

