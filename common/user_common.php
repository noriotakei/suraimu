<?php
/**
 * web 全ページ共通処理
 */

$mbUrl = parse_url($_config["define"]["SITE_URL_MOBILE"]);
// URLがPCかモバイルか
if ( preg_match("/^" . str_replace("/", "\/", preg_quote($mbUrl["path"])) . "/", $_SERVER["REQUEST_URI"]) ) {
    $isURIMobile = true;
    $smartyOBJ->compile_dir = "../templates_c/mobile";
} else {
    $isURIMobile = false;
    $smartyOBJ->compile_dir = "../templates_c/pc";
}

// 共通ファイル読込み
require_once(D_BASE_DIR . "/common/doctype.php");        // 携帯端末種別・PC毎にheader,doctype 等を生成・出力する

require_once(D_BASE_DIR . "/common/ack.php");    // istyle等設定ファイル

// デフォルトセッションキー
$defaultSessionName = ini_get("session.name");
$sesName = $_config["define"]["SESSION_NAME"];

// ユーザエージェントオブジェクト作成
$useragentOBJ = new ComUserAgentMobile();
$mbUa = $useragentOBJ->getCarrier();
$mbSerialNo = $useragentOBJ->getSerialNumber();

//スマートフォン判別
$userAgentSmartPhoneOBJ = new ComUserAgentSmartPhone();
$isSmartPhone = FALSE;
if ($userAgentSmartPhoneOBJ ->isSmartPhone()) {
    $isSmartPhone = TRUE;
}

$server["HTTP_USER_AGENT"] = $requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");
$server["QUERY_STRING"] = $requestOBJ->getParameter("QUERY_STRING", "no_escape", "server");
$server["REMOTE_ADDR"] = $requestOBJ->getParameter("REMOTE_ADDR", "", "server");
$server["HTTPS"] = $requestOBJ->getParameter("HTTPS", "", "server");
$server["HTTP_REFERER"] = $requestOBJ->getParameter("HTTP_REFERER", "", "server");

$actionKey = $requestOBJ->getActionKey();

// getParameterExceptで排除する項目
$exceptArray = array(
    $actionKey,    // アクションキー
    $sesName,      // セッションID
    $defaultSessionName,   // デフォルトセッションキー
    Auth::ACCESS_KEY_NAME,        // ユーザー識別キー
    "guid",     // ドコモimodeID用タグ
    "mlid",     // メルマガID
 );

$sessionId = $requestOBJ->getParameter($sesName);
$commonParam = $requestOBJ->getAllParameter();


// セッションスタート
// モバイル
if (($mbUa != "NonMobile" AND !array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"])) OR preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])) {
    // セッションパス用ディレクトリ作成
    if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/mobile")) {
        if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"])) {
            mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"]);
        }
        mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/mobile");
    }
    ini_set("default_charset", "SJIS");

    $sessionSetOption = array("save_path" => "/tmp/" . $_config["define"]["PROJECT_NAME"] . "/mobile", "name" => $sesName, "use_cookies" => 0, "use_only_cookies" => 0, "use_trans_sid" => 1, "gc_maxlifetime" => 60*60*24*7);

// PCアクセスの場合
} else {
    // モバイル表示時のテストアクセス用
    if ($isURIMobile) {
        ini_set("default_charset", "SJIS");
    }
    // セッションパス用ディレクトリ作成
    if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/www")) {
        if (!is_dir("/tmp/" . $_config["define"]["PROJECT_NAME"])) {
            mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"]);
        }
        mkdir("/tmp/" . $_config["define"]["PROJECT_NAME"] . "/www");
    }
    $sessionSetOption = array("save_path" => "/tmp/" . $_config["define"]["PROJECT_NAME"] . "/www", "name" => $sesName, "gc_maxlifetime" => 60*60*24*7);
}
if (!ComSession::isStarted()) {
    ComSession::setOptions($sessionSetOption);
    if ($sessionId) {
        ComSession::setId($sessionId);
    }
    ComSession::start();
}

// アクセスページ名
$accessPageName = $controllerOBJ->convertActionName($requestOBJ->getActionName());

// common用エラーセッション
$ComErrSessOBJ = new ComSessionNamespace("common_err");
// セッションにセットします
$userSessOBJ = new ComSessionNamespace("user");
$getRequestOBJ = new ComRequest();

$affiliateParam = $getRequestOBJ->getAllParameter("", "get");

$advCd = $affiliateParam["advcd"];

