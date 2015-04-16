<?php
/**
 * courseUserExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面表示場所フォルダ更新処理ページ
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmMonthlyCourseOBJ = AdmMonthlyCourse::getInstance();
$MonthlyCourseOBJ = MonthlyCourse::getInstance();
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

$tags = array(
            "user_id",
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
            "user_offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

if (!$param["update_type"]) {
    if ($param["edit"]) {
        //更新
        $validationOBJ->check("limit_start_date", "開始日",
                        array("Value" => null, "Date" => null),
                        array("Value" => "開始日は必須項目です", "Date" => "開始日を正しく入力してください"));

        $validationOBJ->check("limit_end_date", "終了日",
                        array("Value" => null, "Date" => null),
                        array("Value" => "終了日は必須項目です", "Date" => "終了日を正しく入力してください"));

        $validationOBJ->check("is_invalid", "無効フラグ",
                        array("Numeric" => null),
                        array("Numeric" => "無効フラグが取得出来ません"));

        $validationOBJ->check("is_monthly_update", "月額更新設定",
                        array("Numeric" => null),
                        array("Numeric" => "月額更新設定が取得出来ません"));
    } else {
        //新規登録
        $validationOBJ->check("monthly_course_id", "月額コースID",
                        array("Value" => null, "Numeric" => null),
                        array("Value" => "月額コースIDは必須項目です", "Numeric" => "月額コースIDは数値で入力して下さい"));

        $validationOBJ->check("plus_limit_date", "付与日数",
                        array("Value" => null, "Numeric" => null),
                        array("Value" => "付与日数は必須項目です", "Numeric" => "付与日数は数値で入力して下さい"));

        // 月額更新が「あり」設定の場合(「あり」の場合は以下は必須です)
        if ($param["is_monthly_update"]) {
            $validationOBJ->check("settle_device_type", "支払い種別",
                            array("Value" => null, "Numeric" => null),
                            array("Value" => "支払い種別は必須項目です", "Numeric" => "支払い種別を入力して下さい"));

            $validationOBJ->check("monthly_update_item_id", "月額更新用商品ID",
                            array("Numeric" => null),
                            array("Numeric" => "月額更新用商品IDは数値で入力して下さい"));
        }
    }
} else {
    // 一括コース有効日数付与のチェック
    if ($param["update_type"] == 4) {
        $validationOBJ->check("monthly_course_add_days", "付与日数",
                        array("Value" => null, "Numeric" => null),
                        array("Value" => "付与日数は必須項目です", "Numeric" => "付与日数は数値で入力して下さい"));
    }
}

// チェック
if ($validationOBJ->isError()) {
    $param["return_flag"] = true;
    $returnSessOBJ->return = $param;
    $errorMsg = $validationOBJ->getErrorMessage();
    $messageSessOBJ->exec_msg = $errorMsg;
    header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
    exit;
}

// 支払い種別「ゼロクレジット」の場合は「支払い時デバイス種別」をチェック(PC or MB)
if ($param["pay_type"] && $param["pay_type"] == AdmOrdering::PAY_TYPE_CREDIT) {
    if ($param["settle_device_type"] == AdmMonthlyCourse::DEVICE_TYPE_EITHER) {
        $param["return_flag"] = true;
        $returnSessOBJ->return = $param;
        $errorMsg["settle_device_type"] = "PCまたはMBを選択して下さい。";
        $messageSessOBJ->exec_msg = $errorMsg;
        header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
        exit;
    }
}

$value["admin_id"] = $loginAdminData["id"];

// 月額コース一括操作
if ($param["update_type"]) {

    if ($param["check_mcuid"]) {
        $updateData = array();
        $updateData["update_datetime"] = date("YmdHis");
        if ($param["update_type"] == 1) {
            // コース変更
            $updateData["monthly_course_id"] = $param["chg_monthly_course"];
            $resultMsg = "コース変更";
        } else if ($param["update_type"] == 2) {
            // コース解除(無効フラグ)
            $updateData["is_invalid"] = 1; // ON
            $resultMsg = "コース解除(無効フラグ)";
        } else if ($param["update_type"] == 3) {
            // 月額更新解除
            $updateData["is_monthly_update"] = 1;
            $resultMsg = "月額更新解除";
        } else {
            // コース有効日数付与

            $resultMsg = "コース有効日数付与";
        }

        foreach ($param["check_mcuid"] as $val) {
            $whereArray = array();
            $whereArray[] = "id = " . $val;

            // 変更前の既存月額コースユーザーデータの取得
            if (!$monthlycourseUserData = $AdmMonthlyCourseOBJ->getMonthlyCourseUserData($val)) {
                $messageSessOBJ->exec_msg = array("既存月額コースを取得出来ませんでした。");
                header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
                exit;
            }

            // 月額コースの変更
            if ($param["chg_monthly_course"]) {
                //変更する月額コースデータを取得
                    if (!$monthlyCourseData = $AdmMonthlyCourseOBJ->getMonthlyCourseData($param["chg_monthly_course"])) {
                        $messageSessOBJ->message = array("月額コースが取得出来ません。", "正しいIDを入力して下さい");;
                        header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
                        exit();
                    }

                    // 変更対象のコースユーザーデータ「以外」で同コースがある場合は変更しない。(重複するから)
                    if($monthlyCourseUserList = $AdmMonthlyCourseOBJ->chkMonthlyCourseUser(array("user_id" => $monthlycourseUserData["user_id"], "id" => $monthlycourseUserData["id"]), $monthlyCourseData["monthly_course_group_id"])){
                        $messageSessOBJ->message = array("期限内の同じ月額コースユーザデータが存在します。"
                                                         ,"月額コースグループ名『" . $monthlyCourseData["group_name"] . "』のコースユーザデータは無効にしてから付与して下さい"
                                                   );
                        header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
                        exit();
                    }
            }

            // コース有効日数付与の日付生成
            if ($param["monthly_course_add_days"]) {
                if (!$monthlycourseUserData = $AdmMonthlyCourseOBJ->getMonthlyCourseUserData($val)) {
                    $messageSessOBJ->exec_msg = array("既存月額コースを取得出来ませんでした。");
                    header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
                    exit;
                } else {
                    // コース有効日数付与の生成
                    $updateData["limit_end_date"] = date("Y-m-d",strtotime($param["monthly_course_add_days"]." day",strtotime(date("Y-m-d", strtotime($monthlycourseUserData["limit_end_date"])))));
                }
            }

            // 更新
            if (!$AdmMonthlyCourseOBJ->updateMonthlyCourseUserData($updateData, $whereArray)) {
                $messageSessOBJ->exec_msg = array($resultMsg . "できませんでした。");
                header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
                exit;
            }
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $messageSessOBJ->exec_msg = array($resultMsg . "しました。");

        header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
        exit;
    } else {
        $execMsgSessOBJ->exec_msg = array("更新するデータを選択してください");
        header("Location: ./?action_monthlyCourse_CourseUserSearchList=1&" . $URLparam);
        exit();
    }
}

// 更新
if ($param["mcuid"]) {
    $whereArray[] = "id = " . $param["mcuid"];

    $value["update_datetime"]        = date("YmdHis");
    $value["limit_start_date"]       = $param["limit_start_date"];
    $value["limit_end_date"]         = $param["limit_end_date"];
    $value["is_invalid"]             = $param["is_invalid"];
    $value["is_monthly_update"]      = $param["is_monthly_update"];

    if (!$AdmMonthlyCourseOBJ->updateMonthlyCourseUserData($value, $whereArray)) {
        $messageSessOBJ->message = $AdmMonthlyCourseOBJ->getErrorMsg();
        header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
        exit();
    }

    $messageSessOBJ->message = array("更新しました。");
    header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
    exit();

// 新規
} else {
    //付与する月額コースデータを取得
    if (!$monthlyCourseData = $AdmMonthlyCourseOBJ->getMonthlyCourseData($param["monthly_course_id"])) {
        $messageSessOBJ->message = array("月額コースが取得出来ません。", "正しいIDを入力して下さい");;
        header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
        exit();
    }

    //既存の付与コースユーザデータに同グループのコースがあったら付与中止
    if($monthlyCourseUserList = $MonthlyCourseOBJ->getMonthlyCourseUserList(array("user_id" => $param["user_id"]), $monthlyCourseData["monthly_course_group_id"])){
        $messageSessOBJ->message = array("期限内の月額コースユーザデータが存在します。"
                                         ,"月額コースグループ名『" . $monthlyCourseData["group_name"] . "』のコースユーザデータは無効にしてから付与して下さい"
                                   );
        header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
        exit();
    }

    $value["user_id"]                = $param["user_id"];
    $value["monthly_course_id"]      = $param["monthly_course_id"];
    $value["is_monthly_update"]      = $param["is_monthly_update"];
    $value["settle_device_type"]     = $param["settle_device_type"];
    $value["monthly_update_item_id"] = $param["monthly_update_item_id"];
    $value["limit_start_date"]       = date("Y-m-d");
    $value["limit_end_date"]         = date("Y-m-d",strtotime($param["plus_limit_date"]." day",strtotime(date("Y-m-d"))));
    $value["create_type"]            = AdmMonthlyCourse::COURSE_TYPE_NEW;
    $value["create_datetime"]        = date("YmdHis");

    if (!$AdmMonthlyCourseOBJ->insertMonthlyCourseUserData($value)) {
        $messageSessOBJ->message = $AdmMonthlyCourseOBJ->getErrorMsg();
        header("Location: ./?action_monthlyCourse_CourseUserData=1");
        exit();
    }
    $messageSessOBJ->message = array("登録しました。");
    header("Location: ./?action_monthlyCourse_CourseUserData=1&" . $URLparam);
    exit();
}

?>