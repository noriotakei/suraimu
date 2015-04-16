<?php
/**
 * itemExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側商品データ処理ページ。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */
require_once(D_BASE_DIR . '/common/admin_common.php');
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmItemOBJ = AdmItem::getInstance();

// セッションオブジェクトのインスタンス
$execMsgSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

// 戻り値の格納
$returnSessOBJ->return = $param;

// 検索条件用パラメーター生成
$tags = array(
            "iid",
            "search_category_id",
            "search_is_display",
            //"search_is_self_order", ※現在は使用してないのでコメント(いつか使うかも)
            "search_type",
            "search_conditions_id",
            "search_conditions_display_type",
            "search_conditions_type",
            "search_item_id",
            "search_item_key",
            "search_item_name_type",
            "search_string",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
            "user_search_conditions_type",
            "except_user_search_conditions_type",
            "redirect_unit_item_id",
            "redirect_unit_id",
            "search_sales_datetime_type",
            "sort_id",
            "sort_seq",
            "offset",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

$validationOBJ = new ComArrayValidation($param);

if (!$param["update_type"]) {
    /******* 入力項目の確認 *******/
    $validationOBJ->check("name", "管理用商品名",
                    array("Value" => null),
                    array("Value" => "管理用情報名は必須項目です"));

    $validationOBJ->check("html_text_name_pc", "注文確認用表示商品名(PC)",
                    array("Value" => null),
                    array("Value" => "注文確認用表示商品名(PC)は必須項目です"));

    $validationOBJ->check("html_text_name_mb", "注文確認用表示商品名(MB)",
                    array("Value" => null),
                    array("Value" => "注文確認用表示商品名(MB)は必須項目です"));

    $validationOBJ->check("remail_name", "注文完了リメール表示用商品名",
                    array("Value" => null),
                    array("Value" => "注文完了リメール表示用商品名は必須項目です"));

    $validationOBJ->check("item_category_id", "カテゴリー",
                    array("Numeric" =>null),
                    array("Numeric" => "カテゴリーが取得出来ません"));

    $validationOBJ->check("price", "販売価格",
                    array("Value" => null, "Numeric" => null),
                    array("Value" => "販売価格は必須項目です", "Numeric" => "販売価格は数値のみ入力可能です"));

    $validationOBJ->check("sales_start_date", "販売開始日付",
                    array("Value" => null),
                    array("Value" => "販売開始日付は必須項目です。"));

    $validationOBJ->check("sales_start_time", "販売開始時間",
                    array("Value" => null),
                    array("Value" => "販売開始時間は必須項目です。"));

    $validationOBJ->check("sort_seq", "表示優先度",
                    array("Numeric" =>null),
                    array("Numeric" => "表示優先度は数値のみ入力可能です"));
/*
    // 詳細情報(PC)
    if ($param["html_text_name_pc"]) {
        // 終了タグのチェック
        if (preg_match("/(<([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_pc"], ENT_QUOTES)) && !preg_match("/(<\/([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_pc"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(PC)", "表示情報(PC)タグを正しく入力してください");
        }
        if (!preg_match("/(<([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_pc"], ENT_QUOTES)) && preg_match("/(<\/([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_pc"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(PC)", "表示情報(PC)タグを正しく入力してください");
        }
    }
    // 詳細情報(MB)
    if ($param["html_text_name_mb"]) {
        // 終了タグのチェック
        if (preg_match("/(<([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_mb"], ENT_QUOTES)) && !preg_match("/(<\/([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_mb"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(MB)", "表示情報(MB)タグを正しく入力してください");
        }
        if (!preg_match("/(<([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_mb"], ENT_QUOTES)) && preg_match("/(<\/([\w]+)[^>]*>)/", htmlspecialchars_decode($param["html_text_name_mb"], ENT_QUOTES))) {
            $validationOBJ->setErrorMessage("表示情報(MB)", "表示情報(MB)タグを正しく入力してください");
        }
    }
*/
    // 販売開始日時
    $param["sales_start_datetime"] = $param["sales_start_date"] . " " . $param["sales_start_time"];
    if (($param["sales_start_date"] OR $param["sales_start_time"]) AND !ComValidation::isDateTime($param["sales_start_datetime"])) {
        $validationOBJ->setErrorMessage("販売開始日時", "販売開始日時を正しく入力してください");
    }

    // 販売終了日時
    $param["sales_end_datetime"] = $param["sales_end_date"] . " " . $param["sales_end_time"];
    if ($param["sales_end_date"] AND $param["sales_end_time"] AND !ComValidation::isDateTime($param["sales_end_datetime"])) {
        $validationOBJ->setErrorMessage("販売終了日時", "販売終了日時を正しく入力してください");
    } else if (!$param["sales_end_date"] OR !$param["sales_end_time"]) {
        $param["sales_end_datetime"] = 0;
    }

    // 以下、任意項目
    if ($param["point"]) {
        $validationOBJ->check("point", "付与ポイント",
                     array("Numeric" =>null),
                     array("Numeric" => "付与ポイントは数値のみ入力可能です"));
    }

    if ($param["monthly_course_id"]) {
        $validationOBJ->check("monthly_course_id", "付与月額コースID",
                     array("Numeric" =>null),
                     array("Numeric" => "付与月額コースIDは数値のみ入力可能です"));
    }

    if ($param["monthly_course_plus_limit_date"]) {
        $validationOBJ->check("monthly_course_plus_limit_date", "付与月額コース日数",
                     array("Numeric" =>null),
                     array("Numeric" => "付与月額コース日数は数値のみ入力可能です"));
    }

    if ($param["monthly_update_item_id"]) {
        $validationOBJ->check("monthly_update_item_id", "月額更新用商品ID",
                     array("Numeric" =>null),
                     array("Numeric" => "月額更新用商品IDは数値のみ入力可能です"));
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

    // ﾘﾀﾞｲﾚｸﾄ商品ID
    if ($param["redirect_unit_item_id"]) {
        $redirectUnitItemId = "";
        // 末尾のカンマ削除(あれば)
        $param["redirect_unit_item_id"] = rtrim($param["redirect_unit_item_id"], ",");
        $redirectUnitItemId = explode(",", $param["redirect_unit_item_id"]);
        foreach ($redirectUnitItemId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("redirect_unit_item_id", "ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ商品IDは数値のみ入力可能です");
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
                $validationOBJ->setErrorMessage("redirect_unit_id", "ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄIDは数値のみ入力可能です");
                break;
            }
        }
    }

    // 指定商品ＩＤ注文削除
    if ($param["target_delete_item_id"]) {
    	$displayItemId = "";
    	// 末尾のカンマ削除(あれば)
    	$param["target_delete_item_id"] = rtrim($param["target_delete_item_id"], ",");
    	$targetDeleteItemId = explode(",", $param["target_delete_item_id"]);
    	foreach ($targetDeleteItemId as $key => $val) {
    		if (!ComValidation::isNumeric($val) || !$val) {
    			$validationOBJ->setErrorMessage("target_delete_item_id", "指定商品ＩＤ注文削除は数値のみ入力可能です");
    			break;
    		}
    	}
    }
    
    // 以下、任意項目
    if ($param["item_copy_number"]) {
        $validationOBJ->check("item_copy_number", "商品データコピー数",
        array("Numeric" =>null),
        array("Numeric" => "商品データコピー数は数値のみ入力可能です"));
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
        if ($param["iid"] ) {
            header("Location: ./?action_itemManagement_ItemData=1&" . $URLparam);
        } else {
            header("location: ./?action_itemManagement_ItemCreate=1");
        }
        exit;
    }
}

/****************************/
/*** itemテーブル更新処理 ***/
/****************************/

// 更新データ生成
$registData = array();
$registData["name"]                           = $param["name"];
$registData["html_text_name_pc"]              = $param["html_text_name_pc"];
$registData["html_text_name_mb"]              = $param["html_text_name_mb"];
$registData["remail_name"]                    = $param["remail_name"];
$registData["item_category_id"]               = $param["item_category_id"];
$registData["is_display"]                     = $param["is_display"];
$registData["sales_start_datetime"]           = $param["sales_start_datetime"];
$registData["sales_end_datetime"]             = $param["sales_end_datetime"];
$registData["payment_status"]                 = $param["payment_status"];
$registData["unit_id"]                        = $param["unit_id"];
$registData["except_unit_id"]                 = $param["except_unit_id"];
$registData["item_id"]                        = $param["item_id"];
$registData["except_item_id"]                 = $param["except_item_id"];
$registData["price"]                          = $param["price"];
$registData["point"]                          = $param["point"];
$registData["monthly_course_id"]              = $param["monthly_course_id"];
$registData["monthly_course_plus_limit_date"] = $param["monthly_course_plus_limit_date"];
$registData["monthly_update_item_id"]         = $param["monthly_update_item_id"];
$registData["comment"]                        = $param["comment"];
//$registData["is_self_order"]                = $param["is_self_order"]; ※現在は使用してないのでコメント(いつか使うかも)
$registData["sort_seq"]                       = $param["sort_seq"];
$registData["is_monthly_item"]                = 0; // 固定
$registData["user_search_conditions_id"]      = $param["user_search_conditions_id"];
$registData["except_user_search_conditions_id"]      = $param["except_user_search_conditions_id"];
$registData["redirect_unit_item_id"]      = $param["redirect_unit_item_id"];
$registData["target_delete_item_id"]      = $param["target_delete_item_id"];
$registData["redirect_unit_id"]      = $param["redirect_unit_id"];
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

// 更新
if ($param["update_type"]) {
    if ($param["check_iid"]) {
        $updateData = array();
        if ($param["update_type"] == 1) {
            // 一括表示状態切り替え
            $updateData["is_display"] = $param["chg_display_id"];
            $updateData["update_datetime"] = date("YmdHis");
            $resultMsg = "表示状態切り替え";
        } else if ($param["update_type"] == 2) {
            // 一括カテゴリー移動
            $updateData["item_category_id"] = $param["chg_category_id"];
            $updateData["update_datetime"] = date("YmdHis");
            $resultMsg = "カテゴリー移動";
        } else if ($param["update_type"] == 3) {
            // 情報データコピー
            $copyCount = $param["item_copy_number"];
            $resultMsg = "商品データコピー";
        } else {
            // 削除
            $updateData["disable"]  = TRUE;
            $updateData["update_datetime"] = date("YmdHis");
            $resultMsg = "削除";
        }

        foreach ($param["check_iid"] as $val) {
            $whereArray   = array();

            if ($param["update_type"] == 3) {
                // コピー元の情報データの取得
                if ($val) {
                    $itemCopyData = "";
                    $itemCopyData = $AdmItemOBJ->getItemData($val);

                    // 更新データ生成(必要ないものは空にする)
                    $itemCopyData["name"] = "ID" . $val . "のコピー～" . $itemCopyData["name"];
                    $itemCopyData["id"] = "";
                    $itemCopyData["access_key"] = "";
                    $itemCopyData["is_display"] = 0;
                    $itemCopyData["create_datetime"] = date("YmdHis");
                    $itemCopyData["update_datetime"] = date("YmdHis");
                    $itemCopyData["is_copy"] = 1;

                    // 新規登録
                    $AdmItemOBJ->beginTransaction();

                    for ($i = 0; $i < $copyCount; $i++) {
                        // 書き込み
                        if (!$AdmItemOBJ->insertItemData($itemCopyData)) {
                            $AdmItemOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーできませんでした。");
                            header("Location: ./?action_itemManagement_ItemCreate=1&" . $URLparam);
                            exit;
                        }

                        // インサートした情報IDを取得
                        $copyItemId = $AdmItemOBJ->getInsertId();

                        if(!$accessKey = $AdmItemOBJ->getNewAccessKey($copyItemId)) {
                            $AdmItemOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーできませんでした。");
                            header("Location: ./?action_itemManagement_ItemCreate=1&" . $URLparam);
                            exit;
                        }

                        // アクセスキーの書き込み
                        $registAccessKeyData = array();
                        $whereArray = array();
                        $registAccessKeyData["access_key"] = $accessKey;
                        $whereArray[] = "id = " . $copyItemId;

                        // 「月額更新用商品 and 月額更新用商品ID」があれば、そのIDを新規IDで上書き
                        if ($itemCopyData["is_monthly_item"] && $itemCopyData["monthly_update_item_id"]) {
                            $registAccessKeyData["monthly_update_item_id"] = $copyItemId;
                        }

                        if (!$AdmItemOBJ->updateItemData($registAccessKeyData, $whereArray)) {
                            $AdmItemOBJ->rollbackTransaction();
                            $execMsgSessOBJ->message = array("コピーデータのアクセスキー生成ができませんでした。");
                            header("Location: ./?action_itemManagement_ItemList=1&" . $URLparam);
                            exit;
                        }
                        // コミット
                        $AdmItemOBJ->commitTransaction();
                    }
                }
            } else {
                $whereArray[] = "id = " . $val;
                // 書き込み
                if (!$AdmItemOBJ->updateItemData($updateData, $whereArray)) {
                    $execMsgSessOBJ->message = array($resultMsg . "できませんでした。");
                    header("Location: ./?action_itemManagement_ItemList=1&" . $URLparam);
                    exit;
                }
            }
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array($resultMsg . "しました。");

        header("Location: ./?action_itemManagement_ItemList=1&" . $URLparam);
        exit;

    } else {
        $execMsgSessOBJ->message = array("更新するデータを選択してください。");
        header("Location: ./?action_itemManagement_ItemList=1&" . $URLparam);
        exit;
    }
}
// 更新
if ($param["iid"]) {

        $whereArray   = array();
        $whereArray[] = "id = " . $param["iid"];
        $registData["update_datetime"] = date("YmdHis");

        // コピーフラグ
        $registData["is_copy"] = 0;

        // 書き込み
        if (!$AdmItemOBJ->updateItemData($registData, $whereArray)) {
            $execMsgSessOBJ->message = array("更新できませんでした。");
            header("Location: ./?action_itemManagement_ItemData=1&" . $URLparam);
            exit;
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array("更新しました。");
        header("Location: ./?action_itemManagement_ItemData=1&" . $URLparam);
        exit;
} else {
    // 新規登録

    // トランザクション開始
    $AdmItemOBJ->beginTransaction();

    $registData["create_datetime"] = date("YmdHis");
    $registData["update_datetime"] = date("YmdHis");

    // 書き込み
    if (!$AdmItemOBJ->insertItemData($registData)) {
            // ロールバック
            $AdmItemOBJ->rollbackTransaction();
            $execMsgSessOBJ->message = array("登録できませんでした。");
            header("Location: ./?action_itemManagement_ItemCreate=1");
            exit;
    }

    $itemId = $AdmItemOBJ->getInsertId();

    if(!$accessKey = $AdmItemOBJ->getNewAccessKey($itemId)) {
        // ロールバック
        $AdmItemOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_itemManagement_ItemCreate=1&" . $URLparam);
        exit;
    }

    // アクセスキーの書き込み
    $registData      = array();
    $whereArray = array();
    $registData["access_key"] = $accessKey;
    $whereArray[] = "id = " . $itemId;

    if (!$AdmItemOBJ->updateItemData($registData, $whereArray)) {
            // ロールバック
            $AdmItemOBJ->rollbackTransaction();
            $execMsgSessOBJ->message = array("登録できませんでした。");
            header("Location: ./?action_itemManagement_ItemCreate=1&" . $URLparam);
            exit;
    }

    // セッション変数の破棄
    $returnSessOBJ->unsetAll();

    $execMsgSessOBJ->message = array("登録しました。");
    // コミット
    $AdmItemOBJ->commitTransaction();
    header("Location: ./?action_itemManagement_ItemList=1");
    exit;

}

?>