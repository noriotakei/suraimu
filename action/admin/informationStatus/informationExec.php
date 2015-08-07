<?php
/**
 * informationStatusExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報データ登録処理ページ。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . '/common/admin_common.php');
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoStatusOBJ = AdmInformationStatus::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// 戻り値の格納
$returnSessOBJ->return = $param;

$tags = array(
            "isid",
            "folder_id",
            "position_id",
            "search_type",
            "search_conditions_id",
            "search_conditions_type",
            "search_conditions_display_type",
            "search_is_display",
            "search_string",
            "search_html_text",
            "search_html_text_type",
            "search_information_id",
            "search_information_key",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "user_search_conditions_type",
            "except_user_search_conditions_type",
            "search_display_datetime_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

if (!$param["update_type"]) {
    /******* 入力項目の確認 *******/
    $validationOBJ->check("name", "管理用情報名",
    array("Value" => null),
    array("Value" => "管理用情報名は必須項目です"));

    $validationOBJ->check("information_category_id", "情報表示場所フォルダ",
    array("Numeric" =>null),
    array("Numeric" => "情報表示場所フォルダ情報が取得出来ません"));

    $validationOBJ->check("display_start_date", "表示開始日付",
    array("Value" => null),
    array("Value" => "表示開始日は必須項目です。"));

    $validationOBJ->check("display_start_time", "表示開始時間",
    array("Value" => null),
    array("Value" => "表示開始時は必須項目です。"));

    $validationOBJ->check("sort_seq", "表示優先度",
    array("Numeric" =>null),
    array("Numeric" => "表示優先度は数値のみ入力可能です"));

    // 以下、任意項目
    if ($param["point"]) {
        $validationOBJ->check("point", "消費ポイント",
        array("Numeric" =>null),
        array("Numeric" => "消費ポイントは数値のみ入力可能です"));
    }

    if ($param["bonus_point"]) {
        $validationOBJ->check("bonus_point", "付与ポイント",
        array("Numeric" =>null),
        array("Numeric" => "付与ポイントは数値のみ入力可能です"));
    }

    // ユニットID(表示)
    if ($param["unit_id"]) {
        $displayUnitItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["unit_id"] = rtrim($param["unit_id"], ",");
        $displayUnitItemId = explode(",", $param["unit_id"]);
        foreach ($displayUnitItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("unit_id", "ユニットID(表示)は数値のみ入力可能です");
                break;
            }
        }
    }
    // ユニットID(非表示)
    if ($param["except_unit_id"]) {
        $noDisplayUnitItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["except_unit_id"] = rtrim($param["except_unit_id"], ",");
        $noDisplayUnitItemId = explode(",", $param["except_unit_id"]);
        foreach ($noDisplayUnitItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("except_unit_id", "ユニットID(非表示)は数値のみ入力可能です");
                break;
            }
        }
    }
    // 購入商品ID（表示）
    if ($param["item_id"]) {
        $displayItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["item_id"] = rtrim($param["item_id"], ",");
        $displayItemId = explode(",", $param["item_id"]);
        foreach ($displayItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("item_id", "購入商品ID（表示）は数値のみ入力可能です");
                break;
            }
        }
    }
    // 購入商品ID（非表示）
    if ($param["except_item_id"]) {
        $exeptDisplayItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["except_item_id"] = rtrim($param["except_item_id"], ",");
        $exeptDisplayItemId = explode(",", $param["except_item_id"]);
        foreach ($exeptDisplayItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("except_item_id", "購入商品ID（非表示）は数値のみ入力可能です");
                break;
            }
        }
    }
    // 既読時リダイレクト情報ID
    if ($param["redirect_information_id"]) {
        $redirectInfomationId = "";
        // 末尾のカンマ削除(あれば)
        $param["redirect_information_id"] = rtrim($param["redirect_information_id"], ",");
        $redirectInfomationId = explode(",", $param["redirect_information_id"]);
        foreach ($redirectInfomationId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("redirect_information_id", "既読時リダイレクト情報IDは数値のみ入力可能です");
                break;
            }
        }
    }

    // ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報ID
    if ($param["redirect_unit_information_id"]) {
        $redirectUnitInfomationId = "";
        // 末尾のカンマ削除(あれば)
        $param["redirect_unit_information_id"] = rtrim($param["redirect_unit_information_id"], ",");
        $redirectUnitInfomationId = explode(",", $param["redirect_unit_information_id"]);
        foreach ($redirectUnitInfomationId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("redirect_unit_information_id", "ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報IDは数値のみ入力可能です");
                break;
            }
        }
    }

    // ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄID
    if ($param["redirect_unit_id"]) {
        $redirectUnitId = "";
        // 末尾のカンマ削除(あれば)
        $param["redirect_unit_id"] = rtrim($param["redirect_unit_id"], ",");
        $redirectUnitId = explode(",", $param["redirect_unit_id"]);
        foreach ($redirectUnitId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("redirect_unit_id", "ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報IDは数値のみ入力可能です");
                break;
            }
        }
    }

    // 保存検索条件ID(表示)
    if ($param["user_search_conditions_id"]) {
        $userSearchConditionsId = "";
        // 末尾のカンマ削除(あれば)
        $param["user_search_conditions_id"] = rtrim($param["user_search_conditions_id"], ",");
        $userSearchConditionsId = explode(",", $param["user_search_conditions_id"]);
        foreach ($userSearchConditionsId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("user_search_conditions_id", "保存検索条件(表示)は数値のみ入力可能です");
                break;
            }
        }
    }

    // 保存検索条件ID(非表示)
    if ($param["except_user_search_conditions_id"]) {
        $exceptUserSearchConditionsId = "";
        // 末尾のカンマ削除(あれば)
        $param["except_user_search_conditions_id"] = rtrim($param["except_user_search_conditions_id"], ",");
        $exceptUserSearchConditionsId = explode(",", $param["except_user_search_conditions_id"]);
        foreach ($exceptUserSearchConditionsId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("except_user_search_conditions_id", "保存検索条件(非表示)は数値のみ入力可能です");
                break;
            }
        }
    }

    // 表示開始日時
    $param["display_start_datetime"] = $param["display_start_date"] . " " . $param["display_start_time"];
    if (($param["display_start_date"] OR $param["display_start_time"]) AND !ComValidation::isDateTime($param["display_start_datetime"])) {
        $validationOBJ->setErrorMessage("表示開始日時", "表示開始日時を正しく入力してください");
    }

    // 表示終了日時
    $param["display_end_datetime"] = $param["display_end_date"] . " " . $param["display_end_time"];
    if ($param["display_end_date"] AND $param["display_end_time"] AND !ComValidation::isDateTime($param["display_end_datetime"])) {
        $validationOBJ->setErrorMessage("表示終了日時", "表示終了日時を正しく入力してください");
    } else if (!$param["display_end_date"] OR !$param["display_end_time"]) {
        $param["display_end_datetime"] = 0;
    }

    // 全画面表示フラグ(フラグ「ON」で本文入力があるかチェック)
    if ($param["is_all_display"] && !$param["html_text_pc"] && !$param["html_text_mb"]) {
        $validationOBJ->setErrorMessage("詳細情報(PC)又は詳細情報(MB)", "詳細情報(PC)又は詳細情報(MB)本文を入力してください");
    }

    // 詳細情報(PC)
    if ($param["html_text_pc"]) {
        // 本文入力あって、フラグ「ON」ならbodyタグのチェック※フラグ「OFF」ならタグ不要
        if ($param["is_all_display"]) {
            if (!preg_match("/<body/", htmlspecialchars_decode($param["html_text_pc"], ENT_QUOTES))) {
                $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)bodyタグを入力してください");
            }
        } else {
            if (preg_match("/<body/", htmlspecialchars_decode($param["html_text_pc"], ENT_QUOTES))) {
                $validationOBJ->setErrorMessage("詳細情報(PC)", "詳細情報(PC)bodyタグが入力されてます");
            }
        }
    } else {
        // 本文入力が無いのにフラグ「ON」ならエラー)
        if ($param["is_all_display"] && !$param["html_text_mb"]) {
            $validationOBJ->setErrorMessage("詳細情報(PC)又は詳細情報(MB)", "詳細情報(PC)又は詳細情報(MB)本文を入力してください");
        }
    }

    // 詳細情報(MB)
    if ($param["html_text_mb"]) {
        if (!preg_match("/<body.+?>/", htmlspecialchars_decode($param["html_text_mb"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(MB)", "表示情報(MB)bodyタグを入力してください");
        }
    }

    // 以下、任意項目
    if ($param["info_copy_number"]) {
        $validationOBJ->check("info_copy_number", "情報データコピー数",
        array("Numeric" =>null),
        array("Numeric" => "情報データコピー数は数値のみ入力可能です"));
    }

    //-20100716-takuro 表示曜日縛り 値チェックとDB内容更新
    if($param["is_display_week"] >= 1){
        if($param["display_week_start_num"] > $param["display_week_last_num"]){
            $validationOBJ->setErrorMessage("曜日縛り設定", "曜日縛りは日⇒土の範囲と順番で設定して下さい");
        }

        if($param["display_week_start_num"] == $param["display_week_last_num"]){

            $startTimeArray = explode(":",$param["display_week_start_time"]);
            $lastTimeArray = explode(":",$param["display_week_last_time"]);

            $startTimeValue = mktime($startTimeArray[0],$startTimeArray[1],$startTimeArray[2]);
            $lastTimeValue  = mktime($lastTimeArray[0], $lastTimeArray[1], $lastTimeArray[2]);

            if($startTimeValue > $lastTimeValue){
                $validationOBJ->setErrorMessage("曜日縛り設定", "同曜日設定の場合、開始時間＜終了時間で設定して下さい");
            }
        }
    }

    if(ComValidation::isNumeric($param["display_week_start_num"])
    && ComValidation::isTime($param["display_week_start_time"])
    && ComValidation::isNumeric($param["display_week_last_num"])
    && ComValidation::isTime($param["display_week_last_time"])
    ){
        //『開始曜日』,『開始時間』_『終了曜日』,『終了時間』（1,10:00:00_4,20:00:00)
        $dataString = $param["display_week_start_num"].","
                     .$param["display_week_start_time"]."_"
                     .$param["display_week_last_num"].","
                     .$param["display_week_last_time"];
        //デフォルト状態なら登録しない
        if( ($dataString == '0,00:00:00_0,00:00:00') && ($param["is_display_week"] == 0) ){
            $param["display_week_string"] = '';
        }else{
            $param["display_week_string"] = $dataString;
        }
    }else{
        $validationOBJ->setErrorMessage("表示曜日縛り", "表示期間を正しく入力してください");
    }


    // チェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        if ($param["isid"] ) {
            header("Location: ./?action_informationStatus_InformationData=1&" . $URLparam);
            exit();
        } else {
            header("location: ./?action_informationStatus_InformationCreate=1");
            exit();
        }
    }
}

