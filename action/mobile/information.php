<?php
/**
 * information.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * MBログイン後 情報ージ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

require_once(D_BASE_DIR . "/common/post_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$infoStatusOBJ = InformationStatus::getInstance();
$InfoStatusLogOBJ = InformationStatusLog::getInstance();

$userBankData = $UserOBJ->getBankDetailData($comUserData["user_id"]) ;
$userAddressData = $UserOBJ->getAddressDetailData($comUserData["user_id"]) ;

//フリーワード関連
$freeWordOBJ = new FreeWord();
$userFreeWordData = $freeWordOBJ->getFreeWordData($comUserData["user_id"]) ;
$freeWordSetDataList = $freeWordOBJ->getFreeWordSetDataList() ;
$freeWordSetDisplayData = $freeWordOBJ->getFreeWordSetDisplayData($freeWordSetDataList) ;

if($freeWordSetDisplayData) {
    foreach($freeWordSetDisplayData as $key => $val){
        $smartyOBJ->assign("freeWord_2_".$key, $val);
    }
}

//情報の取得
if ($param["isid"]) {
    if ($infoStatusData = $infoStatusOBJ->getInformationStatusData(array("isid" => $param["isid"]), $comUserData)) {
        // 既読表示情報チェック
        if ($infoStatusData["redirect_information_id"]) {
            $redirectInfomationId = "";
            $redirectInfomationId = explode(",", $infoStatusData["redirect_information_id"]);
            foreach ($redirectInfomationId as $val) {
                // 既読チェック※「既読表示情報ID」が複数登録してある場合、該当するのは1ユーザーでどれか1つ(のはず...)。
                if ($InfoStatusLogOBJ->isAccessed($val, $comUserData["user_id"])) {
                    // 既読なら情報の再取得
                    $infoStatusData = "";
                    if (!$infoStatusData = $infoStatusOBJ->getInformationStatusData(array("id" => $val), $comUserData)) {
                        // 情報取得出来なければTOPページへ
                        header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : ""));
                        exit;
                    }
                    // 1件でも既読情報を取得したらおしまい
                    break;
                }
            }
        }

        //ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報ID処理
        if ($infoStatusData["redirect_unit_id"] && $infoStatusData["redirect_unit_information_id"]) {
            $UnitOBJ = Unit::getInstance();

            $redirectInfomationUnitIdAry = "";
            $redirectUnitIdAry = "";
            $redirectInfomationUnitIdAry = explode(",", $infoStatusData["redirect_unit_information_id"]);
            $redirectUnitIdAry = explode(",", $infoStatusData["redirect_unit_id"]);

            foreach ($redirectUnitIdAry as $key => $unitId) {
                $isInUnitUserResult = $UnitOBJ->isInUnitUser($comUserData["user_id"],$unitId) ;
                if($isInUnitUserResult){
                    $redirectUnitInformationIdKey = $key ;

                    //unit_idと対になる情報IDを取得。
                    $redirectInformationId = $redirectInfomationUnitIdAry[$redirectUnitInformationIdKey] ;

                    if($redirectInformationId){
                        if ($preInfoStatusData = $infoStatusOBJ->getInformationStatusData(array("id" => $redirectInformationId), $comUserData)) {
                            $infoStatusData = $preInfoStatusData ;
                            // 一つでもﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報が取得出来たらﾙｰﾌﾟを抜ける
                            break ;
                        }
                    }
                }
            }
        }

        // コンバート
        $infoStatusData["user_bank_data"] = $userBankData ;
        $infoStatusData["user_address_data"] =$userAddressData ;
        $infoStatusData["user_free_word_data"] =$userFreeWordData ;
        $convertInfoHtmlKey = InformationStatus::INFORMAITON_HTML_TEXT_MB;
        $infoStatusData = $infoStatusOBJ->informationKeyConvert($infoStatusData, $comUserData, $isURIMobile, $convertInfoHtmlKey);
    } else {
        header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
} else {
    // 情報IDが無くてもTOPページへ
    header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
    exit;
}

//ポイント制限
$addWhere = array("information_status_id" => $infoStatusData["id"]) ;
$userPointLogData = $UserOBJ->getPointLogList($comUserData, $addWhere,$order = "id DESC", $limit = "1") ;
if($infoStatusData["bonus_point_limit"] == TRUE){
    if(!$userPointLogData[0]){
    	$userPointLogData[0] = "0000-00-00 00:00:00" ;
    }

    //最新のポイントログが前日以前かのチェック！
    if($userPointLogData[0]["create_datetime"] < date('Y-m-d H:i:s',strtotime("TODAY"))){
        $bonusPointLimitFlag = TRUE ;
    }
    //ポイント加算処理
    if( $infoStatusData["bonus_point"] AND $bonusPointLimitFlag){
        //ポイント足します
        $updatePoint        = $infoStatusData["bonus_point"];
        $updateInfoStatusId = $infoStatusData["id"];

        if (!$UserOBJ->updatePoint($comUserData, $updatePoint, "", $updateInfoStatusId)) {
            $UserOBJ->rollbackTransaction();
            header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : ""));
            exit;
        }
        $AddbonusPointLimitFlag = TRUE ;
    }
}

// ↓未読↓
if (!$InfoStatusLogOBJ->isAccessed($infoStatusData["id"], $comUserData["user_id"])) {

    // インスタンス生成
    $UserOBJ = User::getInstance();

    //トランザクション開始
    $UserOBJ->beginTransaction();

    //ポイント減算処理
    if ($infoStatusData["point"]) {

        // ユーザー所持ポイント不足なら不足処理
        if ($infoStatusData["point"] > $comUserData["point"]) {

            // ロールバック
            $UserOBJ->rollbackTransaction();

            // エラーメッセージ設定
            $errMsgSessOBJ = new ComSessionNamespace("err_msg");

            //強制的に商品の注文を追加
            $errMsgSessOBJ->errMsg[] = "御客様はﾎﾟｲﾝﾄ不足のため";
            $errMsgSessOBJ->errMsg[] = "情報を閲覧できません｡";
            $errMsgSessOBJ->errMsg[] = "情報の閲覧を希望される場合は、";
            $errMsgSessOBJ->errMsg[] = "ﾎﾟｲﾝﾄ追加をお願い致します｡";

            /*
            // 強制注文商品取得
            $ItemOBJ = Item::getInstance();
            if ($itemList = $ItemOBJ->getSelfOrderItemList($comUserData)) {
                // カートに商品追加
                $cartSessOBJ = new ComSessionNamespace("cart");
                foreach ($itemList as $val) {
                    if (!$cartSessOBJ->itemId) {
                        // カートに商品を新規格納
                        $cartSessOBJ->itemId[] = $val["access_key"];
                    } else if (!is_numeric(array_search($val["access_key"], $cartSessOBJ->itemId))) {
                        // 同一商品がカートになければ格納
                        $cartSessOBJ->itemId[] = $val["access_key"];
                    }
                }

                // 商品確認ページに行ってらっしゃい
                // ロールバック
                $UserOBJ->rollbackTransaction();
                header("Location:./?action_SettleSelect=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
                exit;

            } else {
                // 強制注文商品がなければ商品リストページへ行ってらっしゃい
                // ロールバック
                $UserOBJ->rollbackTransaction();
                header("Location:./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
                exit;
            }
            */

            // 商品確認ページに行ってらっしゃい
            header("Location:./?action_ItemList=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
            exit;

        } else {
            //ポイント引きます
            $updatePoint        = (0 - $infoStatusData["point"]);
            $updateInfoStatusId = $infoStatusData["id"];

            if (!$UserOBJ->updatePoint($comUserData, $updatePoint, "", $updateInfoStatusId)) {
                // ロールバック
                $UserOBJ->rollbackTransaction();
                header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
                exit;
            }
        }
    }

    //ポイント加算処理 （ポイント追加制限処理が走っていなければ）
    if(!$AddbonusPointLimitFlag){
        if( $infoStatusData["bonus_point"] ){
            //ポイント足します
            $updatePoint        = $infoStatusData["bonus_point"];
            $updateInfoStatusId = $infoStatusData["id"];
    
            if (!$UserOBJ->updatePoint($comUserData, $updatePoint, "", $updateInfoStatusId)) {
                $UserOBJ->rollbackTransaction();
                header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
                exit;
            }
        }
    }

    //情報アクセスログを取る
    $insertArray = array();
    $insertArray["information_status_id"] = $infoStatusData["id"];
    $insertArray["user_id"]               = $comUserData["user_id"];
    $insertArray["create_datetime"]       = date("YmdHis");

    if (!$InfoStatusLogOBJ->insertInformationStatusLog($insertArray)) {
        // ロールバック
        $UserOBJ->rollbackTransaction();
        header("Location:./?action_Home=1" . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }

    //コミット
    $UserOBJ->commitTransaction();

// ↓既読↓
} else {
    // リダイレクトURLが有ればお逝きなさい。
    if ($infoStatusData["redirect_url"]) {
        header("Location:." . htmlspecialchars_decode($infoStatusData["redirect_url"], ENT_QUOTES) . ($comURLparam ? "&" . $comURLparam : "") . "&" . $sessId);
        exit;
    }
}

