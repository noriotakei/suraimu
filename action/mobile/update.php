<?php
/**
 * update.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後登録情報変更ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

// エラーメッセージの取得
$errSessOBJ = new ComSessionNamespace("err_msg");
if ($errSessOBJ->errMsg) {
    $errMsg = implode("<br>", $errSessOBJ->errMsg);
    $smartyOBJ->assign("errMsg", $errMsg);
    // セッション変数の破棄
    $errSessOBJ->unsetAll();
}


// maito文言
$mailToSubject = ComUtility::mailtoEncode($_config["define"]["SITE_NAME"],$isSmartPhone);
$mailToBody    = ComUtility::mailtoEncode("このまま送信してください",$isSmartPhone);
$mailto =  "adch-" . $comUserData["remail_key"] . "@" . $_config["define"]["MAIL_DOMAIN"]
          ."?subject=".$mailToSubject
          ."&body=".$mailToBody;

$smartyOBJ->assign("mailto", $mailto);

?>
