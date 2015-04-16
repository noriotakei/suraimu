<?php
/**
 * adminUserUpdateExec.php
 *
 * Copyright (c) 2012 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 毎月1日管理ログインパス更新cron処理ファイル。
 *
 * 毎月1日に実行
 *
 * @copyright   2012 Fraise, Inc.
 * @author      norio takei
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$admAdminOBJ = AdmAdmin::getInstance();

$adminList = $admAdminOBJ->getList();

foreach($adminList as $val){
	if(!$val["auto_update_flag"]){
        continue ;
	}
 
    $str = "" ;
    // ランダム文字列生成（配列利用） パスワードに使います。
    $strinit = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ012345679"; 
    $strarray = preg_split("//", $strinit, 0, PREG_SPLIT_NO_EMPTY); 
    for ($i = 0, $str = null; $i < 5; $i++) { 
        $str .= $strarray[array_rand($strarray, 1)]; 
    } 

    $insertData["password"]      = $admAdminOBJ->createPasswordKey($str);

    if (!$admAdminOBJ->updateData($insertData, array("id = " . $val["id"]))){
        mb_send_mail($val['send_mail_address'],$_config["define"]["SITE_NAME"]."のログインＰＡＳＳの変更に失敗しました。",$val['send_mail_address']."さんです。") ;
    } else {
        mb_send_mail($val['send_mail_address'],$_config["define"]["SITE_NAME"]."のログインＰＡＳＳが変更になりました。","\nPASS：：『".$str."』") ;    	
    }

}

exit("COMPLETE!!");
?>