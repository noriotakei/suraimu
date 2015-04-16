<?php
/**
 * baitai_common.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側媒体集計共通処理。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

// 携帯端末種別毎にheader,doctype等を生成
require_once(D_BASE_DIR . "/common/doctype.php");

$sesName = $_config["define"]["BAITAI_SESSION_NAME"];

// セッションパス用ディレクトリ作成
if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitai")) {
    if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"])) {
        mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"]);
    }
    mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitai");
}

// セッションスタート
if (!ComSession::isStarted()) {
    ComSession::setOptions(array("save_path" => "/tmp/" . $_config["define"]["PROJECT_NAME"] . "/baitai", "cache_expire" => 360, "cache_limiter" => "nocache", "name" => $sesName, "gc_maxlifetime" => 60*60*5));
    ComSession::start();
}

// 処理タイムアウトの制限を取る
set_time_limit(0);

$loginId  = $requestOBJ->getParameter("login_id", null, "post");
$password = $requestOBJ->getParameter("password", null, "post");

$adminBaitaiAuthOBJ = AdmAuth::getInstance();

if ($requestOBJ->getActionName() == "baitai_Login") {
    // ログインデータの破棄
    $adminBaitaiAuthOBJ->clearIdentity();
    $result = $adminBaitaiAuthOBJ->baitaiAuthentication($loginId, $password);
} else {
    $result = $adminBaitaiAuthOBJ->baitaiAuthentication();
}

// 認証不可の場合
if (!$result) {
    // 認証画面以外は認証画面へリダイレクト
    if (!($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "baitai_Index")) {
        $errMsgSessOBJ = new ComSessionNamespace("err_msg");
        $errMsgSessOBJ->errMsg = array("認証できません");
        header("Location: ./?action_baitai_Index=1");
        exit;
    }
} else {
    // 認証画面ですでに認証済みはトップページへ
    if ($requestOBJ->getActionName() == "" OR $requestOBJ->getActionName() == "baitai_Index") {
        header("Location: ./?action_baitai_Top=1");
        exit;
    }
}

$loginBaitaiUserData["id"] = $adminBaitaiAuthOBJ->getIdentity()->id;
$loginBaitaiUserData["login_id"] = $adminBaitaiAuthOBJ->getIdentity()->login_id;
$loginBaitaiUserData["authority_type"] = $adminBaitaiAuthOBJ->getIdentity()->authority_type;
$smartyOBJ->assign("loginBaitaiUserData", $loginBaitaiUserData);

$actionKey = $requestOBJ->getActionKey();
$smartyOBJ->assign("actionKey", $actionKey);

// デフォルトセッションキー
$defaultSessionName = ini_get("session.name");

// getParameterExceptで排除する項目
$exceptArray = array(
    $actionKey,    // アクションキー
    $_config["define"]["ADMIN_SESSION_NAME"],   // 管理画面セッションID
    $_config["define"]["BAITAI_AGENCY_SESSION_NAME"],   // 代理店向け媒体集計セッションID
    $sesName,      // セッションID
    $defaultSessionName,   // デフォルトセッションキー
);


?>
