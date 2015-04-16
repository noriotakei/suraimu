<?php

/**
 * freeWordLog.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ﾌﾘｰﾜｰﾄﾞログページ処理ファイル。
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$AdmFreeWordOBJ = AdmFreeWord::getInstance();
$freeWordIndividualUserData =$AdmFreeWordOBJ->getFreeWordIndividualUserData($param["user_id"]);

foreach($freeWordIndividualUserData as $key => $val){
	if($val["free_word_type"] == 2){
        $freeWordSet[] = $val ;
	} else {
        $freeWord[] = $val ;
	}
}

$smartyOBJ->assign("freeWord", $freeWord);
$smartyOBJ->assign("freeWordSet", $freeWordSet);

?>
