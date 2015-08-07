<?php
/**
 * informationCreate.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報データ登録ページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoStatusOBJ = AdmInformationStatus::getInstance();
$AdminUserOBJ = AdmUser::getInstance();

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$message = $execMsgSessOBJ->getIterator();
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $message);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();
if ($returnValue) {
        $returnParam = $returnValue;
}

// selectbox用情報リストの取得
$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();
$infoDispPositionForSelect = $AdmInfoDispPositionOBJ->getInformationDisplayPositionForSelect();
$smartyOBJ->assign("infoDispPositionForSelect", $infoDispPositionForSelect);

// 入金状態
$smartyOBJ->assign("paymentStatus", AdmInformationStatus::$_paymentStatus);

$smartyOBJ->assign("returnParam", $returnParam);

// bodyタグ基本設定
$htmlTagPC = '<body>';
$htmlTagMB = '<body link="#ffcc99" vlink="#cc9966" alink="#ffcc99" text="#ffffff" style="color:#ffffff; background:#000000;" bgcolor="#000000">'
              . "\n".'<a name="top" id="top"></a>'
              . "\n".'<div style="font-size:x-small; text-align:left; width:100%;">';
$smartyOBJ->assign("htmlTagPC", htmlspecialchars($htmlTagPC));
$smartyOBJ->assign("htmlTagMB", htmlspecialchars($htmlTagMB));

// 戻り値の取得
$smartyOBJ->assign("registParam", $registParam);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationStatus::$_isDisplay);

// ｽﾏﾎ表示切り替え
$smartyOBJ->assign("isSmartPhone", AdmInformationStatus::$_isSmartPhone);

// 全画面表示フラグ
$smartyOBJ->assign("isAllDisplay", AdmInformationStatus::$_isAllDisplay);

// 表示曜日縛り
$smartyOBJ->assign("isDisplayWeek", AdmInformationStatus::$_isDisplayWeek);

// 情報定型文データの有無
$AdmInfoTemplateOBJ = AdmInformationTemplate::getInstance();
$infoTemplateList = $AdmInfoTemplateOBJ->getInformationTemplateList();

$smartyOBJ->assign("infoTemplateList", $infoTemplateList);

// 検索保存条件ID(表示/非表示)の検索条件指定
$smartyOBJ->assign("searchConditionsTypeArray", array("0" => "いずれか含む","1" => "すべて含む"));
//付与ポイント無制限
$smartyOBJ->assign("bonusPointLimitTypeArray", array("0" => "無効","1" => "有効"));
?>