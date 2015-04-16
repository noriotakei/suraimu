<?php

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$admAutoPointGrantOBJ = AdmAutoPointGrant::getInstance();
$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// 検索パラメータを返す
$returnSessOBJ->return = $param;

$updateArray["description"] = $param["description"];

if (!$admAutoPointGrantOBJ->updateReservePointGrantData($updateArray, array("id = " . $param["reserve_point_grant_id"]))) {
    $execMsgSessOBJ->message = array("登録が失敗しました。");
} else {
    $execMsgSessOBJ->message = array("登録が完了しました。");
}

header("Location: ./?action_mailLog_ReservePointGrantData=1&reserve_point_grant_id=" . $param["reserve_point_grant_id"]);
exit;
?>
