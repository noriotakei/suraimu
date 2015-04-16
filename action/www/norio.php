<?php
/**
 * settleBank.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後銀行振込処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}
$mailSessOBJ = new ComSessionNamespace("mail_msg");
// セッション変数の破棄
$mailSessOBJ->unsetAll();



$OrderingOBJ = Ordering::getInstance();
$ItemOBJ = Item::getInstance();



$comUserData["user_id"] = 544022 ;

    // 注文の再取得
    if (!$orderingData = $OrderingOBJ->getOrderingData(86086, $comUserData["user_id"])) {
        // ロールバック
        $OrderingOBJ->rollbackTransaction();
        $errSessOBJ->errMsg[] = "注文データを取得できませんでした。";
        header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }


// メール文言取得
$AutoMailOBJ = AutoMail::getInstance();

// 別途%変換用にセット
$convAry = $OrderingOBJ->makeOrderConvertArray($orderingData);

// リメールデータの取得
//$mailAddress = $comUserData["mb_address"] ? $comUserData["mb_address"] : $comUserData["pc_address"];
$mailAddress = "0kc0240t78w323b@ezweb.ne.jp" ;

$mailElementsData = $AutoMailOBJ->getAutoMailData("ordering", "bank", $mailAddress);

$mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"], $convAry);

print_r($mailElements) ;


// メール送信
if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
    $SendMailOBJ = SendMail::getInstance();
    $errMailElements["subject"] = "銀行振込メール送信エラー";
    $errMailElements["text_body"] = "注文ID:" . $orderingData["id"] . "\n金額:" . $orderingData["pay_total"] . "\nユーザーにメール送信できませんでした。";

    // システムにエラーメール
    $SendMailOBJ->debugMailTo($errMailElements);
    // 運営にエラーメール
    $SendMailOBJ->operationMailTo($errMailElements);
    $errSessOBJ->errMsg[] = "メール送信できませんでした。<br>お手数ですが、お問い合わせよりご連絡ください。";
    header("Location: ./?action_SettleSelect=1&" . $URLparam . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}


?>
