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
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$AdmOrderingOBJ = AdmOrdering::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

$data = $AdmSupportMailOBJ->getSupportMailReserveData($param["support_mail_reserve_id"]);
$AdmOrderingOBJ->setWhereString(unserialize($data["search_condition"]));
$data["where_contents"] = $AdmOrderingOBJ->getWhereContents();

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

$reloadTags = array(
            "support_mail_reserve_id",
            );

$POSTparam = $requestOBJ->makePostTag($reloadTags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

