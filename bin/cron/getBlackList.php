<?php
/**
 * getBlackList.php
 *
 * Copyright (c) 2011 Fraise, Inc.
 * All rights regulard.
 */

/**
 * ブラックユーザー処理ファイル。
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
$BlackListOBJ = BlackList::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

// 既存データの取得
$blackList = $BlackListOBJ->getBlackListAll();

//非対象サイトの判断の為、サイトコードをつけて判断させます
$requestParam = "?p=" . md5("blackhorse" . date("Ymd")) ."&siteCd=" . $_config["define"]["BLACK_SITE_CD"];

// XMLファイル取得
if (!$xml = get_object_vars(simplexml_load_file(BlackList::GET_BLACKLIST_URL . $requestParam))) {
    exit("データ取得ならず!行:".__LINE__);
}

$currentList = array();
for ($i=0; !empty($xml["row"][$i]); $i++) {
    $insertFlg = FALSE;
    $tmpCurrentData = get_object_vars($xml["row"][$i]);
    $currentList[] = array(
                            "mail_address"      => $tmpCurrentData["mail_address"],
                            "mb_contract_id"    => $tmpCurrentData["mb_contract_id"]
                            );

    //データがあったら更新
    switch (true) {
        case $tmpCurrentData["mail_address"] != "" :
            if($BlackListOBJ->searchBlackListByAddress($tmpCurrentData["mail_address"])){
                $updateArray = array( "update_datetime" => date("Y-m-d H:i:s"));
                $whereArray  = array( "disable = " . $_config["define"]["FALSE"]
                                     ,"mail_address = '" . $tmpCurrentData["mail_address"] . "'");
                if (!$BlackListOBJ->updateData($updateArray, $whereArray)) {
                    exit("データ更新失敗!行:".__LINE__);
                }
            }else{
                $insertFlg = TRUE;
            }
            break;
        case $tmpCurrentData["mb_contract_id"] != "" :
            if($BlackListOBJ->searchBlackListByMbSerialNumber($tmpCurrentData["mb_contract_id"])){
                $updateArray = array( "update_datetime" => date("Y-m-d H:i:s"));
                $whereArray  = array( "disable = " . $_config["define"]["FALSE"]
                                     ,"mb_contract_id = '" . $tmpCurrentData["mb_contract_id"] . "'");
                if (!$BlackListOBJ->updateData($updateArray, $whereArray)) {
                    exit("データ更新失敗!行:".__LINE__);
                }
            }else{
                $insertFlg = TRUE;
            }
            break;
    }
    //新規登録
    if($insertFlg){
        $param = array("mail_address"     => $tmpCurrentData["mail_address"]
                       ,"mb_contract_id"  => $tmpCurrentData["mb_contract_id"]
                       ,"update_datetime" => date("Y-m-d H:i:s")
                       ,"create_datetime" => date("Y-m-d H:i:s")
                       );
        if (!$BlackListOBJ->insertData($param)) {
            exit("データ登録失敗!行:".__LINE__);

        }
    }
}
// 未更新データを論理的破棄
$updateArray = array( "disable" => $_config["define"]["TRUE"]
                      ,"update_datetime" => date("Y-m-d H:i:s")
);
$whereArray  = array( "disable = " . $_config["define"]["FALSE"]
                     ,"update_datetime < '" . date("Y-m-d") . " 00:00:00'");
if (!$BlackListOBJ->updateData($updateArray, $whereArray)) {
    exit("データ破棄失敗!行:".__LINE__);
}

// 更新ユーザー
$newBlackUserList = "";
$columnArray      = array("user_id", "danger_status");
// データ取得ループ
for ($i=0; !empty($currentList[$i]); $i++) {
    $tmpCurrentData = $currentList[$i];
    $whereFromAddressArray  = "";
    $whereSerialNumberArray = "";

    // トランザクション開始
    $BlackListOBJ->beginTransaction();

    // 登録状況確認
    switch (true) {
        // 登録状況確認
        case $tmpCurrentData["mail_address"] != "" :
            $whereFromAddressArray[] = "(mb_address = '" . $tmpCurrentData["mail_address"] . "' OR pc_address = '" . $tmpCurrentData["mail_address"] . "')";
            $whereFromAddressArray[] = "danger_status = " . $_config["define"]["FALSE"] . "";

            if ($user = $AdminUserOBJ->getUserListByFreeSearch($columnArray, $whereFromAddressArray)) {
                // 登録ユーザーの場合、クレーマーフラグを立てる
                foreach ($user as $val) {
                    // 今回該当したユーザIDを保持しておく
                    // $newBlackUserList[] = $val["user_id"];
                    // ユーザ情報更新
                    $updateArray = array( "danger_status" => $_config["define"]["TRUE"]
                                          ,"update_datetime" => date("Y-m-d H:i:s")
                                         );

                    $whereArray  = array( "id =" . $val["user_id"]);

                    if (!$AdminUserOBJ->updateUserData($updateArray,$whereArray)) {
                        // ロールバック
                        $BlackListOBJ->rollbackTransaction();
                        exit("ﾕｰｻﾞｰ更新失敗!行:".__LINE__);
                    }
                }
            }
            break;

        case $tmpCurrentData["mb_contract_id"] != "" :
            $whereSerialNumberArray[] = "mb_serial_number = '" . $tmpCurrentData["mb_contract_id"] . "'";
            $whereSerialNumberArray[] = "danger_status = " . $_config["define"]["FALSE"] . "";
            if ($user = $AdminUserOBJ->getUserListByFreeSearch($columnArray, $whereSerialNumberArray)) {
                // 登録ユーザーの場合、クレーマーフラグを立てる
                foreach ($user as $val) {
                    // 今回該当したユーザIDを保持しておく
                    // $newBlackUserList[] = $val["user_id"];
                    // ユーザ情報更新
                    $updateArray = array( "danger_status" => $_config["define"]["TRUE"]
                                          ,"update_datetime" => date("Y-m-d H:i:s")
                                         );

                    $whereArray  = array( "id =" . $val["user_id"]);

                    if (!$AdminUserOBJ->updateUserData($updateArray,$whereArray)) {
                        // ロールバック
                        $BlackListOBJ->rollbackTransaction();
                        exit("ﾕｰｻﾞｰ更新失敗!行:".__LINE__);
                    }
                }
            }
            break;

        default :
            break;
    }

    // コミット
    $BlackListOBJ->commitTransaction();

    // 解放
    unset($currentList[$i]);

}
/*
// ブラックサーバから削除されたユーザは正常に戻す
if (!$BlackListOBJ->updateUserNormal($newBlackUserList)) {

    // ロールバック
    $BlackListOBJ->rollbackTransaction();
    exit("ユーザー復活失敗!行:".__LINE__);

}
*/

exit();

?>

