<?php
/**
 * taikai3.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後退会3ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/post_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));

$errSessOBJ = new ComSessionNamespace("err_msg");

$param = $requestOBJ->getParameterExcept($exceptArray);

if (!(ComValidation::isNumeric($param["q1"])
        AND ComValidation::isNumeric($param["q2"])
        AND ComValidation::isNumeric($param["q3"])
        AND ComValidation::isNumeric($param["q4"])
        AND ComValidation::isNumeric($param["q5"])
        )) {
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
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$smartyOBJ->assign("POSTparam", $POSTparam);

?>
