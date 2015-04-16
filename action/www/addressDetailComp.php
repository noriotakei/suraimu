<?php
/**
 * addressDetailComp.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 住所入力完了＆アドレス認証ファイル
 *
 * @copyright   2010 Fraise, Inc.
 * @author      ryohei murata
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);
$errSessOBJ = new ComSessionNamespace("err_msg");
$infoStatusOBJ = InformationStatus::getInstance();
$InfoStatusLogOBJ = InformationStatusLog::getInstance();

// isidがなかったらHOMEに飛ばします。
if (!$param["isid"]) {
    header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}
if (!$infoStatusData = $infoStatusOBJ->getInformationStatusData(array("isid" => $param["isid"]), $comUserData)) {
    header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}
// 未読だったら運営へお知らせメール
if (!$InfoStatusLogOBJ->isAccessed($infoStatusData["id"], $comUserData["user_id"])) {
    $SendMailOBJ = SendMail::getInstance();
    $compMailElements["subject"] = "ユーザーの認証が取れました。";
    $compMailElements["text_body"] = "ユーザーID:" . $comUserData["user_id"] . "\n";
    $SendMailOBJ->operationMailTo($compMailElements);
}

header("Location: ./?action_Information=1&isid=" . $param["isid"] . ($comURLparam ? "&" . $comURLparam : ""));
exit();
?>
