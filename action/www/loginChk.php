<?php
/**
 * loginChk.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * PCログインチェックページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");

if ($comUserData) {
    // 入力画面からのPOST属性をなくすため
    // commonで認証してリダイレクトするだけ
    header("Location: ./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
} else {
    header("Location: ./?action_Index=1"  . ($comURLparam ? "&" . $comURLparam : ""));
    exit();
}
?>
