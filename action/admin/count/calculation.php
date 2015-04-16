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
                array("file_name" => "action_count_RegisteredUserOfDay", "name" => "登録数(日毎)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_RegisteredUserOfMonth", "name" => "登録数・注文額(月間)", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_SalesReportDaily", "name" => "売り上げ(日毎)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_SalesReportMonth", "name" => "売り上げ(月間)", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_SalesReportWeek", "name" => "売り上げ(週間)", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_SalesReportDay", "name" => "売り上げ(曜日)", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_SalesReportItem", "name" => "商品別売り上げ(月間)", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_BasLogList", "name" => "銀行振込ログ<font color=\"red\">※</font>", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_ErrBasLogList", "name" => "エラー銀行振込ログ<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_PaymentLogList", "name" => "入金ログ<font color=\"red\">※</font>", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_FirstPayDailyList", "name" => "初入金者一覧(日毎)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_RegistMonthPaymentList", "name" => "当月登録入金者一覧", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_PaymentLogRate", "name" => "入金割合リスト(月間)", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_QuitUserOfDay", "name" => "退会者人数(退会日)<font color=\"red\">※</font>", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_QuitUserOfRegistDay", "name" => "退会者人数(登録日)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_QuitUserOfMonth", "name" => "退会者人数(月間)", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_UserCount", "name" => "会員数合計<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_QuitCountRegistDateOfMonth", "name" => "登録日毎退会者数", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_QuitCountQuitDateOfMonth", "name" => "退会日毎退会者数", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_Contribution", "name" => "購入回数別集計", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_InformationStatusCntOfDay", "name" => "情報閲覧回数(日毎)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_InformationStatusCntOfMonth", "name" => "情報閲覧回数(月間)", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_ItemRankingOrderPrice", "name" => "商品ランキング(金額順)<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
                array("file_name" => "action_count_ItemRanking", "name" => "商品ランキング(購入回数順)<font color=\"red\">※</font>", "blank" => "", "changeline" => "on"),
                array("file_name" => "action_count_InformationRanking", "name" => "情報ランキング<font color=\"red\">※</font>", "blank" => "", "changeline" => ""),
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
