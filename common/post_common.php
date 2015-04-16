<?php
/**
 * web ログイン後共通処理
 */

require_once(D_BASE_DIR . "/common/user_common.php");

// 認証
// セッションオブジェクトのインスタンス
$loginSessOBJ = new ComSessionNamespace("login");

$AuthOBJ = Auth::getInstance();
$UserOBJ = User::getInstance();

if ($accessPageName == "loginChk") {
    $loginId = $commonParam["login_id"];
    // パスワードをハッシュ値に変換
    $password = $UserOBJ->createPasswordKey($commonParam["password"]);

    // ログインデータの破棄
    $AuthOBJ->clearIdentity();
    $result = $AuthOBJ->authentication($loginId, $password);

    // 認証できない場合
    if (!$result){
        // ログインデータの破棄
        $AuthOBJ->clearIdentity();
        $loginSessOBJ = new ComSessionNamespace("login");
        $loginSessOBJ->errMsg[] = "会員ID、またはパスワードが正しくありません";
    }

// ダイレクト登録の場合
} else if ($accessPageName == "memberLoginDirect") {
    $loginId = $commonParam["l"];
    // パスワードをハッシュ値に変換
    $password = $UserOBJ->createPasswordKey($commonParam["p"]);

    // ログインデータの破棄
    $AuthOBJ->clearIdentity();
    $result = $AuthOBJ->authentication($loginId, $password);

    // 認証できない場合
    if (!$result){
        // ログインデータの破棄
        $AuthOBJ->clearIdentity();
        $loginSessOBJ = new ComSessionNamespace("login");
        $loginSessOBJ->errMsg[] = "会員ID、またはパスワードが正しくありません";
    }

} else if ($accessKey) {

    // アクセスキーがある場合
    $comUserData = $AuthOBJ->authenticateAccesskey($accessKey);
    $loginId = $comUserData["login_id"];
    $password = $comUserData["password"];

    // ログインデータの破棄
    $AuthOBJ->clearIdentity();
    $result = $AuthOBJ->authentication($loginId, $password);

} else if ($mbSerialNo) {

    // 個体識別番号がある場合
    $comUserData = $AuthOBJ->authenticateMbSerialNo($mbSerialNo);
    $loginId = $comUserData["login_id"];
    $password = $comUserData["password"];

    // ログインデータの破棄
    $AuthOBJ->clearIdentity();
    $result = $AuthOBJ->authentication($loginId, $password);



} else {
    $result = $AuthOBJ->authentication();
}

