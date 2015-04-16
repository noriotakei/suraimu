<?php
/**
 * Settlement.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  決済クラス
 *  決済管理するクラス
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class Settlement extends ComCommon {

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array 支払方法配列 */
    public static $_payTypeArray = array(
                Ordering::PAY_TYPE_BANK_AUTOMATIONBAS => "BAS",
                Ordering::PAY_TYPE_BANK_RAKUTEN => "楽天銀行",
                Ordering::PAY_TYPE_BANK_AUTOMATION => "入金おまかせ",
                Ordering::PAY_TYPE_CREDIT => "クレジット",
                Ordering::PAY_TYPE_TELECOM => "テレコムクレジット",
                Ordering::PAY_TYPE_CVD => "コンビニダイレクト",
                Ordering::PAY_TYPE_CCHECK => "C-check",
                Ordering::PAY_TYPE_DIGITALEDY => "デジタルチェックEdy",
                Ordering::PAY_TYPE_BITCASH => "BITCASH",
                  );

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * getInstanceメソッド
     *
     * このクラスのオブジェクトを生成する。
     * 既に生成されていたら、前回と同じものを返す。
     *
     * @return object $instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

     /**
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     *
     * 決済処理をする。
     *
     * @param  array $orderingData 注文データ
     * @param  array $userData ユーザーデータ
     * @param  integer $payType 支払いタイプ
     * @param  array $param パラメータ
     *
     * @return boolean
     */
    public function execSettlement($orderingData, $userData, $payType, $param) {

        if (!$orderingData OR !$userData OR !is_numeric($param["money"]) OR !is_numeric($payType)) {
            return false;
        }

        $SendMailOBJ = SendMail::getInstance();
        $OrderingOBJ = Ordering::getInstance();
        $UserOBJ = User::getInstance();
        $PaymentLogOBJ = PaymentLog::getInstance();
        $ItemOBJ = Item::getInstance();
        $AutoMailOBJ = AutoMail::getInstance();
        $OrderChangeLogOBJ = OrderChangeLog::getInstance();
        $MonthlyCourseOBJ = MonthlyCourse::getInstance();

        // BASログ更新結果フラグ(デフォルト:FALSE)
        $updateBasResult = FALSE;

        // 支払い方法名の取得
        $payTypeName = self::$_payTypeArray[$payType];

        // エラーメッセージの設定
        $errMsg = "注文ID:" . $orderingData["id"] . "\nユーザーID:" . $userData["user_id"] . "\n" . implode("\n", $param["errMsg"]) . "\n手動で対応して下さい。";
        $itemCancel = false;
        $partCancel = false;

        // 入金金額が注文金額より大きい場合
        if ($param["money"] - $orderingData["pay_total"] > 0) {
            $restPaymentMoney = $param["money"] - $orderingData["pay_total"];
            $differenceMoney = $restPaymentMoney;
            $isExcess = true;
        } else {
            $restPaymentMoney = $param["money"];
            $differenceMoney = $orderingData["pay_total"] - $param["money"];
            $isExcess = false;
        }

        // 「入金金額が注文金額と同じ」 or 「入金金額が注文金額より多い」場合は、注文を完了にする
        if ($param["money"] == $orderingData["pay_total"] || $isExcess) {
            // 注文商品関連処理
            if ($orderingDetailList = $ItemOBJ->getOrderingDetailItemList($orderingData["id"])) {
                foreach ($orderingDetailList as $val) {
                    // 仮購入以外は商品無効チェックをする
                    if ($orderingData["status"] != Ordering::ORDERING_STATUS_PRE_COMPLETE) {
                        // 商品の有効性をチェック
                        if (!$ItemOBJ->getItemData($userData, array("id" => $val["id"]))) {
                            // 有効じゃなければ、余り金として処理をする
                            // 注文詳細のキャンセル
                            $updateOrderingDetailArray = array();
                            $updateOrderingDetailArray["is_cancel"] = 1;
                            $updateOrderingDetailArray["cancel_datetime"] = date("YmdHis");
                            $updateOrderingDetailArray["update_datetime"] = date("YmdHis");
                            if (!$OrderingOBJ->updateOrderingDetailData($updateOrderingDetailArray, array("id=" . $val["detail_id"]))) {
                                // 注文情報更新エラー
                                $mailElements["subject"] = $payTypeName . "余り金注文詳細情報更新エラー";
                                $mailElements["text_body"] = "商品無効時の余り金注文詳細更新エラー\n" . $errMsg;

                                // システムにエラーメール
                                $SendMailOBJ->debugMailTo($mailElements);
                                // 運営にエラーメール
                                $SendMailOBJ->operationMailTo($mailElements);

                                return false;
                            }

                            // 注文詳細をキャンセルログに登録する
                            $orderingChangeLogArray = null;

                            // 注文変更ログ登録
                            $orderingChangeLogArray["ordering_id"] = $orderingData["id"];
                            $orderingChangeLogArray["item_id"] = $val["id"];
                            $orderingChangeLogArray["price"] = (0 - $val["price"]);
                            $orderingChangeLogArray["create_datetime"] = date("YmdHis");

                            if (!$OrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
                                // エラー
                                $mailElements["subject"] = $payTypeName . "余り金注文詳細情報の注文変更ログ登録エラー";
                                $mailElements["text_body"] = "商品無効時の余り金注文詳細の注文変更ログ登録に失敗しました。\n" . $errMsg;

                                // システムにエラーメール
                                $SendMailOBJ->debugMailTo($mailElements);
                                // 運営にエラーメール
                                $SendMailOBJ->operationMailTo($mailElements);
                                continue;
                            }

                            // 注文詳細情報作成
                            $insertOrderingDetailArray = array();
                            $insertOrderingDetailArray["ordering_id"] = $orderingData["id"];
                            $insertOrderingDetailArray["price"] = $val["price"];
                            $insertOrderingDetailArray["is_rest"] = 1;
                            $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
                            $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
                            if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
                                // 注文情報作成エラー
                                $mailElements["subject"] = $payTypeName . "余り金注文詳細情報作成エラー";
                                $mailElements["text_body"] = "商品無効時の余り金注文詳細作成エラー\n" . $errMsg;

                                // システムにエラーメール
                                $SendMailOBJ->debugMailTo($mailElements);
                                // 運営にエラーメール
                                $SendMailOBJ->operationMailTo($mailElements);

                                return false;
                            }

                            $val["point"] = floor( $val["price"] / Ordering::ONE_POINT_RATE );

                            // 余り金処理通知メール送信
                            $mailElements = array();
                            $mailElements["subject"] = $payTypeName . "無効商品購入余り金処理完了通知";
                            $mailElements["text_body"][] = "商品無効時の余り金処理が完了しました";
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "余り金金額:". $val["price"] . "円";
                            $mailElements["text_body"]= array_merge($mailElements["text_body"], $param["errMsg"]);
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            $SendMailOBJ->operationMailTo($mailElements);
                            $itemCancel = true;
                            $differenceMoney += $val["price"];
                        } else {
                            $partCancel = true;
                        }

                        // ポイント追加
                        if ($val["point"]) {
                            if (!$UserOBJ->updatePoint($userData, $val["point"], $orderingData["id"])){
                                $mailElements["subject"] = $payTypeName . "注文のポイント更新エラー";
                                $mailElements["text_body"] = $errMsg;
                                // システムにエラーメール
                                $SendMailOBJ->debugMailTo($mailElements);
                                // 運営にエラーメール
                                $SendMailOBJ->operationMailTo($mailElements);

                                return false;
                            }
                        }

                        // 月額コース付与
                        if ($val["monthly_course_id"]) {

                            if ($monthlyCourseData = $MonthlyCourseOBJ->getMonthlyCourseData($val["monthly_course_id"])) {
                                //月額コースユーザデータ新規作成時の利用期限・作成タイプを設定
                                $insertMonthlyCourseUserArray["limit_end_date"] = date("Y-m-d",strtotime($val["monthly_course_plus_limit_date"]." day",strtotime(date("Y-m-d"))));
                                $insertMonthlyCourseUserArray["create_type"] = MonthlyCourse::COURSE_TYPE_NEW;

                                //既存の付与コースユーザデータに同グループのコースがあったら無効フラグを立てる。月額更新フラグも変更。
                                if($monthlyCourseUserList = $MonthlyCourseOBJ->getMonthlyCourseUserList($userData, $monthlyCourseData["monthly_course_group_id"])){
                                    foreach($monthlyCourseUserList as $invalidVal){

                                        $invalidUpdateArray["is_invalid"] = 1;
                                        $invalidUpdateArray["is_monthly_update"] = 0;
                                        $invalidUpdateArray["update_datetime"] = date("YmdHis");

                                        if (!$MonthlyCourseOBJ->updateMonthlyCourseUserData($invalidUpdateArray, array("id=" . $invalidVal["id"]))) {
                                            // 既存月額コース無効フラグオン更新エラー
                                            $mailElements["subject"] = $payTypeName . "既存月額コース無効フラグオン更新エラー";
                                            $mailElements["text_body"] = "月額コース付与時の既存コース無効化処理エラー\n" . $errMsg;

                                            // システムにエラーメール
                                            $SendMailOBJ->debugMailTo($mailElements);
                                            // 運営にエラーメール
                                            $SendMailOBJ->operationMailTo($mailElements);

                                            return false;
                                        }

                                        //更新タイプ「更新」の場合利用期限を引き継ぐ
                                        if ($monthlyCourseData["id"] == $invalidVal["monthly_course_id"]) {
                                            //同じグループ同じコースの場合の更新タイプ
                                            if ($monthlyCourseData["same_monthly_course_type"] == MonthlyCourse::COURSE_TYPE_UPDATE) {
                                                $insertMonthlyCourseUserArray["limit_end_date"] = date("Y-m-d",strtotime($val["monthly_course_plus_limit_date"]." day",strtotime($invalidVal["limit_end_date"])));
                                                $insertMonthlyCourseUserArray["create_type"] = MonthlyCourse::COURSE_TYPE_UPDATE;
                                            }
                                        } else {
                                            //同じグループ違うコースの場合の更新タイプ
                                            if ($monthlyCourseData["different_monthly_course_type"] == MonthlyCourse::COURSE_TYPE_UPDATE) {
                                                $insertMonthlyCourseUserArray["limit_end_date"] = date("Y-m-d",strtotime($val["monthly_course_plus_limit_date"]." day",strtotime($invalidVal["limit_end_date"])));
                                                $insertMonthlyCourseUserArray["create_type"] = MonthlyCourse::COURSE_TYPE_UPDATE;
                                            }
                                        }

                                    }
                                }

                                /************************************************************************************/
                                /* 商品購入時(支払い手続き時)のデバイスタイプ(PC or MB or どちらか)                 */
                                /*  月額更新処理の決済データを渡す時に必須。クライアントIPがMB or PCとで異なるから!!*/
                                /*  でも必須なのは「ゼロクレジット」だけですけど...。                               */
                                /************************************************************************************/

                                if ($param["clientip"] == SettlementCredit::CREDIT_CLIENT_IP_PC) {
                                    // PC
                                    $deviceType = MonthlyCourse::DEVICE_TYPE_PC;
                                } elseif ($param["clientip"] == SettlementCredit::CREDIT_CLIENT_IP_MB) {
                                    // MB
                                    $deviceType = MonthlyCourse::DEVICE_TYPE_MB;
                                } else {
                                    // どちらか(テレコムクレジットは必ずここに入るはず...。)
                                    $deviceType = MonthlyCourse::DEVICE_TYPE_EITHER;
                                }

                                //月額コース付与
                                $insertMonthlyCourseUserArray["user_id"]            = $userData["user_id"];
                                $insertMonthlyCourseUserArray["monthly_course_id"]  = $monthlyCourseData["id"];
                                $insertMonthlyCourseUserArray["settle_device_type"] = $deviceType;
                                $insertMonthlyCourseUserArray["limit_start_date"]   = date("Y-m-d");
                                $insertMonthlyCourseUserArray["create_datetime"]    = date("YmdHis");

                                // 月額更新用商品IDがあれば設定
                                if ($val["monthly_update_item_id"]) {
                                    $insertMonthlyCourseUserArray["monthly_update_item_id"] = $val["monthly_update_item_id"];

                                    // 決済種別が「クレジット」であれば設定
                                    if ($orderingData["pay_type"] == Ordering::PAY_TYPE_CREDIT || $orderingData["pay_type"] == Ordering::PAY_TYPE_TELECOM) {
                                        $insertMonthlyCourseUserArray["is_monthly_update"] = 1;
                                    }
                                }

                                if (!$MonthlyCourseOBJ->insertMonthlyCourseUserData($insertMonthlyCourseUserArray)) {
                                    //月額コース付与エラー
                                    $mailElements["subject"] = $payTypeName . "月額コースデータの付与エラー";
                                    $mailElements["text_body"] = $errMsg;

                                    // システムにエラーメール
                                    $SendMailOBJ->debugMailTo($mailElements);
                                    // 運営にエラーメール
                                    $SendMailOBJ->operationMailTo($mailElements);

                                    return false;

                                }
                            } else {
                                //有効な月額コースが無ければエラー
                                $mailElements["subject"] = $payTypeName . "月額コースデータの取得エラー";
                                $mailElements["text_body"] = $errMsg;

                                // システムにエラーメール
                                $SendMailOBJ->debugMailTo($mailElements);
                                // 運営にエラーメール
                                $SendMailOBJ->operationMailTo($mailElements);

                                return false;
                            }
                        }
                    }
                }
            } else {
                // 注文商品詳細がなければエラー
                $mailElements["subject"] = $payTypeName . "注文詳細データの取得エラー";
                $mailElements["text_body"] = $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // 注文データの更新
            $updateOrderingArray = array();
            $updateOrderingArray["status"] = Ordering::ORDERING_STATUS_COMPLETE;
            $updateOrderingArray["pay_type"] = $payType;
            $updateOrderingArray["is_paid"] = 1;
            $updateOrderingArray["paid_datetime"] = date("YmdHis");
            $updateOrderingArray["update_datetime"] = date("YmdHis");

            // ゼロクレジット電話番号があれば登録
            if ($param["credit_certify_phone_number"]) {
                $updateOrderingArray["credit_certify_phone_number"] = $param["credit_certify_phone_number"];
            } else if ($param["credit_certify_phone_number_mb"]) {
                $updateOrderingArray["credit_certify_phone_number"] = $param["credit_certify_phone_number_mb"];
            }
            // テレコムクレジット電話番号があれば登録
            if ($param["telecom_certify_phone_number"]) {
                $updateOrderingArray["telecom_certify_phone_number"] = $param["telecom_certify_phone_number"];
            }
            $whereOrderingArray = array();
            $whereOrderingArray[] = "id = " . $orderingData["id"];

            if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, $whereOrderingArray)) {
                $mailElements["subject"] = $payTypeName . "注文データの更新エラー";
                $mailElements["text_body"] = $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // 入金ログをインサート
            $paymentInsertArray = array();
            $paymentInsertArray["user_id"] = $userData["user_id"];
            $paymentInsertArray["ordering_id"] = $orderingData["id"];
            $paymentInsertArray["receive_money"] = $orderingData["pay_total"];
            $paymentInsertArray["pay_type"] = $payType;
            $paymentInsertArray["create_datetime"] = date("YmdHis");

            if (!$PaymentLogOBJ->insertPaymentLogData($paymentInsertArray)) {
                $mailElements["subject"] = $payTypeName . "入金ログ登録エラー";
                $mailElements["text_body"] = $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // 支払いタイプ別ログ取り
            switch ($payType) {

                case Ordering::PAY_TYPE_BANK_AUTOMATIONBAS:
                    // バスログ登録
                    $SettlementBankOBJ = SettlementBank::getInstance();

                    $basLogInsertArray = array();
                    $basLogInsertArray["ordering_id"] = $orderingData["id"];
                    $basLogInsertArray["user_id"] = $userData["user_id"];

                    // 登録できなくても進む
                    if (!$SettlementBankOBJ->updateBasLogData($basLogInsertArray, array("id = " . $param["bas_log_id"]))) {
                        $mailElements["subject"] = "BASログ登録エラー";
                        $mailElements["text_body"] = $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);
                    } else {
                        $updateBasResult = TRUE;
                    }

                    break;

                // コンビニダイレクトログ更新
                case Ordering::PAY_TYPE_CVD:

                    $SettlementCvdOBJ = SettlementCvd::getInstance();
                    $cvdLogupdateArray =array();
                    $cvdLogupdateArray["is_paid"] = 1;
                    $cvdLogupdateArray["pay_datetime"] = date("YmdHis");
                    $cvdLogupdateArray["update_datetime"] = date("YmdHis");

                    if (!$SettlementCvdOBJ->updateConvenienceDirectData($cvdLogupdateArray, array("id=" . $param["cvd_id"]))) {
                        $mailElements["subject"] = "余り金コンビニダイレクトログ更新エラー";
                        $mailElements["text_body"] = "余り金コンビニダイレクトログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                // C-checkログ更新
                case Ordering::PAY_TYPE_CCHECK:

                    $SettlementCcheckOBJ = SettlementCcheck::getInstance();
                    $ccheckLogupdateArray =array();
                    $ccheckLogupdateArray["is_paid"] = 1;
                    $ccheckLogupdateArray["pay_datetime"] = date("YmdHis");
                    $ccheckLogupdateArray["update_datetime"] = date("YmdHis");

                    if (!$SettlementCcheckOBJ->updateConvenienceCheckData($ccheckLogupdateArray, array("id=" . $param["ccheck_id"]))) {
                        $mailElements["subject"] = "余り金C-checkログ更新エラー";
                        $mailElements["text_body"] = "余り金C-checkログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                // デジタルチェックEdyログ更新
                case Ordering::PAY_TYPE_DIGITALEDY:

                    $SettlementDigitalEdyOBJ = SettlementDigitalEdy::getInstance();
                    $edyLogupdateArray =array();
                    $edyLogupdateArray["is_paid"] = 1;
                    $edyLogupdateArray["pay_datetime"] = date("YmdHis");
                    $edyLogupdateArray["update_datetime"] = date("YmdHis");

                    if (!$SettlementDigitalEdyOBJ->updateDigitalEdyData($edyLogupdateArray, array("id=" . $param["digital_edy_id"]))) {
                        $mailElements["subject"] = "余り金デジタルチェックEdyログ更新エラー";
                        $mailElements["text_body"] = "余り金デジタルチェックEdyログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                // 該当がなければ
                default :
                    break;
            }
        }

        // 入金額が注文金額と異なれば、余り金分を新規注文でポイント購入
        if ($param["money"] != $orderingData["pay_total"]) {

            /*
            // 入金金額が注文金額より大きい場合
            if ($param["money"] - $orderingData["pay_total"] > 0) {
                $restPaymentMoney = $param["money"] - $orderingData["pay_total"];
                $differenceMoney = $restPaymentMoney;
                $isExcess = true;
            } else {
                $restPaymentMoney = $param["money"];
                $differenceMoney = $orderingData["pay_total"] - $param["money"];
                $isExcess = false;
            }
            */

            // 注文情報作成
            $insertOrderingArray = array();
            $insertOrderingArray["user_id"] = $userData["user_id"];
            $insertOrderingArray["status"] = Ordering::ORDERING_STATUS_REST;
            $insertOrderingArray["pay_type"] = $payType;
            $insertOrderingArray["is_paid"] = 1;
            $insertOrderingArray["paid_datetime"] = date("YmdHis");
            $insertOrderingArray["create_datetime"] = date("YmdHis");
            $insertOrderingArray["update_datetime"] = date("YmdHis");

            // ゼロクレジット電話番号があれば登録
            if ($param["credit_certify_phone_number"]) {
                $insertOrderingArray["credit_certify_phone_number"] = $param["credit_certify_phone_number"];
            } else if ($param["credit_certify_phone_number_mb"]) {
                $insertOrderingArray["credit_certify_phone_number"] = $param["credit_certify_phone_number_mb"];
            }
            // テレコムクレジット電話番号があれば登録
            if ($param["telecom_certify_phone_number"]) {
                $insertOrderingArray["telecom_certify_phone_number"] = $param["telecom_certify_phone_number"];
            }
            if (!$OrderingOBJ->insertOrderingData($insertOrderingArray)) {
                // 注文情報作成エラー
                $mailElements["subject"] = $payTypeName . "余り金注文情報作成エラー";
                $mailElements["text_body"] = "余り金新規注文作成エラー\n" . $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            $restOrderingId = $OrderingOBJ->getInsertId();

            // 注文詳細情報作成
            $insertOrderingDetailArray = array();
            $insertOrderingDetailArray["ordering_id"] = $restOrderingId;
            $insertOrderingDetailArray["price"] = $restPaymentMoney;
            $insertOrderingDetailArray["is_rest"] = 1;
            $insertOrderingDetailArray["create_datetime"] = date("YmdHis");
            $insertOrderingDetailArray["update_datetime"] = date("YmdHis");
            if (!$OrderingOBJ->insertOrderingDetailData($insertOrderingDetailArray)) {
                // 注文情報作成エラー
                $mailElements["subject"] = $payTypeName . "余り金注文詳細情報作成エラー";
                $mailElements["text_body"] = "余り金注文詳細作成エラー\n" . $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // アクセスキーと合計金額の更新
            $updateOrderingArray = array();
            $updateOrderingArray["access_key"] = $OrderingOBJ->getNewAccessKey($restOrderingId);
            $updateOrderingArray["pay_total"] = $restPaymentMoney;
            if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $restOrderingId))) {
                // 注文情報更新エラー
                $mailElements["subject"] = $payTypeName . "余り金注文情報更新エラー";
                $mailElements["text_body"] = "余り金注文情報更新エラー\n" . $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // ポイント追加
            $changePoint  = floor( $restPaymentMoney / Ordering::ONE_POINT_RATE );
            if (!$UserOBJ->updatePoint($userData, $changePoint, $restOrderingId)){
                $mailElements["subject"] = $payTypeName . "余り金注文のポイント更新エラー";
                $mailElements["text_body"] = $errMsg;
                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // 入金ログをインサート
            $paymentInsertArray = array();
            $paymentInsertArray["user_id"] = $userData["user_id"];
            $paymentInsertArray["ordering_id"] = $restOrderingId;
            $paymentInsertArray["receive_money"] = $restPaymentMoney;
            $paymentInsertArray["pay_type"] = $payType;
            $paymentInsertArray["create_datetime"] = date("YmdHis");

            if (!$PaymentLogOBJ->insertPaymentLogData($paymentInsertArray)) {
                $mailElements["subject"] = $payTypeName . "余り金入金ログ登録エラー";
                $mailElements["text_body"] = "余り金入金ログ登録エラー\n" . $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);

                return false;
            }

            // 支払いタイプ別ログ取り
            // ※新規登録ではなくて、既存ログデータの更新で対応
            switch ($payType) {

                case Ordering::PAY_TYPE_BANK_AUTOMATIONBAS:

                    // バスログ登録
                    $SettlementBankOBJ = SettlementBank::getInstance();
                    $basLogUpdateArray =array();
                    $basLogUpdateArray["user_id"] = $userData["user_id"];
                    $basLogUpdateArray["update_datetime"] = date("YmdHis");

                    // 元の注文ログの「注文ID」が更新されてなければ、余り金データの注文IDを更新
                    if (!$updateBasResult) {
                        $basLogUpdateArray["ordering_id"] = $restOrderingId;
                    }

                    // 更新できなくても進む
                    if (!$SettlementBankOBJ->updateBasLogData($basLogUpdateArray, array("id = " . $param["bas_log_id"]))) {
                        $mailElements["subject"] = "BASログ更新エラー";
                        $mailElements["text_body"] = $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);
                    }
                    break;

                // コンビニダイレクトログ登録
                case Ordering::PAY_TYPE_CVD:

                    $SettlementCvdOBJ = SettlementCvd::getInstance();
                    $cvdLogupdateArray =array();

                    $cvdLogupdateArray["is_paid"] = 1;
                    $cvdLogupdateArray["pay_datetime"] = date("YmdHis");
                    $cvdLogupdateArray["update_datetime"] = date("YmdHis");

                    // 入金額と注文金額が異なるので、「入金した金額」で上書き
                    $cvdLogupdateArray["pay_money"] = $param["money"];

                    if (!$SettlementCvdOBJ->updateConvenienceDirectData($cvdLogupdateArray, array("id=" . $param["cvd_id"]))) {
                        $mailElements["subject"] = "余り金コンビニダイレクトログ更新エラー";
                        $mailElements["text_body"] = "余り金コンビニダイレクトログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                // C-checkログ登録
                case Ordering::PAY_TYPE_CCHECK:

                    $SettlementCcheckOBJ = SettlementCcheck::getInstance();
                    $ccheckLogupdateArray =array();

                    $ccheckLogupdateArray["is_paid"] = 1;
                    $ccheckLogupdateArray["pay_datetime"] = date("YmdHis");
                    $ccheckLogupdateArray["update_datetime"] = date("YmdHis");

                    // 入金額と注文金額が異なるので、金額を入金額で上書き
                    $ccheckLogupdateArray["pay_money"] = $param["money"];

                    if (!$SettlementCcheckOBJ->updateConvenienceCheckData($ccheckLogupdateArray, array("id=" . $param["ccheck_id"]))) {
                        $mailElements["subject"] = "余り金C-checkログ更新エラー";
                        $mailElements["text_body"] = "余り金C-checkログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                // デジタルチェックEdyログ登録
                case Ordering::PAY_TYPE_DIGITALEDY:

                    $SettlementDigitalEdyOBJ = SettlementDigitalEdy::getInstance();
                    $edyLogupdateArray =array();

                    $edyLogupdateArray["is_paid"] = 1;
                    $edyLogupdateArray["pay_datetime"] = date("YmdHis");
                    $edyLogupdateArray["update_datetime"] = date("YmdHis");

                    // 入金額と注文金額が異なるので、金額を入金額で上書き
                    $edyLogupdateArray["pay_money"] = $param["money"];

                    if (!$SettlementDigitalEdyOBJ->updateDigitalEdyData($edyLogupdateArray, array("id=" . $param["digital_edy_id"]))) {
                        $mailElements["subject"] = "余り金デジタルチェックEdyログ更新エラー";
                        $mailElements["text_body"] = "余り金デジタルチェックEdyログ更新エラー\n" . $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);

                        return false;
                    }
                    break;

                    // 該当がなければ
                    default :
                        break;
            }

            // 余り金処理通知メール送信
            $mailElements = array();
            $mailElements["subject"] = $payTypeName . "余り金処理完了通知";
            $mailElements["text_body"][] = ($isExcess ? "過剰" : "不足") . "余り金処理が完了しました";
            $mailElements["text_body"][] = "注文ID:" . $restOrderingId;
            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
            $mailElements["text_body"][] = "余り金金額:". $restPaymentMoney . "円";
            $mailElements["text_body"]= array_merge($mailElements["text_body"], $param["errMsg"]);
            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

            // システムにエラーメール
            $SendMailOBJ->debugMailTo($mailElements);
            // 運営にエラーメール
            $SendMailOBJ->operationMailTo($mailElements);
        }

        // ユーザ情報を更新
        // 余り金が発生しても１入金とする
        $profileUpdateArray = array();
        // ｾﾞﾛｸﾚｼﾞｯﾄ電話番号があれば登録
        if ($param["credit_certify_phone_number"]) {
            $profileUpdateArray["credit_certify_phone_number"] = "'" . $param["credit_certify_phone_number"] . "'";
        } else if ($param["credit_certify_phone_number_mb"]) {
            $profileUpdateArray["credit_certify_phone_number_mb"] = "'" . $param["credit_certify_phone_number_mb"] . "'";
        }
        // ﾃﾚｺﾑｸﾚｼﾞｯﾄ電話番号があれば登録
        if ($param["telecom_certify_phone_number"]) {
            $profileUpdateArray["telecom_certify_phone_number"] = "'" . $param["telecom_certify_phone_number"] . "'";
        }

        $AffiliateControlOBJ = AffiliateControl::getInstance();  
        // 初入金の場合はタグ送信(「購入回数が0」 and 「初入金タグが未発行」の場合のみ)
        if ($userData["buy_count"] == 0 && !$userData["affiliate_tag_first_payment_url"]) {
            if ($userData["affiliate_value"]) {
                // 登録時のQUERY_STRINGを配列に格納
                parse_str($userData["affiliate_value"], $aryAffiliateValue);
                // 「初入金時」のみフラグを配列に追加
                $aryAffiliateValue["from_first_payment"] = 1;

                if ($aryAffiliateValue["ad_code"]) {
                    $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
                }

                // タグ発行
                if (!$AffiliateControlOBJ->sendAffiliateData($userData["user_id"], $aryAffiliateValue, AffiliateControl::SEND_TYPE_REGIST, $isSuccess = TRUE)) {
                    $userAffiliateUpdateArray["affiliate_tag_first_payment_url"] = "NO_TAG";
                    // userテーブルへの更新処理
                    if (!$UserOBJ->updateUserData($userAffiliateUpdateArray, array("id = " . $userData["user_id"]))) {
                        $mailElements["subject"] = $payTypeName . "ユーザー「初入金タグ」アフィリエイトソケット通信エラー";
                        $mailElements["text_body"] = $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        //$SendMailOBJ->operationMailTo($mailElements);
                    }
                }
            }
        }

        // アフィリエイトデータの取得
        if($userData["media_cd"]){
            $affiliateData = $AffiliateControlOBJ->getAffiliateDataFromAdvcd($userData["media_cd"]);
        }
        //入金時タグ発行
        if($affiliateData["payment_parameter"]){
            if ($userData["affiliate_value"]) {
                // 登録時のQUERY_STRINGを配列に格納
                $aryAffiliateValue = "" ;
                parse_str($userData["affiliate_value"], $aryAffiliateValue);
                // 「入金時」のみフラグを配列に追加
                $aryAffiliateValue["from_payment"] = 1;

                if ($aryAffiliateValue["ad_code"]) {
                    $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
                }

                $aryAffiliateValue["payment"] =  $param["money"] ;

                // タグ発行
                if (!$AffiliateControlOBJ->sendAffiliateData($userData["user_id"], $aryAffiliateValue, AffiliateControl::SEND_TYPE_REGIST, $isSuccess = TRUE)) {
                    // payment_parameter_logテーブルへのインサート処理
                    $insertArray["user_id"] = $userData["user_id"];
                    $insertArray["media_cd"] = $aryAffiliateValue["advcd"];
                    $insertArray["affiliate_tag_url"] = "NO_TAG";
                    $insertArray["create_datetime"] = date("YmdHis");
                    $insertArray["update_datetime"] = date("YmdHis");

                    if (!$AffiliateControlOBJ->insertPaymentAffiliateTagLog($insertArray)) {
                        $mailElements["subject"] = $payTypeName . "ユーザー「入金タグ」アフィリエイトソケット通信エラー";
                        $mailElements["text_body"] = $errMsg;

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);

                    }
                }
            }
        }

        $profileUpdateArray["total_payment"] = "total_payment + " . $param["money"];
        $profileUpdateArray["buy_count"] = "buy_count + 1";
        $profileUpdateArray["last_buy_datetime"] = "'" . date("YmdHis") . "'";
        $profileUpdateArray["update_datetime"]   = "'" . date("YmdHis") . "'";
        if (!ComValidation::isDateTime($userData["first_pay_datetime"])) {
            $profileUpdateArray["first_pay_datetime"] = "'" . date("YmdHis") . "'";
        }

        if (!$UserOBJ->updateProfileData($profileUpdateArray, array("user_id=" . $userData["user_id"]), false)) {
            $mailElements["subject"] = $payTypeName . "決済ユーザ情報更新エラー";
            $mailElements["text_body"] = $errMsg;

            // システムにエラーメール
            $SendMailOBJ->debugMailTo($mailElements);
            // 運営にエラーメール
            $SendMailOBJ->operationMailTo($mailElements);

            return false;
        }

        // 決済完了メール送信
        // 別途%変換用にセット
        $convAry = $OrderingOBJ->makeOrderConvertArray($orderingData);
        $convAry["-%rest_money-"] = $differenceMoney . "円";
        $convAry["-%payment_money-"] = $param["money"]  . "円";

        // 過入金のメール文言取得
        if ($param["money"] > $orderingData["pay_total"]) {
            $arrayName = "excess";
        // 不足入金のメール文言取得
        } else if ($param["money"] < $orderingData["pay_total"]) {
            $arrayName = "lack";
        // 商品が全て期限切れ
        } else if (!$partCancel AND $itemCancel) {
            $arrayName = "allCancel";
        // 商品が一部期限切れ
        } else if ($partCancel AND $itemCancel) {
            $arrayName = "partCancel";
        // 正常のメール文言取得
        } else {
            $arrayName = "settlement_end";
        }
        
        if ($userData["pc_address"] AND $payType != Ordering::PAY_TYPE_BANK_RAKUTEN AND $payType != Ordering::PAY_TYPE_BANK_AUTOMATIONBAS) {
            $mailElementsData = $AutoMailOBJ->getAutoMailData("settlement", $arrayName, $userData["pc_address"]);

            $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"], $convAry);
            // メール送信
            if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
                $mailElements["subject"] = $payTypeName . "決済完了PCメール送信エラー";
                $mailElements["text_body"] = $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);
            }
        }

        if ($userData["mb_address"] AND $payType != Ordering::PAY_TYPE_BANK_RAKUTEN AND $payType != Ordering::PAY_TYPE_BANK_AUTOMATIONBAS) {
            $mailElementsData = $AutoMailOBJ->getAutoMailData("settlement", $arrayName, $userData["mb_address"]);
            $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $userData["user_id"], $convAry);
            // メール送信
            if (!$AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"])) {
                $mailElements["subject"] = $payTypeName . "決済完了MBメール送信エラー";
                $mailElements["text_body"] = $errMsg;

                // システムにエラーメール
                $SendMailOBJ->debugMailTo($mailElements);
                // 運営にエラーメール
                $SendMailOBJ->operationMailTo($mailElements);
            }
        }

        // 同商品が入っている注文の削除
        if ($orderingDetailList) {

            foreach ((array)$orderingDetailList as $val) {

//////////////竹井ここから
                //商品管理で指定してある商品ＩＤの注文が入っているものも一緒に削除
                if($val["target_delete_item_id"]){
                    $targetDeleteItemIdAry = explode(",", $val["target_delete_item_id"]) ;
                    foreach((array)$targetDeleteItemIdAry as $targetDeleteItemIdVal){
                        if($targetDeleteItemIdVal != $val["id"]){
                            $itemIdArray[] = $targetDeleteItemIdVal;
                        }
                    }
                }
//////////////竹井ここまで
                
                $itemIdArray[] = $val["id"];
            }

            // キャンセルする注文データの取得
            $cancelOrderingList = $OrderingOBJ->getOrderingListFromItemId($userData["user_id"], $itemIdArray);
            if ($cancelOrderingList) {
                foreach ((array)$cancelOrderingList as $val) {

                    $mailElements = null;

                    // 注文詳細リストの確認
                    if (!$itemList = $ItemOBJ->getOrderingDetailItemList($val["id"])) {
                        // 注文商品詳細がなければエラー
                        $mailElements["subject"] = "注文削除の注文詳細データの取得エラー";
                        $mailElements["text_body"][] = "注文ID:" . $val["id"];
                        $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                        $mailElements["text_body"][] = "注文削除の注文詳細データの取得に失敗しました。";
                        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);
                        continue;
                    }

                    foreach ((array)$itemList as $itemVal) {

                        // 注文詳細をキャンセルログに登録する
                        $orderingChangeLogArray = null;

                        // 注文変更ログ登録
                        $orderingChangeLogArray["ordering_id"] = $itemVal["ordering_id"];
                        $orderingChangeLogArray["item_id"] = $itemVal["id"];
                        $orderingChangeLogArray["price"] = (0 - $itemVal["price"]);
                        $orderingChangeLogArray["create_datetime"] = date("YmdHis");

                        if (!$OrderChangeLogOBJ->insertOrderingChangeLogData($orderingChangeLogArray)) {
                            // エラー
                            $mailElements["subject"] = "注文削除の注文変更ログ登録エラー";
                            $mailElements["text_body"][] = "注文ID:" . $val["id"];
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "注文削除の注文変更ログ登録に失敗しました。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            $SendMailOBJ->operationMailTo($mailElements);
                            continue;
                        }

                        $orderingDetailArray = null;

                        $orderingDetailArray["is_cancel"] = 1;
                        $orderingDetailArray["update_datetime"] = date("YmdHis");

                        // 注文詳細データ更新
                        if (!$OrderingOBJ->updateOrderingDetailData($orderingDetailArray, array("id = " . $itemVal["detail_id"]))) {
                            // エラー
                            $mailElements["subject"] = "注文削除の注文詳細データ更新エラー";
                            $mailElements["text_body"][] = "注文ID:" . $val["id"];
                            $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                            $mailElements["text_body"][] = "注文削除の注文詳細データ更新に失敗しました。";
                            $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

                            // システムにエラーメール
                            $SendMailOBJ->debugMailTo($mailElements);
                            // 運営にエラーメール
                            $SendMailOBJ->operationMailTo($mailElements);
                            continue;
                        }
                    }

                    $updateOrderingArray = null;

                    // 注文情報更新
                    $updateOrderingArray["is_cancel"] = 1;
                    $updateOrderingArray["pay_total"] = 0;
                    $updateOrderingArray["update_datetime"] = date("YmdHis");
                    $updateOrderingArray["cancel_datetime"] = date("YmdHis");

                    if (!$OrderingOBJ->updateOrderingData($updateOrderingArray, array("id=" . $val["id"]))) {
                        // エラー
                        $mailElements["subject"] = "注文削除の注文情報更新エラー";
                        $mailElements["text_body"][] = "注文ID:" . $val["id"];
                        $mailElements["text_body"][] = "ユーザーID:" . $userData["user_id"];
                        $mailElements["text_body"][] = "注文削除の注文情報更新に失敗しました。";
                        $mailElements["text_body"] = implode("\n", $mailElements["text_body"]);

                        // システムにエラーメール
                        $SendMailOBJ->debugMailTo($mailElements);
                        // 運営にエラーメール
                        $SendMailOBJ->operationMailTo($mailElements);
                        continue;
                    }
                }
            }
        }

        return true;
    }

    /**
     * 決済種別の飛び先更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateSettleSelectData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$this->update("settle_control", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return true;
    }

    /**
     *
     * 決済種別の飛び先の取得
     *
     * @return array データ配列
     */
    public function getSettleSelectData() {

        $columnArray[] = "*";

        $sql = $this->makeSelectQuery("settle_control", $columnArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

}
?>