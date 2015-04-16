<?php
/**
 * getAllowDomain.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ブラックドメインユーザー処理ファイル。
 *
 * @copyright   2011 Fraise, Inc.
 * @author      takuro ito
 * @author      ryohei murata
 */

ini_set("memory_limit", "-1");
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
set_time_limit(0);
$AllowDomainOBJ = AllowDomain::getInstance();
$AdminUserOBJ   = AdmUser::getInstance();

// XMLファイル取得
$requestParam = "?p=" . md5("blackhorse" . date("Ymd")) ."&siteCd=" . $_config["define"]["BLACK_SITE_CD"];
if (!$xml = get_object_vars(simplexml_load_file(AllowDomain::GET_DOMAINLIST_URL . $requestParam))) {
    exit("データ取得ならず!行:".__LINE__);
}

//データ同期処理
for ($i=0; !empty($xml["row"][$i]); $i++) {
    $tmpCurrentData = get_object_vars($xml["row"][$i]);
    //過去データがあったら更新
    if($AllowDomainOBJ->duplicateDomainData($tmpCurrentData["domain"],$tmpCurrentData["authority_type"])){
        // 既存データを論理的破棄
        $updateArray = array( "update_datetime" => date("Y-m-d H:i:s"));
        $whereArray  = array( "domain = '" . $tmpCurrentData["domain"] . "'"
                              ,"is_deny = " . $tmpCurrentData["authority_type"]
                              ,"disable = " . $_config["define"]["FALSE"]);

        if (!$AllowDomainOBJ->updateData($updateArray,$whereArray)) {
            exit("データ破棄失敗!行:".__LINE__);
        }
    }else{
        //値が正常＆既存データにない場合に登録
        if(ComValidation::isString($tmpCurrentData["domain_name"])
        && ComValidation::isString($tmpCurrentData["domain"])
        && ComValidation::isNumeric($tmpCurrentData["authority_type"])){
            $param = array("domain_name" => $tmpCurrentData["domain_name"]
                           ,"domain"     => $tmpCurrentData["domain"]
                           ,"is_deny"    => $tmpCurrentData["authority_type"]
                           ,"update_datetime" => date("Y-m-d H:i:s")
                           ,"create_datetime" => date("Y-m-d H:i:s")
                           );
            if (!$AllowDomainOBJ->insertData($param)) {
                exit("データ登録失敗!行:".__LINE__);
            }
        }
    }
}

// 未更新データを論理的破棄
$updateArray = array( "disable" => $_config["define"]["TRUE"]
                      ,"update_datetime" => date("Y-m-d H:i:s")
);
$whereArray  = array( "disable = " . $_config["define"]["FALSE"]
                     ,"update_datetime < '" . date("Y-m-d") . " 00:00:00'");
if (!$AllowDomainOBJ->updateData($updateArray,$whereArray)) {
    exit("データ破棄失敗!行:".__LINE__);
}

//不許可ドメインを取得
$nonAllowDomainArray = $AllowDomainOBJ->getNonAllowDomainList();
$columnArray  = array("user_id","pc_address");
if($nonAllowDomainArray){

    foreach($nonAllowDomainArray as $key => $value){

        $whereFromDomainArray = "";
        $whereFromDomainArray[] = "pc_address  LIKE '%" . $value["domain"] . "'";
        $whereFromDomainArray[] = "danger_status = " . $_config["define"]["FALSE"] . "";
        //許可ドメインを取得
        if($allowDomainArray = $AllowDomainOBJ->getAllowDomainList($value["domain"])){
            foreach($allowDomainArray as $key2 => $value2){
                $whereFromDomainArray[] = "pc_address NOT LIKE '%" . $value3["domain"] . "'";
            }
        }
        if ($user = $AdminUserOBJ->getUserListByFreeSearch($columnArray, $whereFromDomainArray)) {
            foreach($user as $key3 => $value3){
                // ユーザ情報更新
                $updateArray = array( "danger_status" => $_config["define"]["TRUE"]
                                      ,"update_datetime" => date("Y-m-d H:i:s")
                                     );

                $whereArray  = array( "id =" . $value3["user_id"]);
                if (!$AdminUserOBJ->updateUserData($updateArray,$whereArray)) {
                    exit("ﾕｰｻﾞｰ更新失敗!行:".__LINE__);
                }
            }
        }
    }
}
exit();

?>

