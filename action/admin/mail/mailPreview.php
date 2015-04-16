<?php
/**
 * mailPreview.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガプレビューHTML表示ページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

// インスタンスの作成
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["pc"]) {
    $smartyOBJ->assign("html_body", htmlspecialchars_decode($param["pc_html_contents"], ENT_QUOTES));
} else {
    $smartyOBJ->assign("html_body", htmlspecialchars_decode($param["mb_html_contents"], ENT_QUOTES));
}
?>

