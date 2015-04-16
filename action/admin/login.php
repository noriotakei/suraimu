<?php
/**
 * login.php
 *
 * Copyright (c) 2009 ZEN Creative, Inc.
 * All rights reserved.
 */

/**
 * ログインページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

// 入力画面からのPOST属性をなくすため
// commonで認証してリダイレクトするだけ
header("Location: ./?action_Top=1");
exit();
?>