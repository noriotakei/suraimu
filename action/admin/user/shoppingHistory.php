<?php

/**
 * shoppingHistory.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報購入履歴ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$adminUserOBJ = AdmUser::getInstance();
$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = $param["limit"];
if (!$dispCnt) {
    $dispCnt = 20;
}

$userId = $param["user_id"];
$userData =$adminUserOBJ->getUserData($userId);

$AdmOrderingOBJ = AdmOrdering::getInstance();

$orderingHistoryList = $AdmOrderingOBJ->getOrderingHistoryList($userId, $offset, $dispCnt);
$totalCount = $AdmOrderingOBJ->getFoundRows();

$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $offset + 1);
$smartyOBJ->assign("dispLast", $offset + count($orderingHistoryList));

$smartyOBJ->assign("userData", $userData);
$smartyOBJ->assign("orderingHistoryList", $orderingHistoryList);

$tags = array(
            "user_id",
            );
$reloadTags = array(
            "user_id",
            "offset",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$URLparam = $requestOBJ->makeGetTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "User_ShoppingHistory=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

?>
