<?php
/**
 * settleCvdExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後コンビニダイレクト決済予約処理ファイル。
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
            "odid",        // 注文アクセスキー
            "cv_cd"      //ｺﾝﾋﾞﾆｺｰﾄﾞ
            );

$URLparam = $requestOBJ->makeGetTag($tags);

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
    header("Location: ./?action_SettleCvd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();

// 注文情報の取得
if (!$orderingData = $OrderingOBJ->getOrderingDataFromAccessKey($param["odid"], $comUserData["user_id"])) {
    $errSessOBJ->errMsg[] = "注文がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

// 決済金額の確認
if ($orderingData["pay_total"] > 30000) {
    $errSessOBJ->errMsg[] = "コンビニ決済は30000円以下しか使えません。";
    header("Location: ./?action_SettleBank=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

// 注文詳細リストの確認
if (!$ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
    // エラーメッセージ作成
    $errSessOBJ->errMsg[] = "ご注文商品がありません。";
    header("Location: ./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$SettlementCvdOBJ = SettlementCvd::getInstance();

//ｺﾝﾋﾞﾆ名ｺｰﾄﾞからｺﾝﾋﾞﾆ決済ﾀｲﾌﾟﾞｺｰﾄﾞを取得。
$cvName = SettlementCvd::$_cvName[$param["cv_cd"]] ;
$cvdRemailKey = "cvd_end_".$param["cv_cd"] ;
$param["cv_cd"] =SettlementCvd::$_cvSettleCd[$param["cv_cd"]] ;

// テスト環境でなければ決済する
if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
    // コンビニダイレクト決済
    if (!$SettlementCvdOBJ->sendToCvd($orderingData, $comUserData, $param, true)) {
        $errSessOBJ->errMsg[] = "申込に失敗しました。";
        header("Location: ./?action_SettleCvd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
} else {
    // テスト環境用決済(Http通信は行わないが、CVDデータはDBに作成する)
    // コンビニダイレクト決済
    if (!$SettlementCvdOBJ->testSendToCvd($orderingData, $comUserData, $param, true)) {
        $errSessOBJ->errMsg[] = "[テスト]申込に失敗しました。";
        header("Location: ./?action_SettleCvd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
}

// メール送信
// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

// 別途%変換用にセット
$convAry = $OrderingOBJ->makeOrderConvertArray($orderingData);

// キーコンバート用データの取得
$cvdKeyconvData = $SettlementCvdOBJ->getCvdKeyconvData();
$convAry["-%cvs_name-"] = $cvName;
$convAry["-%pay_limit-"] = date("Y/m/d", strtotime($cvdKeyconvData["payLimit"]));
$convAry["-%shno-"] = $cvdKeyconvData["shnoMailString"];

// リメールデータの取得
$mailAddress = $comUserData["mb_address"] ? $comUserData["mb_address"] : $comUserData["pc_address"];
$mailElementsData = $AutoMailOBJ->getAutoMailData("ordering", $cvdRemailKey, $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"], $convAry);
// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $SendMailOBJ = SendMail::getInstance();
    $mailElements["subject"] = "コンビニダイレクト決済予約メール送信エラー";
    $mailElements["text_body"] = "注文ID:" . $orderingData["id"] . "\n金額:" . $orderingData["pay_total"] . "\nユーザーにメール送信できませんでした。";

    // システムにエラーメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($mailElements);
    $errSessOBJ->errMsg[] = "メール送信できませんでした。<br>お手数ですが、お問い合わせよりご連絡ください。";
    header("Location: ./?action_SettleCvd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

header("Location: ./?action_SettleCvdEnd=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId . "&name1=" . $param["name1"] . "&name2=" . $param["name2"] . "&telno=" . $param["telno"]);
exit;
?>
