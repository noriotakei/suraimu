<?php
/**
 * /action/admin/media/repExec.php
 *
 * */


require_once(D_BASE_DIR . "/common/admin_common.php");

$AdminUserOBJ = AdmUser::getInstance();
$UserOBJ = User::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();

// セッションオブジェクトのインスタンス
$param = $requestOBJ->getParameterExcept($exceptArray);
$errSessOBJ = new ComSessionNamespace("err");
$execMsgSessOBJ = new ComSessionNamespace("execMsg");
$returnSessOBJ = new ComSessionNamespace("return");

//チェキ
if(!$_FILES['regCsvFile']['name']){
    $errMsg[] = "ファイルが存在しません。";
}

//えらーがあったら表示しておしまい
switch($_FILES['regCsvFile']['error']){
        case 1:
        case 2:
                $errMsg[] = "ファイルサイズは２ＭＢまでにして下さい。";
                break;
        case 3:
                $errMsg[] = "何らかの要因により失敗です。再度上げ直しを御願いします。";
                break;
        case 4:
                $errMsg[] = "ファイルのアップロードが失敗です。";
                break;
}

if( !ComValidation::isNumeric($param["registPageId"]) OR ComValidation::isEmpty($param["registPageId"]) ) {
    $errMsg[] = "登録入口コードは数字で入力して下さい。";
}

if (!ComValidation::isString($param["advcd"]) OR ComValidation::isEmpty($param["advcd"]) ) {
    $errMsg[] = "媒体コードが不正です。";
}

if ($errMsg) {
    $errSessOBJ->errMsg = $errMsg;
    header("Location: ./?action_User_RegistCsv=1");
    exit;
}

//ファイルの中身を配列に格納
$targetMailAddressArray = file($_FILES['regCsvFile']['tmp_name']);

//空だったら中止
if(!ComValidation::isValue($targetMailAddressArray)){
    $errMsg[] = "ファイルの中身が認識出来ません。";
    header("location: ./?action_User_RegistCsv=1");
    exit;

}
$targetCountNum = count($targetMailAddressArray);
$i = 0;
//順番にまわす
foreach($targetMailAddressArray as $key => $address){
    //改行除去
    $address = trim($address);

    //アドレス無し、もしくはアドレスの体を成していない場合はcontinue
    if (!$address OR !ComValidation::isMailAddress($address)) {
        continue;
    }

    //アドレスから重複チェック
    $duplicateUserData = FALSE;
    if(!$duplicateUserData = $UserOBJ->getUserDataFromMailAddressDuplication($address)){
        $duplicateUserData = $UserOBJ->chkUserDataFromLoginIdDuplication($address);
    }

    //重複がないなら
    if($duplicateUserData == FALSE){

        $UserOBJ->beginTransaction();

        //現在時刻のみだと重複が発生しやすいので値を足してユニークになり易い様に仕向けます
        $currentDateTime = date("Y-m-d H:i:s");
        $accessKey       = $UserOBJ->getNewAccessKey( $currentDateTime.$key );
        $remailKey       = $UserOBJ->getNewRemailKey( $currentDateTime.$key );
        $password        = $UserOBJ->createPasswordKey(ComUtility::getRamdomNumber(4));

        $addressColumn = "";
        $deviceColumn  = "";
        $mbFlag        = FALSE;
        // 携帯メールアドレス?
        if (ComValidation::isMobileAddress($address)) {
            $deviceCd = $ComUtilityOBJ->getDeviceFromMailAddress($address);
            $addressColumn = "mb_address";
            $deviceColumn  = "mb_device_cd";
            $mbFlag = TRUE;
        }else{
            $deviceCd = $_config["define"]["DEVICE_PC"];
            $addressColumn = "pc_address";
            $deviceColumn  = "pc_device_cd";
        }

        $userAry = array(
                            "login_id"            => $address,
                            "password"            => $password,
                            "access_key"          => $accessKey,
                            "remail_key"          => $remailKey,
                            $addressColumn        => $address,
                            $deviceColumn         => $deviceCd,
                            "regist_status"       => $_config["define"]["USER_REGIST_STATUS_MEMBER"],
                            "regist_page_id"      => $param["registPageId"],
                            "media_cd"            => $param["advcd"],
                            "affiliate_tag_url"   => "NO_TAG",
                            "pre_regist_datetime" => $currentDateTime,
                            "regist_datetime"     => $currentDateTime,
                            "update_datetime"     => $currentDateTime,
                            "description"     => "tc20177_VOL13_7",
                        );

        // userテーブルへのインサート処理
        if (!$UserOBJ->insertUserData($userAry)) {
            $UserOBJ->rollbackTransaction();
            continue;
        }

        //userの次はprofileテーブルへ
        $userId = $UserOBJ->getInsertId();

        $profileAry = array(
            "user_id"                 => $userId,
            "by_user_update_datetime" => $currentDateTime,
            "update_datetime"         => $currentDateTime,
            "user_profile_flag_code"         => 1,
        );

        // profileテーブルへのインサート処理
        if (!$UserOBJ->insertProfileData($profileAry)) {
            $UserOBJ->rollbackTransaction();
            continue;
        }

        // トランザクションコミット
        $UserOBJ->commitTransaction();

        // サイト間登録通信
        $RegistSiteOBJ = RegistSite::getInstance();
        $RegistSiteOBJ->sendRegistSiteData($address);
        $updateRegistSiteData = "";
        $updateRegistSiteData["user_id"] = $userId;
        $updateRegistSiteData["update_datetime"] = date("YmdHis");

        $whereRegistSiteArray = "";
        $whereRegistSiteArray[] = "mail_address = '" . $address . "'";
        $whereRegistSiteArray[] = "disable = 0";
        $RegistSiteOBJ->updateRegistSiteLogData($updateRegistSiteData, $whereRegistSiteArray);

        $i++;

    }
}
$execMsgSessOBJ->execMsg = array($targetCountNum."件中：".$i."件登録しました。");
header("Location: ./?action_user_registCsvEnd=1");
exit;

?>

















