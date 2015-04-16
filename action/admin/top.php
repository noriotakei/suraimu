<?php
/**
 * top.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面フレーム設定ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$smartyOBJ->assign("docType", $docType);
$smartyOBJ->assign("contentType", $contentType);
$smartyOBJ->assign("siteName", $_config["define"]["SITE_NAME"]);
?>