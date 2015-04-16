<?php
/**
 * monthlyCourseSettleCredit.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後月額コース決済処理ファイル。
 *
 * クレジット用
 *
 * 毎日11時30分に回す
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

// プロジェクトディレクトリの絶対パス
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));

// Web側・管理側共通処理ファイルの読み込み
require_once(D_BASE_DIR . "/common/common.php");
ini_set("memory_limit", "-1");

$SendMailOBJ          = SendMail::getInstance();
$UserOBJ              = User::getInstance();
$SettlementCreditOBJ  = SettlementCredit::getInstance();
$OrderingOBJ          = Ordering::getInstance();
$ItemOBJ              = Item::getInstance();
$MonthlyCourseOBJ     = MonthlyCourse::getInstance();

// データ件数の初期値
$totalListCount = 0;
$updateCoount = 0;
$updateOkCount = 0;

// 全月額コースデータ取得
$whereArray = "";
$whereArray[] = "mcu.is_monthly_update = 1"; // 月額更新フラグあり
$whereArray[] = "mcu.limit_end_date = '" . date("Y-m-d") . "'"; // コース有効期限が今日まで

$monthlyCourseCreditList = "";
if ($monthlyCourseCreditList = $MonthlyCourseOBJ->getMonthlyCourseList($whereArray)) {

    // リスト総件数取得
    $totalListCount = $MonthlyCourseOBJ->getFoundRows();

    // 月額注文データの取得
    foreach ($monthlyCourseCreditList as $val) {

        // ユーザーデータ取得
        $userData = "";
        $userData = $UserOBJ->getUserData($val["user_id"]);

        // メールアドレス
        $mail = "";
        $mail = ($userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"]);

        // 月額更新フラグがあれば処理
        if ($val["is_monthly_update"]) {

            $updateCoount++;

            // 月額更新用商品の有効性の確認と取得
            $monthlyUpdateItemData = "";
            if ($monthlyUpdateItemData = $ItemOBJ->getItemData($userData, array("id" => $val["monthly_update_item_id"]))) {

                // トランザクション開始
                $OrderingOBJ->beginTransaction();

                // 注文情報作成
                $insertOrderingArray = "";
                $insertOrderingArray["user_id"]         = $userData["user_id"];
                $insertOrderingArray["status"]          = Ordering::ORDERING_STATUS_WAIT_CREDIT;
                $insertOrderingArray["pay_type"]        = Ordering::PAY_TYPE_CREDIT;
                $insertOrderingArray["create_datetime"] = date("YmdHis");
                $insertOrderingArray["update_datetime"] = date("YmdHis");

                if (!$OrderingOBJ->insertOrderingData($insertOrderingArray)) {

                    // ロールバック
                    $OrderingOBJ->rollbackTransaction();
                    // 異常処理 ⇒ メール送信文言作成
                    $mailElements["subject"]     = "自動月額更新用商品の予約注文NG";
                    $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                    $mailElements["text_body"][] = "自動月額更新用商品の予約注文登録に失敗しました。";
                    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($mailElements);
                    // 運営にエラーメール
                    $SendMailOBJ->operationMailTo($mailElements);
                    continue;
                }

                $orderingId = "";
                $orderingId = $OrderingOBJ->getInsertId();

                // 注文詳細情報作成
                $insertOrderingDetailArray = "";
                $insertOrderingDetailArray["ordering_id"]     = $orderingId;
                $insertOrderingDetailArray["item_id"]         = $monthlyUpdateItemData["id"];
                $insertOrderingDetailArray["price"]           = $monthlyUpdateItemData["price"];
                $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
                $insertOrderingDetailArray["update_datetime"] = date("YmdHis");

                if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {

                    // ロールバック
                    $OrderingOBJ->rollbackTransaction();
                    // 異常処理 ⇒ メール送信文言作成
                    $mailElements["subject"]     = "自動月額更新用商品詳細の登録エラー";
                    $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                    $mailElements["text_body"][] = "自動月額更新用商品詳細の登録に失敗しました。";
                    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($mailElements);
                    // 運営にエラーメール
                    $SendMailOBJ->operationMailTo($mailElements);
                    continue;
                }

                // 自動月額更新用商品の金額を設定
                $itemPayTotal = "";
                $itemPayTotal = $monthlyUpdateItemData["price"];

                // アクセスキーと合計金額の更新
                $updateOrderingArray = "";
                $updateOrderingArray["access_key"] = $OrderingOBJ->getNewAccessKey($orderingId);
                $updateOrderingArray["pay_total"] = $itemPayTotal;

                if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingId))) {

                    // ロールバック
                    $OrderingOBJ->rollbackTransaction();
                    // 異常処理 ⇒ メール送信文言作成
                    $mailElements["subject"]     = "自動月額更新用商品の更新エラー";
                    $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                    $mailElements["text_body"][] = "自動月額更新用商品の更新に失敗しました。";
                    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($mailElements);
                    // 運営にエラーメール
                    $SendMailOBJ->operationMailTo($mailElements);
                    continue;
                }

                // コミット
                $OrderingOBJ->commitTransaction();

                // テスト環境でなければ決済する
                if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {

                    // ゼロクレジットの場合、「PC/MB」で渡す値を切り替え。
                    if ($val["settle_device_type"] == MonthlyCourse::DEVICE_TYPE_PC) {
                        // さらにチェック
                        if ($userData["credit_certify_phone_number"]) {
                            $SettlementCreditOBJ->setSettleType("quick_pc");
                            $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number"]);
                        } elseif ($userData["credit_certify_phone_number_mb"]) {
                            $SettlementCreditOBJ->setSettleType("quick");
                            $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number_mb"]);
                        } else {
                            // クレジット電話番号が無ければさよなら ⇒ メール送信文言作成
                            $mailElements["subject"]     = "決済処理NG";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "クレジット番号取得に失敗しました。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            $SendMailOBJ->operationMailTo($mailElements);
                            continue;
                        }
                    } elseif ($val["settle_device_type"] == MonthlyCourse::DEVICE_TYPE_MB) {
                        // さらにチェック
                        if ($userData["credit_certify_phone_number_mb"]) {
                            $SettlementCreditOBJ->setSettleType("quick");
                            $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number_mb"]);
                        } else if ($userData["credit_certify_phone_number"]) {
                            $SettlementCreditOBJ->setSettleType("quick_pc");
                            $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number"]);
                        } else {
                            // クレジット電話番号が無ければさよなら ⇒ メール送信文言作成
                            $mailElements["subject"]     = "決済処理NG";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "クレジット番号取得に失敗しました。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            $SendMailOBJ->operationMailTo($mailElements);
                            continue;
                        }
                    }

                    $SettlementCreditOBJ->setPostData("money", $itemPayTotal);
                    $SettlementCreditOBJ->setPostData("sendid", $userData["user_id"]);
                    $SettlementCreditOBJ->setPostData("sendpoint", $orderingId);
                    $SettlementCreditOBJ->setPostData("email", $mail);
                    $SettlementCreditOBJ->setPostData("siteurl", $_config["define"]["SITE_URL"] . "?action_Home=1&" . $sessId);

                    // 決済処理実行
                    if (!$SettlementCreditOBJ->sendToCredit()) {

                        // 異常決済処理 ⇒ メール送信文言作成
                        $mailElements["subject"]     = "月額決済クイックチャージ(クレジット)NG";
                        $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                        $mailElements["text_body"][] = "注文ID:" . $orderingId;
                        $mailElements["text_body"][] = "商品合計額:" . $itemPayTotal . "円";
                        $mailElements["text_body"][] = "月額決済クイックチャージ(クレジット)に失敗しました。";
                        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);
                        continue;
                    }
                } else {
                    // 決済処理だけは終わらせたいので、テスト用決済戻り処理をする。

                    // 前回支払い「PC or MB」で切り替え(クレジットだけなので、必ずどちらか存在するはず...。)
                    if ($val["settle_device_type"] == MonthlyCourse::DEVICE_TYPE_PC) {
                        $clientIP = SettlementCredit::CREDIT_CLIENT_IP_PC;
                    } elseif ($val["settle_device_type"] == MonthlyCourse::DEVICE_TYPE_MB) {
                        $clientIP = SettlementCredit::CREDIT_CLIENT_IP_MB;
                    }

                    // 必須追加パラメータ(たぶんこれで大丈夫かと...。)
                    $param = "";
                    $param["clientip"] = $clientIP;
                    $param["money"]    = $itemPayTotal;
                    $userId            = $userData["user_id"];
                    $result            = "ok";

                    if ($param["clientip"] == SettlementCredit::CREDIT_CLIENT_IP_PC) {
                        $param["credit_certify_phone_number"]  = "00000000000";
                    } else {
                        $param["credit_certify_phone_number_mb"]  = "00000000000";
                    }

                    if (!is_dir(D_BASE_DIR . "/log/settlement/" . date("Ym"))) {
                        if (!is_dir(D_BASE_DIR . "/log/settlement")) {
                            mkdir(D_BASE_DIR . "/log/settlement");
                        }
                        mkdir(D_BASE_DIR . "/log/settlement/" . date("Ym"));
                    }

                    // 書き込み
                    $fileName = D_BASE_DIR . "/log/settlement/" . date("Ym") . "/settlement-" . date("Ymd") .  "-" . mb_convert_encoding(Settlement::$_payTypeArray[Ordering::PAY_TYPE_CREDIT] . ".txt", "SJIS");

                    $queryString = "&clientip=" . $clientIP           // サイトコード
                               . "&money=" . $itemPayTotal         // トータル金額
                               . "&telno=00000000000"              // 決済時入力電話番号
                               . "&sendid=" . $userData["user_id"] // ユーザーID
                               . "&sendpoint=" . $orderingId       // 注文ID
                               . "&result=ok";                     // 決済戻り結果

                    ComUtility::writeLog(urldecode($queryString), $fileName);

                    // メール送信文言作成
                    $mailElements["text_body"][] = "注文ID:" . $orderingId;
                    $mailElements["text_body"][] = "入金額:" . $param["money"] . "円";

                    $result = strtoupper($result);
                    if ($result == "OK") {

                        // 正常決済処理
                        if (!is_numeric($param["money"]) OR $param["money"] <= 0) {
                            $mailElements["subject"] = "[テスト]クレジット金額のエラー";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "手動で対応して下さい。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            continue;
                        }

                        // 注文情報の取得
                        if (!$orderingData = $OrderingOBJ->getOrderingData($orderingId, $userId)) {
                            $mailElements["subject"] = "[テスト]クレジット注文データの取得エラー";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "手動で対応して下さい。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            continue;
                        }

                        // ユーザーデータの取得
                        if (!$userData = $UserOBJ->getUserData($orderingData["user_id"])) {
                            $mailElements["subject"] = "[テスト]クレジットユーザーデータの取得エラー";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "手動で対応して下さい。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            continue;
                        }

                        // エラー文言
                        $param["errMsg"][] = "入金額:" . $param["money"] . "円";

                        // トランザクション開始
                        $SettlementCreditOBJ->beginTransaction();

                        // 決済処理
                        if (!$SettlementCreditOBJ->execSettlement($orderingData, $userData, Ordering::PAY_TYPE_CREDIT, $param)) {
                            // ロールバック
                            $SettlementCreditOBJ->rollbackTransaction();
                            continue;
                        }

                        // コミット
                        $SettlementCreditOBJ->commitTransaction();
                    } else {
                        // 異常決済処理 ⇒ メール送信文言作成
                        $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                        $mailElements["text_body"][] = "自動決済更新用商品ID:" . $val["monthly_update_item_id"];
                        $mailElements["subject"]     = "[テスト]月額決済NG";
                        $mailElements["text_body"][] = "自動決済更新用商品の取得に失敗しました。";

                        $mailElements["text_body"]   = implode("\n", $mailElements["text_body"]);
                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        continue;
                    }
                }

                // 更新成功件数
                $updateOkCount++;

            } else {
                // 異常決済処理 ⇒ メール送信文言作成
                $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                $mailElements["text_body"][] = "自動決済更新用商品ID:" . $val["monthly_update_item_id"];
                $mailElements["subject"]     = "月額決済NG";
                $mailElements["text_body"][] = "自動決済更新用商品の取得に失敗しました。";

                $mailElements["text_body"]   = implode("\n", $mailElements["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);
                continue;
            }
        }
    }

    // 処理完了報告
    $mailElements["subject"]     = "月額決済処理";
    $mailElements["text_body"][] = "全件数" . $totalListCount;
    $mailElements["text_body"][] = "更新対象全件数" . $updateCoount;
    $mailElements["text_body"][] = "更新件数" . $updateCoount;
    $mailElements["text_body"][] = "自動決済更新が完了しました。";
    $mailElements["text_body"]   = implode("\n", $mailElements["text_body"]);
    // システムにメール
    $SendMailOBJ->debugMailTo($mailElements);
    // 運営にメール
    $SendMailOBJ->operationMailTo($mailElements);
}

?>