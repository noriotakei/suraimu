<?php
/**
 * regularSupportMailDelExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期サポートメール削除ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
// 検索パラメータを返す
$returnSessOBJ->return = $param;

$updateArray["disable"] = 1;

if (!$AdmSupportMailOBJ->updateSupportMailRegular($updateArray, array("id = " . $param["support_mail_regular_id"]))) {
    $execMsgSessOBJ->message = array("削除できませんでした。");
} else {
    $execMsgSessOBJ->message = array("削除しました。");
}

header("Location: ./?action_ordering_RegularSupportMailList=1");
exit;
?>