// 更新データ生成
$registData = array();
$registData["name"]                             = $param["name"];
$registData["information_category_id"]          = $param["information_category_id"];
$registData["display_start_datetime"]           = $param["display_start_datetime"];
$registData["redirect_information_id"]          = $param["redirect_information_id"];
$registData["redirect_unit_information_id"]     = $param["redirect_unit_information_id"];
$registData["redirect_unit_id"]                     = $param["redirect_unit_id"];
$registData["redirect_url"]                     = $param["redirect_url"];
$registData["is_display"]                       = $param["is_display"];
$registData["is_smart_phone"]                       = $param["is_smart_phone"];
$registData["payment_status"]                   = $param["payment_status"];
$registData["is_all_display"]                   = $param["is_all_display"];
$registData["html_text_banner_pc"]              = $param["html_text_banner_pc"];
$registData["html_text_pc"]                     = $param["html_text_pc"];
$registData["html_text_banner_mb"]              = $param["html_text_banner_mb"];
$registData["html_text_mb"]                     = $param["html_text_mb"];
$registData["comment"]                          = $param["comment"];
$registData["sort_seq"]                         = $param["sort_seq"];
$registData["display_end_datetime"]             = $param["display_end_datetime"];
$registData["unit_id"]                          = $param["unit_id"];
$registData["except_unit_id"]                   = $param["except_unit_id"];
$registData["item_id"]                          = $param["item_id"];
$registData["except_item_id"]                   = $param["except_item_id"];
$registData["point"]                            = $param["point"];
$registData["bonus_point"]                      = $param["bonus_point"];
$registData["bonus_point_limit"]                      = $param["bonus_point_limit"];
$registData["user_search_conditions_id"]        = $param["user_search_conditions_id"];
$registData["except_user_search_conditions_id"] = $param["except_user_search_conditions_id"];
$registData["is_display_week"]                  = $param["is_display_week"];
$registData["display_week_string"]              = $param["display_week_string"];

