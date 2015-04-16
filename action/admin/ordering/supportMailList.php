<?php
/**
 * supportMailSetting.php
 *
 * 管理画面注サポートメール一覧処理ページファイル。
 *
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmSupportMailOBJ = AdmSupportMail::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$supportMailList = $AdmSupportMailOBJ->getSupportMailList();

$smartyOBJ->assign("supportMailList", $supportMailList);

?>