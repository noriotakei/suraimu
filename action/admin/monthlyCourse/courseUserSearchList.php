<?php
/**
 * courseUserSearchList.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面 月額コースユーザーリスト処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$offset = $requestOBJ->getParameter("offset");
if (!$offset) {
    $offset = 0;
}

$exceptArray[] = "offset";
$param = $requestOBJ->getParameterExcept($exceptArray);
$dispCnt = 10;

// セッションオブジェクトのインスタンス
//$monthlyCourseUserSearchSessOBJ = new ComSessionNamespace("courseUserSearch");
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

// メッセージの取得
$smartyOBJ->assign("execMsg", $execMsgSessOBJ->getIterator());
// セッション変数の破棄
$execMsgSessOBJ->unsetAll();

$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

/*
// セッションにセットします
if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    $param = $monthlyCourseUserSearchSessOBJ->$param["sesKey"];
} else {
    $sesKey = "courseUserSearch_" . strtotime("NOW");
    $monthlyCourseUserSearchSessOBJ->$sesKey = $param;
}
$requestOBJ->setParameter("sesKey", $sesKey);
*/

// 検索項目の取得
$searchValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻ってきた場合
if ($searchValue) {
    $param = $searchValue;
}

// 月額コースユーザーリストの取得
if ($param["search_flag"]) {
    $validationOBJ = new ComArrayValidation($param);

    // ユーザーID
    if ($param["search_user_id"]) {
        $userId = "";
        // 末尾のカンマ削除(あれば)
        $param["search_user_id"] = rtrim($param["search_user_id"], ",");
        $userId = explode(",", $param["search_user_id"]);
        foreach ($userId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("search_user_id", "ユーザーIDは数値のみ入力可能です");
                break;
            }
        }
    }

    // 月額コース
    if ($param["monthly_course"]) {
        $validationOBJ->check("monthly_course", "月額コース",
                        array("Numeric" => null),
                        array("Numeric" => "月額コースを入力してください"));
    }

    // 月額コースID
    if ($param["monthly_course_id"]) {
        $monthlyCourseId = "";
        // 末尾のカンマ削除(あれば)
        $param["monthly_course_id"] = rtrim($param["monthly_course_id"], ",");
        $monthlyCourseId = explode(",", $param["monthly_course_id"]);
        foreach ($monthlyCourseId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("monthly_course_id", "月額コースIDは数値のみ入力可能です");
                break;
            }
        }
    }

    // 月額更新用商品ID
    if ($param["monthly_update_item_id"]) {
        $monthlyUpdateItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["monthly_update_item_id"] = rtrim($param["monthly_update_item_id"], ",");
        $monthlyUpdateItemId = explode(",", $param["monthly_update_item_id"]);
        foreach ($monthlyUpdateItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("monthly_update_item_id", "月額更新用商品IDは数値のみ入力可能です");
                break;
            }
        }
    }

    // 月額コース有効日付(開始日)
    if ($param["monthly_course_start_date"] AND !ComValidation::isDate($param["monthly_course_start_date"])) {
        $validationOBJ->setErrorMessage("月額コース有効日付(開始日)", "月額コース有効日付(開始日)を正しく入力してください");
    }

    // 月額コース有効日付(終了日)
    if ($param["monthly_course_end_date"] AND !ComValidation::isDate($param["monthly_course_end_date"])) {
        $validationOBJ->setErrorMessage("月額コース有効日付(終了日)", "月額コース有効日付(終了日)を正しく入力してください");
    }

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        header("location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
        exit;
    }

    $monthlyCourseUserList = $AdmMonthlyCourseOBJ->getMonthlyCourseUserList($param, $offset, "mcu.id DESC", $dispCnt);

    $totalCount = $AdmMonthlyCourseOBJ->getFoundRows();
    $dispFirst = $offset + 1;
    $dispLast = $offset + count($monthlyCourseUserList);
}

$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$smartyOBJ->assign("monthlyCourseUserList", $monthlyCourseUserList);
$smartyOBJ->assign("param", $param);

$urlTags = array(
            "search_user_id",
            "monthly_course_name",
            "monthly_course_id",
            "monthly_course_group_id",
            "create_type",
            "monthly_course_start_date",
            "monthly_course_end_date",
            "specify_monthly_update",
            "monthly_update_item_id",
            "admin_id",
            "search_flag",
            //"sesKey",

            );

$tags = array(
            //"sesKey",
            "search_user_id",
            "monthly_course_name",
            "monthly_course_id",
            "monthly_course_group_id",
            "create_type",
            "monthly_course_start_date",
            "monthly_course_end_date",
            "specify_monthly_update",
            "monthly_update_item_id",
            "admin_id",
            "search_flag",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($urlTags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("URLparam", "&offset=" . $offset . "&" . $URLparam);

$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

// <FORM>で渡す検索パラメーター
$smartyOBJ->assign("searchParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "monthlyCourse_CourseUserSearchList=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));

// 月額コース
if ($monthlyCourseListSelectArray = $AdmMonthlyCourseOBJ->getMonthlyCourseListForSelect()) {
    $smartyOBJ->assign("monthlyCourseListSelectArray", array("" => "指定なし") + $monthlyCourseListSelectArray);
} else {
    $smartyOBJ->assign("monthlyCourseListSelectArray", array("" => "月額コースの登録が有りません"));
}

// 月額コースグループ
if ($monthlyCourseGroupeListSelectArray = $AdmMonthlyCourseOBJ->getMonthlyCourseGroupForSelect()) {
    $smartyOBJ->assign("monthlyCourseGroupeListSelectArray", array("" => "指定なし") + $monthlyCourseGroupeListSelectArray);
} else {
    $smartyOBJ->assign("monthlyCourseGroupeListSelectArray", array("" => "グループの登録が有りません"));
}

// 月額コース更新タイプ
$smartyOBJ->assign("monthlyCourseCreateTypeSelectArray", array("" => "指定なし") + AdmMonthlyCourse::$_monthlyCourseUserCreateType);

// 管理ﾎﾞｯｸｽ
$AdmAdminOBJ = AdmAdmin::getInstance();
$adminList = $AdmAdminOBJ->getListForSelect();
$smartyOBJ->assign("adminList", array("" => "指定なし") + AdmAdmin::$_searchArray + (array)$adminList);

// 月額コース一括操作
$smartyOBJ->assign("batchOperateMonthlyCourseUserSelectAry", AdmMonthlyCourse::$_batchOperateMonthlyCourseUserSelectAry);
$smartyOBJ->assign("batchMonthlyCourseList", $monthlyCourseListSelectArray);

?>

