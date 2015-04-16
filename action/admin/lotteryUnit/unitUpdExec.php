<?php
/**
 * unitUpdExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面抽選ユニット更新処理ページファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmUnitOBJ = AdmUnit::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["id"] AND $param["disable"]) {

    $value["update_datetime"] = date("YmdHis");
    $value["disable"] = 1;

    if (!$AdmUnitOBJ->updateLotteryUnitData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $returnSessOBJ->return = $param;
        header("Location: ./?action_lotteryUnit_List=1");
        exit();
    }

    $messageSessOBJ->message = array("削除しました。");
    header("Location: ./?action_lotteryUnit_List=1");
    exit();

} else if ($param["id"]) {

    if ($errMsg) {
        $messageSessOBJ->message = $errMsg;
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_lotteryUnit_UnitData=1&id=" . $param["id"]);
        exit();
    }

    $value["update_datetime"] = date("YmdHis");
    $value["comment"] = $param["comment"];

    if (!$AdmUnitOBJ->updateLotteryUnitData($value , array("id = " . $param["id"]))) {
        $messageSessOBJ->message = $AdmUnitOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("Location: ./?action_lotteryUnit_UnitData=1&id=" . $param["id"]);
        exit();
    }

    $messageSessOBJ->message = array("更新しました。");

    header("Location: ./?action_lotteryUnit_UnitData=1&id=" . $param["id"]);
    exit();
}

?>