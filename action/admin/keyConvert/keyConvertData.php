<?php
/**
 * keyConvertData.php
 *
 * システム変換編集ページ
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);

// インスタンスの作成
$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$keyConvertData = $AdmKeyConvertOBJ->getKeyConvertData($param["key_convert_list_id"]);
if ($loginAdminData.authority_type != $_config["define"]["AUTHORITY_TYPE_SYSTEM"] AND $keyConvertData["is_not_update"]) {
        header("location: ./?action_keyConvert_KeyConvertList=1");
        exit;
}

$keyConvertContentsList = $AdmKeyConvertOBJ->getKeyConvertContentsList($param["key_convert_list_id"]);

$keyConvertData["return_flag"] = 0;
$keyConvertContentsData["return_flag"] = 0;

// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    if ($returnValue["return_cd"] == "list") {
        $keyConvertData = $returnValue;
        $keyConvertData["return_flag"] = 1;
    } else {
        $keyConvertContentsData = $returnValue;
        $keyConvertContentsData["return_flag"] = 1;
    }
} else {
    if ($returnValue["return_cd"] == "list") {
        $keyConvertData["return_flag"] = 0;
    } else {
        $keyConvertContentsData["return_flag"] = 0;
    }
}

$dispDatetimeFrom = $keyConvertContentsData["disp_datetime_from_date"]
                        . " " . $keyConvertContentsData["disp_datetime_from_time"];
if (ComValidation::isDatetime($dispDatetimeFrom)) {
    $keyConvertContentsData["display_start_datetime"] = $dispDatetimeFrom;
} else {
    $keyConvertContentsData["display_start_datetime"] = date("Y-m-d 00:00:00");
}

$dispDatetimeTo = $keyConvertContentsData["disp_datetime_to_date"]
                        . " " . $keyConvertContentsData["disp_datetime_to_time"];
if (ComValidation::isDatetime($dispDatetimeTo)) {
    $keyConvertContentsData["display_end_datetime"] = $dispDatetimeTo;
} else {
    $keyConvertContentsData["display_end_datetime"] = "";
}

$smartyOBJ->assign("keyConvertData", $keyConvertData);
$smartyOBJ->assign("keyConvertContentsData", $keyConvertContentsData);
$smartyOBJ->assign("keyConvertContentsList", $keyConvertContentsList);

$categoryList = $AdmKeyConvertOBJ->getKeyConvertCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);

$tags = array(
            "key_convert_list_id",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

?>