// 検索条件保存ID(表示)
if ($param["user_search_conditions_id"]) {
    $registData["user_search_conditions_type"] = $param["user_search_conditions_type"];
} else {
    $registData["user_search_conditions_type"] = 0;
}
// 検索条件保存ID(非表示)
if ($param["except_user_search_conditions_id"]) {
    $registData["except_user_search_conditions_type"] = $param["except_user_search_conditions_type"];
} else {
    $registData["except_user_search_conditions_type"] = 0;
}

// 情報データ一括操作
if ($param["update_type"]) {

    if ($param["check_isid"]) {
        $updateData = array();
        if ($param["update_type"] == 1) {
            // 一括表示状態切り替え
            $updateData["update_datetime"] = date("YmdHis");
            $updateData["is_display"] = $param["chg_display_id"];
            $resultMsg = "表示状態切り替え";
        } else if ($param["update_type"] == 2) {
            // 一括フォルダ移動
            $updateData["update_datetime"] = date("YmdHis");
            $updateData["information_category_id"] = $param["chg_folder_id"];
            $resultMsg = "フォルダ移動";
        } else if ($param["update_type"] == 3) {
            // 情報データコピー
            $copyCount = $param["info_copy_number"];
            $resultMsg = "情報データコピー";
        } else {
            // 削除
            $updateData["update_datetime"] = date("YmdHis");
            $updateData["disable"] = TRUE;
            $resultMsg = "削除";
        }

        foreach ($param["check_isid"] as $val) {
            $whereArray = array();

            if ($param["update_type"] == 3) {
                // コピー元の情報データの取得
                if ($val) {
                    $infoStatusCopyData = "";
                    $infoStatusCopyData = $AdmInfoStatusOBJ->getInformationStatusData($val);

                    // 更新データ生成(必要ないものは空にする)
                    $infoStatusCopyData["name"] = "ID" . $val . "のコピー～" . $infoStatusCopyData["name"];
                    $infoStatusCopyData["id"] = "";
                    $infoStatusCopyData["access_key"] = "";
                    $infoStatusCopyData["is_display"] = 0;
                    $infoStatusCopyData["is_smart_phone"] = 0;
                    $infoStatusCopyData["create_datetime"] = date("YmdHis");
                    $infoStatusCopyData["update_datetime"] = date("YmdHis");
                    $infoStatusCopyData["is_copy"] = 1;

                    // 新規登録
                    $AdmInfoStatusOBJ->beginTransaction();

                    for ($i = 0; $i < $copyCount; $i++) {
                        // 書き込み
                        if (!$AdmInfoStatusOBJ->insertInformationStatusData($infoStatusCopyData)) {
                            $AdmInfoStatusOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーできませんでした。");
                            header("Location: ./?action_informationStatus_InformationCreate=1&" . $URLparam);
                            exit;
                        }

                        // インサートした情報IDを取得
                        $copyInformationId = $AdmInfoStatusOBJ->getInsertId();

                        if(!$accessKey = $AdmInfoStatusOBJ->getNewAccessKey($copyInformationId)) {
                            $AdmInfoStatusOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーできませんでした。");
                            header("Location: ./?action_informationStatus_InformationCreate=1&" . $URLparam);
                            exit;
                        }

                        // アクセスキーの書き込み
                        $registAccessKeyData = array();
                        $whereArray = array();
                        $registAccessKeyData["access_key"] = $accessKey;
                        $whereArray[] = "id = " . $copyInformationId;

                        if (!$AdmInfoStatusOBJ->updateInformationStatusData($registAccessKeyData, $whereArray)) {
                            $AdmInfoStatusOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーデータのアクセスキー生成ができませんでした。");
                            header("Location: ./?action_informationStatus_InformationSearchList=1&" . $URLparam);
                            exit;
                        }
                        // コミット
                        $AdmInfoStatusOBJ->commitTransaction();
                    }
                }
            } else {
                $whereArray[] = "id = " . $val;
                // 書き込み
                if (!$AdmInfoStatusOBJ->updateInformationStatusData($updateData, $whereArray)) {
                    $execMsgSessOBJ->message = array($resultMsg . "できませんでした。");
                    header("Location: ./?action_informationStatus_InformationSearchList=1&" . $URLparam);
                    exit;
                }
            }
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array($resultMsg . "しました。");

        header("Location: ./?action_informationStatus_InformationSearchList=1&" . $URLparam);
        exit;
    } else {
        $execMsgSessOBJ->message = array("更新するデータを選択してください");
        header("Location: ./?action_informationStatus_InformationSearchList=1&" . $URLparam);
        exit();
    }
}

// データ更新 or データ新規追加
if ($param["isid"]) {
    // 更新
    $whereArray = array();
    $whereArray[] = "id = " . $param["isid"];

    // 更新データ作成
    $registData["update_datetime"] = date("YmdHis");

    // コピーフラグ
    $registData["is_copy"] = 0;

    // 書き込み
    if (!$AdmInfoStatusOBJ->updateInformationStatusData($registData, $whereArray)) {
        $execMsgSessOBJ->message = array("更新できませんでした。");
        header("Location: ./?action_informationStatus_InformationData=1&" . $URLparam);
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("更新しました。");

    header("Location: ./?action_informationStatus_InformationData=1&" . $URLparam);
    exit;
} else {
    // 新規登録
    $AdmInfoStatusOBJ->beginTransaction();

    // 更新データ作成(登録日付と同じく更新日付も作る)
    $registData["create_datetime"] = date("YmdHis");
    $registData["update_datetime"] = date("YmdHis");

    // 書き込み
    if (!$AdmInfoStatusOBJ->insertInformationStatusData($registData)) {
        $AdmInfoStatusOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_informationStatus_InformationCreate=1&" . $URLparam);
        exit;
    }

    $informationId = $AdmInfoStatusOBJ->getInsertId();

    if(!$accessKey = $AdmInfoStatusOBJ->getNewAccessKey($informationId)) {
        $AdmInfoStatusOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_informationStatus_InformationCreate=1&" . $URLparam);
        exit;
    }

    // アクセスキーの書き込み
    $registData = array();
    $whereArray = array();
    $registData["access_key"] = $accessKey;
    $whereArray[] = "id = " . $informationId;

    if (!$AdmInfoStatusOBJ->updateInformationStatusData($registData, $whereArray)) {
        $AdmInfoStatusOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_informationStatus_InformationCreate=1");
        exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("登録しました。");
    $AdmInfoStatusOBJ->commitTransaction();
    header("Location: ./?action_informationStatus_InformationSearchList");
    exit;

}

?>