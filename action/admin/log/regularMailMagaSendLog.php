<?php

/**
 * regularMailMagaSendLogList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面定期送信メルマガログリストページ処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

// ログリスト
$whereArray[] = "msl.mailmagazine_log_id_regular = ml.id";
$dataList = $AdmMailMagazineOBJ->getDispMailMagaSendLogList($param["user_id"], $whereArray, "msl.mailmagazine_log_id_regular DESC");

$smartyOBJ->assign("dataList", $dataList);

?>
