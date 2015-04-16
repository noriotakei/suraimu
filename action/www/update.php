<?php
/**
 * update.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログイン後登録情報変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");
// エラーメッセージの取得
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}

$returnSessOBJ = new ComSessionNamespace("return");
$value = $returnSessOBJ->return;

// アドレスの初期値
if (!$value["pc_mail_account"] AND !$value["pc_mail_domain"]) {
    // PCアドレスの分解
    list($value["pc_mail_account"], $value["pc_mail_domain"]) = explode("@", $comUserData["pc_address"]);
}
if (!$value["mb_mail_account"] AND !$value["mb_mail_domain"]) {
    // MBアドレスの分解
    list($value["mb_mail_account"], $value["mb_mail_domain"]) = explode("@", $comUserData["mb_address"]);
}

$smartyOBJ->assign("value", $value);
// セッション変数の破棄
$returnSessOBJ->unsetAll();

?>
