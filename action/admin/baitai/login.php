<?php
/**
 * login.php
 *
 * Copyright (c) 2009 ZEN Creative, Inc.
 * All rights reserved.
 */

/**
 * 媒体集計ログインページ。
 *
 * @copyright   2009 ZEN Creative, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");

// 入力画面からのPOST属性をなくすため
// commonで認証してリダイレクトするだけ
header("Location: ./?action_baitai_Top=1");
exit();
?>