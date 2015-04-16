<?php
/**
 * regularMailData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期メルマガ表示ページ処理ファイル。
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

$data = $AdmMailMagazineOBJ->getMailRegularData($param["mail_maga_regular_id"]);

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
    if ($data["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_DAY) {
        $data["send_time"] = $returnValue["send_time_day"];
    } else if ($param["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_WEEK) {
        $data["send_time"] = $returnValue["send_time_week"];
    } else if ($param["send_condition_type"] == AdmMailMagazine::SEND_CONDITION_TYPE_MONTH) {
        $data["send_time"] = $returnValue["send_time_month"];
    }
}
$smartyOBJ->assign("data", $data);

$pcImgList = $AdmMailMagazineOBJ->getMailImageRegularData($param["mail_maga_regular_id"], false);
$mbImgList = $AdmMailMagazineOBJ->getMailImageRegularData($param["mail_maga_regular_id"], true);

// imgタグの変換
foreach ((array)$pcImgList as $value) {
    $imageSize = getimagesize("./img/mail/regular/" . $value["file_name"]);
    $replace = '<img src="' . "./img/mail/regular/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';
    $pcImgTagAry[$no] = $replace;
}

foreach ((array)$mbImgList as $value) {
    $imageSize = getimagesize("./img/mail/regular/" . $value["file_name"]);
    $replace = '<img src="' . "./img/mail/regular/" . $value["file_name"] . '?' . time() . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';
    $mbImgTagAry[$no] = $replace;
}

$smartyOBJ->assign("pcImgTagAry", $pcImgTagAry);
$smartyOBJ->assign("mbImgTagAry", $mbImgTagAry);

$reloadTags = array(
            "mail_maga_regular_id",
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// 日にち配列
for ($i = 1; $i < 31; $i++) {
    $dayAry[$i] = $i;
}
$dayAry["0"] = "月末";

$smartyOBJ->assign("dayAry", $dayAry);
$smartyOBJ->assign("sendConditionTypeHourSecond", AdmMailMagazine::$_sendConditionTypeHourSecond);
$smartyOBJ->assign("sendConditionType", AdmMailMagazine::$_sendConditionType);
$smartyOBJ->assign("stopFlag", AdmMailMagazine::$_stopFlag);

?>