$smartyOBJ->assign("infoStatusData", $infoStatusData);

// 銀行振込先データ取得
if ($data = $UserOBJ->getBankDetailData($comUserData["user_id"])) {
    $bankData["bank_name"] = $data["bank_name"];
    $bankData["bank_code"] = $data["bank_code"];
    $bankData["branch_name"] = $data["branch_name"];
    $bankData["branch_code"] = $data["branch_code"];
    $bankData["type"] = $data["type"];
    $bankData["account_number"] = $data["account_number"];
    $bankData["name"] = $data["name"];
}

$data = "";
// 住所データ取得
if ($data = $UserOBJ->getAddressDetailData($comUserData["user_id"])) {
    $addressData["postal_code"] = $data["postal_code"];
    $addressData["address"] = $data["address"];
    $addressData["address_name"] = $data["name"];
    $addressData["phone_number"] = $data["phone_number"];
}

$returnSessOBJ = new ComSessionNamespace("return");
// エラーメッセージの取得
if ($returnSessOBJ->return) {
    $bankData = $returnSessOBJ->return;
    $addressData = $returnSessOBJ->return;
    $errSessOBJ = new ComSessionNamespace("err_msg");
    if ($errSessOBJ->errMsg) {
        $errMsg = implode("<br>", $errSessOBJ->errMsg) . "<br>";
        $smartyOBJ->assign("errMsg", $errMsg);
        // セッション変数の破棄
        $errSessOBJ->unsetAll();
    }
    // セッション変数の破棄
    $returnSessOBJ->unsetAll();
}
$smartyOBJ->assign("bankData", $bankData);
$smartyOBJ->assign("bankType", array("普通"=>"普通","当座" =>"当座") );
$smartyOBJ->assign("addressData", $addressData);
$smartyOBJ->assign("sexCd", $_config["web_config"]["sex_cd"]);
$smartyOBJ->assign("bloodType", $_config["web_config"]["blood_type"]);
$smartyOBJ->assign("month", $_config["web_config"]["month"]);
$smartyOBJ->assign("day", $_config["web_config"]["day"]);

require_once($controllerOBJ->getIncludeBusinessLogic("postInclude"));
?>