// 検索アドコード取得
if (preg_match("/^http:\/\/www.google.co.jp\/search\//", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["GOOGLE_AD_CD_PC"];
} else if (preg_match("/^http:\/\/search.yahoo.co.jp\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["YAHOO_AD_CD_PC"];
} else if (preg_match("/^http:\/\/search.yahoo.co.jp\/bin\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["YAHOO2_AD_CD_PC"];
} else if (preg_match("/^http:\/\/search.msn.co.jp\/results.aspx/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["MSN_AD_CD_PC"];
} else if (preg_match("/^http:\/\/www.google.co.jp\/m\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["GOOGLE_AD_CD_MB"];
} else if (preg_match("/^http:\/\/is.mobile.yahoo.co.jp/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["YAHOO_AD_CD_MB"];
} else if (preg_match("/^http:\/\/m.msn.co.jp\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["MSN_AD_CD_MB"];
} else if (preg_match("/^http:\/\/m.live.com\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["LIVE_AD_CD_MB"];
} else if (preg_match("/^http:\/\/ezsch.ezweb.ne.jp\/search/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["EZSCH_AD_CD_MB"];
} else if (preg_match("/^http:\/\/sbs.mobile.yahoo.co.jp/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["SBS_AD_CD_MB"];
} else if (preg_match("/^http:\/\/dir.mobile.yahoo.co.jp/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["DIL_YAHOO_AD_CD_MB"];
} else if (preg_match("/^http:\/\/ws.mobile.yahoo.co.jp/", $server["HTTP_REFERER"])) {
        $advCd = $_config["define"]["WS_YAHOO_AD_CD_MB"];
} else if (!$advCd) {
    if ($mbUa != "NonMobile" OR $isSmartPhone) {
        $advCd = $_config["define"]["DEFAULT_AD_CD_MB"];
    } else {
        $advCd = $_config["define"]["DEFAULT_AD_CD_PC"];
    }
}

$getRequestOBJ->setParameter("advcd", $advCd);

if ($mbUa != "NonMobile" OR $isSmartPhone) {
    $sessId = $sesName . "=" . ComSession::getId();
}

// SESSIONへの格納
if (!$userSessOBJ->affiliate_value OR $affiliateParam["advcd"]) {
    $userSessOBJ->unsetAll();
    $userSessOBJ->affiliate_value = $getRequestOBJ->makeGetTagExcept($exceptArray);
    // ポータルから性別、生年月日があれば、リダイレクトしてパラメータを隠す
    if ($affiliateParam["s"] OR $affiliateParam["b"]) {
        if ($isURIMobile) {
            header("Location: " . $_config["define"]["SITE_URL_MOBILE"] . ($mbUa == "Docomo" ? "?guid=ON" . ($sessId ? "&" . $sessId : "") : ($sessId ? "?" . $sessId : "")));
            exit();
        } else {
            header("Location: " . $_config["define"]["SITE_URL"]);
            exit();
        }
    }
}

// モバイルなら表示文字コードを設定する
if ((($mbUa != "NonMobile" OR $isSmartPhone) AND !array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"]))
    OR preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])) {
    // モバイルURLでなければ
    // ドコモ個体識別がなければリダイレクト
    if (!$isURIMobile OR ($mbUa == "Docomo" AND !$commonParam["guid"] AND !$mbSerialNo)) {
        if ($server["QUERY_STRING"]) {
            parse_str($server["QUERY_STRING"], $queryAry);
            if ($queryAry[$sesName]) {
                unset($queryAry[$sesName]);
            }
            if (ComValidation::isArray($queryAry)) {
                foreach((array)$queryAry as $key => $val) {
                    $queryString[] = $key . "=" . $val;
                }
                $queryString = implode("&", (array)$queryString);
            }
        }
        header("Location: " . $_config["define"]["SITE_URL_MOBILE"] . "index.php?" . $queryString . ($mbUa == "Docomo" ? ($queryString ? "&guid=ON&" .  $sessId : "guid=ON&" . $sessId) : ($queryString ? "&" .  $sessId : $sessId)));
        exit();
    }

// PCアクセスの場合
} else {

    // 自社アクセス以外はPC用ページに飛ばす
    if (($isURIMobile AND !array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"]))
         OR preg_match("/" . implode("|", $_config["web_config"]["crawler_pc"]) . "/", $server["HTTP_USER_AGENT"])) {
        header("Location: " . $_config["define"]["SITE_URL"] . "?" . $server["QUERY_STRING"]);
        exit();
    }
}

// メンテナンスフラグのチェック
if ($accessPageName != "maintenance" AND Maintenance::checkMaintenance()) {
    if ($mbSerialNo AND !array_key_exists($mbSerialNo, $_config["common_config"]["mb_serial_number"])) {
        header("Location: ./?action_Maintenance=1");
        exit();
    } else if (!$mbSerialNo AND !array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"])) {
        header("Location: ./?action_Maintenance=1");
        exit();
    }
}

$accessKey = $commonParam[Auth::ACCESS_KEY_NAME];

// 特殊引継ぎデータの指定
$specialKeyArray = array(
    "guid",        // ドコモキー
);

$comURLparam = $requestOBJ->makeGetTag($specialKeyArray); // URLに付加する特殊GET用
$comFORMparam = $requestOBJ->makePostTag($specialKeyArray); // formに付加するPOST用

$smartyOBJ->assign("comURLparam", $comURLparam);
$smartyOBJ->assign("comFORMparam", $comFORMparam);

/*****************************************************/
/******** ↓ メルマガからのアクセス数取得 ↓ *********/
/*****************************************************/

// メルマガからのアクセス数カウントアップ処理
if ($commonParam["mlid"]) {

    // オブジェクト生成
    $AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

    $mailMagaLogId = intval($commonParam["mlid"]);

    // モバイル
    if ($isURIMobile) {

        $mailMagaLog["access_count_mb"] = "access_count_mb + 1";
        $mailMagaLog["update_datetime"] = "'" . date("YmdHis") . "'";

        // アクセス数カウントアップ
        if (!$AdmMailMagazineOBJ->updateMailMagaLog($mailMagaLog, array("id = " . $mailMagaLogId), false)) {
            $ComErrSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg;
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
            exit();
        }
        // ＰＣ
    } else {
        $mailMagaLog["access_count_pc"] = "access_count_pc + 1";
        $mailMagaLog["update_datetime"] = "'" . date("YmdHis") . "'";

        // アクセス数カウントアップ
        if (!$AdmMailMagazineOBJ->updateMailMagaLog($mailMagaLog, array("id = " . $mailMagaLogId), false)) {
            $ComErrSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg;
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
            exit();
        }
    }
}

/********** ↑ mailmagazine_log 管理処理 ↑ **********/
/*****************************************************/

// アクセスページ名
$accessPageName = $controllerOBJ->convertActionName($requestOBJ->getActionName());

// クローラーに表示しないようにする
if (preg_match("/" . implode("|", $_config["web_config"]["crawler_pc"]) . "/", $server["HTTP_USER_AGENT"])
      OR preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])) {
    exit;
}

if (!array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"])
    AND !preg_match("/" . implode("|", $_config["web_config"]["crawler_pc"]) . "/", $server["HTTP_USER_AGENT"])
    AND !preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])
    AND !$isSmartPhone) {
      if ($isURIMobile) {
        switch ($accessPageName) {
            case "error":
            case "preOn":
                break;

            default :

                // 対応機種じゃない場合
                if (!$useragentOBJ->is3G()) {
                    $ComErrSessOBJ->errMsg[] = "対応機種ではありません。";
                    header("Location: " . $_config["define"]["SITE_URL_MOBILE"] . "?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                    exit();
                // 個体識別が無かったらエラーページへ飛ばす
                } else if (!$mbSerialNo AND !$accessKey) {
                    header("Location: " . $_config["define"]["SITE_URL_MOBILE"] . "?action_PreOn=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                    exit();
                }
                break;
        }
    }
}

// トップページアクセスならカウントする
if (!$accessPageName OR $accessPageName == "index") {
    // 自社アクセス以外
    if (!array_key_exists($server["REMOTE_ADDR"], $_config["common_config"]["corporation_ip_address"])
        AND !preg_match("/" . implode("|", $_config["web_config"]["crawler_pc"]) . "/", $server["HTTP_USER_AGENT"])
            AND !preg_match("/" . implode("|", $_config["web_config"]["crawler_mb"]) . "/", $server["HTTP_USER_AGENT"])) {

            $MediaAnalyzeOBJ = MediaAnalyze::getInstance();

            $insertAnalyzeData["analyze_datetime"] = "'" . date("YmdH0000") . "'";
            $insertAnalyzeData["media_cd"] = "'" . $advCd . "'";
            $insertAnalyzeData["access_count"] = 1;
            $insertAnalyzeData["create_datetime"] = "'" . date("YmdHis") . "'";

            $updateAnalyzeData["access_count"] = "access_count + 1";

            if (!$MediaAnalyzeOBJ->insertDuplicateMediaAnalyzeData($insertAnalyzeData, $updateAnalyzeData, false)) {
                $ComErrSessOBJ->errMsg = $MediaAnalyzeOBJ->getErrorMsg;
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
    }
}

// 文言切り替え ※2011-8-23で切り替え(ページはaction_SettleCvd)
$nowDate = time(); // 今の時間
$chgDate = mktime(0,0,0,8,23,2011); // 切り替える日時
$isDisp = true;
if ($nowDate > $chgDate) {
    $isDisp = false;
}
$smartyOBJ->assign("isDisp", $isDisp);

?>
