<?php
/**
 * orderingData.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面注文詳細ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$returnSessOBJ = new ComSessionNamespace("return");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

$AdmOrderingOBJ = AdmOrdering::getInstance();
$AdminUserOBJ = AdmUser::getInstance();
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();
$AdmItemOBJ = AdmItem::getInstance();
$AdmOrderChangeLogOBJ = AdmOrderChangeLog::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$orderingData = $AdmOrderingOBJ->getOrderingData($param["ordering_id"]);

// 商品詳細の取得
$itemList = $AdmItemOBJ->getOrderingDetailItemList($param["ordering_id"]);
$smartyOBJ->assign("itemList", $itemList);

// 注文変更詳細の取得
$changeItemList = $AdmOrderChangeLogOBJ->getChangeItemList($param["ordering_id"]);
foreach ($changeItemList as $chgVal) {
    $changeItemTotalMoney += $chgVal["price"];
}
$smartyOBJ->assign("changeItemList", $changeItemList);
$smartyOBJ->assign("changeItemTotalMoney", $changeItemTotalMoney);

$userData =$AdminUserOBJ->getUserData($orderingData["user_id"]);

$supportMailList = $AdmSupportMailLogOBJ->getSupportMailLogList($param["ordering_id"]);
$smartyOBJ->assign("userData", $userData);
$smartyOBJ->assign("userAddressData", $userAddressData);
$smartyOBJ->assign("supportMailList", $supportMailList);


// 登録エラーで戻った場合
if ($returnValue["return_flag"]) {
    if ($returnValue["return_cd"] == "status") {
        $orderingData["status"] = $returnValue["status"];
        $orderingData["description"] = $returnValue["description"];
    }
    if ($returnValue["return_cd"] == "pay_type") {
        $orderingData["pay_type"] = $returnValue["pay_type"];
    }
}
$smartyOBJ->assign("orderingData", $orderingData);

// 支払い方法が「銀行振り込み(BAS) or 楽天銀行」の場合は、『一括完済処理ボタン』を表示する
// 支払い済みの場合はボタンを表示しない
$isAuomationBas = "";
if (!($orderingData["is_paid"] || $orderingData["is_cancel"])) {
    if ($orderingData["pay_type"]) {
        switch ($orderingData["pay_type"]) {
            // 銀行振り込み(BAS)
            case AdmOrdering::PAY_TYPE_BANK_AUTOMATIONBAS:
                $settleUrl = "SettleBankManualPaymentExec";
                break;
            // 楽天銀行
            case AdmOrdering::PAY_TYPE_BANK_RAKUTEN:
                $settleUrl = "SettleRakutenManualPaymentExec";
                break;
            // 該当がなければ
            default :
                $isAuomationBas = FALSE;
                break;
        }

        if ($settleUrl) {
            $isAuomationBas = TRUE;
            $smartyOBJ->assign("settleUrl", $settleUrl);
            $smartyOBJ->assign("isAuomationBas", $isAuomationBas);
        }
    }
}

$tags = array(
            "ordering_id",
            "sesKey",
            );

$POSTparam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $POSTparam);

// 注文ステータス
$smartyOBJ->assign("orderStatus", AdmOrdering::$_orderStatus);
// 支払方法
$smartyOBJ->assign("payType", AdmOrdering::$_payType);
// キャンセルフラグ
$smartyOBJ->assign("cancelFlag", AdmOrdering::$_cancelFlag);
// 入金フラグ
$smartyOBJ->assign("paidFlag", AdmOrdering::$_paidFlag);
// 注文変更時ステータス
$smartyOBJ->assign("changeStatus", AdmOrderChangeLog::$_status);

?>

