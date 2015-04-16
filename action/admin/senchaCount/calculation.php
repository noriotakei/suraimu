<?php

/**
 * calculation.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面集計リストページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$culcMenu = array(
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=RegisteredUserOfDay", "name" => "登録数(日毎)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=RegisteredUserOfMonth", "name" => "登録数・注文額(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportDaily", "name" => "売り上げ(日毎)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportMonth", "name" => "売り上げ(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportWeek", "name" => "売り上げ(週間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportDay", "name" => "売り上げ(曜日)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportItem", "name" => "商品別売り上げ(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportItemMonth", "name" => "当月登録商品別売り上げ(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=BasLogList", "name" => "銀行振込ログ<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=ErrBasLogList", "name" => "エラー銀行振込ログ<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=PaymentLogList", "name" => "入金ログ<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=FirstPayDailyList", "name" => "初入金者一覧(日毎)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=FirstPayDaySinceOpenSite", "name" => "初入金日(ｻｲﾄｵｰﾌﾟﾝ時からの累計)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=RegistMonthPaymentList", "name" => "当月登録入金者一覧<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=PaymentLogRate", "name" => "入金割合リスト(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=QuitUserOfDay", "name" => "退会者人数(退会日)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=QuitUserOfRegistDay", "name" => "退会者人数(登録日)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=QuitUserOfMonth", "name" => "退会者人数(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=UserCount", "name" => "会員数合計<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=QuitCountRegistDateOfMonth", "name" => "登録日毎退会者数"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=QuitCountQuitDateOfMonth", "name" => "退会日毎退会者数"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=Contribution", "name" => "購入回数別集計"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=InformationStatusCntOfDay", "name" => "情報閲覧回数(日毎)<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=InformationStatusCntOfMonth", "name" => "情報閲覧回数(月間)"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=ItemRanking", "name" => "商品ランキング<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=InformationRanking", "name" => "情報ランキング<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=SalesReportTotal", "name" => "全体売り上げ<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=ActiveUser", "name" => "アクティブ会員数<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=ActiveUser2", "name" => "アクティブ会員数2<font color=\"red\">※</font>"),
                array("file_name" => "action_senchaCount_CalculationSwitch=1&file_name=PaymentCountSinceOpenSite", "name" => "入金回数(ｻｲﾄｵｰﾌﾟﾝ時からの累計)"),
                );

$smartyOBJ->assign("culcMenu", $culcMenu);
$smartyOBJ->assign("specifyArray", AdmCalculation::$_specifyArray);

$AdmMediaCdOBJ = AdmMediaCd::getInstance();

$mediaCdAry = $AdmMediaCdOBJ->getMediaCdAryForSelect();
if (is_array($mediaCdAry)) {
    $smartyOBJ->assign("mediaCdAry", array("") + $mediaCdAry);
}

// 登録ページカテゴリーの取得
$AdmRegistPageOBJ = AdmRegistPage::getInstance();
$registPageCategoryList = $AdmRegistPageOBJ->getRegistPageCategoryForSelect();
$smartyOBJ->assign("registPageCategoryList", array("0" => "ダイレクト登録") + (array)$registPageCategoryList);

?>
