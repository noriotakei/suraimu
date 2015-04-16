<?php
/**
 * taikai4.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後退会4ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

if (($param["q1"] == 1 AND !ComValidation::isNumeric($param["q6"]))
        OR ($param["q2"] == 1 AND !ComValidation::isNumeric($param["q7"]))
        OR ($param["q3"] == 1 AND !ComValidation::isNumeric($param["q8"]))
        OR ($param["q4"] == 1 AND !ComValidation::isNumeric($param["q9"]))
        OR ($param["q5"] == 1 AND !$param["q10"])
        ) {
    $errFlag = true;
}

if ($errFlag) {
    $errSessOBJ->errMsg[] = "必須項目に入力漏れがあります";
    header("Location: ./?action_Taikai=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

$tags = array(
            "q1",
            "q2",
            "q3",
            "q4",
            "q5",
            "q6",
            "q7",
            "q8",
            "q9",
            "q10",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);

?>
