<?php

/**
* @copyright   2014 Lampart, Inc.
* @author      hoang_minh
*/

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminAutoOBJ = AdmAutoPointGrant::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

$tags = array(
        "sesKey",
);

$URLparam = $requestOBJ->makeGetTag($tags);

$messageSessOBJ = new ComSessionNamespace("exec_msg");

$errSessOBJ = new ComSessionNamespace("err");

$param = $requestOBJ->getParameterExcept($exceptArray);

$param["disp_datetime"] = $param["disp_date"] . " " . $param["disp_time"];

$userSearchSessOBJ = new ComSessionNamespace("user_search");

if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}

$validationOBJ = new ComArrayValidation($param);

//check if point is numberic
$validationOBJ->check("auto_point", "ポイント",
        array("Value" => null, "Numeric" => null),
        array("Numeric" => "ポイントは数値で入力してください"));

//check if date is valid
$validationOBJ->check("disp_datetime", "datetimevalid",
        array("Value" => null, "DateTime" => null),
        array("DateTime" => "有効な時間に設定してください")
);

if (!$validationOBJ->getErrorMessage('disp_datetime')) {
    if (strtotime($param["disp_datetime"]) < time()) {
        $validationOBJ->setErrorMessage(disp_datetime, '有効な時間に設定してください');
    }
}
if ($validationOBJ->isError()) {
    $errorMsg = $validationOBJ->getErrorMessage();
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_List&" . $URLparam);
    exit;
}

//insert profile
$numberOfUser = $AdminUserOBJ->getNumberOfUserByParams($searchParam);
$search_sql   = str_replace("count(*) as 'total'", "SQL_CALC_FOUND_ROWS * ", $AdminUserOBJ->getListSql());

//columns be inserted data
$insertColmun["search_sql"] = htmlspecialchars($search_sql, ENT_QUOTES);
$insertColmun["search_condition"] = serialize($searchParam);
$insertColmun["point"] = $param["auto_point"];
$insertColmun["target_user_count"] = $numberOfUser;
$insertColmun["description"] = "";
$insertColmun["is_exec"] = 0;
$insertColmun["update_user_point_datetime"] = $param["disp_datetime"];
$insertColmun["create_datetime"] = date('Y-m-d H:i:s');
$insertColmun["disable"] = 0;

if (!$AdminAutoOBJ->insertReservePointGrantData($insertColmun)) {

    $messageSessOBJ->message = array("ポイントばらまき更新できませんでした");
    $messageSessOBJ->message = $errorMsg;
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

$messageSessOBJ->message = array("ポイントばらまき完了しました。");

header("location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;