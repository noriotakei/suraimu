<?php

/**
 * remakeExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面媒体集計再集計ページ処理ファイル。
 * 変更したら、cron処理の変更も忘れずに。
 *
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/baitai_common.php");
ini_set("memory_limit", "-1");
$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmBaitaiOBJ = AdmBaitai::getInstance();

$validationOBJ = new ComArrayValidation($param);

$validationOBJ->check("date", "日付",
                array("Date" => null));

if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $execMsgSessOBJ->exec_msg = $errorMsg;
    $returnSessOBJ->return = $param;
    header("location: ./?action_baitai_Remake=1&" . $URLparam);
    exit;
}

// トランザクション開始
$AdmBaitaiOBJ->beginTransaction();

for ($i = 0; $i < 24; $i++) {

    $param["date_hour"] = date("Y-m-d H", mktime($i, 0, 0, date("n", strtotime($param["date"])), date("j", strtotime($param["date"])), date("Y", strtotime($param["date"]))));

    if (!$AdmBaitaiOBJ->execMediaAnalyze($param)) {
        $errorMsg = $AdmBaitaiOBJ->getErrorMsg();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        $returnSessOBJ->return = $param;
        // ロールバック
        $AdmBaitaiOBJ->rollbackTransaction();
        header("location: ./?action_baitai_Remake=1&" . $URLparam);
        exit;
    }
}

// コミット
$AdmBaitaiOBJ->commitTransaction();
$execMsgSessOBJ->exec_msg[] = "再集計しました。";
header("location: ./?action_baitai_Remake=1&" . $URLparam);
exit;
?>
