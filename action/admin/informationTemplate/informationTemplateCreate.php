<?php
/**
 * informationTemplateCreate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報定型文登録ページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoTemplateOBJ = AdmInformationTemplate::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 戻り値入力項目の取得
$registParam = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

$smartyOBJ->assign("registParam", $registParam);

// bodyタグ基本設定
$htmlBodyPC = '<body>';
$htmlBodyMB = '<body link="#ffcc99" vlink="#cc9966" alink="#ffcc99" text="#ffffff" style="color:#ffffff; background:#000000;" bgcolor="#000000">'
              . "\n".'<a name="top" id="top"></a>'
              . "\n".'<div style="font-size:x-small; text-align:left; width:100%;">';
$smartyOBJ->assign("htmlBodyPC", htmlspecialchars($htmlBodyPC));
$smartyOBJ->assign("htmlBodyMB", htmlspecialchars($htmlBodyMB));

// 全画面表示フラグ
$smartyOBJ->assign("isAllDisplay", AdmInformationTemplate::$_isAllDisplay);


?>