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
 * @copyright   2009 ZEN Creative, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");

$adminBaitaiAuthOBJ->clearIdentity();
ComSession::expireSessionCookie();
ComSession::destroy();
header("Location: ./?action_baitai_Index=1");
exit();
?>