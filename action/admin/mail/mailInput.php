<?php
/**
 * mailInput.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガ作成ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

// セッションオブジェクトのインスタンス
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$returnSessOBJ = new ComSessionNamespace("return");
// 入力項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();
if (!$returnValue['from_name']) {
    $returnValue['from_name'] = '';
}
// 戻り値の取得
$smartyOBJ->assign("param", $returnValue);

// セッション変数の取得
if ($param["sesKey"]) {
    $value = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search=1");
    exit;
}

$userListCount = $AdmMailMagazineOBJ->getUserListCount($value);
if ($AdmMailMagazineOBJ->getErrorMsg()) {
    $errSessOBJ->errMsg = $AdmMailMagazineOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}
/* 未来でも予約できるようにコメントアウト
if (!$userListCount) {
    $errSessOBJ->errMsg = array("アドレス入力済みユーザーデータがありません");
    header("Location: ./?action_user_Search=1");
    exit;
}
*/
// 検索条件の取得
$whereContents = $AdmMailMagazineOBJ->getWhereContents();

$smartyOBJ->assign("whereContents", $whereContents);

$pcCount = $userListCount["pc"] ? array_sum($userListCount["pc"]) : 0;
$mbCount = $userListCount["mb"] ? array_sum($userListCount["mb"]) : 0;
$totalCount = $pcCount + $mbCount;

// 推定時間
// 大体３件で１秒かかっています
if ($totalCount) {
    $totalSecond = floor($totalCount / 3);
    if ($totalSecond >= 60) {
        $sendTime = $totalSecond / 60 . "分";
        if ($sendTime >= 300) {
            $recommend = "(予約ﾒﾙﾏｶﾞ推奨)";
        }
    } else if ($totalSecond >= 1) {
        $sendTime = $totalSecond . "秒";
    } else {
        $sendTime = "数秒";
    }
}

$smartyOBJ->assign("pcCount", $pcCount);
$smartyOBJ->assign("mbCount", $mbCount);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("sendTime", $sendTime);
$smartyOBJ->assign("recomend", $recommend);

$requestOBJ->setParameter("sesKey", $param["sesKey"]);
$tags = array(
            "sesKey",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// エラーメッセージの取得
$errMsg = $errSessOBJ->getIterator();
// セッション変数の破棄
$errSessOBJ->unsetAll();

$smartyOBJ->assign("errMsg", $errMsg);

// 日にち配列
for ($i = 1; $i < 31; $i++) {
    $dayAry[$i] = $i;
}
$dayAry["0"] = "月末";

$smartyOBJ->assign("dayAry", $dayAry);
$mailReserveType = AdmMailMagazine::$_mailReserveType;
$defaultMailReserveType = AdmMailMagazine::MAILMAGAZINE_TYPE_NORMAL;
if (!$totalCount) {
    unset($mailReserveType[AdmMailMagazine::MAILMAGAZINE_TYPE_NORMAL]);
    $defaultMailReserveType = AdmMailMagazine::MAILMAGAZINE_TYPE_TIMER;
}

/* 2011-08-04 hosoda TEST予約
 * 拡張ヘッダー X-SM-SendStart に送信日時指定で、
 * 予約データをcronではなく即メールサーバーに渡す
if ($loginAdminData["authority_type"] == $configOBJ->define->AUTHORITY_TYPE_SYSTEM) {
    $mailReserveType = $mailReserveType + array(3 => "TEST予約");
}
*/

$smartyOBJ->assign("mailReserveType", $mailReserveType);
$smartyOBJ->assign("defaultMailReserveType", $defaultMailReserveType);
$smartyOBJ->assign("intervalSecond", AdmMailMagazine::$_intervalSecond);
$smartyOBJ->assign("sendConditionTypeHourSecond", AdmMailMagazine::$_sendConditionTypeHourSecond);
$smartyOBJ->assign("sendConditionType", AdmMailMagazine::$_sendConditionType);
$smartyOBJ->assign("sendAddress", AdmMailMagazine::MAIL_MAGAZINE_ADDRESS_ACCOUNT . "@" . $_config["define"]["MAIL_DOMAIN"]);
?>

