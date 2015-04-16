<?php
/**
 * cushion.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights regulard.
 */

/**
 *  短縮URLﾘﾀﾞｲﾚｸﾄ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norio takei
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR",  dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");

// メンテナンスフラグのチェック
if (Maintenance::checkMaintenance()) {
    exit;
}

// ユーザエージェントオブジェクト作成
$useragentOBJ = new ComUserAgentMobile();
$mbUa = $useragentOBJ->getCarrier();

if ($mbUa != "NonMobile" ) {
    //ﾓﾊﾞｲﾙｱｸｾｽの場合 //20140428
    header("Location: http://fm.ko-haito.com/?action_FrontDesk=true&id=c255fe6b39&ad_code=te20040");
} else {
    //PCｱｸｾｽの場合
    header("Location: http://fm.ko-haito.com/?action_FrontDesk=true&id=c255fe6b39&ad_code=te20040");
}

exit();
?>
