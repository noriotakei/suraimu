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
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/baitai_agency_common.php");

$adminBaitaiAuthOBJ->clearIdentity();
ComSession::expireSessionCookie();
ComSession::destroy();
header("Location: ./?action_Index=1" . ($adminId ? "&aid=" . $adminId : ""));
exit();
?>