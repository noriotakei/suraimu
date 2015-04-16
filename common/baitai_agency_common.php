<?php
/**
 * baitai_agency_common.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 代理店用媒体集計共通処理。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

// 携帯端末種別毎にheader,doctype等を生成
require_once(D_BASE_DIR . "/common/doctype.php");

$sesName = $_config["define"]["BAITAI_AGENCY_SESSION_NAME"];

// セッションパス用ディレクトリ作成
if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitaiAgency")) {
    if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"])) {
        mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"]);
    }
    mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitaiAgency");
}

// セッションスタート
if (!ComSession::isStarted()) {
    ComSession::setOptions(array("save_path" => "/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitaiAgency", "cache_expire" => 360, "cache_limiter" => "nocache", "name" => $sesName, "gc_maxlifetime" => 60*60*5));
    ComSession::start();
}

// 処理タイムアウトの制限を取る
set_time_limit(0);

$loginId  = $requestOBJ->getParameter("login_id", null, "post");
$password = $requestOBJ->getParameter("password", null, "post");
$adminId = $requestOBJ->getParameter("aid", null);

$adminIdOBJ = new ComSessionNamespace("admin_id");

// 代理店URLからのアクセスはセッション破棄
if (!$requestOBJ->getActionName()) {
    // セッション変数の破棄
    $adminIdOBJ->unsetAll();
}

if ($adminId) {
    $adminIdOBJ->admin_id = $adminId;
} else if ($adminIdOBJ->admin_id) {
    $adminId = $adminIdOBJ->admin_id;
} else {
    // セッション変数の破棄
    $adminIdOBJ->unsetAll();
}

// アクセス時のIPアドレス
$server["REMOTE_ADDR"] = $requestOBJ->getParameter("REMOTE_ADDR", "", "server");

// 管理画面からのアクセスは、IPアドレスチェックはしない
if ($adminId) {
    $corporation = TRUE;
    $smartyOBJ->assign("adminId", $adminId);
    $smartyOBJ->assign("corporation", $corporation);
} else {
    // 「管理画面」以外はIPアドレスチェック
    $ipAddress = $server["REMOTE_ADDR"];
}

$adminBaitaiAuthOBJ = AdmAuth::getInstance();

// loginページの場合に認証チェック
if ($requestOBJ->getActionName() == "login") {
    // ログインデータの破棄
    $adminBaitaiAuthOBJ->clearIdentity();
    $result = $adminBaitaiAuthOBJ->baitaiAgencyAuthentication($loginId, $password, $ipAddress, $corporation);
} else {
    $result = $adminBaitaiAuthOBJ->baitaiAgencyAuthentication();
}

// 認証不可の場合
if (!$result) {
    // 認証画面以外は認証画面へリダイレクト
    if (!($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "index")) {
        $errMsgSessOBJ = new ComSessionNamespace("err_msg");
        $errMsgSessOBJ->errMsg = array("認証できません");
        header("Location: ./?action_Index=1" . ($adminId ? "&aid=" . $adminId : ""));
        exit;
    }
} else {
    // 認証画面ですでに認証済みはトップページへ
    if ($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "index") {
        header("Location: ./?action_agency_Top=1" . ($adminId ? "&aid=" . $adminId : ""));
        exit;
    }
}

// ログインユーザーデータを取得
$loginBaitaiUserData["id"] = $adminBaitaiAuthOBJ->getIdentity()->id;
$loginBaitaiUserData["login_id"] = $adminBaitaiAuthOBJ->getIdentity()->login_id;
$loginBaitaiUserData["name"] = $adminBaitaiAuthOBJ->getIdentity()->name;
//$loginBaitaiUserData["is_display_trade_amount"] = $adminBaitaiAuthOBJ->getIdentity()->is_display_trade_amount;

// 管理画面からのアクセスと格納データを切り分ける
if ($adminId) {
    $loginBaitaiUserData["authority_type"] = $adminBaitaiAuthOBJ->getIdentity()->authority_type;
} else {
    $loginBaitaiUserData["is_display_trade_amount"] = $adminBaitaiAuthOBJ->getIdentity()->is_display_trade_amount;
}
$smartyOBJ->assign("loginBaitaiUserData", $loginBaitaiUserData);

$actionKey = $requestOBJ->getActionKey();
$smartyOBJ->assign("actionKey", $actionKey);

// デフォルトセッションキー
$defaultSessionName = ini_get("session.name");

// getParameterExceptで排除する項目
$exceptArray = array(
    $actionKey,    // アクションキー
    $_config["define"]["ADMIN_SESSION_NAME"],   // 管理画面セッションID
    $_config["define"]["BAITAI_SESSION_NAME"],   // 媒体集計セッションID
    $sesName,      // セッションID
    $defaultSessionName,   // デフォルトセッションキー
);

?>
