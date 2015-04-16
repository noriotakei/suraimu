<?php
/**
 * supportMailLogData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面サポートメールデータ処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "ordering_id",
            "sesKey",
            );
$reloadTags = array(
            "ordering_id",
            "support_mail_id",
            "sesKey",
            );
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $reloadParam);

$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();

$supportMailData = $AdmSupportMailLogOBJ->getSupportMailLogData($param["support_mail_id"]);

$replaceString = "";
if(!in_array("pc_address",$displayUserDetail)){
    $replaceString[] = $supportMailData["pc_to_address"];
}
if(!in_array("mb_address",$displayUserDetail)){
    $replaceString[] = $supportMailData["mb_to_address"];
}
if($replaceString){
    $supportMailData["pc_subject"] =  str_replace($replaceString,"<アドレス>",$supportMailData["pc_subject"]);
    $supportMailData["pc_text_body"] =  str_replace($replaceString,"<アドレス>",$supportMailData["pc_text_body"]);
    $supportMailData["mb_subject"] =  str_replace($replaceString,"<アドレス>",$supportMailData["mb_subject"]);
    $supportMailData["mb_text_body"] =  str_replace($replaceString,"<アドレス>",$supportMailData["mb_text_body"]);
}



$smartyOBJ->assign("supportMailData", $supportMailData);

?>

