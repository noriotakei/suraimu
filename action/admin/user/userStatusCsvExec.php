<?php

/**
 * addressCsvExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/** 
 * 管理画面住所csv出力ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

ini_set("memory_limit", "-1");

$param = $requestOBJ->getParameterExcept($exceptArray);
// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$AdminUserOBJ = AdmUser::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = "&" . $requestOBJ->makeGetTag($tags);

// セッション変数の取得
if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1");
    exit;
}

$userList = $AdminUserOBJ->getUserList($value);

if ($errSessOBJ->errMsg) {
    $errSessOBJ->errMsg = $AdminUserOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}

$fileName = "userStatusList_" . date("YmdHis") . ".csv";

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $fileName);

foreach ($userList as $val) {

    // 1984-09-10からＣＳＶを実行した日時の年齢に変換
    $birthDate =  ($val["birth_date"] == "0000-00-00")? "" :(int)((date("Ymd") - date("Ymd",strtotime($val["birth_date"])))/10000) ;

    if($val["sex_cd"] == 1){
       	$sex = "男" ;
    } else if($val["sex_cd"] == 2){
       	$sex = "女" ;
    } else {
       	$sex = "未設定" ;
    }

    print(mb_convert_encoding($birthDate . ",","SJIS","UTF-8"));
    print(mb_convert_encoding($sex. ",","SJIS","UTF-8"));
    print(mb_convert_encoding($val["login_id"] . ",","SJIS","UTF-8"));
    print("\n");
}

// セッション変数の破棄
$errSessOBJ->unsetAll();
exit;

?>
