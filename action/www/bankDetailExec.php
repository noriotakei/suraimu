<?php
/**
 * bankDetailExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 銀行振込情報登録処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("bank_name", "銀行名",
                array("Value" => null));

$validationOBJ->check("bank_code", "銀行コード",
                array("Numeric" => null));

$validationOBJ->check("branch_name", "支店名",
                array("Value" => null));

//$validationOBJ->check("branch_code", "支店コード",
//                array("Numeric" => null));

$validationOBJ->check("type", "種別",
                array("Value" => null));

$validationOBJ->check("account_number", "口座番号",
                array("Numeric" => null));

if (mb_strlen($param["account_number"]) != 7) {
    $validationOBJ->setErrorMessage("account_number", "口座番号は7桁の数字で入力してください。");
}
$validationOBJ->check("name", "名義人",
                array("Value" => null, "Katakana" => null));


if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$UserOBJ = User::getInstance();

// 銀行振込情報登録
if (!$data = $UserOBJ->getBankDetailData($comUserData["user_id"])) {

    $insertData["bank_name"] = $param["bank_name"];
    $insertData["bank_code"] = mb_convert_kana($param["bank_code"], a);
    $insertData["branch_name"] = $param["branch_name"];
    $insertData["branch_code"] = mb_convert_kana($param["branch_code"], a);
    $insertData["type"] = $param["type"];
    $insertData["account_number"] = mb_convert_kana($param["account_number"], a);
    $insertData["name"] = $param["name"];
    $insertData["user_id"] = $comUserData["user_id"];
    $insertData["update_datetime"] = date("YmdHis");

    if (!$UserOBJ->insertBankDetailData($insertData)) {
        $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg;
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
        exit();
    }

} else {
    $updateData["bank_name"] = $param["bank_name"];
    $updateData["bank_code"] = mb_convert_kana($param["bank_code"], a);
    $updateData["branch_name"] = $param["branch_name"];
    $updateData["branch_code"] = mb_convert_kana($param["branch_code"], a);
    $updateData["type"] = $param["type"];
    $updateData["account_number"] = mb_convert_kana($param["account_number"], a);
    $updateData["name"] = $param["name"];
    $updateData["update_datetime"] = date("YmdHis");

    $whereArray[] = "id = " . $data["id"];

    if (!$UserOBJ->updateBankDetailData($updateData, $whereArray)) {
        $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg;
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
        exit();
    }
}

if($param["mail"]){
    // %変換用セット
    $convAry["-%bank_name-"] = $param["bank_name"];
    $convAry["-%bank_code-"] = $param["bank_code"];
    $convAry["-%branch_name-"] = $param["branch_name"];
    $convAry["-%type-"] = $param["type"];
    $convAry["-%account_number-"] = $param["account_number"];
    $convAry["-%name-"] = $param["name"];

    // メール文言取得
    $AutoMailOBJ = AutoMail::getInstance();
    $mailAddress = $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"];
    // リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("bank", "bank_detail", $mailAddress);
    $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserData["user_id"],$convAry);

    // メール送信
    if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
        $errSessOBJ->errMsg[] = "メール送信ができませんでした。";
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
        exit();
    }
}

// セッション変数の破棄
$returnSessOBJ->unsetAll();

header("Location: ./?action_Information=1&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
