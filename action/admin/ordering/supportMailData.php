<?php
/**
 * supportMailData.php
 *
 * 管理画面注サポートメール入力処理ページファイル。
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// インスタンスの作成
$AdmSupportMailOBJ = AdmSupportMail::getInstance();

$supportMailData = $AdmSupportMailOBJ->getSupportMailData($param["support_mail_id"]);

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    $supportMailData = $returnValue;
}

$smartyOBJ->assign("supportMailData", $supportMailData);

$tags = array(
            "support_mail_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

?>