<?php
/**
 * logout.php
 *
 * Copyright (c) 2009 ZEN Creative, Inc.
 * All rights reserved.
 */

/**
 * ログアウトページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$adminAuthOBJ->clearIdentity();
ComSession::expireSessionCookie();
ComSession::destroy();
header("Location: ./");
exit();
?>