<?php
/**
 * settleCvdChk.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後コンビニダイレクト確認処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);
$returnSessOBJ->return = $param;

$tags = array(
            "cv_cd",
            "name1",
            "name2",
            "telno",
            "odid",        // 注文アクセスキー
            );

$urlTags = array(
            "odid",        // 注文アクセスキー
            );

$FORMparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($urlTags);
$smartyOBJ->assign("FORMparam", $FORMparam);
$smartyOBJ->assign("URLparam", $URLparam);

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("cv_cd", "コンビニ選択",
                array("Numeric" => null),
                array("Numeric" => "コンビニ選択は必須項目です"));

$validationOBJ->check("name1", "姓",
                array("value" => null),
                array("value" => "姓は必須項目です"));

$validationOBJ->check("name2", "名",
                array("value" => null),
                array("value" => "名は必須項目です"));

$validationOBJ->check("telno", "携帯電話番号",
                array("TelephoneNumber" => null),
                array("TelephoneNumber" => "携帯電話番号は必須項目です"));

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_SettleCvd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "ご予約がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 決済金額の確認
if ($orderingData["pay_total"] > 30000) {
    $errSessOBJ->errMsg[] = "コンビニ決済は30000円以下しか使えません。";
    header("Location: ./?action_SettleBank=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 注文詳細リストの確認
if (!$itemList = $ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご予約商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

//カウントダウン処理
if(count($itemList)){

    $salesEndDatetimeAry = array();
    foreach($itemList as $key => $val){
        if($val["sales_end_datetime"] != "0000-00-00 00:00:00"){
            $salesEndDatetimeAry[] = $val["sales_end_datetime"] ;
        }
    }

    if(count($salesEndDatetimeAry)){
        $countDownDate = min($salesEndDatetimeAry) ;
        $smartyOBJ->assign("countDownYear", substr($countDownDate, 0, 4));
        $smartyOBJ->assign("countDownMonth", substr($countDownDate, 5, 2));
        $smartyOBJ->assign("countDownDay", substr($countDownDate, 8, 2));
        $smartyOBJ->assign("countDownHour", substr($countDownDate, 11, 2));
        $smartyOBJ->assign("countDownMinute", substr($countDownDate, 14, 2));
        $smartyOBJ->assign("showCountDown",TRUE);
    }
}

$smartyOBJ->assign("orderingData", $orderingData);
// 表示配列を逆順にしてアサイン
$smartyOBJ->assign("itemList", array_reverse($itemList));

$smartyOBJ->assign("param", $param);
// コンビニデータ配列
$smartyOBJ->assign("cvName", SettlementCvd::$_cvName);

?>
