<?php
/**
 * addressDetailExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 住所情報登録処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$errSessOBJ = new ComSessionNamespace("err_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$returnSessOBJ->return = $param;

//電話番号が全角の場合が有る為半角に変換
$param["phone_number"] = mb_convert_kana($param["phone_number"] ,"a");

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("postal_code", "郵便番号",
                array("Numeric" => null));

$validationOBJ->check("address", "住所",
                array("Value" => null));

$validationOBJ->check("address_name", "氏名",
                array("Value" => null));

if($param["mail"]){
$validationOBJ->check("phone_number", "電話番号",
                array("TelephoneNumber" => null));
}

if (mb_strlen($param["postal_code"]) != 7) {
    $validationOBJ->setErrorMessage("postal_code", "郵便番号はﾊｲﾌﾝ無しの7桁の数字で入力してください。");
}

if ($validationOBJ->isError()) {
    $errSessOBJ->errMsg = $validationOBJ->getErrorMessage();
    header("Location: ./?action_Information=1&isid=" . $param["eisid"] . ($comURLparam ? "&" . $comURLparam : ""));
    exit;
}

$UserOBJ = User::getInstance();

// 住所情報登録
if (!$data = $UserOBJ->getAddressDetailData($comUserData["user_id"])) {

    $insertData["postal_code"] = $param["postal_code"];
    $insertData["address"] = $param["address"];
    $insertData["name"] = $param["address_name"];
    $insertData["user_id"] = $comUserData["user_id"];
    $insertData["update_datetime"] = date("YmdHis");
    if($param["mail"]){$insertData["phone_number"] = $param["phone_number"];}

    if (!$UserOBJ->insertAddressDetailData($insertData)) {
        $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg;
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
        exit();
    }

} else {
    $updateData["postal_code"] = $param["postal_code"];
    $updateData["address"] = $param["address"];
    $updateData["name"] = $param["address_name"];
    $updateData["update_datetime"] = date("YmdHis");
    if($param["mail"]){$updateData["phone_number"] = $param["phone_number"];}

    $whereArray[] = "id = " . $data["id"];

    if (!$UserOBJ->updateAddressDetailData($updateData, $whereArray)) {
        $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg;
        header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : ""));
        exit();
    }
}

if($param["mail"]){
    // %変換用セット
    $convAry["-%address_comp_url-"] = $_config["define"]["SITE_URL"] . "?action_addressDetailComp=1&isid=" . $param["cisid"] . "&" . Auth::ACCESS_KEY_NAME . "=" . $comUserData["access_key"];
    $convAry["-%postal_code-"] = $param["postal_code"];
    $convAry["-%address-"] = $param["address"];
    $convAry["-%address_name-"] = $param["address_name"];
    $convAry["-%phone_number-"] = $param["phone_number"];

    // メール文言取得
    $AutoMailOBJ = AutoMail::getInstance();
    $mailAddress = $comUserData["pc_address"] ? $comUserData["pc_address"] : $comUserData["mb_address"];
    // リメールデータの取得
    $mailElementsData = $AutoMailOBJ->getAutoMailData("address", "address_detail", $mailAddress);
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