// 認証の場合
if ($result){
    $comUserDataId = $AuthOBJ->getIdentity()->user_id;
    $comUserData = $UserOBJ->getUserData($comUserDataId);
    // 仮登録なら本登録に更新
    if ($comUserData["regist_status"] == $_config["define"]["USER_REGIST_STATUS_PRE_MEMBER"]) {

        // 個体識別の重複チェック
        if ($mbSerialNo) {
            if ($UserOBJ->chkUserDataFromMbSerialNumber($mbSerialNo, $comUserData["user_id"])) {

            	$SendMailOBJ = SendMail::getInstance();

            	$mailElements["subject"] = "個体識別番号が重複しています";
            	$mailElements["text_body"][] = "ユーザーＩＤ  ".$comUserData["user_id"];
            	$mailElements["text_body"][] = "重複対象個体識別  ".$mbSerialNo;

            	$mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
            	// 運営にエラーメール
            	$SendMailOBJ->operationMailTo($mailElements);

            	$ComErrSessOBJ->errMsg[] = "個体識別番号が重複しています。";
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
        }

        $registAry = array(
            "regist_status" => $_config["define"]["USER_REGIST_STATUS_MEMBER"],
            "regist_datetime" => date("YmdHis"),
            "update_datetime"  => date("YmdHis"),
        );

        // userテーブルへの更新処理
        if (!$UserOBJ->updateUserData($registAry, array("id = " . $comUserDataId))) {
            $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
            exit();
        }

        // 登録時のQUERY_STRINGを配列に格納
        parse_str($comUserData["affiliate_value"], $aryAffiliateValue);
        // 広告コードの引数が違うため格納
        if ($aryAffiliateValue["ad_code"]) {
            $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
        }

        if (ComValidation::isNumeric($aryAffiliateValue["s"])) {
            $registProfileAry["sex_cd"] = $aryAffiliateValue["s"];
        }
        // タイムスタンプで来る
        if (ComValidation::isNumeric($aryAffiliateValue["b"])) {
            $registProfileAry["birth_date"] = date("Y-m-d", $aryAffiliateValue["b"]);
        }
        // profileテーブルへの更新処理
        if ($updateProfileData) {
            $registProfileAry["update_datetime"] = date("YmdHis");
            if (!$UserOBJ->updateProfileData($registProfileAry, array("id=" . $comUserData["profile_id"]))) {
                $errSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
        }

        $AutoMailOBJ = AutoMail::getInstance();
        // リメールデータの取得
        $mailAddress = $comUserData["mb_address"] ? $comUserData["mb_address"] : $comUserData["pc_address"];
        $mailElementsData = $AutoMailOBJ->getAutoMailData("regist", "regist_end", $mailAddress);

        $mailElements = $AutoMailOBJ->convertMailElements($mailElementsData["elements"], $comUserDataId);

        // メール送信
        $AutoMailOBJ->mailTo($mailElements, "", $mailElementsData["image_data"], $mailElementsData["image_type"]);

        // 再認証
        $loginId = $comUserData["login_id"];
        $password = $comUserData["password"];

        // ログインデータの破棄
        $AuthOBJ->clearIdentity();
        if (!$result = $AuthOBJ->authentication($loginId, $password)) {
            header("Location: ./?action_PreLogin=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
            exit();
        }
        $comUserData = $UserOBJ->getUserData($comUserDataId);
    }

    // ログインチェックページ以外からのアクセスのみ
    if ($accessPageName != "loginChk") {
        // アフィリエイト処理をしていなければ発行
        if (!$comUserData["affiliate_tag_url"]) {

            // 登録時のQUERY_STRINGを配列に格納
            parse_str($comUserData["affiliate_value"], $aryAffiliateValue);
            // 広告コードの引数が違うため格納
            if ($aryAffiliateValue["ad_code"]) {
                $aryAffiliateValue["advcd"] = $aryAffiliateValue["ad_code"];
            }

            if(AffiliateControl16::ROUTES_CD_LENGTH == strlen($aryAffiliateValue["advcd"])){
                $AffiliateControlOBJ = AffiliateControl16::getInstance();
            } else {
                $AffiliateControlOBJ = AffiliateControl::getInstance();
            }

            // 登録タグ発行
            if (!$AffiliateControlOBJ->sendAffiliateData($comUserDataId, $aryAffiliateValue, AffiliateControl::SEND_TYPE_REGIST)) {
                $userAffiliateUpdateArray["affiliate_tag_url"] = "NO_TAG";
                // userテーブルへの更新処理
                if (!$UserOBJ->updateUserData($userAffiliateUpdateArray, array("id = " . $comUserDataId))) {
                    $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                    header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                    exit();
                }
            } else {
                // imgタグがあればアサイン
                if ($imgTag = $AffiliateControlOBJ->getImgTag()) {
                    $smartyOBJ->assign("comImgTag", $imgTag);
                }
            }
        }
    }

    if ($comUserData) {

        $smartyOBJ->assign("comUserData", $comUserData);

        $comUpdateAccessData["previous_access_datetime"] = $comUserData["last_access_datetime"];
        $comUpdateAccessData["last_access_datetime"] = date("YmdHis");

        if (!$UserOBJ->updateUserData($comUpdateAccessData, array("id=" . $comUserData["user_id"]))) {
            $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
            header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
            exit();
        }

        // 機種情報の登録
        if ($mbSerialNo) {
            $comUpdateUserData = "";
            if ($mbUa == "Ezweb") {
                $deviceId = $useragentOBJ->getDeviceId();
                // AUの場合、デバイスIDあり and 既存データと異なる ⇒ 登録
                if ($deviceId AND $deviceId != $comUserData["mb_model"]) {
                    $comUpdateUserData["mb_model"] = $deviceId;
                }
            } else {
                $model = $useragentOBJ->getModel();
                if ($model AND $model != $comUserData["mb_model"]) {
                    $comUpdateUserData["mb_model"] = $model;
                }
            }

            if ($mbSerialNo != $comUserData["mb_serial_number"]) {
                // 個体識別の重複チェック
                if ($UserOBJ->chkUserDataFromMbSerialNumber($mbSerialNo, $comUserData["user_id"])) {

                	$SendMailOBJ = SendMail::getInstance();

                	$mailElements["subject"] = "個体識別番号が重複しています";
                	$mailElements["text_body"][] = "ユーザーＩＤ  ".$comUserData["user_id"];
                	$mailElements["text_body"][] = "重複対象個体識別  ".$mbSerialNo;

                	$mailElements["text_body"] = implode("\n", $mailElements["text_body"]);
                	// 運営にエラーメール
                	$SendMailOBJ->operationMailTo($mailElements);

                	$ComErrSessOBJ->errMsg[] = "個体識別番号が重複しています。";
                    header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                    exit();
                }
                $comUpdateUserData["mb_serial_number"] = $mbSerialNo;
            }
            $comUpdateUserData["mb_user_agent"] = $server["HTTP_USER_AGENT"] ;
            $comUpdateUserData["update_datetime"] = date("YmdHis");

            if (!$UserOBJ->updateUserData($comUpdateUserData, array("id=" . $comUserData["user_id"]))) {
                $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
        }

        //ｽﾏｰﾄﾌｫﾝ,ﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ及び機種名登録
        if($isSmartPhone){
            $comUpdateUserData = "";
            $smartPhoneModel = $userAgentSmartPhoneOBJ ->getSmartPhoneModel() ;

            //機種名
            if($smartPhoneModel && $comUserData["mb_model"] != $smartPhoneModel){
            	$comUpdateUserData["mb_model"] = $smartPhoneModel ;
            }
            //ﾕｰｻﾞｰエージェント
            if($comUserData["mb_user_agent"] != $server["HTTP_USER_AGENT"] ){
            	$comUpdateUserData["mb_user_agent"] = $server["HTTP_USER_AGENT"] ;
            }
            if($comUpdateUserData){
                $comUpdateUserData["update_datetime"] = date("YmdHis");
                if (!$UserOBJ->updateUserData($comUpdateUserData, array("id=" . $comUserData["user_id"]))) {
                    $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                    header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                    exit();
                }
            }
        }

        // PCIPアドレスの登録
        if (!$isURIMobile && $comUserData["pc_user_agent"] != $server["HTTP_USER_AGENT"]) {
            $comUpdateUserData = "";
            $comUpdateUserData["pc_user_agent"] = $server["HTTP_USER_AGENT"];
            $comUpdateUserData["pc_ip_address"] = $server["REMOTE_ADDR"];
            $comUpdateUserData["update_datetime"] = date("YmdHis");

            if (!$UserOBJ->updateUserData($comUpdateUserData, array("id=" . $comUserData["user_id"]))) {
                $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
        }

        $AdminUserProfileFlagOBJ = AdmUserProfileFlag::getInstance();
        $userProfileFlagData["code"] = $comUserData['user_profile_flag'] ;
        $userProfileFlagParamDate = $AdminUserProfileFlagOBJ->getUserProfileFlag($userProfileFlagData) ;

        //ユーザーフラクと変更するフラグが同じ場合はアップデートしない
        if( $comUserData['user_profile_flag'] != $userProfileFlagParamDate[0]["convert_code"] ){
            $comUpdateProfileData['update_datetime'] = date("YmdHis");
            $comUpdateProfileData['user_profile_flag_code'] =$userProfileFlagParamDate[0]["convert_code"];

            if (!$UserOBJ->updateProfileData($comUpdateProfileData, array("user_id=" . $comUserData["user_id"]))) {
                $ComErrSessOBJ->errMsg = $UserOBJ->getErrorMsg();
                header("Location: ./?action_Error=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
                exit();
            }
        }
    } else {
        // ログインデータの破棄
        $AuthOBJ->clearIdentity();
        header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
        exit();
    }
} else {
    // ログインデータの破棄
    $AuthOBJ->clearIdentity();
    if ($isURIMobile) {
        header("Location: ./?action_PreLogin=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
    } else {
        header("Location: ./?action_Index=1" . ($comURLparam ? "&" . $comURLparam  : "") . ($sessId ? "&" . $sessId : ""));
    }
    exit();
}
?>