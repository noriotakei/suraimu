<?php
/**
 * settleCvdEnd.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後コンビニダイレクト処理完了ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$SettlementCvdOBJ = SettlementCvd::getInstance();
$OrderingOBJ = Ordering::getInstance();

// 注文データの取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "ご予約がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// コンビニダイレクトデータの取得
$cvdData = $SettlementCvdOBJ->getConvenienceDirectData($orderingData["id"], $comUserData);
// データがないか、支払済みなら商品リストに飛ぶ
if (!$cvdData OR $cvdData["is_paid"]) {
    $errSessOBJ->errMsg[] = "コンビニ決済予約データがありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

//強引ですが、store_cdにｺﾝﾋﾞﾆｺｰﾄﾞを代入します。
$cvdData["store_cd"] = $param["cv_cd"] ;
$smartyOBJ->assign("cvdData", $cvdData);
// コンビニデータ配列
$smartyOBJ->assign("cvName", SettlementCvd::$_cvName);

?>
