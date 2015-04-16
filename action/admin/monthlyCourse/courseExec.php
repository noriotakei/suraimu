<?php
/**
 * courseExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側月額コース処理ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */
require_once(D_BASE_DIR . '/common/admin_common.php');
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$admMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// 戻り値の格納
$returnSessOBJ->return = $param;

// 検索条件用パラメーター生成
$tags = array(
            "mcid",
            "search_group_id",
            "search_type",
            "search_montly_course_id",
            "specify_keyword",
            "search_string",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

if (!$param["update_type"]) {
    /******* 入力項目の確認 *******/
    $validationOBJ->check("name", "管理側表示用コース名",
                    array("Value" => null),
                    array("Value" => "管理側表示用コース名は必須項目です"));

    $validationOBJ->check("monthly_course_group_id", "グループ",
                    array("Numeric" =>null),
                    array("Numeric" => "グループが取得出来ません"));

    $validationOBJ->check("same_monthly_course_type", "同月額コース更新タイプ",
                    array("Numeric" =>null),
                    array("Numeric" => "同月額コース更新タイプが取得出来ません"));

    $validationOBJ->check("different_monthly_course_type", "別月額コース更新タイプ",
                    array("Numeric" =>null),
                    array("Numeric" => "別月額コース更新タイプが取得出来ません"));

    $validationOBJ->check("sort_seq", "表示優先度",
                    array("Numeric" =>null),
                    array("Numeric" => "表示優先度は数値のみ入力可能です"));

    // チェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        if ($param["mcid"] ) {
            header("Location: ./?action_MonthlyCourse_CourseData=1&" . $URLparam);
        } else {
            header("location: ./?action_MonthlyCourse_CourseCreate=1");
        }
        exit;
    }
}

/****************************/
/*** itemテーブル更新処理 ***/
/****************************/

// 更新データ生成
$registData = array();
$registData["name"]                          = $param["name"];
$registData["monthly_course_group_id"]       = $param["monthly_course_group_id"];
$registData["same_monthly_course_type"]      = $param["same_monthly_course_type"];
$registData["different_monthly_course_type"] = $param["different_monthly_course_type"];
$registData["sort_seq"]                      = $param["sort_seq"];

// 更新
if ($param["update_type"]) {
    if ($param["check_mcid"]) {
        $updateData = array();
        if ($param["update_type"] == 2) {
            // 一括グループ移動
            $updateData["monthly_course_group_id"] = $param["chg_group_id"];
            $updateData["update_datetime"] = date("YmdHis");
            $resultMsg = "グループ移動";
        } else {
            // 削除
            $updateData["disable"]  = TRUE;
            $updateData["update_datetime"] = date("YmdHis");
            $resultMsg = "削除";
        }

        foreach ($param["check_mcid"] as $val) {
            $whereArray   = array();
            $whereArray[] = "id = " . $val;

            // 書き込み
            if (!$admMonthlyCourseOBJ->updateMonthlyCourseData($updateData, $whereArray)) {
                $execMsgSessOBJ->message = array($resultMsg . "できませんでした。");
                header("Location: ./?action_MonthlyCourse_courseSearchList=1&" . $URLparam);
                exit;
            }
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array($resultMsg . "しました。");

        header("Location: ./?action_MonthlyCourse_courseSearchList=1&" . $URLparam);
        exit;

    } else {
        $execMsgSessOBJ->message = array("更新するデータを選択してください。");
        header("Location: ./?action_MonthlyCourse_courseSearchList=1&" . $URLparam);
        exit;
    }
}

// 更新
if ($param["mcid"]) {

        $whereArray   = array();
        $whereArray[] = "id = " . $param["mcid"];
        $registData["update_datetime"] = date("YmdHis");

        // 書き込み
        if (!$admMonthlyCourseOBJ->updateMonthlyCourseData($registData, $whereArray)) {
            $execMsgSessOBJ->message = array("更新できませんでした。");
            header("Location: ./?action_MonthlyCourse_CourseData=1&" . $URLparam);
            exit;
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array("更新しました。");
        header("Location: ./?action_MonthlyCourse_CourseData=1&" . $URLparam);
        exit;
} else {
    // 新規登録

    // トランザクション開始
    $admMonthlyCourseOBJ->beginTransaction();

    $registData["create_datetime"] = date("YmdHis");
    $registData["update_datetime"] = date("YmdHis");

    // 書き込み
    if (!$admMonthlyCourseOBJ->insertMonthlyCourseData($registData)) {
            // ロールバック
            $admMonthlyCourseOBJ->rollbackTransaction();
            $execMsgSessOBJ->message = array("登録できませんでした。");
            header("Location: ./?action_MonthlyCourse_CourseCreate=1");
            exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("登録しました。");
    // コミット
    $admMonthlyCourseOBJ->commitTransaction();
    header("Location: ./?action_MonthlyCourse_courseSearchList=1");
    exit;

}

?>