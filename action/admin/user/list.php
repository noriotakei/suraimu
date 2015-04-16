<?php
/**
 * list.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザーリストページ処理ファイル。
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
$sesParam = $param;

$dispCnt = $param["limit"];
if (!$dispCnt) {
    $dispCnt = 100;
}

// 競馬観コンバートの場合、条件追加
$admConvertConfigOBJ = AdmConvertConfig::getInstance();
if ($param["specify_convert_type"] == 2) {
    if ($param["convert_pay_type"] == 1) {
        // 入なし
        $sesParam["total_payment_from"] = ($sesParam["total_payment_from"]) ? $sesParam["total_payment_from"] : "";
        $sesParam["buy_count_from"] = ($sesParam["buy_count_from"]) ? $sesParam["buy_count_from"] : "";
        $sesParam["total_payment_to"] = ($sesParam["total_payment_to"]) ? $sesParam["total_payment_to"] : 0;
        $sesParam["buy_count_to"] = ($sesParam["buy_count_to"]) ? $sesParam["buy_count_to"] : 0;
    } elseif ($param["convert_pay_type"] == 2) {
        // 入あり
        $sesParam["total_payment_from"] = ($sesParam["total_payment_from"]) ? $sesParam["total_payment_from"] : 1;
        $sesParam["buy_count_from"] = ($sesParam["buy_count_from"]) ? $sesParam["buy_count_from"] : 1;
        $sesParam["total_payment_to"] = ($sesParam["total_payment_to"]) ? $sesParam["total_payment_to"] : "";
        $sesParam["buy_count_to"] = ($sesParam["buy_count_to"]) ? $sesParam["buy_count_to"] : "";
    } else {
        // 関係無し
        $sesParam["total_payment_from"] = ($sesParam["total_payment_from"]) ? $sesParam["total_payment_from"] : "";
        $sesParam["buy_count_from"] = ($sesParam["buy_count_from"]) ? $sesParam["buy_count_from"] : "";
        $sesParam["total_payment_to"] = ($sesParam["total_payment_to"]) ? $sesParam["total_payment_to"] : "";
        $sesParam["buy_count_to"] = ($sesParam["buy_count_to"]) ? $sesParam["buy_count_to"] : "";
    }

    // サイト間登録（未登録）※固定
    $sesParam["specify_regist_site"] = 0;
    switch ($param["to_convert_sites"]) {
        case "suraimu" :
            $sesParam["regist_site"][] = 5;
            break;
        case "chimera" :
            $sesParam["regist_site"][] = 6;
            break;
        case "troll" :
            $sesParam["regist_site"][] = 9;
            break;
        case "golem" :
            $sesParam["regist_site"][] = 8;
            break;
        case "gizmo" :
            $sesParam["regist_site"][] = 3;
            break;
        default:
            // 必要ないと思うけど一応...。
            unset($sesParam["regist_site"]);
            break;
    }

    // 検索保存条件IDによってコンバート客の種類を取得
    $cnvType = $admConvertConfigOBJ->getVisitorType($param["search_conditions_id"]);
    if (!$cnvType) {
        $errSessOBJ->errMsg = array("競馬間コンバートデータ抽出失敗");
        header("Location: ./?action_user_Search=1");
        exit;
    }
    $smartyOBJ->assign("cnvType", $_config["admin_config"]["specify_convert_type_select"][$cnvType]);

    $whereArray[] = "from_convert_site_name = '" . $_config["define"]["PROJECT_NAME"] . "'";
    $whereArray[] = "to_convert_site_name = '" . $param["to_convert_sites"] . "'";
    $whereArray[] = "convert_type = " . $cnvType;
    $whereArray[] = "pay_type = " . $param["convert_pay_type"];
    $convertList = $admConvertConfigOBJ->getConvertConfigList($whereArray);

    if (!$convertList) {
        $errSessOBJ->errMsg = array("競馬間コンバートデータ抽出失敗");
        header("Location: ./?action_user_Search=1");
        exit;
    }
}

// セッションにセットします
$userSearchSessOBJ = new ComSessionNamespace("user_search");
$errSessOBJ = new ComSessionNamespace("err");
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

if ($param["mail_maga_regular_id"]) {
    $smartyOBJ->assign("mailMagaRegularId", $param["mail_maga_regular_id"]);
    unset($sesParam["mail_maga_regular_id"]);
} else if ($param["mail_maga_reserve_id"]) {
    $smartyOBJ->assign("mailMagaReserveId", $param["mail_maga_reserve_id"]);
    unset($sesParam["mail_maga_reserve_id"]);
}

if ($param["search_conditions_id"]) {
    $searchSaveData = $adminUserOBJ->getUserSearchConditionData($param["search_conditions_id"] );
    $returnSessOBJ->return["search_conditions_id"] = $param["search_conditions_id"];
    unset($sesParam["search_conditions_id"]);
    $messageSessOBJ->searchSaveComment = array("検索画面で" . $searchSaveData["comment"] . "をロードしています");

    if($searchSaveData["update_permission"]){
        $messageSessOBJ->searchSaveComment = array("この検索保存条件は更新禁止に設定されています。");
        $smartyOBJ->assign("update_permission_flag", $searchSaveData["update_permission"]);
    }

}

$smartyOBJ->assign("searchConditionReturn", $returnSessOBJ->return);
$returnSessOBJ->unsetAll();

if ($param["sesKey"]) {
    $sesKey = $param["sesKey"];
    $sesParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $sesKey = "param_" . strtotime("NOW");
    $userSearchSessOBJ->$sesKey = $sesParam;
}

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

// user profile flag
$AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();

//get all user profile flag
$userProfileFlagList = $AdminUserProfileFlagOBJ->getUserProfileFlag();

// generate user profile code flag
$userProfileFlagCodeList = array("0" => "フラグＯＦＦ");
foreach ($userProfileFlagList as $item) {
    $userProfileFlagCodeList += array(
            $item['code'] => $item['name']);
}
$sesParam['userProfileCodeFlagList'] = $userProfileFlagCodeList;
$smartyOBJ->assign("user_profile_flag_code", $userProfileFlagCodeList);

$userList = $adminUserOBJ->getUserList($sesParam, $offset, $sesParam["order"], $dispCnt);
$totalCount = $adminUserOBJ->getFoundRows();

$smartyOBJ->assign("userList", $userList);

if ($adminUserOBJ->getErrorMsg()) {
    $errSessOBJ->errMsg = $adminUserOBJ->getErrorMsg();
    header("Location: ./?action_user_Search=1");
    exit;
}

$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $offset + 1);
$smartyOBJ->assign("dispLast", $offset + count($userList));

$smartyOBJ->assign("whereContents", $adminUserOBJ->getWhereContents());

$requestOBJ->setParameter("sesKey", $sesKey);
$tags = array(
            "sesKey",
            );
$reloadTags = array(
            "sesKey",
            "mail_maga_regular_id",
            "mail_maga_reserve_id",
            "search_conditions_id",
            "specify_convert_type",
            "convert_pay_type",
            "to_convert_sites",
            "offset",
            );
$urlTags = array(
            "sesKey",
            "mail_maga_regular_id",
            "mail_maga_reserve_id",
            "search_conditions_id",
            "specify_convert_type",
            "convert_pay_type",
            "to_convert_sites",
            );
$URLparam = $requestOBJ->makeGetTag($urlTags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($reloadTags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("POSTparam", $POSTparam);
$smartyOBJ->assign("reloadParam", $reloadParam);

$pagerArray["total_count"] = $totalCount;
$pagerArray["offset"] = $offset;
$pagerArray["disp_count"] = $dispCnt;
$pagerArray["action_name"] = "User_List=1";
$pagerArray["additional_param"] = "&" . $URLparam;

$smartyOBJ->assign("pager", ComPager::getLink($pagerArray));
$smartyOBJ->assign("accessKeyName", Auth::ACCESS_KEY_NAME);

// 検索条件保存カテゴリー

// カテゴリーの取得
$categoryList = $adminUserOBJ->getUserSearchConditionsCategoryForSelect();
$smartyOBJ->assign("categoryList", $categoryList);

// 月額コースの取得
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
// 月額コースリスト取得
$monthlyCourseList = $AdmMonthlyCourseOBJ->getMonthlyCourseListForSelect();
if ($monthlyCourseList) {
    $smartyOBJ->assign("monthlyCourseList", array("0" => "設定しない") + $monthlyCourseList);
} else {
    $smartyOBJ->assign("monthlyCourseList", array("0" => "月額コースが登録されていません。"));
}

// 強行メール設定
$smartyOBJ->assign("isPcReverse", array("0" => "しない", "1" => "する"));
$smartyOBJ->assign("isMbReverse", array("0" => "しない", "1" => "する"));

// フリーワード設定
$smartyOBJ->assign("freeWordType", array("1" => "数字選択", "2" => "管理選択"));
$smartyOBJ->assign("freeWordCd", array("1" =>"1","2" =>"2","3" =>"3","4" =>"4","5" =>"5","6" =>"6","7" =>"7","8" =>"8","9" =>"9","10" =>"10"));

$smartyOBJ->assign("update_permission", array(0=>"無効",1=>"有効"));

// 競馬間コンバートCSVファイル用データ
$smartyOBJ->assign("convertList", $convertList);

?>

