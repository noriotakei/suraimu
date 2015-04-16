<?php
/**
 * user_common.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 WEBメーラー共通処理
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

 // 管理画面のセッションを取ってくる。
session_save_path("/tmp/" . $define["define"]["PROJECT_NAME"] . "/admin");
session_cache_expire(360);
session_cache_limiter("nocache");
session_name($define["define"]["ADMIN_SESSION_NAME"]);
ini_set('session.gc_maxlifetime',  60*60*5);
session_start();

$adminUserDataObject = $_SESSION["Zend_Auth"]["storage"];
$loginAdminData      = (array)$adminUserDataObject;

if(!$loginAdminData){
    //TOPへさようなら。
    header("Location: ./../");
    exit;

}else{
    $adminId = $loginAdminData["id"];
    if($adminId){
        // 問い合わせオペレーターユーザーデータを取得する
        $sql = " SELECT *"
             . " FROM information_operator_list"
             . " WHERE admin_id = " . $adminId
             . " AND disable = 0 "
             . " ORDER BY id DESC" ;

        $rs = $db->executeSql($sql);
        $userData = "";
        if ($rs->numRows() > 0) {
            while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
                $userData = $row;
            }
        }
        $operatorId = $userData["id"];
    }
}
?>
