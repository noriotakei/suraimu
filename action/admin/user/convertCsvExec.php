<?php
/**
 * 管理画面コンバート対象ユーザーcsv出力ページ処理ファイル。
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
if (!$userList = $AdminUserOBJ->getConvertCsvList($value)) {
    $errSessOBJ->errMsg = "対象者がいません";
    header("Location: ./?action_user_Search=1");
    exit;
}

$fileName = "convert_" .$_config["define"]["PROJECT_NAME"] ."_". date("YmdHis") . ".txt";

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $fileName);

$loginIdArray = array();
$mbSerialNumberArray = array();
$mbAddressArray = array();
$pcAddressArray = array();

foreach ($userList as $val) {

    if(in_array($val["login_id"],$loginIdArray)){
        continue;
    }else{
        $loginIdArray[] = $val["login_id"];
    }

    if((ComValidation::isValue($val["mb_serial_number"])) && in_array($val["mb_serial_number"],$mbSerialNumberArray)){
        continue;
    }else{
        $mbSerialNumberArray[] = $val["mb_serial_number"];
    }

    if((ComValidation::isValue($val["mb_address"])) && in_array($val["mb_address"],$mbSerialNumberArray)){
        continue;
    }else{
        $mbAddressArray[] = $val["mb_address"];
    }

    if((ComValidation::isValue($val["pc_address"])) && in_array($val["pc_address"],$mbSerialNumberArray)){
        continue;
    }else{
        $pcAddressArray[] = $val["pc_address"];
    }

    print(mb_convert_encoding("\"".$val["user_id"]."\",","SJIS","UTF-8"));

    // 空白の場合、NULL値を入れる(ログインID)
    if ($val["login_id"] == "") {
        print(mb_convert_encoding(",","SJIS","UTF-8"));
    } else {
        print(mb_convert_encoding("\"".$val["login_id"]."\",","SJIS","UTF-8"));
    }

   // print(mb_convert_encoding("\"".$val["login_id"]."\",","SJIS","UTF-8"));

    print(mb_convert_encoding("\"".$val["admin_id"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["pc_ip_address"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["pc_user_agent"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["mb_ip_address"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["mb_user_agent"]."\",","SJIS","UTF-8"));

    // 空白の場合、NULL値を入れる(MB個体識別)
    if ($val["mb_serial_number"] == "") {
        print(mb_convert_encoding(",","SJIS","UTF-8"));
    } else {
        print(mb_convert_encoding("\"".$val["mb_serial_number"]."\",","SJIS","UTF-8"));
    }

    print(mb_convert_encoding("\"".$val["mb_model"]."\",","SJIS","UTF-8"));

    // 空白の場合、NULL値を入れる(PCアドレス)
    if ($val["pc_address"] == "") {
        print(mb_convert_encoding(",","SJIS","UTF-8"));
    } else {
        print(mb_convert_encoding("\"".$val["pc_address"]."\",","SJIS","UTF-8"));
    }

    // 空白の場合、NULL値を入れる(MBアドレス)
    if ($val["mb_address"] == "") {
        print(mb_convert_encoding(",","SJIS","UTF-8"));
    } else {
        print(mb_convert_encoding("\"".$val["mb_address"]."\",","SJIS","UTF-8"));
    }

    //print(mb_convert_encoding("\"".$val["mb_serial_number"]."\",","SJIS","UTF-8"));
    //print(mb_convert_encoding("\"".$val["pc_address"]."\",","SJIS","UTF-8"));
    //print(mb_convert_encoding("\"".$val["mb_address"]."\",","SJIS","UTF-8"));

    print(mb_convert_encoding("\"".$val["regist_status"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["pc_device_cd"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$val["mb_device_cd"]."\",","SJIS","UTF-8"));
    print(mb_convert_encoding("\"".$param["regist_page_id"]."\",","SJIS","UTF-8"));
    //print(mb_convert_encoding("\"".$param["media_cd"]."\"","SJIS","UTF-8"));

    // 通常コンバートの場合、現在の媒体コードを入れる
    if (empty($param["media_cd"])) {
        print(mb_convert_encoding("\"".$val["media_cd"]."\"","SJIS","UTF-8"));
    } else {
        print(mb_convert_encoding("\"".$param["media_cd"]."\"","SJIS","UTF-8"));
    }

    print("\n");
}

// セッション変数の破棄
$errSessOBJ->unsetAll();
exit;

?>
