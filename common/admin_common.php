<?php
/**
 * admin_common.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側共通処理。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// 携帯端末種別毎にheader,doctype等を生成
require_once(D_BASE_DIR . "/common/doctype.php");

$smartyOBJ->compile_dir="../templates_c/admin";

$sesName = $_config["define"]["ADMIN_SESSION_NAME"];

// セッションパス用ディレクトリ作成
if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/admin")) {
    if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"])) {
        mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"]);
    }
    mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/admin");
}

// セッションスタート
if (!ComSession::isStarted()) {
    ComSession::setOptions(array("save_path" => "/tmp/" . $_config["define"]["PROJECT_NAME"] . "/admin", "cache_expire" => 360, "cache_limiter" => "nocache", "name" => $sesName, "gc_maxlifetime" => 60*60*5));
    ComSession::start();
}

// 処理タイムアウトの制限を取る
set_time_limit(0);

$loginId  = $requestOBJ->getParameter("login_id", null, "post");
$password = $requestOBJ->getParameter("password", null, "post");

$adminAuthOBJ = AdmAuth::getInstance();

if ($requestOBJ->getActionName() == "login") {
    // ログインデータの破棄
    $adminAuthOBJ->clearIdentity();
    $result = $adminAuthOBJ->authentication($loginId, $password);
} else {
    $result = $adminAuthOBJ->authentication();
}

// 認証不可の場合
if (!$result) {
    // 認証画面以外は認証画面へリダイレクト
    if (!($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "index")) {
        $errMsgSessOBJ = new ComSessionNamespace("err_msg");
        $errMsgSessOBJ->errMsg = array("認証できません");
        header("Location: ./");
        exit;
    }
} else {
    // 認証画面ですでに認証済みはトップページへ
    if ($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "index") {
        header("Location: ./?action_Top=1");
        exit;
    }
}

$loginAdminData["id"] = $adminAuthOBJ->getIdentity()->id;
$loginAdminData["name"] = $adminAuthOBJ->getIdentity()->name;
$loginAdminData["login_id"] = $adminAuthOBJ->getIdentity()->login_id;
$loginAdminData["authority_type"] = $adminAuthOBJ->getIdentity()->authority_type;
$smartyOBJ->assign("loginAdminData", $loginAdminData);

$actionKey = $requestOBJ->getActionKey();
$smartyOBJ->assign("actionKey", $actionKey);

// デフォルトセッションキー
$defaultSessionName = ini_get("session.name");

// getParameterExceptで排除する項目
$exceptArray = array(
    $actionKey,    // アクションキー
    $_config["define"]["BAITAI_SESSION_NAME"],   // 媒体集計セッションID
    $_config["define"]["BAITAI_AGENCY_SESSION_NAME"],   // 代理店向け媒体集計セッションID
    $sesName,      // セッションID
    $defaultSessionName,   // デフォルトセッションキー
);

// 競馬間コンバートの場合は処理しない（executeQueryしたくない）
if ($requestOBJ->getActionName() != "user_convertCsvExec") {
    if($loginAdminData && $actionKey){
        //アクセス制限
        $AdmAdminAccessControlOBJ = AdmAdminAccessControl::getInstance();
        $AdmAdminAccessControlOBJ->adminAccessControl($loginAdminData["authority_type"],$actionKey);
        // ユーザー情報表示制限
        $AdmAdminDisplayControlOBJ = AdmAdminDisplayControl::getInstance();
        $displayUserDetail = $AdmAdminDisplayControlOBJ->adminDisplayControlUserDetail($loginAdminData["authority_type"]);
        $smartyOBJ->assign("displayUserDetail", $displayUserDetail);
        //管理画面アクセス情報
        $admTmpAdminAccessOBJ = AdmTmpAdminAccess::getInstance();
        $insertAdminAccessData["create_datetime"] = "'" . date("YmdH0000") . "'";
        $insertAdminAccessData["admin_id"] = $loginAdminData["id"];
        $insertAdminAccessData["action_key"] = "'" . $actionKey . "'";
        $updateAdminAccessData["access_count"] = "access_count + 1";
        $insertAdminAccessData["global_ip_address"] = "'".$_SERVER['REMOTE_ADDR'] ."'";
        $admTmpAdminAccessOBJ->insertDuplicateAdmAccessData($insertAdminAccessData, $updateAdminAccessData, false);
    }
}

// 代理店媒体CHK用URLのパラメータセット
if ($loginAdminData["id"]) {
    $agencyParamURL = "&aid=" . $loginAdminData["id"];
    $smartyOBJ->assign("agencyParamURL", $agencyParamURL);
}

// 問い合わせのパラメータセット
if ($loginAdminData["id"]) {
    $infoParamURL = "?aid=" . $loginAdminData["id"];
    $smartyOBJ->assign("infoParamURL", $infoParamURL);
}

?>
