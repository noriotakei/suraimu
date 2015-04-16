<?php

/**
 * batchMonthlyCourseUserExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面ユーザー情報 月額コース一括付与更新処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
$MonthlyCourseOBJ = MonthlyCourse::getInstance();

$tags = array(
            "sesKey",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$messageSessOBJ = new ComSessionNamespace("exec_msg");
$errSessOBJ = new ComSessionNamespace("err");

$param = $requestOBJ->getParameterExcept($exceptArray);

$userSearchSessOBJ = new ComSessionNamespace("user_search");

// セッション変数の取得
if ($param["sesKey"]) {
    $searchParam = $userSearchSessOBJ->$param["sesKey"];
} else {
    $errSessOBJ->errMsg = "パラメータがありません";
    header("location: ./?action_user_Search");
    exit;
}

$validationOBJ = new ComArrayValidation($param);

// 月額コース付与であればチェック
if ($param["monthly_course"] > 0) {

    $validationOBJ->check("monthly_course", "月額コース",
                    array("Numeric" => null),
                    array("Numeric" => "月額コースを入力してください"));

    $validationOBJ->check("monthly_course_days", "月額コース有効日数",
                    array("Numeric" => null),
                    array("Numeric" => "ポイントは数値で入力してください"));

    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $messageSessOBJ->message = $errorMsg;
        header("location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit;
    }
} else {
    $messageSessOBJ->message = array("月額コースを選んで下さい");
    header("location: ./?action_user_ExecEnd=1&" . $URLparam);
    exit;
}

// 登録月額コースデータの取得
$monthlyCourseData = $AdmMonthlyCourseOBJ->getMonthlyCourseData($param["monthly_course"]);

// ユーザー検索条件
$whereArray = $AdminUserOBJ->setWhereString($searchParam);
$userList = $AdminUserOBJ->getUserList($searchParam);

// 更新データ生成
$setMonthlyCourseParam["monthly_course_id"]            = $monthlyCourseData["id"];
$setMonthlyCourseParam["limit_start_date"]             = date("Y-m-d");
$setMonthlyCourseParam["limit_end_date"]               = date("Y-m-d",strtotime($param["monthly_course_days"] . " day"));
$setMonthlyCourseParam["monthly_course_user.admin_id"] = $loginAdminData["id"];
$setMonthlyCourseParam["create_datetime"]              = date("YmdHis");

//更新タイプ
if ($monthlyCourseData["same_monthly_course_type"] == MonthlyCourse::COURSE_TYPE_UPDATE) {
    $setMonthlyCourseParam["create_type"] = MonthlyCourse::COURSE_TYPE_UPDATE;
} else {
    if ($monthlyCourseData["different_monthly_course_type"] == MonthlyCourse::COURSE_TYPE_UPDATE) {
        $setMonthlyCourseParam["create_type"] = MonthlyCourse::COURSE_TYPE_UPDATE;
    }
}

// トランザクション開始
$AdmMonthlyCourseOBJ->beginTransaction();

foreach ($userList as $val) {

    //既存の付与コースユーザデータに同グループのコースが1件以上でもあったら付与中止
    if($monthlyCourseUserList = $MonthlyCourseOBJ->getAllMonthlyCourseUserList(array("user_id" => $val["user_id"]), $monthlyCourseData["monthly_course_group_id"])){
        print_r($monthlyCourseUserList);

        $messageSessOBJ->message = array("期限内の同グループの月額コースユーザデータが存在します。"
                                         ,"ユーザーID『" . $val["user_id"] . "』"
                                         ,"月額コースグループ名『" . $monthlyCourseData["group_name"] . "』のコースユーザデータは無効にしてから付与して下さい"
                                   );

        // ロールバック
        $AdmMonthlyCourseOBJ->rollbackTransaction();
        header("location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit;
    }

    $setMonthlyCourseParam["user_id"] = $val["user_id"];

    if (!$AdmMonthlyCourseOBJ->insertMonthlyCourseUserData($setMonthlyCourseParam)) {
        // ロールバック
        $AdmMonthlyCourseOBJ->rollbackTransaction();
        $messageSessOBJ->message = array("月額コース付与できませんでした。");
        header("location: ./?action_user_ExecEnd=1&" . $URLparam);
        exit;
    }
}

// コミット
$AdmMonthlyCourseOBJ->commitTransaction();

$messageSessOBJ->message = array("月額コース付与完了しました。");

header("Location: ./?action_user_ExecEnd=1&" . $URLparam);
exit;

?>
