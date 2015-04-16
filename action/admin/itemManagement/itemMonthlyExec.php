<?php
/**
 * itemMonthlyExec.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側 月額更新用商品データ処理ページ。
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
            "search_item_id",
            "search_item_key",
            "search_item_name_type",
            "search_string",
            "search_datetime_from_date",
            "search_datetime_from_time",
            "search_datetime_to_date",
            "search_datetime_to_time",
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

    $validationOBJ->check("remail_name", "注文完了リメール表示用商品名",
                    array("Value" => null),
                    array("Value" => "注文完了リメール表示用商品名は必須項目です"));

    $validationOBJ->check("price", "販売価格",
                    array("Value" => null, "Numeric" => null),
                    array("Value" => "販売価格は必須項目です", "Numeric" => "販売価格は数値のみ入力可能です"));

    $validationOBJ->check("monthly_course_id", "付与月額コースID",
                    array("Numeric" =>null),
                    array("Numeric" => "付与月額コースIDは数値のみ入力可能です"));

    $validationOBJ->check("monthly_course_plus_limit_date", "付与月額コース日数",
                    array("Numeric" =>null),
                    array("Numeric" => "付与月額コース日数は数値のみ入力可能です"));

    // 以下、任意項目
    if ($param["point"]) {
        $validationOBJ->check("point", "付与ポイント",
                     array("Numeric" =>null),
                     array("Numeric" => "付与ポイントは数値のみ入力可能です"));
    }

    $validationOBJ->check("sort_seq", "表示優先度",
                    array("Numeric" =>null),
                    array("Numeric" => "表示優先度は数値のみ入力可能です"));

    // 保存検索条件ID
    if ($param["user_search_conditions_id"]) {
        $userSearchConditionsId = "";
        // 末尾のカンマ削除(あれば)
        $param["user_search_conditions_id"] = rtrim($param["user_search_conditions_id"], ",");
        $userSearchConditionsId = explode(",", $param["user_search_conditions_id"]);
        foreach ($userSearchConditionsId as $key => $val) {
            if (!ComValidation::isNumeric($val) || !$val) {
                $validationOBJ->setErrorMessage("user_search_conditions_id", "保存検索条件は数値のみ入力可能です");
                break;
            }
        }
    }

    // チェック
    if ($validationOBJ->isError()) {
        $errorMsg = $validationOBJ->getErrorMessage();
        $execMsgSessOBJ->exec_msg = $errorMsg;
        if ($param["iid"] ) {
            header("Location: ./?action_itemManagement_ItemMonthlyData=1&" . $URLparam);
        } else {
            header("location: ./?action_itemManagement_ItemMonthlyCreate=1");
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
$registData["remail_name"]                    = $param["remail_name"];
$registData["item_category_id"]               = $param["item_category_id"];
$registData["is_display"]                     = 1;  // 固定(表示にしないと商品データ取得出来ない)
$registData["price"]                          = $param["price"];
$registData["point"]                          = $param["point"];
$registData["monthly_course_id"]              = $param["monthly_course_id"];
$registData["monthly_course_plus_limit_date"] = $param["monthly_course_plus_limit_date"];
//$registData["monthly_update_item_id"]         = $param["monthly_update_item_id"];
$registData["comment"]                        = $param["comment"];
//$registData["is_self_order"]                = $param["is_self_order"]; ※現在は使用してないのでコメント(いつか使うかも)
$registData["sort_seq"]                       = $param["sort_seq"];
$registData["is_monthly_item"]                = 1; // 固定
$registData["user_search_conditions_id"]      = $param["user_search_conditions_id"];

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
            header("Location: ./?action_itemManagement_ItemMonthlyData=1&" . $URLparam);
            exit;
        }

        // セッション変数の破棄
        $returnSessOBJ->unsetAll();

        $execMsgSessOBJ->message = array("更新しました。");
        header("Location: ./?action_itemManagement_ItemMonthlyData=1&" . $URLparam);
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
            header("Location: ./?action_itemManagement_ItemMonthlyCreate=1");
            exit;
    }

    $itemId = $AdmItemOBJ->getInsertId();

    if(!$accessKey = $AdmItemOBJ->getNewAccessKey($itemId)) {
        // ロールバック
        $AdmItemOBJ->rollbackTransaction();
        $execMsgSessOBJ->message = array("登録できませんでした。");
        header("Location: ./?action_itemManagement_ItemMonthlyCreate=1&" . $URLparam);
        exit;
    }

    // アクセスキーの書き込み
    $registData = array();
    $whereArray = array();
    $registData["access_key"] = $accessKey;
    $whereArray[] = "id = " . $itemId;

    // 月額更新用商品IDを自分自身の商品IDで設定(常に自分自身を決済する)
    $registData["monthly_update_item_id"] = $itemId;

    if (!$AdmItemOBJ->updateItemData($registData, $whereArray)) {
            // ロールバック
            $AdmItemOBJ->rollbackTransaction();
            $execMsgSessOBJ->message = array("登録できませんでした。");
            header("Location: ./?action_itemManagement_ItemMonthlyCreate=1&" . $URLparam);
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