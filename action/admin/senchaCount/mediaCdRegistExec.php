<?php
/**
 * adcodeRegistExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面広告コード更新ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$AdmMediaCdOBJ = AdmMediaCd::getInstance();

$insertData = null;

$insertData["name"]             = $param["name"];
$insertData["description"]      = $param["description"];
$insertData["update_datetime"]  = date("YmdHis");


if ($param["media_cd_id"]) {
    if ($param["disable"]) {
        $insertData["disable"] = $param["disable"];
    }

    if (!$AdmMediaCdOBJ->updateData($insertData, array("id = " . $param["media_cd_id"]))) {
        $execMsgSessOBJ->exec_msg = $AdmCompanyOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_Count_MediaCdData=1");
        exit;
    }

    if ($param["disable"]) {
        $execMsgSessOBJ->errMsg = array("削除しました。");
    } else {
        $execMsgSessOBJ->errMsg = array("更新しました。");
    }


} else {

    if (!$AdmMediaCdOBJ->insertData($insertData)) {
        $execMsgSessOBJ->exec_msg = $AdmCompanyOBJ->getErrorMsg();
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        header("location: ./?action_Count_MediaCdRegistExec=1");
        exit;
    }
    $execMsgSessOBJ->errMsg = array("更新しました。");

}


header("location: ./?action_Count_MediaCdRegist=1");
exit;


?>