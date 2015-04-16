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
$userOBJ              = User::getInstance();
$SettlementCreditOBJ  = SettlementCredit::getInstance();
$OrderingOBJ          = Ordering::getInstance();
$ItemOBJ              = Item::getInstance();
$MonthlyCourseOBJ     = MonthlyCourse::getInstance();

// 全月額コースデータ取得
$whereArray = "";
$whereArray[] = "mcu.pay_type = " . Ordering::PAY_TYPE_CREDIT; // 支払い種別が「クレジット」
$whereArray[] = "mcu.limit_end_date = '" . date("Y-m-d") . "'"; // コース有効期限が今日まで

$monthlyCourseCreditList = "";
if ($monthlyCourseCreditList = $MonthlyCourseOBJ->getMonthlyCourseList($whereArray)) {

    // 月額注文データの取得
    foreach ($monthlyCourseCreditList as $val) {

        // ユーザーデータ取得
        $userData = "";
        $userData = $userOBJ->getUserData($val["user_id"]);

        // メールアドレス
        $mail = "";
        $mail = ($userData["pc_address"] ? $userData["pc_address"] : $userData["mb_address"]);

        // 自動決済更新用商品の有効性の確認と取得
        $autoSettlementItemData = "";
        if ($autoSettlementItemData = $ItemOBJ->getItemData($userData, array("id" => $val["auto_settlement_item_id"]))) {

            // トランザクション開始
            //$OrderingOBJ->beginTransaction();

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
                $mailElements["text_body"][] = "自動月額更新用商品の予約注文に失敗しました。";

                $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                //$SendMailOBJ->operationMailTo($mailElements);
            }

            $orderingId = "";
            $orderingId = $OrderingOBJ->getInsertId();

            // 注文詳細情報作成
            $insertOrderingDetailArray = "";
            $insertOrderingDetailArray["ordering_id"]     = $orderingId;
            $insertOrderingDetailArray["item_id"]         = $autoSettlementItemData["id"];
            $insertOrderingDetailArray["price"]           = $autoSettlementItemData["price"];
            $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
            $insertOrderingDetailArray["update_datetime"] = date("YmdHis");

            if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {

                // ロールバック
                $OrderingOBJ->rollbackTransaction();
                // 異常処理 ⇒ メール送信文言作成
                $mailElements["subject"]     = "自動月額更新用商品詳細の登録エラー";
                $mailElements["text_body"][] = "自動月額更新用商品詳細の登録に失敗しました。";

                $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                //$SendMailOBJ->operationMailTo($mailElements);
            }


            // 自動月額更新用商品の金額を設定
            $itemPayTotal = "";
            $itemPayTotal = $autoSettlementItemData["price"];

            // アクセスキーと合計金額の更新
            $updateOrderingArray = "";
            $updateOrderingArray["access_key"] = $OrderingOBJ->getNewAccessKey($orderingId);
            $updateOrderingArray["pay_total"] = $itemPayTotal;

            if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $orderingId))) {

                // ロールバック
                $OrderingOBJ->rollbackTransaction();
                // 異常処理 ⇒ メール送信文言作成
                $mailElements["subject"]     = "自動月額更新用商品の更新エラー";
                $mailElements["text_body"][] = "自動月額更新用商品の更新に失敗しました。";

                $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                //$SendMailOBJ->operationMailTo($mailElements);
            }

            // コミット
            $OrderingOBJ->commitTransaction();

            // テスト環境でなければ決済する
            if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {

                if ($val["isDevice"] == MonthlyCourse::PAY_TYPE_PC) {
                    $SettlementCreditOBJ->setSettleType("quick_pc");
                    $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number"]);
                } elseif ($val["isDevice"] == MonthlyCourse::PAY_TYPE_MB) {
                    $SettlementCreditOBJ->setSettleType("quick_mb");
                    $SettlementCreditOBJ->setPostData("telno", $userData["credit_certify_phone_number_mb"]);
                }

                $SettlementCreditOBJ->setPostData("money", $itemPayTotal);
                $SettlementCreditOBJ->setPostData("sendid", $userData["user_id"]);
                $SettlementCreditOBJ->setPostData("sendpoint", $orderingId);
                $SettlementCreditOBJ->setPostData("email", $mail);
                $SettlementCreditOBJ->setPostData("siteurl", $_config["define"]["SITE_URL"] . "?action_Home=1&" . $sessId);

                if (!$SettlementTelecomOBJ->sendToCredit()) {

                    // 異常決済処理 ⇒ メール送信文言作成
                    $mailElements["text_body"][] = "注文ID:" . $paidOrderingData["id"];
                    $mailElements["text_body"][] = "商品合計額:" . $paidOrderingData["pay_total"] . "円";
                    $mailElements["subject"]     = "月額決済クイックチャージ(クレジット)NG";
                    $mailElements["text_body"][] = "月額決済クイックチャージ(クレジット)に失敗しました。";

                    $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                    // システムにエラーメール
                    $SendMailOBJ->debugMailTo($mailElements);
                    // 運営にエラーメール
                    //$SendMailOBJ->operationMailTo($mailElements);
                    print("NG");
                    exit();
                }
            } else {
                // 決済処理だけは終わらせたいので、テスト用決済戻りURLを叩くようにする。
                $siteDomain = $_config["define"]["SITE_DOMAIN"];
                $searchString = "/test.3rd.fraise.jp/";

                if (!preg_match($searchString, $siteDomain)) {
                    // 開発環境
                    $returnSettlementURL = "http://stl." . $_config["define"]["SITE_DOMAIN"] . "/credit/?action_Index=1";
                } else {
                    // ローカル環境
                    $returnSettlementURL = "http://" . $_config["define"]["SITE_DOMAIN"] . "/bin/settlement/credit/?action_Index=1";
                }

                // 前回支払い「PC or MB」で切り替え(クレジットだけなので、必ずどちらか存在するはず...。)
                if ($val["is_device"] == MonthlyCourse::PAY_TYPE_PC) {
                    $clientIP = SettlementCredit::CREDIT_CLIENT_IP_PC;
                } elseif ($val["is_device"] == MonthlyCourse::PAY_TYPE_MB) {
                    $clientIP = SettlementCredit::CREDIT_CLIENT_IP_MB;
                }

                // 必須追加パラメータ(たぶんこれで大丈夫かと...。)

                $addParam = "&clientip=" . $clientIP           // サイトコード
                           . "&money=" . $itemPayTotal         // トータル金額
                           . "&telno=00000000000"              // 決済時入力電話番号
                           . "&email=" . $mail                 // 決済時入力メアド
                           . "&sendid=" . $userData["user_id"] // ユーザーID
                           . "&sendpoint=" . $orderingId       // 注文ID
                           . "&result=ok";                     // 決済戻り結果

                // 決済処理ファイル実行
                header("Location: " . $returnSettlementURL . $addParam);
            }

        } else {

            // 異常決済処理 ⇒ メール送信文言作成
            $mailElements["text_body"][] = "自動決済更新用商品ID:" . $val["auto_settlement_item_id"];
            $mailElements["subject"]     = "月額決済NG";
            $mailElements["text_body"][] = "自動決済更新用商品の取得に失敗しました。";

            $mailElements["text_body"]   = implode("\n", $mailElements["text_body"]);
            // システムにエラーメール
            $SendMailOBJ->debugMailTo($mailElements);
            // 運営にエラーメール
            //$SendMailOBJ->operationMailTo($mailElements);
            print("NG");
            exit();
        }
    }
}

// 終了
exit("COMPLETE!!");

?>