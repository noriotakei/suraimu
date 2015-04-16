<?php
/**
 * regularMailDelExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期メルマガ削除ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$admMailMagazineOBJ = AdmMailMagazine::getInstance();
$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
// 検索パラメータを返す
$returnSessOBJ->return = $param;

$updateArray["update_datetime"] = date("YmdHis");
$updateArray["disable"] = 1;

if (!$admMailMagazineOBJ->updateMailMagaRegular($updateArray, array("id = " . $param["mail_maga_regular_id"]))) {
    $execMsgSessOBJ->message = array("削除できませんでした。");
} else {
    $execMsgSessOBJ->message = array("削除しました。");
}

header("Location: ./?action_mailLog_RegularMailList=1");
exit;
?>
